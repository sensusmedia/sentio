<?php
namespace SentioAddon\Widgets;

use Elementor\Widget_Base;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Scheme_Typography;
use Elementor\Repeater;
use Elementor\Controls_Manager;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Sentio_Posts extends \Elementor\Widget_Base {

	public function get_name() {
		return 'sentio-posts';
	}

	public function get_title() {
		return __( 'Sentio Posts', 'sentio-addons' );
	}

	public function get_icon() {
		return 'fa fa-blog';
	}

	public function get_categories() {
		return [ 'sentio-addon' ];
	}

	public function get_keywords() {
		return [ 'posts', 'blog' ];
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
			'section_posts',
			[
				'label' => __( 'Sentio Posts', 'sentio-addons' ),
			]
		);
		

		// We'll need this var only in this method.
		$post_types = apply_filters( 'micemade_elements_post_types', '' );
	

		$this->add_control(
			'post_type',
			[
				'label'    => esc_html__( 'Post type', 'sentio-addons' ),
				'type'     => Controls_Manager::SELECT,
				'default'  => 'post',
				'options'  => $post_types,
				'multiple' => false,
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label'   => __( 'Total posts', 'sentio-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => '6',
				'title'   => __( 'Enter total number of posts to show', 'sentio-addons' ),
			]
		);

		$this->add_control(
			'offset',
			[
				'label'   => __( 'Offset', 'sentio-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => '',
				'title'   => __( 'Offset is number of skipped posts', 'sentio-addons' ),
			]
		);

		$this->add_control(
			'heading_filtering',
			[
				'label'     => __( 'Posts filtering options', 'sentio-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'post_type!' => 'page',
				],
			]
		);

		// Get all the post types with its taxonomies in array.
		foreach ( $post_types as $post_type => $label ) {
			$posttypes_and_its_taxonomies[ $post_type ] = get_cpt_taxonomies( $post_type );
		}

		foreach ( $posttypes_and_its_taxonomies as $post_type => $taxes ) {

			if ( 'page' === $post_type || empty( $taxes ) ) {
				continue;
			}

			// Create options from all publicly queryable taxonomies.
			foreach ( $taxes as $tax ) {
				$tax_object = get_taxonomy( $tax );
				if ( ! $tax_object->publicly_queryable ) {
					continue;
				}
				$tax_options[ $tax ] = $tax_object->label;
			}

			// Controls for selection of taxonomies per post type.
			// -- correct "-" to "_" in taxonomies, JS issue in Elementor-conditional hiding.
			$taxonomy_control = str_replace( '-', '_', $post_type ) . '_taxonomies';
			$this->add_control(
				$taxonomy_control,
				[
					'label'       => esc_html__( 'Select taxonomy', 'sentio-addons' ),
					'type'        => Controls_Manager::SELECT2,
					'default'     => '',
					'options'     => $tax_options,
					'multiple'    => false,
					'label_block' => true,
					'condition'   => [
						'post_type' => $post_type,
					],
				]
			);

			foreach ( $tax_options as $taxonomy => $label ) {
				$this->add_control(
					$taxonomy . '_terms',
					[
						'label'       => esc_html__( 'Select ', 'sentio-addons' ) . strtolower( $label ),
						'type'        => Controls_Manager::SELECT2,
						'default'     => array(),
						'options'     => apply_filters( 'micemade_elements_terms', $taxonomy ),
						'multiple'    => true,
						'label_block' => true,
						'condition'   => [
							$taxonomy_control => $taxonomy,
							'post_type'       => $post_type,
						],
					]
				);

			}

			unset( $tax_options );
		}

		$this->add_control(
			'sticky',
			[
				'label'     => esc_html__( 'Show only sticky posts', 'sentio-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'No', 'elementor' ),
				'label_on'  => __( 'Yes', 'elementor' ),
				'condition' => [
					'post_type' => 'post',
				],
			]
		);

		$this->add_control(
			'heading_grid_options',
			[
				'label'     => __( 'Grid options', 'sentio-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'posts_per_row',
			[
				'label'   => __( 'Posts per row', 'sentio-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 3,
				'options' => [
					1 => __( 'One', 'sentio-addons' ),
					2 => __( 'Two', 'sentio-addons' ),
					3 => __( 'Three', 'sentio-addons' ),
					4 => __( 'Four', 'sentio-addons' ),
					6 => __( 'Six', 'sentio-addons' ),
				],
			]
		);

		$this->add_control(
			'posts_per_row_tab',
			[
				'label'   => __( 'Posts per row (on tablets)', 'sentio-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 1,
				'options' => [
					1 => __( 'One', 'sentio-addons' ),
					2 => __( 'Two', 'sentio-addons' ),
					3 => __( 'Three', 'sentio-addons' ),
					4 => __( 'Four', 'sentio-addons' ),
					6 => __( 'Six', 'sentio-addons' ),
				],
			]
		);

		$this->add_control(
			'posts_per_row_mob',
			[
				'label'   => __( 'Posts per row (on mobiles)', 'sentio-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 1,
				'options' => [
					1 => __( 'One', 'sentio-addons' ),
					2 => __( 'Two', 'sentio-addons' ),
					3 => __( 'Three', 'sentio-addons' ),
					4 => __( 'Four', 'sentio-addons' ),
					6 => __( 'Six', 'sentio-addons' ),
				],
			]
		);

		$this->add_responsive_control(
			'horiz_spacing',
			[
				'label'     => __( 'Posts grid horizontal spacing', 'sentio-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => '',
				],
				'range'     => [
					'px' => [
						'max'  => 50,
						'min'  => 0,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mme-row .post' => 'padding-left:{{SIZE}}px;padding-right:{{SIZE}}px;',
					'{{WRAPPER}} .mme-row'       => 'margin-left:-{{SIZE}}px; margin-right:-{{SIZE}}px;',
				],

			]
		);
		$this->add_responsive_control(
			'vert_spacing',
			[
				'label'     => __( 'Posts grid vertical spacing', 'sentio-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => '20',
				],
				'range'     => [
					'px' => [
						'max'  => 100,
						'min'  => 0,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mme-row .post' => 'margin-bottom:{{SIZE}}px;',
					'{{WRAPPER}} .mme-row'       => 'margin-bottom:-{{SIZE}}px;',
				],

			]
		);

		$this->end_controls_section();

		// TAB 2 - STYLES FOR POSTS.
		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'General style and layout', 'sentio-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'style',
			[
				'label'   => __( 'Style', 'sentio-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'style_1',
				'options' => [
					'style_1' => __( 'Image above, text bellow', 'sentio-addons' ),
					'style_2' => __( 'Image left, text right', 'sentio-addons' ),
					'style_3' => __( 'Image as background', 'sentio-addons' ),
					'style_4' => __( 'Image and text overlapping', 'sentio-addons' ),
				],
			]
		);

		$this->add_control(
			'show_thumb',
			[
				'label'     => esc_html__( 'Show featured image (thumbnail)', 'sentio-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'No', 'elementor' ),
				'label_on'  => __( 'Yes', 'elementor' ),
				'default'   => 'yes',
			]
		);

		$this->add_control(
			'img_format',
			[
				'label'     => esc_html__( 'Featured image format', 'sentio-addons' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'thumbnail',
				'options'   => apply_filters( 'micemade_elements_image_sizes', '' ),
				'condition' => [
					'show_thumb!' => '',
				],
			]
		);

		$this->add_control(
			'excerpt',
			[
				'label'     => esc_html__( 'Show excerpt', 'sentio-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'No', 'elementor' ),
				'label_on'  => __( 'Yes', 'elementor' ),
				'default'   => 'yes',
			]
		);

		$this->add_control(
			'meta',
			[
				'label'     => esc_html__( 'Show post meta', 'sentio-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'No', 'elementor' ),
				'label_on'  => __( 'Yes', 'elementor' ),
				'default'   => 'yes',
			]
		);

		$this->add_responsive_control(
			'post_overal_padding',
			[
				'label'      => esc_html__( 'Post overal padding', 'sentio-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .inner-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// CONTENT BOX STYLES.
		$this->start_controls_section(
			'section_post_text',
			[
				'label' => __( 'Post text styling', 'sentio-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'background_type',
			[
				'label'       => __( 'Post background type', 'sentio-addons' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'default'     => 'solid',
				'options'     => [
					'solid'    => [
						'title' => __( 'Solid color', 'sentio-addons' ),
						'icon'  => 'fa fa-eyedropper',
					],
					'gradient' => [
						'title' => __( 'Gradient', 'sentio-addons' ),
						'icon'  => 'fa fa-list-ul',
					],
				],
			]
		);

		$this->start_controls_tabs( 'tabs_post_background' );

		$this->start_controls_tab(
			'tab_post_background_normal',
			[
				'label' => __( 'Normal', 'sentio-addons' ),
			]
		);

		$this->add_control(
			'post_text_background_color',
			[
				'label'     => __( 'Background color', 'sentio-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .inner-wrap'   => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .post-overlay' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'background_type' => 'solid',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'post_text_background_gradient',
				'label'     => __( 'Background gradient', 'sentio-addons' ),
				'types'     => [ 'gradient' ],
				'selector'  => '{{WRAPPER}} .inner-wrap, {{WRAPPER}} .post-overlay',
				'condition' => [
					'background_type' => 'gradient',
				],
			]
		);

		$this->end_controls_tab();

		// HOVER.
		$this->start_controls_tab(
			'tab_product_background_hover',
			[
				'label' => __( 'Hover', 'sentio-addons' ),
			]
		);
		$this->add_control(
			'post_text_background_color_hover',
			[
				'label'     => __( 'Post text background (hover)', 'sentio-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .inner-wrap:hover' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .inner-wrap:hover .post-overlay' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'background_type' => 'solid',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'post_text_background_gradient_hover',
				'label'     => __( 'Background gradient', 'sentio-addons' ),
				'types'     => [ 'gradient' ],
				'selector'  => '{{WRAPPER}} .inner-wrap:hover, {{WRAPPER}} .inner-wrap:hover .post-overlay',
				'condition' => [
					'background_type' => 'gradient',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'post_text_height',
			[
				'label'     => __( 'Post height', 'sentio-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => '',
				],
				'range'     => [
					'px' => [
						'max'  => 800,
						'min'  => 0,
						'step' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .inner-wrap' => 'height: {{SIZE}}px;',
				],
				'condition' => [
					'style' => [ 'style_3', 'style_4' ],
				],
			]
		);

		$this->add_responsive_control(
			'post_thumb_width',
			[
				'label'     => __( 'Post thumb width (%)', 'sentio-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => '',
				],
				'range'     => [
					'px' => [
						'max'  => 100,
						'min'  => 0,
						'step' => 1,
					],
				],
				'selectors' => [
					// thumb style 2.
					'{{WRAPPER}} .post-thumb'         => 'width:{{SIZE}}%;',
					'{{WRAPPER}} .style_2 .post-text' => 'width: calc( 100% - {{SIZE}}%);',
					// thumb style 4.
					'{{WRAPPER}} .post-thumb-back'    => 'right: calc( 100% - {{SIZE}}%); width: auto;',

				],
				'condition' => [
					'style'       => [ 'style_2', 'style_4' ],
					'show_thumb!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'post_content_width',
			[
				'label'     => __( 'Post content width (%)', 'sentio-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => '',
				],
				'range'     => [
					'px' => [
						'max'  => 100,
						'min'  => 0,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .style_4 .post-overlay' => 'left: calc( 100% - {{SIZE}}%);',
					'{{WRAPPER}} .style_4 .post-text'    => 'left: calc( 100% - {{SIZE}}%);',
				],
				'condition' => [
					'style' => [ 'style_4' ],
				],
			]
		);

		$this->add_responsive_control(
			'post_text_padding',
			[
				'label'      => esc_html__( 'Post text padding', 'sentio-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .post-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'post_text_align',
			[
				'label'     => __( 'Post text alignment', 'sentio-addons' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => __( 'Left', 'sentio-addons' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'sentio-addons' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'sentio-addons' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .post-text' => 'text-align: {{VALUE}};',
				],

			]
		);
		/*
		$this->add_responsive_control(
			'content_vertical_alignment',
			[
				'label'     => __( 'Vertical align', 'sentio-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'flex-start' => __( 'Top', 'sentio-addons' ),
					'center'     => __( 'Middle', 'sentio-addons' ),
					'flex-end'   => __( 'Bottom', 'sentio-addons' ),
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .post-text'  => 'justify-content: {{VALUE}};',
					'{{WRAPPER}} .inner-wrap' => 'align-items: {{VALUE}};',
				],
				'condition' => [
					'style' => [ 'style_2', 'style_3', 'style_4' ],
				],
			]
		);
		*/
		$this->add_responsive_control(
			'content_vertical_alignment',
			[
				'label'       => __( 'Vertical Align', 'sentio-addons' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
					'flex-start' => [
						'title' => __( 'Start', 'sentio-addons' ),
						'icon'  => 'eicon-v-align-top',
					],
					'center'     => [
						'title' => __( 'Center', 'sentio-addons' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'flex-end'   => [
						'title' => __( 'End', 'sentio-addons' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'default'     => 'center',
				'selectors'   => [
					'{{WRAPPER}} .post-text'  => 'justify-content: {{VALUE}};',
					'{{WRAPPER}} .inner-wrap' => 'align-items: {{VALUE}};',
				],
				'condition'   => [
					'style' => [ 'style_2', 'style_3', 'style_4' ],
				],
			]
		);

		$this->add_responsive_control(
			'post_elements_spacing',
			[
				'label'     => __( 'Elements vertical spacing', 'sentio-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => '',
				],
				'range'     => [
					'px' => [
						'max'  => 200,
						'min'  => 0,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .post-text > *:not(.sentio-addons-readmore)' => 'margin-bottom: {{SIZE}}px; padding-bottom: 0;',
					/*,
					 '{{WRAPPER}} .post-text .meta' => 'margin-bottom: {{SIZE}}px;',
					'{{WRAPPER}} .post-text p' => 'margin-bottom: {{SIZE}}px;',
					'{{WRAPPER}} .post-text a.sentio-addons-readmore  ' => 'margin-bottom: {{SIZE}}px;', */
				],

			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'border',
				'label'       => __( 'Border', 'sentio-addons' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .inner-wrap',
			]
		);

		$this->end_controls_section();

		// Title styles.
		$this->start_controls_section(
			'section_title',
			[
				'label' => __( 'Title', 'sentio-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Hover tabs.
		$this->start_controls_tabs( 'tabs_button_style' );

		// Normal.
		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => __( 'Normal', 'sentio-addons' ),
			]
		);

		$this->add_control(
			'title_text_color',
			[
				'label'     => __( 'Title Color', 'sentio-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .post-text h4 a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_back_color',
			[
				'label'     => __( 'Title Back Color', 'sentio-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .post-text h4' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();

		// Hover.
		$this->start_controls_tab(
			'tab_title_hover',
			[
				'label' => __( 'Hover', 'sentio-addons' ),
			]
		);

		$this->add_control(
			'title_hover_color',
			[
				'label'     => __( 'Title Color on Hover', 'sentio-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .inner-wrap:hover .post-text h4 a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_back_color_hover',
			[
				'label'     => __( 'Title Back Color on Hover', 'sentio-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .inner-wrap:hover .post-text h4' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		// end tabs.

		// Title border.
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'postgrid_title_border',
				'label'       => __( 'Title Border', 'sentio-addons' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .post-text h4',
			]
		);

		$this->add_responsive_control(
			'postgrid_title_padding',
			[
				'label'      => esc_html__( 'Title padding', 'sentio-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .post-text h4' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		// Title typohraphy.
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'    => __( 'Typography', 'sentio-addons' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .post-text h4',
			]
		);

		$this->end_controls_section();

		// Meta controls.
		$this->start_controls_section(
			'section_meta',
			[
				'label'     => __( 'Meta', 'sentio-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'meta!' => '',
				],
			]
		);

		// Meta hover tabs.
		$this->start_controls_tabs( 'tabs_meta_style' );

		// Normal.
		$this->start_controls_tab(
			'tab_meta_normal',
			[
				'label' => __( 'Normal', 'sentio-addons' ),
			]
		);

		$this->add_control(
			'meta_text_color',
			[
				'label'     => __( 'Meta Text Color', 'sentio-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .post-text .meta span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'meta_links_color',
			[
				'label'     => __( 'Meta Links Color', 'sentio-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .post-text .meta a, {{WRAPPER}} .post-text .meta a:active' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover.
		$this->start_controls_tab(
			'tab_meta_hover',
			[
				'label' => __( 'Hover', 'sentio-addons' ),
			]
		);
		$this->add_control(
			'meta_text_hover_color',
			[
				'label'     => __( 'Meta Text Hover Color', 'sentio-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .inner-wrap:hover .post-text .meta span' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'meta_links_hover_color',
			[
				'label'     => __( 'Meta Links Hover Color', 'sentio-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .inner-wrap:hover .post-text .meta a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'meta_typography',
				'label'     => __( 'Meta typography', 'sentio-addons' ),
				'selector'  => '{{WRAPPER}} .post-text .meta',
				'condition' => [
					'meta!' => '',
				],
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'meta_sorter_label',
			[
				'label'      => esc_html__( 'Sort meta info', 'sentio-addons' ),
				'type'       => 'sorter_label', // Custom type - class Micemade_Control_Setting.
				'show_label' => false,
			]
		);
		$repeater->add_control(
			'meta_part_enabled',
			[
				'label'     => esc_html__( 'Enable', 'sentio-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'No', 'elementor' ),
				'label_on'  => __( 'Yes', 'elementor' ),
				'default'   => 'yes',
			]
		);

		$this->add_control(
			'meta_ordering',
			[
				'label'        => __( 'Meta selection and ordering', 'sentio-addons' ),
				'type'         => \Elementor\Controls_Manager::REPEATER,
				'fields'       => $repeater->get_controls(),
				'item_actions' => [
					'duplicate' => false,
					'add'       => false,
					'remove'    => false,
				],
				'default'      => [
					[
						'meta_sorter_label' => 'Date',
						'meta_part_enabled' => 'yes',
					],
					[
						'meta_sorter_label' => 'Author',
						'meta_part_enabled' => 'yes',
					],
					[
						'meta_sorter_label' => 'Posted in',
						'meta_part_enabled' => 'yes',
					],
				],
				'title_field'  => '{{{ meta_sorter_label }}}',
				'condition'    => [
					'meta!' => '',
				],
			]
		);

		$this->end_controls_section();

		// Excerpt controls.
		$this->start_controls_section(
			'section_excerpt',
			[
				'label'     => __( 'Excerpt', 'sentio-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'excerpt!' => '',
				],
			]
		);

		$this->add_control(
			'excerpt_limit',
			[
				'label'   => __( 'Excerpt Limit (words)', 'sentio-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => '20',
				'title'   => __( 'Max. number of words in excerpt', 'sentio-addons' ),
			]
		);

		// EXCERPT HOVER TABS.
		$this->start_controls_tabs( 'tabs_excerpt_style' );
		// NORMAL.
		$this->start_controls_tab(
			'tab_excerpt_normal',
			[
				'label' => __( 'Normal', 'sentio-addons' ),
			]
		);
		// Excerpt text color.
		$this->add_control(
			'excerpt_text_color',
			[
				'label'     => __( 'Excerpt Text Color', 'sentio-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .post-text p' => 'color: {{VALUE}};',
					'{{WRAPPER}} .post-text .sentio-addons-readmore' => 'color: {{VALUE}};',
				],

			]
		);
		$this->end_controls_tab();

		// HOVER.
		$this->start_controls_tab(
			'tab_excerpt_hover',
			[
				'label' => __( 'Hover', 'sentio-addons' ),
			]
		);
		// Excerpt text color.
		$this->add_control(
			'excerpt_text_hover_color',
			[
				'label'     => __( 'Excerpt Text Hover Color', 'sentio-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .inner-wrap:hover .post-text p' => 'color: {{VALUE}};',
					'{{WRAPPER}} .inner-wrap:hover .post-text .sentio-addons-readmore' => 'color: {{VALUE}};',
				],

			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		// Excerpt typohraphy.
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'text_typography',
				'label'    => __( 'Excerpt typography', 'sentio-addons' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .post-text p',

			]
		);

		// Excerpt padding.
		$this->add_responsive_control(
			'postgrid_excerpt_padding',
			[
				'label'      => esc_html__( 'Excerpt padding', 'sentio-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .post-text p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		// Excerpt border.
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'postgrid_excerpt_border',
				'label'       => __( 'Excerpt Border', 'sentio-addons' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .post-text p',
			]
		);

		$this->add_control(
			'readmore_title',
			[
				'label'     => __( '"Read more" button custom css', 'sentio-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'css_class',
			[
				'label'       => __( 'Enter css class(es) for "Read more"', 'sentio-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'title'       => __( 'Style the "Read more" with css class(es) defined in your theme, plugin or customizer', 'sentio-addons' ),
				'label_block' => true,
			]
		);

		$this->end_controls_section();

		// Ajax LOAD MORE settings.
		$this->start_controls_section(
			'section_ajax_load_more',
			[
				'label' => __( 'Ajax LOAD MORE settings', 'sentio-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'use_load_more',
			[
				'label'     => esc_html__( 'Use load more', 'sentio-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'No', 'elementor' ),
				'label_on'  => __( 'Yes', 'elementor' ),
				'default'   => 'yes',
			]
		);

		$this->add_responsive_control(
			'load_more_padding',
			[
				'label'      => esc_html__( '"LOAD MORE" margin', 'sentio-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .sentio-addons_more-posts-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'use_load_more!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'loadmore_align',
			[
				'label'     => __( '"LOAD MORE"  alignment', 'sentio-addons' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => __( 'Left', 'sentio-addons' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'sentio-addons' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'sentio-addons' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .sentio-addons_more-posts-wrap' => 'text-align: {{VALUE}};',
				],
				'condition' => [
					'use_load_more!' => '',
				],
			]
		);

		$this->end_controls_section();
}



	protected function render() {
		$settings = $this->get_settings();





		// Get our input from the widget settings.
		$settings = $this->get_settings_for_display();

		// ---- QUERY SETTINGS
		$post_type = $settings['post_type'];
		// "Dynamic" setting.

		if ($post_type != 'page') {
		$taxonomy = $settings[ $post_type . '_taxonomies' ];
		} else {
		$taxonomy = 'null';
		}
		 
		$ppp      = (int) $settings['posts_per_page'];
		// "Dynamic" setting.
		$categories = isset( $settings[ $taxonomy . '_terms' ] ) ? $settings[ $taxonomy . '_terms' ] : [];
		$sticky     = $settings['sticky'];
		$offset     = (int) $settings['offset'];
		// ---- end QUERY SETTINGS.

		// Grid settings.
		$ppr     = (int) $settings['posts_per_row'];
		$ppr_tab = (int) $settings['posts_per_row_tab'];
		$ppr_mob = (int) $settings['posts_per_row_mob'];

		// Layout and style settings.
		$show_thumb    = $settings['show_thumb'];
		$img_format    = $settings['img_format'];
		$style         = $settings['style'];
		$excerpt       = $settings['excerpt'];
		$excerpt_limit = $settings['excerpt_limit'];
		$meta          = $settings['meta'];
		$meta_ordering = $settings['meta_ordering'];
		$css_class     = $settings['css_class'];
		$use_load_more = $settings['use_load_more'];

		global $post;

		$grid = micemade_elements_grid_class( intval( $ppr ), intval( $ppr_tab ), intval( $ppr_mob ) );

		// Query posts - "micemade_elements_query_args" hook in includes/helpers.php.
		$args  = apply_filters( 'micemade_elements_query_args', $post_type, $taxonomy, $ppp, $categories, $sticky, $offset );
		$posts = get_posts( $args );

		if ( ! empty( $posts ) ) {

			echo '<div class="micemade-elements_posts-grid' . ( $use_load_more ? ' micemade-elements-load-more' : '' ) . ' mme-row ' . esc_attr( $style ) . '">';

			// If "Load more" is selected, turn on the arguments for Ajax call.
			if ( $use_load_more ) {

				$postoptions = wp_json_encode(
					array(
						'post_type'     => $post_type,
						'taxonomy'      => $taxonomy,
						'ppp'           => $ppp,
						'sticky'        => $sticky,
						'categories'    => $categories,
						'style'         => $style,
						'show_thumb'    => $show_thumb,
						'img_format'    => $img_format,
						'excerpt'       => $excerpt,
						'excerpt_limit' => $excerpt_limit,
						'meta'          => $meta,
						'meta_ordering' => $meta_ordering,
						'css_class'     => $css_class,
						'grid'          => $grid,
						'startoffset'   => $offset,
					)
				);

				echo '<input type="hidden" class="posts-grid-settings" data-postoptions="' . esc_js( $postoptions ) . '">';
			}

			foreach ( $posts as $post ) {

				setup_postdata( $post );

				// Hook in includes/helpers.php.
				apply_filters( 'micemade_elements_loop_post', $style, $grid, $show_thumb, $img_format, $meta, $meta_ordering, $excerpt, $excerpt_limit, $css_class );

			}

			echo '</div>';
		}

		wp_reset_postdata();

		if ( $use_load_more ) {
			echo '<div class="micemade-elements_more-posts-wrap"><a href="#" class="micemade-elements_more-posts more_posts button">' . __( 'Load more', 'micemade-elements' ) . '</a></div>';
			print_r ($args);
		}

	}





	protected function _content_template() {
		}
		
			public function render_plain_content( $instance = [] ) {}

		




}