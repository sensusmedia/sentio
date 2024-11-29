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
class Sentio_Pricing extends \Elementor\Widget_Base {

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
		return 'sentio-pricing';
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
		return __( 'Sentio Pricing', 'sentio-addons' );
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
		return 'fa fa-globe';
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
				'label' => __( 'Price Plan', 'sentio-addons' ),
			]
		);

						$this->add_control(
			'price_plan',
			[
				'label' => __( 'Price Plan', 'sentio-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Premium', 'sentio-addons' ),
				'label_block' => true,
			]
		);

				$this->add_control(
			'price',
			[
				'label' => __( 'Price', 'sentio-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( '$100', 'sentio-addons' ),
				'label_block' => true,
			]
		);

								$this->add_control(
			'term',
			[
				'label' => __( 'Term', 'sentio-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'per month', 'sentio-addons' ),
				'label_block' => true,
			]
		);




		$this->end_controls_section();


		$this->start_controls_section(
			'section_slides',
			[
				'label' => __( 'Pricing Features', 'sentio-addons' ),
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'slides_repeater' );




		$repeater->add_control(
			'quote',
			[
				'label' => __( 'Feature', 'sentio-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( 'Feature', 'sentio-addons' ),
				'label_block' => true,
			]
		);




		$this->add_control(
			'slides',
			[
				'label' => __( 'Features', 'sentio-addons' ),
				'type' => Controls_Manager::REPEATER,
				'show_label' => true,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'feature' => __( 'Feature 1', 'sentio-addons' ),
					],
					[
						'feature' => __( 'Feature 2', 'sentio-addons' ),
					],
					[
						'feature' => __( 'Feature 3', 'sentio-addons' ),
					],
				],
				'title_field' => '{{{ feature }}}',
			]
		);



		$repeater->end_controls_tab();

		






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
					'{{WRAPPER}} .sentio-pricing-container' => 'max-width: {{SIZE}}{{UNIT}}; margin: 0 auto;',
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
					'{{WRAPPER}} .sentio-pricing-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
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
					'{{WRAPPER}} .sentio-pricing-container' => 'text-align: {{VALUE}}',
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
			'section_style_quote',
			[
				'label' => __( 'Quote', 'sentio-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'quote_heading_spacing',
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
					'{{WRAPPER}} .swiper-slide-inner .elementor-slide-quote:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'quote_heading_color',
			[
				'label' => __( 'Text Color', 'sentio-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-slide-quote' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'quote_heading_typography',
				'scheme' => Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .elementor-slide-quote',
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
            'sentio-testimonial-carousel-container',
            [
                'class' => [
                    'swiper-container-wrap',
                    'elementor-slides-wrapper',
                    'elementor-main-swiper',
                    'swiper-container',
                    'sentio-testimonial-carousel'
                ],
                
            ]
        );

	
		

		$slides = [];
		$slide_count = 0;

		foreach ( $settings['slides'] as $slide ) {
			$slide_html = '';
			$btn_attributes = '';
			$slide_attributes = '';
			$slide_element = 'div';
			$btn_element = 'div';
		


			$slide_html .= '<' . $slide_element . ' class="swiper-slide-inner" ' . $slide_attributes . '>';

			$slide_html .= '<div class="swiper-slide-contents">';

		

			if ( $slide['quote'] ) {
				$slide_html .= '<div class="elementor-slide-quote">' . $slide['quote'] . '</div>';
			}

		




			$slide_html .= '</div></' . $slide_element . '>';

			

			$slides[] = '<div class="elementor-repeater-item-' . $slide['_id'] . '">' . $slide_html . '</div>';
			$slide_count++;
		}

		

		$slides_count = count( $settings['slides'] );
		?>
		<div class="sentio-pricing-container">
			<div> <?php echo $settings['price_plan']; ?></div>
			<div> <?php echo $settings['price']; ?></div>
			<div> <?php echo $settings['term']; ?></div>
			<div <?php echo $this->get_render_attribute_string('sentio-pricing-container'); ?> data-animation="">
				<div class="wrapper">
					<?php echo implode( '', $slides ); ?>
				</div>
				
			</div>
		</div>

		<?php
	}

	protected function _content_template() {
		?>
			<div class="sentio-pricing-container">
		<div>{{{settings.price_plan}}}</div>
			<div>{{{settings.price}}}</div>
			<div>{{{settings.term}}}</div>
		<div class="swiper">
			<div class="slides-wrapper elementor-main-swiper sentio-pricing" data-animation="{{ settings.content_animation }}">
				<div class="">
					<# jQuery.each( settings.slides, function( index, slide ) { #>
						<div class="elementor-repeater-item-{{ slide._id }}">
						
							<div class="swiper-slide-inner">
								<div class="swiper-slide-contents">
									<# if ( slide.quote ) { #>
										<div class="elementor-slide-quote">{{{ slide.quote }}}</div>
									<# }
									
									if ( slide.name ) { #>
										<div class="elementor-slide-name">{{{ slide.name }}}</div>
									<# }
									if ( slide.title ) { #>
										<div class="elementor-slide-title">{{{ slide.title }}}</div>
									<# } #>
								</div>
							</div>
						</div>
					<# } ); #>
				</div>
			
			</div>
		</div>
	</div>
		<?php
	}
}
