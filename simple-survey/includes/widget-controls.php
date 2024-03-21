<?php

function register_survey_widget_controls($widget)
{
    // Alignment control for the entire form
    $widget->start_controls_section(
        'form_layout_section',
        [
            'label' => __('Form Layout', 'simple-survey'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]
    );

    $widget->add_control(
        'form_alignment',
        [
            'label' => __('Alignment', 'simple-survey'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
                'left' => [
                    'title' => __('Left', 'simple-survey'),
                    'icon' => 'eicon-text-align-left',
                ],
                'center' => [
                    'title' => __('Center', 'simple-survey'),
                    'icon' => 'eicon-text-align-center',
                ],
                'right' => [
                    'title' => __('Right', 'simple-survey'),
                    'icon' => 'eicon-text-align-right',
                ],
            ],
            'default' => 'center',
            'selectors' => [
                '{{WRAPPER}} .elementor-survey' => 'text-align: {{VALUE}};',
            ],
        ]
    );

    $widget->end_controls_section();

    $widget->start_controls_section(
        'survey_questions_section',
        [
            'label' => __('Survey Questions', 'simple-survey'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]
    );

    $questions_repeater = new \Elementor\Repeater();

    $questions_repeater->add_control(
        'question_text',
        [
            'label' => __('Question', 'simple-survey'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __('Enter your question here', 'simple-survey'),
            'label_block' => true,
        ]
    );

    $questions_repeater->add_control(
        'question_image',
        [
            'label' => __('Question Image', 'simple-survey'),
            'type' => \Elementor\Controls_Manager::MEDIA,
            'dynamic' => [
                'active' => true,
            ],
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
            'label_block' => true,
        ]
    );

    // Render "Yes" button for each question:
    $questions_repeater->add_control(
        'yes_redirect_url',
        [
            'label' => __('Yes Button Redirect URL', 'simple-survey'),
            'type' => \Elementor\Controls_Manager::URL,
            'label_block' => true,
            'description' => __('Set the redirect URL for the "Yes" button.', 'simple-survey'),
            'dynamic' => [
                'active' => true,
            ],
        ]
    );

    // Render "No" button for each question:
    $questions_repeater->add_control(
        'no_redirect_url',
        [
            'label' => __('No Button Redirect URL', 'simple-survey'),
            'type' => \Elementor\Controls_Manager::URL,
            'label_block' => true,
            'description' => __('Set the redirect URL for the "No" button.', 'simple-survey'),
            'dynamic' => [
                'active' => true,
            ],
        ]
    );

    $widget->add_control(
        'questions_list',
        [
            'label' => __('Questions', 'simple-survey'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $questions_repeater->get_controls(),
            'title_field' => '{{{ question_text }}}',
        ]
    );


    $widget->end_controls_section();

    /**
     * Styles Controls
     */

    $widget->start_controls_section(
        'style_section',
        [
            'label' => __('Text Style', 'simple-survey'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );

    // Add a typography control for the questions
    $widget->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'questions_typography', // Unique name for the control
            'label' => __('Questions Typography', 'simple-survey'),
            'selector' => '{{WRAPPER}} .elementor-survey__question h4', // CSS selector to target the questions
        ]
    );

    // Add a color control for the questions
    $widget->add_control(
        'questions_color',
        [
            'label' => __('Questions Color', 'simple-survey'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .elementor-survey__question h4' => 'color: {{VALUE}};',
            ],
        ]
    );

    $widget->end_controls_section();

    // Button Style Section
    $widget->start_controls_section(
        'yes_no_buttons_style',
        [
            'label' => __('Yes/No Buttons Style', 'simple-survey'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );


    // Button Typography
    $widget->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'buttons_typography',
            'selector' => '{{WRAPPER}} .yes-btn, {{WRAPPER}} .no-btn',
        ]
    );

    // Button Padding
    $widget->add_control(
        'buttons_padding',
        [
            'label' => __('Padding', 'simple-survey'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .yes-btn, {{WRAPPER}} .no-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    // Button Shadow
    $widget->add_group_control(
        \Elementor\Group_Control_Box_Shadow::get_type(),
        [
            'name' => 'buttons_box_shadow',
            'label' => __('Box Shadow', 'simple-survey'),
            'selector' => '{{WRAPPER}} .yes-btn, {{WRAPPER}} .no-btn',
        ]
    );

    // Button Margin
    $widget->add_control(
        'buttons_margin',
        [
            'label' => __('Margin', 'simple-survey'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .yes-btn, {{WRAPPER}} .no-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    // Button Text Color
    $widget->add_control(
        'buttons_text_color',
        [
            'label' => __('Text Color', 'simple-survey'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .yes-btn, {{WRAPPER}} .no-btn' => 'color: {{VALUE}};',
            ],
        ]
    );

    // Button Border
    $widget->add_group_control(
        \Elementor\Group_Control_Border::get_type(),
        [
            'name' => 'buttons_border',
            'label' => __('Border', 'simple-survey'),
            'selector' => '{{WRAPPER}} .yes-btn, {{WRAPPER}} .no-btn',
        ]
    );

    // Button Border Radius
    $widget->add_control(
        'buttons_border_radius',
        [
            'label' => __('Border Radius', 'simple-survey'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .yes-btn, {{WRAPPER}} .no-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );


    // Button Background Color
    $widget->add_control(
        'buttons_background_color',
        [
            'label' => __('Background Color', 'simple-survey'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .yes-btn, {{WRAPPER}} .no-btn' => 'background-color: {{VALUE}};',
            ],
        ]
    );

    // Button Hover Background Color
    $widget->add_control(
        'buttons_hover_background_color',
        [
            'label' => __('Hover Background Color', 'simple-survey'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .yes-btn:hover, {{WRAPPER}} .no-btn:hover' => 'background-color: {{VALUE}};', // Use :hover pseudo-class
            ],
        ]
    );

    // Button Hover Text Color
    $widget->add_control(
        'buttons_hover_text_color',
        [
            'label' => __('Hover Text Color', 'simple-survey'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .yes-btn:hover, {{WRAPPER}} .no-btn:hover' => 'color: {{VALUE}};', // Use :hover pseudo-class
            ],
        ]
    );

    $widget->end_controls_section();

    $widget->start_controls_section(
        'images_style_section',
        [
            'label' => __('Question Images Style', 'simple-survey'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );

    // Image Margin
    $widget->add_control(
        'images_margin',
        [
            'label' => __('Margin', 'simple-survey'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .question-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    // Image Width Control
    $widget->add_control(
        'image_width',
        [
            'label' => __('Width', 'simple-survey'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', '%', 'vw'], // Ensure units are appropriate
            'selectors' => [
                '{{WRAPPER}} .question-image' => 'width: {{SIZE}}{{UNIT}};', // Ensure the selector matches your HTML structure
            ],
        ]
    );

    // Space Between Image and Question Text
    $widget->add_control(
        'image_text_spacing',
        [
            'label' => __('Space Between Image and Text', 'simple-survey'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
                '%' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .elementor-survey__question h4' => 'margin-top: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $widget->end_controls_section();
}
