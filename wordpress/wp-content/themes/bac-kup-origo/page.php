<?php
if (!defined('ABSPATH')) {
    exit;
}

get_header();

if (have_posts()) {
    while (have_posts()) {
        the_post();
        $is_elementor = class_exists('\Elementor\Plugin') && \Elementor\Plugin::$instance->db->is_built_with_elementor(get_the_ID());
        if ($is_elementor) {
            echo \Elementor\Plugin::$instance->frontend->get_builder_content(get_the_ID(), true);
        } else {
            echo apply_filters('the_content', get_the_content());
        }
    }
}

get_footer();
