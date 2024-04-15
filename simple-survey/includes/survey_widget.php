<?php

// simple-survey/includes/survey_widget.php

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

        echo '<div class="elementor-survey">';

        foreach ($settings['questions_list'] as $index => $question) {
            $display_style = $index === 0 ? 'block' : 'none';
            echo '<div class="elementor-survey__question" style="display: ' . $display_style . ';">';

            // Question Image
            if (!empty($question['question_image']['url'])) {
                echo '<img src="' . esc_url($question['question_image']['url']) . '" alt="" class="question-image">';
            }

            // Question Text
            echo '<h4>' . esc_html($question['question_text']) . '</h4>';

            // Yes/No Buttons with redirect URLs and decisiveness
            $yes_redirect_url = !empty($question['yes_redirect_url']['url']) ? $question['yes_redirect_url']['url'] : '#';
            $no_redirect_url = !empty($question['no_redirect_url']['url']) ? $question['no_redirect_url']['url'] : '#';
            $is_decisive = !empty($question['is_decisive']) && $question['is_decisive'] === 'yes' ? 'yes' : 'no';

            echo '<button type="button" class="yes-btn" data-index="' . $index . '" data-redirect-url="' . esc_url($yes_redirect_url) . '" data-importance="' . esc_attr($question['yes_answer_importance']) . '">' . esc_html($question['custom_yes_button_text']) . '</button>';
            echo '<button type="button" class="no-btn" data-redirect-url="' . esc_url($no_redirect_url) . '" data-importance="' . esc_attr($question['no_answer_importance']) . '">' . esc_html($question['custom_no_button_text']) . '</button>';

            // Previous Button as an elegant arrow
            if ($index > 0) {
                echo '<div class="survey-prev-btn">&#8592;</div>';
            }

            echo '</div>'; // End of .elementor-survey__question
        }

        echo '</div>'; // End of .elementor-survey
    }
}
