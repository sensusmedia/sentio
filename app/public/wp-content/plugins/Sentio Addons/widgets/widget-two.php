<?php
namespace Sentio;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Color;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class WidgetTwo extends Widget_Base
{
    public function get_name()
    {
        return 'sentio-widget-two';
    }

    public function get_title()
    {
        return __('Sentio Widget Two', 'sentio-addons');
    }

    public function get_icon()
    {
        return 'eicon-heart';
    }

    public function get_categories()
    {
        return ['sentio'];
    }

    protected function _register_controls()
    {
        // Content section
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Content', 'sentio-addons'),
            ]
        );

        $this->add_control(
            'content',
            [
                'label' => __('Content', 'sentio-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Default content for Widget Two', 'sentio-addons'),
            ]
        );

        $this->end_controls_section();

        // Style section
        $this->start_controls_section(
            'section_style',
            [
                'label' => __('Style', 'sentio-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // Typography Control
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'label' => __('Typography', 'sentio-addons'),
                'selector' => '{{WRAPPER}} .widget-two-content',
            ]
        );

        // Text Color Control
        $this->add_control(
            'content_color',
            [
                'label' => __('Text Color', 'sentio-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .widget-two-content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        echo '<div class="widget-two-content" style="color: ' . esc_attr($settings['content_color']) . ';">' . esc_html($settings['content']) . '</div>';
    }

    protected function _content_template()
    {
        ?>
        <div class="widget-two-content" style="color: {{{ settings.content_color }}};">{{{ settings.content }}}</div>
        <?php
    }
}
