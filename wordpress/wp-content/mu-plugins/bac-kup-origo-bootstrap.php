<?php
/**
 * Plugin Name: Bac-kup Origo Import Bootstrap
 * Description: Imports Origo pages into WordPress and configures the Bac-kup clone theme.
 */

if (!defined('ABSPATH')) {
    exit;
}

function bac_kup_origo_map(): array
{
    return [
        'index.html' => ['title' => 'Home', 'slug' => 'home', 'is_front' => true],
        'abonnementen.html' => ['title' => 'Abonnementen', 'slug' => 'abonnementen'],
        'werkwijze.html' => ['title' => 'Werkwijze', 'slug' => 'werkwijze'],
        'artsroute.html' => ['title' => 'Basiscontract & Arts-route', 'slug' => 'artsroute'],
        'tarieven.html' => ['title' => 'Tarieven', 'slug' => 'tarieven'],
        'overons.html' => ['title' => 'Over ons', 'slug' => 'overons'],
        'faq.html' => ['title' => 'FAQ', 'slug' => 'faq'],
        'contact.html' => ['title' => 'Contact', 'slug' => 'contact'],
        'privacyverklaring.html' => ['title' => 'Privacyverklaring', 'slug' => 'privacyverklaring'],
        'cookieverklaring.html' => ['title' => 'Cookieverklaring', 'slug' => 'cookieverklaring'],
        'disclaimer.html' => ['title' => 'Disclaimer', 'slug' => 'disclaimer'],
        'klachtenregeling.html' => ['title' => 'Klachtenregeling', 'slug' => 'klachtenregeling'],
        'algemene-voorwaarden.html' => ['title' => 'Algemene voorwaarden', 'slug' => 'algemene-voorwaarden'],
        'colofon.html' => ['title' => 'Colofon', 'slug' => 'colofon'],
    ];
}

function bac_kup_origo_url_replacements(): array
{
    return [
        'https://origo.care/index.html' => home_url('/'),
        'https://origo.care/' => home_url('/'),
        '/index.html' => home_url('/'),
        'index.html' => home_url('/'),
        '/abonnementen.html' => home_url('/abonnementen/'),
        'abonnementen.html' => home_url('/abonnementen/'),
        '/werkwijze.html' => home_url('/werkwijze/'),
        'werkwijze.html' => home_url('/werkwijze/'),
        '/artsroute.html' => home_url('/artsroute/'),
        'artsroute.html' => home_url('/artsroute/'),
        '/tarieven.html' => home_url('/tarieven/'),
        'tarieven.html' => home_url('/tarieven/'),
        '/overons.html' => home_url('/overons/'),
        'overons.html' => home_url('/overons/'),
        '/faq.html' => home_url('/faq/'),
        'faq.html' => home_url('/faq/'),
        '/contact.html' => home_url('/contact/'),
        'contact.html' => home_url('/contact/'),
        '/privacyverklaring.html' => home_url('/privacyverklaring/'),
        'privacyverklaring.html' => home_url('/privacyverklaring/'),
        '/cookieverklaring.html' => home_url('/cookieverklaring/'),
        'cookieverklaring.html' => home_url('/cookieverklaring/'),
        '/disclaimer.html' => home_url('/disclaimer/'),
        'disclaimer.html' => home_url('/disclaimer/'),
        '/klachtenregeling.html' => home_url('/klachtenregeling/'),
        'klachtenregeling.html' => home_url('/klachtenregeling/'),
        '/algemene-voorwaarden.html' => home_url('/algemene-voorwaarden/'),
        'algemene-voorwaarden.html' => home_url('/algemene-voorwaarden/'),
        '/colofon.html' => home_url('/colofon/'),
        'colofon.html' => home_url('/colofon/'),
        'logo.png' => get_template_directory_uri() . '/assets/img/logo-origo.png',
    ];
}

function bac_kup_origo_element_id(): string
{
    return substr(md5(uniqid((string) wp_rand(), true)), 0, 8);
}

function bac_kup_origo_merge_classes(string ...$classes): string
{
    $all = [];
    foreach ($classes as $class_line) {
        $class_line = trim($class_line);
        if ($class_line === '') {
            continue;
        }

        foreach (preg_split('/\s+/', $class_line) ?: [] as $class_item) {
            $class_item = trim($class_item);
            if ($class_item !== '') {
                $all[$class_item] = true;
            }
        }
    }

    return implode(' ', array_keys($all));
}

function bac_kup_origo_outer_html(\DOMNode $node): string
{
    return $node->ownerDocument ? $node->ownerDocument->saveHTML($node) : '';
}

function bac_kup_origo_inner_html(\DOMElement $element): string
{
    $html = '';
    foreach ($element->childNodes as $child) {
        $html .= bac_kup_origo_outer_html($child);
    }
    return $html;
}

function bac_kup_origo_class_name(\DOMElement $element): string
{
    $class = trim((string) $element->getAttribute('class'));
    return preg_replace('/\s+/', ' ', $class) ?: '';
}

function bac_kup_origo_is_button_anchor(\DOMElement $element): bool
{
    $class = ' ' . strtolower(bac_kup_origo_class_name($element)) . ' ';

    return str_contains($class, ' btn ')
        || str_contains($class, ' plan-btn ')
        || str_contains($class, ' nav-cta ')
        || str_contains($class, ' mob-cta ')
        || str_contains($class, ' svc-link ');
}

function bac_kup_origo_anchor_text(\DOMElement $element): string
{
    $text = trim(preg_replace('/\s+/', ' ', strip_tags(bac_kup_origo_inner_html($element))));
    return is_string($text) ? $text : '';
}

function bac_kup_origo_element_has_block_children(\DOMElement $element): bool
{
    foreach ($element->childNodes as $child) {
        if (!($child instanceof \DOMElement)) {
            continue;
        }

        $tag = strtolower($child->tagName);
        if (in_array($tag, ['section', 'div', 'article', 'main', 'ul', 'ol', 'table', 'blockquote'], true)) {
            return true;
        }
    }

    return false;
}

function bac_kup_origo_widget(string $type, array $settings = []): array
{
    $settings_class = isset($settings['_css_classes']) ? (string) $settings['_css_classes'] : '';
    $settings['_css_classes'] = bac_kup_origo_merge_classes($settings_class, 'bk-origo-widget');

    return [
        'id' => bac_kup_origo_element_id(),
        'elType' => 'widget',
        'widgetType' => $type,
        'isInner' => false,
        'settings' => empty($settings) ? [] : $settings,
        'elements' => [],
    ];
}

function bac_kup_origo_container(array $elements, string $class_name = '', bool $is_inner = false): array
{
    $is_wrap = trim($class_name) === '';
    $container_classes = $is_wrap
        ? bac_kup_origo_merge_classes($class_name, 'bk-origo-node', 'bk-origo-wrap')
        : bac_kup_origo_merge_classes($class_name, 'bk-origo-node');

    $settings = [
        'content_width' => 'full',
    ];

    $settings['_css_classes'] = $container_classes;
    $settings['css_classes'] = $container_classes;

    $class_l = ' ' . strtolower($class_name) . ' ';
    if (str_contains($class_l, ' banner ')) {
        $settings['background_background'] = 'gradient';
        $settings['background_color'] = '#3d8c7a';
        $settings['background_color_b'] = '#2d5a3d';
        $settings['background_gradient_type'] = 'linear';
        $settings['background_gradient_angle'] = [
            'unit' => 'deg',
            'size' => 90,
            'sizes' => [],
        ];
        $settings['padding'] = [
            'unit' => 'px',
            'top' => 11,
            'right' => 24,
            'bottom' => 11,
            'left' => 24,
            'isLinked' => false,
        ];
        $settings['justify_content'] = 'center';
        $settings['align_items'] = 'center';
        $settings['gap'] = [
            'unit' => 'px',
            'size' => 14,
            'sizes' => [],
        ];
        $settings['flex_wrap'] = 'wrap';
    }

    return [
        'id' => bac_kup_origo_element_id(),
        'elType' => 'container',
        'isInner' => $is_inner,
        'settings' => $settings,
        'elements' => $elements,
    ];
}

function bac_kup_origo_text_widget(string $html, string $class_name = ''): array
{
    $settings = [
        'editor' => $html,
    ];

    $settings['_css_classes'] = bac_kup_origo_merge_classes($class_name, 'bk-origo-text');

    return bac_kup_origo_widget('text-editor', $settings);
}

function bac_kup_origo_convert_children(\DOMNode $parent, array $replacements, bool $is_inner = true): array
{
    $elements = [];

    foreach ($parent->childNodes as $child) {
        $converted = bac_kup_origo_convert_node($child, $replacements, $is_inner);

        if (empty($converted)) {
            continue;
        }

        if (isset($converted['elType'])) {
            $elements[] = $converted;
            continue;
        }

        foreach ($converted as $item) {
            if (is_array($item) && isset($item['elType'])) {
                $elements[] = $item;
            }
        }
    }

    return $elements;
}

function bac_kup_origo_convert_node(\DOMNode $node, array $replacements, bool $is_inner = true): array
{
    if ($node instanceof \DOMComment) {
        return [];
    }

    if ($node instanceof \DOMText) {
        $text = trim(preg_replace('/\s+/', ' ', $node->wholeText ?? ''));
        if ($text === '') {
            return [];
        }

        return bac_kup_origo_text_widget('<p>' . esc_html($text) . '</p>');
    }

    if (!($node instanceof \DOMElement)) {
        return [];
    }

    $tag = strtolower($node->tagName);
    $class_name = bac_kup_origo_class_name($node);

    if (in_array($tag, ['script', 'style', 'noscript', 'meta', 'link'], true)) {
        return [];
    }

    if (in_array($tag, ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'], true)) {
        $settings = [
            'title' => bac_kup_origo_inner_html($node),
            'header_size' => $tag,
        ];

        if ($class_name !== '') {
            $settings['_css_classes'] = $class_name;
        }

        return bac_kup_origo_widget('heading', $settings);
    }

    if ($tag === 'p') {
        return bac_kup_origo_text_widget(bac_kup_origo_outer_html($node), $class_name);
    }

    if (in_array($tag, ['ul', 'ol', 'table', 'blockquote'], true)) {
        return bac_kup_origo_text_widget(bac_kup_origo_outer_html($node), $class_name);
    }

    if ($tag === 'span') {
        return bac_kup_origo_text_widget(bac_kup_origo_outer_html($node), $class_name);
    }

    if ($tag === 'svg') {
        $html = strtr(bac_kup_origo_outer_html($node), $replacements);

        return bac_kup_origo_widget('html', [
            'html' => $html,
            '_css_classes' => $class_name,
        ]);
    }

    if ($tag === 'img') {
        $src = trim((string) $node->getAttribute('src'));
        $alt = trim((string) $node->getAttribute('alt'));

        if ($src === '') {
            return [];
        }

        $src = strtr($src, $replacements);

        $settings = [
            'image' => [
                'url' => $src,
                'id' => 0,
            ],
            'image_size' => 'full',
            'link_to' => 'none',
        ];

        if ($alt !== '') {
            $settings['caption_source'] = 'none';
        }

        if ($class_name !== '') {
            $settings['_css_classes'] = $class_name;
        }

        return bac_kup_origo_widget('image', $settings);
    }

    if ($tag === 'a') {
        if (bac_kup_origo_is_button_anchor($node)) {
            $href = trim((string) $node->getAttribute('href'));
            $href = $href === '' ? '' : strtr($href, $replacements);
            $text = bac_kup_origo_anchor_text($node);

            return bac_kup_origo_widget('button', [
                'text' => $text !== '' ? $text : 'Meer info',
                'link' => [
                    'url' => $href,
                    'is_external' => '',
                    'nofollow' => '',
                ],
                'size' => 'sm',
                '_css_classes' => $class_name,
            ]);
        }

        return bac_kup_origo_text_widget(strtr(bac_kup_origo_outer_html($node), $replacements), $class_name);
    }

    if ($tag === 'div' && $class_name !== '' && !bac_kup_origo_element_has_block_children($node)) {
        $class_l = ' ' . strtolower($class_name) . ' ';
        $text = bac_kup_origo_anchor_text($node);
        if ($text !== '' && (str_contains($class_l, ' title ') || str_contains($class_l, ' h2 ') || str_contains($class_l, ' h1 '))) {
            return bac_kup_origo_widget('heading', [
                'title' => esc_html($text),
                'header_size' => str_contains($class_l, ' h1 ') ? 'h1' : (str_contains($class_l, ' h2 ') ? 'h2' : 'h3'),
                '_css_classes' => $class_name,
            ]);
        }
    }

    if (in_array($tag, ['section', 'div', 'article', 'main'], true)) {
        $children = bac_kup_origo_convert_children($node, $replacements, true);

        if (empty($children)) {
            if ($class_name !== '') {
                return bac_kup_origo_widget('html', [
                    'html' => strtr(bac_kup_origo_outer_html($node), $replacements),
                    '_css_classes' => $class_name,
                ]);
            }

            return [];
        }

        if ($class_name === '' && count($children) === 1) {
            return $children[0];
        }

        return bac_kup_origo_container($children, $class_name, $is_inner);
    }

    $html = strtr(bac_kup_origo_outer_html($node), $replacements);
    return bac_kup_origo_widget('html', [
        'html' => $html,
        '_css_classes' => $class_name,
    ]);
}

function bac_kup_origo_build_elementor_data(string $body_html, array $replacements): array
{
    $sections = [];

    if (class_exists('DOMDocument')) {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        libxml_use_internal_errors(true);
        $html = '<!doctype html><html><body>' . $body_html . '</body></html>';
        $loaded = $dom->loadHTML('<?xml encoding="utf-8" ?>' . $html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        if ($loaded) {
            $body = $dom->getElementsByTagName('body')->item(0);
            if ($body instanceof \DOMElement) {
                foreach ($body->childNodes as $child) {
                    if ($child instanceof \DOMComment) {
                        continue;
                    }
                    if ($child instanceof \DOMText && trim((string) $child->wholeText) === '') {
                        continue;
                    }

                    $converted = bac_kup_origo_convert_node($child, $replacements, false);
                    if (empty($converted)) {
                        continue;
                    }

                    $elements = [];
                    if (isset($converted['elType'])) {
                        $elements[] = $converted;
                    } else {
                        foreach ($converted as $item) {
                            if (is_array($item) && isset($item['elType'])) {
                                $elements[] = $item;
                            }
                        }
                    }

                    if (empty($elements)) {
                        continue;
                    }

                    $section_classes = '';
                    if ($child instanceof \DOMElement) {
                        $child_classes = ' ' . bac_kup_origo_class_name($child) . ' ';
                        if (str_contains($child_classes, ' hero ')) {
                            $section_classes = 'bk-top-hero-section';
                        }
                    }

                    $section_settings = [
                        'layout' => 'full_width',
                        'content_width' => 'full',
                        'stretch_section' => 'section-stretched',
                        'gap' => 'no',
                    ];

                    if ($section_classes !== '') {
                        $section_settings['_css_classes'] = $section_classes;
                        $section_settings['css_classes'] = $section_classes;
                    }

                    $sections[] = [
                        'id' => bac_kup_origo_element_id(),
                        'elType' => 'section',
                        'isInner' => false,
                        'settings' => $section_settings,
                        'elements' => [
                            [
                                'id' => bac_kup_origo_element_id(),
                                'elType' => 'column',
                                'isInner' => false,
                                'settings' => [
                                    '_column_size' => 100,
                                    '_inline_size' => null,
                                ],
                                'elements' => $elements,
                            ],
                        ],
                    ];
                }
            }
        }
    }

    if (empty($sections)) {
        $sections[] = [
            'id' => bac_kup_origo_element_id(),
            'elType' => 'section',
            'isInner' => false,
            'settings' => [
                'layout' => 'full_width',
                'content_width' => 'full',
                'stretch_section' => 'section-stretched',
                'gap' => 'no',
            ],
            'elements' => [
                [
                    'id' => bac_kup_origo_element_id(),
                    'elType' => 'column',
                    'isInner' => false,
                    'settings' => [
                        '_column_size' => 100,
                        '_inline_size' => null,
                    ],
                    'elements' => [
                        bac_kup_origo_widget('text-editor', [
                            'editor' => strtr($body_html, $replacements),
                            '_css_classes' => 'bk-origo-block',
                        ]),
                    ],
                ],
            ],
        ];
    }

    return $sections;
}

function bac_kup_origo_extract_body(string $raw_html): string
{
    $body = '';
    if (preg_match('~<body[^>]*>(.*)</body>~is', $raw_html, $body_match)) {
        $body = $body_match[1];
    }

    if ($body === '') {
        return '';
    }

    $body = preg_replace('~<script\b[^>]*>.*?</script>~is', '', $body);
    return is_string($body) ? trim($body) : '';
}

function bac_kup_origo_extract_css(string $raw_html): string
{
    $custom_css = '';
    if (preg_match_all('~<style[^>]*>(.*?)</style>~is', $raw_html, $css_matches)) {
        $custom_css = implode("\n\n", $css_matches[1]);
    }

    return is_string($custom_css) ? trim($custom_css) : '';
}

function bac_kup_origo_sanitize_element_settings(array &$node): void
{
    if (!isset($node['settings']) || !is_array($node['settings'])) {
        return;
    }

    $css_classes = (string) ($node['settings']['_css_classes'] ?? $node['settings']['css_classes'] ?? '');
    $class_l = ' ' . strtolower($css_classes) . ' ';
    $is_banner = str_contains($class_l, ' banner ');

    $remove_keys = [
        'background_background',
        'background_color',
        'background_image',
        'background_repeat',
        'background_size',
        'background_position',
        'background_attachment',
        'background_overlay_background',
        'background_overlay_color',
    ];

    if ($is_banner) {
        $remove_keys = [
            'background_image',
            'background_repeat',
            'background_size',
            'background_position',
            'background_attachment',
            'background_overlay_background',
            'background_overlay_color',
        ];
    }

    foreach ($remove_keys as $key) {
        unset($node['settings'][$key]);
    }
}

function bac_kup_origo_sanitize_elementor_tree(array &$nodes): void
{
    foreach ($nodes as &$node) {
        if (!is_array($node)) {
            continue;
        }

        bac_kup_origo_sanitize_element_settings($node);

        if (isset($node['elements']) && is_array($node['elements'])) {
            bac_kup_origo_sanitize_elementor_tree($node['elements']);
        }
    }
    unset($node);
}

function bac_kup_origo_import_execute(bool $force = false): void
{
    if (!$force && get_option('bac_kup_origo_imported') === '1') {
        return;
    }

    $source_dir = WP_CONTENT_DIR . '/origo-source/pages';
    if (!is_dir($source_dir)) {
        return;
    }

    require_once ABSPATH . 'wp-admin/includes/plugin.php';

    $plugins_to_activate = [
        'sqlite-database-integration/load.php',
        'elementor/elementor.php',
    ];

    foreach ($plugins_to_activate as $plugin_file) {
        if (file_exists(WP_PLUGIN_DIR . '/' . $plugin_file) && !is_plugin_active($plugin_file)) {
            activate_plugin($plugin_file, '', false, true);
        }
    }

    if (wp_get_theme('bac-kup-origo')->exists()) {
        switch_theme('bac-kup-origo');
    }

    $map = bac_kup_origo_map();
    $replacements = bac_kup_origo_url_replacements();
    $home_page_id = 0;

    foreach ($map as $file => $page) {
        $path = $source_dir . '/' . $file;
        if (!file_exists($path)) {
            continue;
        }

        $raw_html = file_get_contents($path);
        if (!is_string($raw_html) || $raw_html === '') {
            continue;
        }

        $body = bac_kup_origo_extract_body($raw_html);
        if ($body === '') {
            continue;
        }

        $body = strtr($body, $replacements);
        $custom_css = bac_kup_origo_extract_css($raw_html);
        $elementor_data = bac_kup_origo_build_elementor_data($body, $replacements);
        bac_kup_origo_sanitize_elementor_tree($elementor_data);

        $existing = get_page_by_path($page['slug'], OBJECT, 'page');
        $postarr = [
            'post_type' => 'page',
            'post_status' => 'publish',
            'post_title' => $page['title'],
            'post_name' => $page['slug'],
            'post_content' => '',
        ];

        if ($existing instanceof WP_Post) {
            $postarr['ID'] = $existing->ID;
            $post_id = wp_update_post($postarr, true);
        } else {
            $post_id = wp_insert_post($postarr, true);
        }

        if (is_wp_error($post_id) || !$post_id) {
            continue;
        }

        update_post_meta($post_id, '_bac_kup_page_css', $custom_css);
        update_post_meta($post_id, '_wp_page_template', 'default');
        update_post_meta($post_id, '_elementor_data', wp_slash(wp_json_encode($elementor_data)));
        update_post_meta($post_id, '_elementor_edit_mode', 'builder');
        update_post_meta($post_id, '_elementor_template_type', 'wp-page');
        update_post_meta($post_id, '_elementor_version', defined('ELEMENTOR_VERSION') ? ELEMENTOR_VERSION : '');
        delete_post_meta($post_id, '_elementor_element_cache');
        delete_post_meta($post_id, '_elementor_css');
        delete_post_meta($post_id, '_elementor_page_assets');

        if (!empty($page['is_front'])) {
            $home_page_id = (int) $post_id;
        }
    }

    if ($home_page_id > 0) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', $home_page_id);
    }

    update_option('permalink_structure', '/%postname%/');
    flush_rewrite_rules(false);

    update_option('blogdescription', 'Procesregie voor verzuim | MKB');
    update_option('bac_kup_origo_imported', '1');

    // Clear generated CSS so Elementor regenerates after structural changes.
    $css_dir = WP_CONTENT_DIR . '/uploads/elementor/css';
    if (is_dir($css_dir)) {
        foreach (glob($css_dir . '/*.css') ?: [] as $file_path) {
            @unlink($file_path);
        }
    }

    if (class_exists('\\Elementor\\Plugin')) {
        \Elementor\Plugin::$instance->files_manager->clear_cache();
    }
}

add_action('admin_init', function (): void {
    if (!current_user_can('manage_options')) {
        return;
    }

    $force = isset($_GET['bac_kup_rebuild_widgets']) && $_GET['bac_kup_rebuild_widgets'] === '1';
    bac_kup_origo_import_execute($force);
});
