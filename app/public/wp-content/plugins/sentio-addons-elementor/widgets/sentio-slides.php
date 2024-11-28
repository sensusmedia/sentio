<?php
namespace SentioAddon\Widgets;

use Elementor\Widget_Base;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Controls_Manager;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class Sentio_Slides extends \Elementor\Widget_Base {

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.1.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'sentio-slides';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.1.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Sentio Slides', 'sentio-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.1.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'fa fa-pencil';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.1.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'sentio-addon' ];
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.1.0
	 *
	 * @access protected
	 */
	public function get_keywords() {
		return [ 'slides', 'carousel', 'image', 'title', 'slider' ];
	}

	public function get_script_depends() {
		return [ 'imagesloaded' ];
	}

	public static function get_button_sizes() {
		return [
			'xs' => __( 'Extra Small', 'sentio-addons' ),
			'sm' => __( 'Small', 'sentio-addons' ),
			'md' => __( 'Medium', 'sentio-addons' ),
			'lg' => __( 'Large', 'sentio-addons' ),
			'xl' => __( 'Extra Large', 'sentio-addons' ),
		];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_slides',
			[
				'label' => __( 'Sentio Slides', 'sentio-addons' ),
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'slides_repeater' );

		$repeater->start_controls_tab( 'background', [ 'label' => __( 'Background', 'sentio-addons' ) ] );

		$repeater->add_control(
			'background_color',
			[
				'label' => __( 'Color', 'sentio-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#bbbbbb',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .swiper-slide-bg' => 'background-color: {{VALUE}}',
				],
			]
		);

		$repeater->add_control(
			'background_image',
			[
				'label' => _x( 'Image', 'Background Control', 'sentio-addons' ),
				'type' => Controls_Manager::MEDIA,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .swiper-slide-bg' => 'background-image: url({{URL}})',
				],
			]
		);

		$repeater->add_control(
			'background_size',
			[
				'label' => _x( 'Size', 'Background Control', 'sentio-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'cover',
				'options' => [
					'cover' => _x( 'Cover', 'Background Control', 'sentio-addons' ),
					'contain' => _x( 'Contain', 'Background Control', 'sentio-addons' ),
					'auto' => _x( 'Auto', 'Background Control', 'sentio-addons' ),
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .swiper-slide-bg' => 'background-size: {{VALUE}}',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'background_image[url]',
							'operator' => '!=',
							'value' => '',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'background_ken_burns',
			[
				'label' => __( 'Ken Burns Effect', 'sentio-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'conditions' => [
					'terms' => [
						[
							'name' => 'background_image[url]',
							'operator' => '!=',
							'value' => '',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'zoom_direction',
			[
				'label' => __( 'Zoom Direction', 'sentio-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'in',
				'options' => [
					'in' => __( 'In', 'sentio-addons' ),
					'out' => __( 'Out', 'sentio-addons' ),
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'background_ken_burns',
							'operator' => '!=',
							'value' => '',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'background_overlay',
			[
				'label' => __( 'Background Overlay', 'sentio-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'conditions' => [
					'terms' => [
						[
							'name' => 'background_image[url]',
							'operator' => '!=',
							'value' => '',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'background_overlay_color',
			[
				'label' => __( 'Color', 'sentio-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgba(0,0,0,0.5)',
				'conditions' => [
					'terms' => [
						[
							'name' => 'background_overlay',
							'value' => 'yes',
						],
					],
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .elementor-background-overlay' => 'background-color: {{VALUE}}',
				],
			]
		);

		$repeater->add_control(
			'background_overlay_blend_mode',
			[
				'label' => __( 'Blend Mode', 'sentio-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => __( 'Normal', 'sentio-addons' ),
					'multiply' => 'Multiply',
					'screen' => 'Screen',
					'overlay' => 'Overlay',
					'darken' => 'Darken',
					'lighten' => 'Lighten',
					'color-dodge' => 'Color Dodge',
					'color-burn' => 'Color Burn',
					'hue' => 'Hue',
					'saturation' => 'Saturation',
					'color' => 'Color',
					'exclusion' => 'Exclusion',
					'luminosity' => 'Luminosity',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'background_overlay',
							'value' => 'yes',
						],
					],
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .elementor-background-overlay' => 'mix-blend-mode: {{VALUE}}',
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab( 'content', [ 'label' => __( 'Content', 'sentio-addons' ) ] );

		$repeater->add_control(
			'heading',
			[
				'label' => __( 'Title & Description', 'sentio-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Slide Heading', 'sentio-addons' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'description',
			[
				'label' => __( 'Description', 'sentio-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'sentio-addons' ),
				'show_label' => false,
			]
		);

		$repeater->add_control(
			'button_text',
			[
				'label' => __( 'Button Text', 'sentio-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Click Here', 'sentio-addons' ),
			]
		);

		$repeater->add_control(
			'link',
			[
				'label' => __( 'Link', 'sentio-addons' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'sentio-addons' ),
			]
		);

		$repeater->add_control(
			'link_click',
			[
				'label' => __( 'Apply Link On', 'sentio-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'slide' => __( 'Whole Slide', 'sentio-addons' ),
					'button' => __( 'Button Only', 'sentio-addons' ),
				],
				'default' => 'slide',
				'conditions' => [
					'terms' => [
						[
							'name' => 'link[url]',
							'operator' => '!=',
							'value' => '',
						],
					],
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab( 'style', [ 'label' => __( 'Style', 'sentio-addons' ) ] );

		$repeater->add_control(
			'custom_style',
			[
				'label' => __( 'Custom', 'sentio-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'description' => __( 'Set custom style that will only affect this specific slide.', 'sentio-addons' ),
			]
		);

		$repeater->add_control(
			'horizontal_position',
			[
				'label' => __( 'Horizontal Position', 'sentio-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'sentio-addons' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'sentio-addons' ),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'sentio-addons' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .swiper-slide-contents' => '{{VALUE}}',
				],
				'selectors_dictionary' => [
					'left' => 'margin-right: auto',
					'center' => 'margin: 0 auto',
					'right' => 'margin-left: auto',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'vertical_position',
			[
				'label' => __( 'Vertical Position', 'sentio-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'top' => [
						'title' => __( 'Top', 'sentio-addons' ),
						'icon' => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => __( 'Middle', 'sentio-addons' ),
						'icon' => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => __( 'Bottom', 'sentio-addons' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .swiper-slide-inner' => 'align-items: {{VALUE}}',
				],
				'selectors_dictionary' => [
					'top' => 'flex-start',
					'middle' => 'center',
					'bottom' => 'flex-end',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'text_align',
			[
				'label' => __( 'Text Align', 'sentio-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'sentio-addons' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'sentio-addons' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'sentio-addons' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .swiper-slide-inner' => 'text-align: {{VALUE}}',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'content_color',
			[
				'label' => __( 'Content Color', 'sentio-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .swiper-slide-inner .elementor-slide-heading' => 'color: {{VALUE}}',
					'{{WRAPPER}} {{CURRENT_ITEM}} .swiper-slide-inner .elementor-slide-description' => 'color: {{VALUE}}',
					'{{WRAPPER}} {{CURRENT_ITEM}} .swiper-slide-inner .elementor-slide-button' => 'color: {{VALUE}}; border-color: {{VALUE}}',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'repeater_text_shadow',
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .swiper-slide-contents',
				'conditions' => [
					'terms' => [
						[
							'name' => 'custom_style',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'slides',
			[
				'label' => __( 'Slides', 'sentio-addons' ),
				'type' => Controls_Manager::REPEATER,
				'show_label' => true,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'heading' => __( 'Slide 1 Heading', 'sentio-addons' ),
						'description' => __( 'Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'sentio-addons' ),
						'button_text' => __( 'Click Here', 'sentio-addons' ),
						'background_color' => '#833ca3',
					],
					[
						'heading' => __( 'Slide 2 Heading', 'sentio-addons' ),
						'description' => __( 'Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'sentio-addons' ),
						'button_text' => __( 'Click Here', 'sentio-addons' ),
						'background_color' => '#4054b2',
					],
					[
						'heading' => __( 'Slide 3 Heading', 'sentio-addons' ),
						'description' => __( 'Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'sentio-addons' ),
						'button_text' => __( 'Click Here', 'sentio-addons' ),
						'background_color' => '#1abc9c',
					],
				],
				'title_field' => '{{{ heading }}}',
			]
		);

		$this->add_responsive_control(
			'slides_height',
			[
				'label' => __( 'Height', 'sentio-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 1000,
					],
					'vh' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'default' => [
					'size' => 400,
				],
				'size_units' => [ 'px', 'vh', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .swiper-slide' => 'height: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_slider_options',
			[
				'label' => __( 'Slider Options', 'sentio-addons' ),
				'type' => Controls_Manager::SECTION,
			]
		);

		$this->add_control(
			'navigation',
			[
				'label' => __( 'Navigation', 'sentio-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'both',
				'options' => [
					'both' => __( 'Arrows and Dots', 'sentio-addons' ),
					'arrows' => __( 'Arrows', 'sentio-addons' ),
					'dots' => __( 'Dots', 'sentio-addons' ),
					'none' => __( 'None', 'sentio-addons' ),
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label' => __( 'Autoplay', 'sentio-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'pause_on_hover',
			[
				'label' => __( 'Pause on Hover', 'sentio-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'frontend_available' => true,
				'condition' => [
					'autoplay!' => '',
				],
			]
		);

		$this->add_control(
			'pause_on_interaction',
			[
				'label' => __( 'Pause on Interaction', 'sentio-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'frontend_available' => true,
				'condition' => [
					'autoplay!' => '',
				],
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label' => __( 'Autoplay Speed', 'sentio-addons' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 5000,
				'condition' => [
					'autoplay' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-slide' => 'transition-duration: calc({{VALUE}}ms*1.2)',
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'infinite',
			[
				'label' => __( 'Infinite Loop', 'sentio-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'transition',
			[
				'label' => __( 'Transition', 'sentio-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'slide',
				'options' => [
					'slide' => __( 'Slide', 'sentio-addons' ),
					'fade' => __( 'Fade', 'sentio-addons' ),
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'transition_speed',
			[
				'label' => __( 'Transition Speed', 'sentio-addons' ) . ' (ms)',
				'type' => Controls_Manager::NUMBER,
				'default' => 500,
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'content_animation',
			[
				'label' => __( 'Content Animation', 'sentio-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'fadeInUp',
				'options' => [
					'' => __( 'None', 'sentio-addons' ),
					'fadeInDown' => __( 'Down', 'sentio-addons' ),
					'fadeInUp' => __( 'Up', 'sentio-addons' ),
					'fadeInRight' => __( 'Right', 'sentio-addons' ),
					'fadeInLeft' => __( 'Left', 'sentio-addons' ),
					'zoomIn' => __( 'Zoom', 'sentio-addons' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_slides',
			[
				'label' => __( 'Slides', 'sentio-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'content_max_width',
			[
				'label' => __( 'Content Width', 'sentio-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units' => [ '%', 'px' ],
				'default' => [
					'size' => '66',
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-slide-contents' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'slides_padding',
			[
				'label' => __( 'Padding', 'sentio-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .swiper-slide-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'slides_horizontal_position',
			[
				'label' => __( 'Horizontal Position', 'sentio-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'default' => 'center',
				'options' => [
					'left' => [
						'title' => __( 'Left', 'sentio-addons' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'sentio-addons' ),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'sentio-addons' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'prefix_class' => 'elementor--h-position-',
			]
		);

		$this->add_control(
			'slides_vertical_position',
			[
				'label' => __( 'Vertical Position', 'sentio-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'default' => 'middle',
				'options' => [
					'top' => [
						'title' => __( 'Top', 'sentio-addons' ),
						'icon' => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => __( 'Middle', 'sentio-addons' ),
						'icon' => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => __( 'Bottom', 'sentio-addons' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'prefix_class' => 'elementor--v-position-',
			]
		);

		$this->add_control(
			'slides_text_align',
			[
				'label' => __( 'Text Align', 'sentio-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'sentio-addons' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'sentio-addons' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'sentio-addons' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .swiper-slide-inner' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'text_shadow',
				'selector' => '{{WRAPPER}} .swiper-slide-contents',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_title',
			[
				'label' => __( 'Title', 'sentio-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_spacing',
			[
				'label' => __( 'Spacing', 'sentio-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-slide-inner .elementor-slide-heading:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label' => __( 'Text Color', 'sentio-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-slide-heading' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'heading_typography',
				'scheme' => Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .elementor-slide-heading',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_description',
			[
				'label' => __( 'Description', 'sentio-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'description_spacing',
			[
				'label' => __( 'Spacing', 'sentio-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-slide-inner .elementor-slide-description:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'description_color',
			[
				'label' => __( 'Text Color', 'sentio-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-slide-description' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography',
				'scheme' => Schemes\Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .elementor-slide-description',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button',
			[
				'label' => __( 'Button', 'sentio-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'button_size',
			[
				'label' => __( 'Size', 'sentio-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'sm',
				'options' => self::get_button_sizes(),
			]
		);

		$this->add_control( 'button_color',
			[
				'label' => __( 'Text Color', 'sentio-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-slide-button' => 'color: {{VALUE}}; border-color: {{VALUE}}',

				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'selector' => '{{WRAPPER}} .elementor-slide-button',
				'scheme' => Schemes\Typography::TYPOGRAPHY_4,
			]
		);

		$this->add_control(
			'button_border_width',
			[
				'label' => __( 'Border Width', 'sentio-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-slide-button' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label' => __( 'Border Radius', 'sentio-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-slide-button' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);

		$this->start_controls_tabs( 'button_tabs' );

		$this->start_controls_tab( 'normal', [ 'label' => __( 'Normal', 'sentio-addons' ) ] );

		$this->add_control(
			'button_text_color',
			[
				'label' => __( 'Text Color', 'sentio-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-slide-button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label' => __( 'Background Color', 'sentio-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-slide-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_border_color',
			[
				'label' => __( 'Border Color', 'sentio-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-slide-button' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'hover', [ 'label' => __( 'Hover', 'sentio-addons' ) ] );

		$this->add_control(
			'button_hover_text_color',
			[
				'label' => __( 'Text Color', 'sentio-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-slide-button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_background_color',
			[
				'label' => __( 'Background Color', 'sentio-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-slide-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label' => __( 'Border Color', 'sentio-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-slide-button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_navigation',
			[
				'label' => __( 'Navigation', 'sentio-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'navigation' => [ 'arrows', 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'heading_style_arrows',
			[
				'label' => __( 'Arrows', 'sentio-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_position',
			[
				'label' => __( 'Arrows Position', 'sentio-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'inside',
				'options' => [
					'inside' => __( 'Inside', 'sentio-addons' ),
					'outside' => __( 'Outside', 'sentio-addons' ),
				],
				'prefix_class' => 'elementor-arrows-position-',
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_size',
			[
				'label' => __( 'Arrows Size', 'sentio-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 60,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-button' => 'font-size: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_color',
			[
				'label' => __( 'Arrows Color', 'sentio-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-button' => 'color: {{VALUE}}',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'heading_style_dots',
			[
				'label' => __( 'Dots', 'sentio-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'dots_position',
			[
				'label' => __( 'Dots Position', 'sentio-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'inside',
				'options' => [
					'outside' => __( 'Outside', 'sentio-addons' ),
					'inside' => __( 'Inside', 'sentio-addons' ),
				],
				'prefix_class' => 'elementor-pagination-position-',
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'dots_size',
			[
				'label' => __( 'Dots Size', 'sentio-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 15,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .swiper-container-horizontal .swiper-pagination-progressbar' => 'height: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .swiper-pagination-fraction' => 'font-size: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'dots_color',
			[
				'label' => __( 'Dots Color', 'sentio-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination-bullet-active' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings();

				if ( empty( $settings['slides'] ) ) {
			return;
		}

		        $this->add_render_attribute(
            'sentio-post-carousel-container',
            [
                'class' => [
                    'swiper-container-wrap',
                    'elementor-slides-wrapper',
                    'elementor-main-swiper',
                    'swiper-container'
                ],
                
            ]
        );

		if ($settings['transition']) {
           $this->add_render_attribute('sentio-post-carousel-container', 'data-effect', $settings['transition']);
        }
         if ($settings['autoplay'] == 'yes' && !empty($settings['autoplay_speed'])) {
            $this->add_render_attribute('sentio-post-carousel-container', 'data-autoplay', $settings['autoplay_speed']);
        } else {
            $this->add_render_attribute('sentio-post-carousel-container', 'data-autoplay', '0');
        }


        if ($settings['infinite'] == 'yes') {
            $this->add_render_attribute('sentio-post-carousel-container', 'data-loop', '1');
        }

       if ($settings['transition_speed']) {
            $this->add_render_attribute('sentio-post-carousel-container', 'data-speed', $settings['transition_speed']);
        }
        
       if ($settings['pause_on_hover'] == 'yes') {
            $this->add_render_attribute('sentio-post-carousel-container', 'data-pause-on-hover', '1');
        }
            if ($settings['pause_on_interaction'] !== 'yes') {
            $this->add_render_attribute('sentio-post-carousel-container', 'data-pause-on-interaction', '0');
        }   

		$this->add_render_attribute( 'button', 'class', [ 'elementor-button', 'elementor-slide-button' ] );

		if ( ! empty( $settings['button_size'] ) ) {
			$this->add_render_attribute( 'button', 'class', 'elementor-size-' . $settings['button_size'] );
		}

		$slides = [];
		$slide_count = 0;

		foreach ( $settings['slides'] as $slide ) {
			$slide_html = '';
			$btn_attributes = '';
			$slide_attributes = '';
			$slide_element = 'div';
			$btn_element = 'div';
			$slide_url = $slide['link']['url'];

			if ( ! empty( $slide_url ) ) {
				$this->add_render_attribute( 'slide_link' . $slide_count, 'href', $slide_url );

				if ( $slide['link']['is_external'] ) {
					$this->add_render_attribute( 'slide_link' . $slide_count, 'target', '_blank' );
				}

				if ( 'button' === $slide['link_click'] ) {
					$btn_element = 'a';
					$btn_attributes = $this->get_render_attribute_string( 'slide_link' . $slide_count );
				} else {
					$slide_element = 'a';
					$slide_attributes = $this->get_render_attribute_string( 'slide_link' . $slide_count );
				}
			}

			$slide_html .= '<' . $slide_element . ' class="swiper-slide-inner" ' . $slide_attributes . '>';

			$slide_html .= '<div class="swiper-slide-contents">';

			if ( $slide['heading'] ) {
				$slide_html .= '<div class="elementor-slide-heading">' . $slide['heading'] . '</div>';
			}

			if ( $slide['description'] ) {
				$slide_html .= '<div class="elementor-slide-description">' . $slide['description'] . '</div>';
			}

			if ( $slide['button_text'] ) {
				$slide_html .= '<' . $btn_element . ' ' . $btn_attributes . ' ' . $this->get_render_attribute_string( 'button' ) . '>' . $slide['button_text'] . '</' . $btn_element . '>';
			}

			$slide_html .= '</div></' . $slide_element . '>';

			if ( 'yes' === $slide['background_overlay'] ) {
				$slide_html = '<div class="elementor-background-overlay"></div>' . $slide_html;
			}

			$ken_class = '';

			if ( $slide['background_ken_burns'] ) {
				$ken_class = ' elementor-ken-burns elementor-ken-burns--' . $slide['zoom_direction'];
			}

			$slide_html = '<div class="swiper-slide-bg' . $ken_class . '"></div>' . $slide_html;

			$slides[] = '<div class="elementor-repeater-item-' . $slide['_id'] . ' swiper-slide">' . $slide_html . '</div>';
			$slide_count++;
		}

		$direction = is_rtl() ? 'rtl' : 'ltr';
		$show_dots = ( in_array( $settings['navigation'], [ 'dots', 'both' ] ) );
		$show_arrows = ( in_array( $settings['navigation'], [ 'arrows', 'both' ] ) );

		$slides_count = count( $settings['slides'] );
		?>
		<div class="slides-container">
			
			<div <?php echo $this->get_render_attribute_string('sentio-post-carousel-container'); ?> dir="<?php echo $direction; ?>" data-animation="<?php echo $settings['content_animation']; ?>">
				<div class="swiper-wrapper slides">
					<?php echo implode( '', $slides ); ?>
				</div>
				<?php if ( 1 < $slides_count ) : ?>
					<?php if ( $show_dots ) : ?>
						<div class="swiper-pagination"></div>
					<?php endif; ?>
					<?php if ( $show_arrows ) : ?>
						<div class="swiper-button swiper-button-prev">
							<i class="eicon-chevron-left" aria-hidden="true"></i>
							<span class="elementor-screen-only"><?php _e( 'Previous', 'sentio-addons' ); ?></span>
						</div>
						<div class="swiper-button swiper-button-next">
							<i class="eicon-chevron-right" aria-hidden="true"></i>
							<span class="elementor-screen-only"><?php _e( 'Next', 'sentio-addons' ); ?></span>
						</div>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		</div>

		<?php
	}

	protected function _content_template() {
		?>
		<#
			var direction        = elementorCommon.config.isRTL ? 'rtl' : 'ltr',
				navi             = settings.navigation,
				showDots         = ( 'dots' === navi || 'both' === navi ),
				showArrows       = ( 'arrows' === navi || 'both' === navi ),
				buttonSize       = settings.button_size;
		#>
		<div class="swiper">
			<div class="slides-wrapper elementor-main-swiper swiper-container" dir="{{ direction }}" data-animation="{{ settings.content_animation }}">
				<div class="swiper-wrapper slides">
					<# jQuery.each( settings.slides, function( index, slide ) { #>
						<div class="elementor-repeater-item-{{ slide._id }} swiper-slide">
							<#
							var kenClass = '';

							if ( '' != slide.background_ken_burns ) {
								kenClass = ' elementor-ken-burns elementor-ken-burns--' + slide.zoom_direction;
							}
							#>
							<div class="swiper-slide-bg{{ kenClass }}"></div>
							<# if ( 'yes' === slide.background_overlay ) { #>
							<div class="elementor-background-overlay"></div>
							<# } #>
							<div class="swiper-slide-inner">
								<div class="swiper-slide-contents">
									<# if ( slide.heading ) { #>
										<div class="elementor-slide-heading">{{{ slide.heading }}}</div>
									<# }
									if ( slide.description ) { #>
										<div class="elementor-slide-description">{{{ slide.description }}}</div>
									<# }
									if ( slide.button_text ) { #>
										<div class="elementor-button elementor-slide-button elementor-size-{{ buttonSize }}">{{{ slide.button_text }}}</div>
									<# } #>
								</div>
							</div>
						</div>
					<# } ); #>
				</div>
				<# if ( 1 < settings.slides.length ) { #>
					<# if ( showDots ) { #>
						<div class="swiper-pagination"></div>
					<# } #>
					<# if ( showArrows ) { #>
						<div class="swiper-button swiper-button-prev">
							<i class="eicon-chevron-left" aria-hidden="true"></i>
							<span class="elementor-screen-only"><?php _e( 'Previous', 'sentio-addons' ); ?></span>
						</div>
						<div class="swiper-button swiper-button-next">
							<i class="eicon-chevron-right" aria-hidden="true"></i>
							<span class="elementor-screen-only"><?php _e( 'Next', 'sentio-addons' ); ?></span>
						</div>
					<# } #>
				<# } #>
			</div>
		</div>
		<?php
	}
}
