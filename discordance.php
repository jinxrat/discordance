<?php
/*
Plugin Name: Discordance
Plugin URI: https://github.com/jinxrat/discordance
Description: An WordPress plugin to send your posts to Discord using Webhooks.
Version: 1.0.0
Author: JINXRAT
Author URI: https://jinxr.at/
Donate link: https://jinxr.at/donate
License: GPLv2 or later
*/

defined('ABSPATH') or die;
$discordance_opts = get_option('discordance');
add_action('init', function () {
    global $discordance_opts;
    $current_user = wp_get_current_user();
    $current_user_id = $current_user->ID;
    if (!is_array($discordance_opts)) {
        add_action('admin_notices', function () {
            global $hook_suffix;
            if (!current_user_can('manage_options') || $hook_suffix === 'toplevel_page_discordance') {
                return;
            }
            echo '<div class="updated notice is-dismissible" id="discordance-setup-prompt"><p><a href="' . get_bloginfo('wpurl') . '/wp-admin/admin.php?page=discordance">Please configure the <strong>Discordance</strong> plugin</a></p></div>';
        });
        $discordance_opts = array(
            'webhooks' => '',
            'format' => '
    {
        "content": ":loudspeaker: **New %type% on the blog!**",
        "embeds": [
            {
                "author": {
                    "name": "%author%",
                    "url": "%author_url%",
                    "icon_url": "%gravatar%"
                },
                "title": "%title%",
                "description": "%excerpt%",
                "url": "%link%",
                "thumbnail": {
                    "url": "%thumbnail%"
                }
            }
        ]
    }'
        );
        register_setting('options', 'discordance');
        add_option('discordance', $discordance_opts);
    }
    if (!isset($discordance_opts['types'])) {
        $discordance_opts['types'] = ['post'];
    }
    foreach ($discordance_opts['types'] as $type) {
        if (!post_type_supports($type, 'custom-fields')) {
            add_post_type_support($type, 'custom-fields');
        }
        register_post_meta($type, '_discordance_state', [
            'single' => true,
            'type' => 'string',
            'show_in_rest' => true,
            'auth_callback' => function () {
                return current_user_can('edit_posts');
            }
        ]);
        register_post_meta($type, '_discordance_checked', [
            'single' => true,
            'type' => 'boolean',
            'default' => true,
            'show_in_rest' => true,
            'auth_callback' => function () {
                return current_user_can('edit_posts');
            }
        ]);
    }
});
add_action('rest_api_init', function () {
    register_rest_route('discordance/v1', '/update', array(
        'methods' => 'PUT',
        'callback' => function (WP_REST_Request $request) {
            $request_body = $request->get_body_params();
            if (
                isset($request_body['format'])
            ) {
                $discordance_opts = filter_var_array($request_body, FILTER_SANITIZE_STRING);
                if (update_option('discordance', $discordance_opts)) {
                    $response = new WP_REST_Response(array('success' => true));
                    $response->set_status(200);
                } else {
                    $response = new WP_REST_Response(array('success' => false));
                    $response->set_status(400);
                }
                return $response;
            } else {
                return new WP_Error('invalid_request', 'Something went wrong', array('status' => 401));
            }
        },
        'permission_callback' => function () {
            return current_user_can('edit_posts');
        }
    ));
});
add_action('admin_print_scripts-toplevel_page_discordance', function () {
    wp_enqueue_script('twitter-bootstrap', plugins_url('/js/bootstrap.bundle.min.js', __FILE__), array(), '5.0.0-beta3', true);
    wp_enqueue_script('discordance', plugins_url('/js/main.js', __FILE__), array(), filemtime(dirname(__FILE__) . '/js/main.js'), true);
    wp_localize_script(
        'discordance',
        'DISCORDANCE',
        array(
            'rest_url' => get_rest_url(),
            'nonce' => wp_create_nonce('wp_rest')
        )
    );
});
add_action('admin_print_styles-toplevel_page_discordance', function () {
    wp_enqueue_style('twitter-bootstrap', plugins_url('/css/bootstrap.min.css', __FILE__), array(), '5.0.0-beta3');
    wp_enqueue_style('discordance', plugins_url('/css/style.css', __FILE__), array(), filemtime(dirname(__FILE__) . '/css/style.css'));
});
add_action('admin_menu', function () {
    if (function_exists('add_menu_page')) {
        add_menu_page('Discordance &lsaquo; Settings', 'Discordance', 'manage_options', 'discordance', function () {
            global $discordance_opts;
            if (!current_user_can('manage_options')) {
                return;
            }
            include_once('includes/config.php');
        }, 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+CjxzdmcKICAgeG1sbnM6ZGM9Imh0dHA6Ly9wdXJsLm9yZy9kYy9lbGVtZW50cy8xLjEvIgogICB4bWxuczpjYz0iaHR0cDovL2NyZWF0aXZlY29tbW9ucy5vcmcvbnMjIgogICB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiCiAgIHhtbG5zOnN2Zz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciCiAgIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIKICAgeG1sbnM6c29kaXBvZGk9Imh0dHA6Ly9zb2RpcG9kaS5zb3VyY2Vmb3JnZS5uZXQvRFREL3NvZGlwb2RpLTAuZHRkIgogICB4bWxuczppbmtzY2FwZT0iaHR0cDovL3d3dy5pbmtzY2FwZS5vcmcvbmFtZXNwYWNlcy9pbmtzY2FwZSIKICAgdmlld0JveD0iMCAwIDUwMCA1MDAiCiAgIHZlcnNpb249IjEuMSIKICAgaWQ9InN2ZzM0IgogICBzb2RpcG9kaTpkb2NuYW1lPSJkaXNjb3JkYW5jZS5zdmciCiAgIGlua3NjYXBlOnZlcnNpb249IjEuMC4yLTIgKGU4NmM4NzA4NzksIDIwMjEtMDEtMTUpIj4KICA8bWV0YWRhdGEKICAgICBpZD0ibWV0YWRhdGE0MCI+CiAgICA8cmRmOlJERj4KICAgICAgPGNjOldvcmsKICAgICAgICAgcmRmOmFib3V0PSIiPgogICAgICAgIDxkYzpmb3JtYXQ+aW1hZ2Uvc3ZnK3htbDwvZGM6Zm9ybWF0PgogICAgICAgIDxkYzp0eXBlCiAgICAgICAgICAgcmRmOnJlc291cmNlPSJodHRwOi8vcHVybC5vcmcvZGMvZGNtaXR5cGUvU3RpbGxJbWFnZSIgLz4KICAgICAgPC9jYzpXb3JrPgogICAgPC9yZGY6UkRGPgogIDwvbWV0YWRhdGE+CiAgPGRlZnMKICAgICBpZD0iZGVmczM4IiAvPgogIDxzb2RpcG9kaTpuYW1lZHZpZXcKICAgICBwYWdlY29sb3I9IiNmZmZmZmYiCiAgICAgYm9yZGVyY29sb3I9IiM2NjY2NjYiCiAgICAgYm9yZGVyb3BhY2l0eT0iMSIKICAgICBvYmplY3R0b2xlcmFuY2U9IjEwIgogICAgIGdyaWR0b2xlcmFuY2U9IjEwIgogICAgIGd1aWRldG9sZXJhbmNlPSIxMCIKICAgICBpbmtzY2FwZTpwYWdlb3BhY2l0eT0iMCIKICAgICBpbmtzY2FwZTpwYWdlc2hhZG93PSIyIgogICAgIGlua3NjYXBlOndpbmRvdy13aWR0aD0iMTkyMCIKICAgICBpbmtzY2FwZTp3aW5kb3ctaGVpZ2h0PSIxMDE3IgogICAgIGlkPSJuYW1lZHZpZXczNiIKICAgICBzaG93Z3JpZD0iZmFsc2UiCiAgICAgaW5rc2NhcGU6em9vbT0iMS43IgogICAgIGlua3NjYXBlOmN4PSIyNTAiCiAgICAgaW5rc2NhcGU6Y3k9IjE0OC45NzE3NyIKICAgICBpbmtzY2FwZTp3aW5kb3cteD0iMTkxMiIKICAgICBpbmtzY2FwZTp3aW5kb3cteT0iLTgiCiAgICAgaW5rc2NhcGU6d2luZG93LW1heGltaXplZD0iMSIKICAgICBpbmtzY2FwZTpjdXJyZW50LWxheWVyPSJzdmczNCIgLz4KICA8cGF0aAogICAgIGlkPSJyZWN0MjYiCiAgICAgc3R5bGU9ImZpbGw6IHJnYigxMTQsIDEzNywgMjE4KTsiCiAgICAgZD0iTSAxNi4yNzM0MzggMTYuMjczNDM4IEwgMTYuMjczNDM4IDQ4My43MjY1NiBMIDQ4My43MjY1NiA0ODMuNzI2NTYgTCA0ODMuNzI2NTYgMTYuMjczNDM4IEwgMTYuMjczNDM4IDE2LjI3MzQzOCB6IE0gNzcuMTUyMzQ0IDcyLjUgTCA0MjcuNSA3Mi41IEwgNDI3LjUgNDI2LjM3MzA1IEwgNzQuMjQ4MDQ3IDQyNi4zNzMwNSBMIDcyLjUgNDI3LjUgTCA3My4wNDg4MjggNDI2Ljk2Mjg5IEwgNzMuMDQ4ODI4IDM3NS42NjAxNiBMIDExNy4zOTY0OCAzNzUuNjYwMTYgTCAxMTcuMzk2NDggMTIzLjQxOTkyIEwgNzcuMTUyMzQ0IDEyMy40MTk5MiBMIDc3LjE1MjM0NCA3Mi41IHogTSAyNzUgMTI0IEwgMjc1IDI1OSBMIDMwOCAyNTkgTCAzMDggMTI0IEwgMjc1IDEyNCB6IE0gMzUwIDEyNCBMIDM1MCAyNTkgTCAzODMgMjU5IEwgMzgzIDEyNCBMIDM1MCAxMjQgeiAiIC8+Cjwvc3ZnPgo=');
    }
});
add_action(
    'enqueue_block_editor_assets',
    function () {
        global $post_type, $discordance_opts;
        if (in_array($post_type, $discordance_opts['types'])) {
            wp_enqueue_script(
                'discordance-block',
                plugins_url('/js/discordance.min.js', __FILE__),
                array('wp-blocks', 'wp-element'),
                filemtime(dirname(__FILE__) . '/js/discordance.min.js'),
                true
            );
        }
    }
);
add_action('transition_post_status', function ($newStatus, $oldStatus, $post) {
    global $discordance_opts;
    if (!in_array($post->post_type, $discordance_opts['types'])) {
        return;
    }
    if ($newStatus !== 'publish' || $newStatus === $oldStatus || wp_is_post_revision($post->ID)) {
        return;
    }
    add_action('wp_after_insert_post', function ($postID, $post, $update) {
        global $discordance_opts;
        if ($post->_discordance_checked && $post->_discordance_state !== 'publish') {
            $title = sanitize_text_field($post->post_title);
            $excerpt = sanitize_text_field(
                html_entity_decode(
                    (!empty($post->post_excerpt) ? $post->post_excerpt : $post->post_content)
                )
            );
            $tag_list = get_the_terms($postID, 'post_tag');
            if ($tag_list) {
                $tags = array_map(function ($tag) {
                    return $tag->name;
                }, $tag_list);
                $hashtags = array_map(function ($tag) {
                    return "#" . str_replace("-", "", $tag->slug);
                }, $tag_list);
            } else {
                $tags = [];
                $hashtags = [];
            }
            $categories = get_the_category($postID);
            $postType = get_post_type_object($post->post_type);
            $postTypeName = mb_strtolower($postType->labels->singular_name);
            $variables = array(
                '%author%' => get_the_author_meta('display_name', $post->post_author),
                '%author_url%' => get_the_author_meta('user_url', $post->post_author),
                '%gravatar%' => get_avatar_url($post->post_author, 96, 'retro'),
                '%title%' => trim(substr($title, 0, 248)) . (strlen($title) > 248 ? '[...]' : ''),
                '%excerpt%' => trim(substr($excerpt, 0, 512)) . (strlen($excerpt) > 512 ? '[...]' : ''),
                '%thumbnail%' => get_the_post_thumbnail_url($postID, 'thumbnail'),
                '%image%' => get_the_post_thumbnail_url($postID, 'large'),
                '%category%' => isset($categories[0]) ? mb_strtolower($categories[0]->name) : $postTypeName,
                '%hashtags%' => implode(" ", $hashtags),
                '%tags%' => implode(", ", $tags),
                '%link%' => get_permalink($postID),
                '%type%' => $postTypeName
            );
            if (function_exists('wc_get_product')) {
                $product = wc_get_product($postID);
                $variables = array_merge($variables, array(
                    '%price%' => $product->get_price(),
                ));
            }
            $embed = $discordance_opts['format'];
            foreach ($variables as $search => $replace) {
                $embed = html_entity_decode(str_replace($search, $replace, $embed));
            }
            $hooks = preg_split('/\r\n|\r|\n/', $discordance_opts['webhooks']);
            foreach ($hooks as $hook) {
                $url = trim($hook);
                if (preg_match('/^(https\:\/\/(www\.)?discord\.com\/api\/webhooks\/([0-9]+)\/([a-zA-Z0-9_-]+))/', $url)) {
                    $data = wp_remote_post($url, array(
                        'data_format' => 'body',
                        'headers' => array('Content-Type' => 'application/json'),
                        'body' => stripslashes($embed)
                    ));
                    if ($data['response']['code'] >= 300) {
                        error_log($data['body']);
                    }
                }
            }
            update_post_meta($post->ID, '_discordance_state', $post->post_status);
        }
    }, 10, 3);
}, 10, 3);
