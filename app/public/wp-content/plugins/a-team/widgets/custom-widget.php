<?php
namespace CustomElementorWidgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Plugin;

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class Custom_Slideshow_Widget extends Widget_Base
{
    /**
     * Get widget name.
     *
     * Retrieve custom slideshow widget name.
     *
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'custom-slideshow';
    }

    /**
     * Get widget title.
     *
     * Retrieve custom slideshow widget title.
     *
     * @return string Widget title.
     */
    public function get_title()
    {
        return __('Custom Slideshow', 'custom-elementor-widgets');
    }

    /**
     * Get widget icon.
     *
     * Retrieve custom slideshow widget icon.
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return 'eicon-slideshow';
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the custom slideshow widget belongs to.
     *
     * @return array Widget categories.
     */
    public function get_categories()
    {
        return ['basic'];
    }

    /**
     * Register custom slideshow widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     */
    protected function _register_controls() {
        // Content Tab
        $this->start_controls_section(
            'section_content',
            [
                'label' => __( 'Content', 'custom-elementor-widgets' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
    
        $this->add_control(
            'images',
            [
                'label' => __( 'Images', 'custom-elementor-widgets' ),
                'type'  => Controls_Manager::GALLERY,
            ]
        );
    
        $this->add_control(
            'autoplay',
            [
                'label'        => __( 'Autoplay', 'custom-elementor-widgets' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Yes', 'custom-elementor-widgets' ),
                'label_off'    => __( 'No', 'custom-elementor-widgets' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );
    
        $this->end_controls_section();
        // End Content Tab
    
        // Style Tab
        $this->start_controls_section(
            'section_style',
            [
                'label' => __( 'Style', 'custom-elementor-widgets' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
    
        $this->add_control(
            'text_color',
            [
                'label'     => __( 'Text Color', 'custom-elementor-widgets' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .custom-widget' => 'color: {{VALUE}};',
                ],
            ]
        );
    
        $this->add_control(
            'background_color',
            [
                'label'     => __( 'Background Color', 'custom-elementor-widgets' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .custom-widget' => 'background-color: {{VALUE}};',
                ],
            ]
        );
    
        $this->add_control(
            'font_size',
            [
                'label'     => __( 'Font Size', 'custom-elementor-widgets' ),
                'type'      => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .custom-widget' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
    
        // End Style Tab
        $this->end_controls_section();
    }
    

    /**
     * Render custom slideshow widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     */
    protected function render() {
        // Enqueue Swiper JS
        wp_enqueue_script('swiper', plugins_url('../js/swiper.min.js', __FILE__), array(), '1.0', true);

        // Enqueue custom slideshow JS
    wp_enqueue_script('custom-slideshow', plugins_url('../js/custom-slideshow.js', __FILE__), array('swiper'), '1.0', true);
    
    $settings = $this->get_settings_for_display();
        // Rest of your rendering logic...
       
   // Get slideshow settings
   $images = isset($settings['images']) ? $settings['images'] : array();

   $autoplay = $settings['autoplay'] === 'yes' ? true : false;

   // Get style settings
   $text_color = $settings['text_color'];
   $background_color = $settings['background_color'];
   $font_size = $settings['font_size'];

    
        $slider_classes = [];
        if ($autoplay) {
            $slider_classes[] = 'autoplay';
        }
          // Check if navigation is enabled
    if (isset($settings['navigation'])) {
        $navigation = $settings['navigation'] === 'yes' ? true : false;
    }
        // Initialize $pagination
    $pagination = false;

    // Check if pagination is enabled
    if (isset($settings['pagination'])) {
        $pagination = $settings['pagination'] === 'yes' ? true : false;
    }
        $slider_classes = implode(' ', $slider_classes);
    
        ?>
         // Start output
    ?>
    <div class="custom-slideshow" style="background-color: <?php echo esc_attr($background_color); ?>;">
        <div class="swiper-container">
            <div class="swiper-wrapper">
            <?php foreach ($images as $image): ?>
    <div class="swiper-slide">
        <?php if (isset($image['url'])) : ?>
            <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo isset($image['title']) ? esc_attr($image['title']) : ''; ?>">
        <?php endif; ?>
    </div>
<?php endforeach; ?>
            </div>
            <?php if (count($images) > 1 && $autoplay): ?>
                <div class="swiper-pagination"></div>
            <?php endif; ?>
            <?php if (count($images) > 1): ?>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            <?php endif; ?>
        </div>
    </div>
    <style>
        .custom-slideshow {
            color: <?php echo esc_attr($text_color); ?>;
            font-size: <?php echo esc_attr($font_size['size'] . $font_size['unit']); ?>;
        }
    </style>
    <?php
}
}

    
\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Custom_Slideshow_Widget());

