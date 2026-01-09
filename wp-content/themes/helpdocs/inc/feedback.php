<?php
/**
 * Sistema de Feedback "Isso ajudou?"
 *
 * @package HelpDocs
 */

// Evita acesso direto
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Cria tabela de feedback na ativação do tema
 */
function helpdocs_create_feedback_table() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'helpdocs_feedback';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        post_id bigint(20) NOT NULL,
        feedback_type varchar(10) NOT NULL,
        user_ip varchar(45) DEFAULT NULL,
        user_agent text DEFAULT NULL,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (id),
        KEY post_id (post_id),
        KEY feedback_type (feedback_type)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
add_action('after_switch_theme', 'helpdocs_create_feedback_table');

/**
 * Handler AJAX para feedback
 */
function helpdocs_handle_feedback() {
    // Verifica nonce
    if (!check_ajax_referer('helpdocs_ajax_nonce', 'nonce', false)) {
        wp_send_json_error(array('message' => 'Nonce inválido'));
        return;
    }

    // Valida dados
    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
    $feedback = isset($_POST['feedback']) ? sanitize_text_field($_POST['feedback']) : '';

    if (!$post_id || !in_array($feedback, array('yes', 'no'))) {
        wp_send_json_error(array('message' => 'Dados inválidos'));
        return;
    }

    // Verifica se o post existe
    if (!get_post($post_id)) {
        wp_send_json_error(array('message' => 'Post não encontrado'));
        return;
    }

    // Pega informações do usuário
    $user_ip = helpdocs_get_user_ip();
    $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? sanitize_text_field($_SERVER['HTTP_USER_AGENT']) : '';

    global $wpdb;
    $table_name = $wpdb->prefix . 'helpdocs_feedback';

    // Verifica se já votou (mesmo IP nas últimas 24h)
    $existing_vote = $wpdb->get_row($wpdb->prepare(
        "SELECT id FROM $table_name
         WHERE post_id = %d
         AND user_ip = %s
         AND created_at > DATE_SUB(NOW(), INTERVAL 24 HOUR)",
        $post_id,
        $user_ip
    ));

    if ($existing_vote) {
        // Atualiza o voto existente
        $wpdb->update(
            $table_name,
            array(
                'feedback_type' => $feedback,
                'created_at' => current_time('mysql')
            ),
            array('id' => $existing_vote->id),
            array('%s', '%s'),
            array('%d')
        );
    } else {
        // Insere novo voto
        $wpdb->insert(
            $table_name,
            array(
                'post_id' => $post_id,
                'feedback_type' => $feedback,
                'user_ip' => $user_ip,
                'user_agent' => $user_agent
            ),
            array('%d', '%s', '%s', '%s')
        );
    }

    // Atualiza contadores em post_meta para acesso rápido
    helpdocs_update_feedback_counts($post_id);

    wp_send_json_success(array(
        'message' => 'Feedback registrado com sucesso',
        'feedback' => $feedback
    ));
}
add_action('wp_ajax_helpdocs_feedback', 'helpdocs_handle_feedback');
add_action('wp_ajax_nopriv_helpdocs_feedback', 'helpdocs_handle_feedback');

/**
 * Atualiza contadores de feedback em post_meta
 */
function helpdocs_update_feedback_counts($post_id) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'helpdocs_feedback';

    // Conta votos positivos
    $yes_count = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM $table_name
         WHERE post_id = %d AND feedback_type = 'yes'",
        $post_id
    ));

    // Conta votos negativos
    $no_count = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM $table_name
         WHERE post_id = %d AND feedback_type = 'no'",
        $post_id
    ));

    // Atualiza post_meta
    update_post_meta($post_id, '_helpdocs_feedback_yes', intval($yes_count));
    update_post_meta($post_id, '_helpdocs_feedback_no', intval($no_count));
    update_post_meta($post_id, '_helpdocs_feedback_total', intval($yes_count) + intval($no_count));

    // Calcula taxa de utilidade (%)
    $total = intval($yes_count) + intval($no_count);
    if ($total > 0) {
        $helpfulness = round(($yes_count / $total) * 100, 1);
        update_post_meta($post_id, '_helpdocs_helpfulness_rate', $helpfulness);
    }
}

/**
 * Obtém IP do usuário
 */
function helpdocs_get_user_ip() {
    $ip_keys = array(
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'HTTP_X_FORWARDED',
        'HTTP_X_CLUSTER_CLIENT_IP',
        'HTTP_FORWARDED_FOR',
        'HTTP_FORWARDED',
        'REMOTE_ADDR'
    );

    foreach ($ip_keys as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (explode(',', $_SERVER[$key]) as $ip) {
                $ip = trim($ip);
                if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
                    return $ip;
                }
            }
        }
    }

    return '0.0.0.0';
}

/**
 * Obtém estatísticas de feedback de um post
 */
function helpdocs_get_feedback_stats($post_id) {
    $yes = get_post_meta($post_id, '_helpdocs_feedback_yes', true);
    $no = get_post_meta($post_id, '_helpdocs_feedback_no', true);
    $total = get_post_meta($post_id, '_helpdocs_feedback_total', true);
    $rate = get_post_meta($post_id, '_helpdocs_helpfulness_rate', true);

    return array(
        'yes' => intval($yes),
        'no' => intval($no),
        'total' => intval($total),
        'helpfulness_rate' => floatval($rate)
    );
}

/**
 * Adiciona coluna de feedback no admin
 */
function helpdocs_add_feedback_column($columns) {
    $columns['feedback'] = '👍 Feedback';
    return $columns;
}
add_filter('manage_posts_columns', 'helpdocs_add_feedback_column');

/**
 * Exibe dados da coluna de feedback
 */
function helpdocs_display_feedback_column($column, $post_id) {
    if ($column === 'feedback') {
        $stats = helpdocs_get_feedback_stats($post_id);

        if ($stats['total'] > 0) {
            echo '<div style="font-size: 12px;">';
            echo '<span style="color: #46b450;">👍 ' . $stats['yes'] . '</span> | ';
            echo '<span style="color: #dc3232;">👎 ' . $stats['no'] . '</span><br>';
            echo '<strong>' . $stats['helpfulness_rate'] . '%</strong> útil';
            echo '</div>';
        } else {
            echo '<span style="color: #999;">Sem votos</span>';
        }
    }
}
add_action('manage_posts_custom_column', 'helpdocs_display_feedback_column', 10, 2);

/**
 * Torna a coluna de feedback ordenável
 */
function helpdocs_sortable_feedback_column($columns) {
    $columns['feedback'] = '_helpdocs_helpfulness_rate';
    return $columns;
}
add_filter('manage_edit-post_sortable_columns', 'helpdocs_sortable_feedback_column');
