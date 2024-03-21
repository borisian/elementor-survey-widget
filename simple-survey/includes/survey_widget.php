<?php
include_once plugin_dir_path(__FILE__) . 'widget-controls.php';

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly to ensure security
}

class Elementor_Survey_Widget extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'elementor_survey';
    }

    public function get_title()
    {
        return __('Survey', 'simple-survey');
    }

    public function get_icon()
    {
        return 'eicon-form-horizontal';
    }

    public function get_categories()
    {
        return ['general'];
    }

    protected function _register_controls()
    {
        register_survey_widget_controls($this);
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        if (!empty($settings)) {
            wp_enqueue_script('my-elementor-widget-script');
        }

        echo '<div class="elementor-survey">';

        foreach ($settings['questions_list'] as $index => $question) {
            $display_style = $index === 0 ? 'block' : 'none';
            echo '<div class="elementor-survey__question" style="display: ' . $display_style . ';">';
            if (!empty($question['question_image']['url'])) {
                echo '<img src="' . esc_url($question['question_image']['url']) . '" alt="" class="question-image">';
            }
            echo '<h4>' . esc_html($question['question_text']) . '</h4>';

            // Yes/No buttons
            $yes_redirect_url = !empty($question['yes_redirect_url']['url']) ? $question['yes_redirect_url']['url'] : '#';
            $no_redirect_url = !empty($question['no_redirect_url']['url']) ? $question['no_redirect_url']['url'] : '#';
            echo '<button type="button" class="yes-btn" data-index="' . $index . '" data-redirect-url="' . esc_url($yes_redirect_url) . '">Yes</button>';
            echo '<button type="button" class="no-btn" data-redirect-url="' . esc_url($no_redirect_url) . '">No</button>';

            if ($index > 0) {
                echo '<div class="survey-prev-btn">&#8592;</div>'; // Using the left arrow character as the "Previous" button
            }

            echo '</div>';
        }

        echo '</div>';
    }
}