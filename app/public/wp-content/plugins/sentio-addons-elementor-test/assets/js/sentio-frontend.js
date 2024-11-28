( function( $ ) {
/**
* @param $scope The Widget wrapper element as a jQuery element
* @param $ The jQuery alias
*/ 

/**
*  SWIPER SLIDER
*/

var sentioSwiperWidget = function( $scope, $ ) {

	var $postCarousel = $scope.find(".swiper-container").eq(0),

	$autoplay =
	$postCarousel.data("autoplay") !== undefined
	? $postCarousel.data("autoplay")
	: 999999,

	$effect =
	$postCarousel.data("effect") !== undefined
	? $postCarousel.data("effect")
	: "slide";
	$loop =
	$postCarousel.data("loop") !== undefined
	? $postCarousel.data("loop")
	: 0;

	$speed =
	$postCarousel.data("speed") !== undefined
	? $postCarousel.data("speed")
	: 500,

	$pause_on_hover =
	$postCarousel.data("pause-on-hover") !== undefined
	? $postCarousel.data("pause-on-hover")
	: "",
	$pause_on_interaction =
	$postCarousel.data("pause-on-interaction") !== undefined
	? $postCarousel.data("pause-on-interaction")
	: 1,



	console.log($pause_on_interaction);

	var sentioSwiper = new Swiper( $postCarousel, {
// Optional parameters
direction: "horizontal",
speed: $speed,
effect: $effect,
loop: $loop,
autoplay: {
	delay: $autoplay
},
grabCursor: true,
slidesPerView: 1,
disableOnInteraction: $pause_on_interaction, 

navigation: {
	nextEl: '.swiper-button-next', 
	prevEl: '.swiper-button-prev',
},
on: {
	transitionStart: function() {
		$(".swiper-slide-active .swiper-slide-contents").addClass("animated fadeInUp");
	},
	slideNextTransitionStart: function() {
		$(".swiper-slide-active .swiper-slide-bg").addClass("elementor-ken-burns--active");
	},
	slideChange: function() {
		$(".swiper-slide-active .swiper-slide-contents").removeClass("animated fadeInUp");
		$(".swiper-slide-active .swiper-slide-bg").removeClass("elementor-ken-burns--active");
	},
},
// If we need pagination
pagination: {
	el: '.swiper-pagination',
	clickable: true,
},

});

	if ($autoplay === 0) {
		sentioSwiper.autoplay.stop();
	}

	if ($pause_on_hover && $autoplay !== 0) {
		$postCarousel.on("mouseenter", function() {
			sentioSwiper.autoplay.stop();
		});
		$postCarousel.on("mouseleave", function() {
			sentioSwiper.autoplay.start();
		});
	}

};

// Make sure you run this code under Elementor.
$( window ).on( 'elementor/frontend/init', function() {
	elementorFrontend.hooks.addAction( 
		'frontend/element_ready/sentio-slides.default', 
		sentioSwiperWidget
		);
});

/**
*  SWIPER SLIDER
*/

var sentioTestimonialWidget = function( $scope, $ ) {

	var $postCarousel = $scope.find(".swiper-container").eq(0),

	$autoplay =
	$postCarousel.data("autoplay") !== undefined
	? $postCarousel.data("autoplay")
	: 999999,

	$effect =
	$postCarousel.data("effect") !== undefined
	? $postCarousel.data("effect")
	: "slide";
	$loop =
	$postCarousel.data("loop") !== undefined
	? $postCarousel.data("loop")
	: 0;

	$speed =
	$postCarousel.data("speed") !== undefined
	? $postCarousel.data("speed")
	: 500,

	$pause_on_hover =
	$postCarousel.data("pause-on-hover") !== undefined
	? $postCarousel.data("pause-on-hover")
	: "",
	$pause_on_interaction =
	$postCarousel.data("pause-on-interaction") !== undefined
	? $postCarousel.data("pause-on-interaction")
	: 1,



	console.log($pause_on_interaction);

	var sentioSwiper = new Swiper( $postCarousel, {
// Optional parameters
direction: "horizontal",
speed: $speed,
effect: $effect,
loop: $loop,
autoplay: {
	delay: $autoplay
},
grabCursor: true,
slidesPerView: 1,
disableOnInteraction: $pause_on_interaction, 

navigation: {
	nextEl: '.swiper-button-next', 
	prevEl: '.swiper-button-prev',
},
on: {
	transitionStart: function() {
		$(".swiper-slide-active .swiper-slide-contents").addClass("animated fadeInUp");
	},
	slideNextTransitionStart: function() {
		$(".swiper-slide-active .swiper-slide-bg").addClass("elementor-ken-burns--active");
	},
	slideChange: function() {
		$(".swiper-slide-active .swiper-slide-contents").removeClass("animated fadeInUp");
		$(".swiper-slide-active .swiper-slide-bg").removeClass("elementor-ken-burns--active");
	},
},
// If we need pagination
pagination: {
	el: '.swiper-pagination',
	clickable: true,
},

});

	if ($autoplay === 0) {
		sentioSwiper.autoplay.stop();
	}

	if ($pause_on_hover && $autoplay !== 0) {
		$postCarousel.on("mouseenter", function() {
			sentioSwiper.autoplay.stop();
		});
		$postCarousel.on("mouseleave", function() {
			sentioSwiper.autoplay.start();
		});
	}

};

// Make sure you run this code under Elementor.
$( window ).on( 'elementor/frontend/init', function() {
	elementorFrontend.hooks.addAction( 
		'frontend/element_ready/sentio-testimonial.default', 
		sentioTestimonialWidget
		);
});

	/**
		 * AJAX LOADING POSTS
		 *
		 */
		var $posts_holder = $('.micemade-elements-load-more');
			
		$posts_holder.each( function() {
			
			var $_posts_holder = $(this);
			
			var $loader       = $_posts_holder.next('.micemade-elements_more-posts-wrap').find('.more_posts'),
				postoptions   = $_posts_holder.find('.posts-grid-settings' ).data( 'postoptions' ),
				post_type     = postoptions.post_type,
				taxonomy      = postoptions.taxonomy,
				ppp           = postoptions.ppp,
				sticky        = postoptions.sticky,
				categories    = postoptions.categories,
				style         = postoptions.style,
				show_thumb    = postoptions.show_thumb,
				img_format    = postoptions.img_format,
				excerpt       = postoptions.excerpt,
				excerpt_limit = postoptions.excerpt_limit,
				meta          = postoptions.meta,
				meta_ordering = postoptions.meta_ordering,
				css_class     = postoptions.css_class,
				grid          = postoptions.grid,
				startoffset   = postoptions.startoffset,
				offset        = $_posts_holder.find('.post').length;
			
			$loader.on( 'click', load_ajax_posts );

			function load_ajax_posts(e) {

				e.preventDefault();
				
				if ( !($loader.hasClass('post_loading_loader') || $loader.hasClass('no_more_posts')) ) {

					$.ajax({
						type: 'POST',
						dataType: 'html',
						url: sentioJsLocalize.ajaxurl,
						data: {
							'post_type': post_type,
							'taxonomy': taxonomy,
							'ppp': ppp,
							'sticky': sticky,
							'categories': categories,
							'style': style,
							'show_thumb': show_thumb,
							'img_format': img_format,
							'excerpt': excerpt,
							'excerpt_limit': excerpt_limit,
							'meta': meta,
							'meta_ordering': meta_ordering,
							'css_class': css_class,
							'grid': grid,
							'offset': offset + startoffset,
							'action': 'micemade_elements_more_post_ajax'
						},
						beforeSend : function () {
							$loader.addClass('post_loading_loader').html(sentioJsLocalize.loadingposts);
						},
						success: function (data) {
							
							var $data = $(data);
							if ($data.length) {
								var $newElements = $data.css({ opacity: 0 });
								$_posts_holder.append($newElements);
								$newElements.animate({ opacity: 1 });
								$loader.removeClass('post_loading_loader').html(sentioJsLocalize.loadmore);
							} else {
								$loader.removeClass('post_loading_loader').addClass('no_more_posts disabled').html(sentioJsLocalize.noposts);
							}
						},
						error : function (jqXHR, textStatus, errorThrown) {
							$loader.html($.parseJSON(jqXHR.responseText) + ' :: ' + textStatus + ' :: ' + errorThrown);
						},
					});
					
				}
				offset += ppp;
				return false;
			}

		
		}); // end $posts_holder.each
		
} )( jQuery );

