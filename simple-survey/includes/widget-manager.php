<?php

// simple-survey/includes/widget-manager.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

function register_elementor_survey_widget($widgets_manager)
{
    require_once(__DIR__ . '/survey_widget.php');
    $widgets_manager->register(new \Elementor_Survey_Widget());
}

add_action('elementor/widgets/register', 'register_elementor_survey_widget');
