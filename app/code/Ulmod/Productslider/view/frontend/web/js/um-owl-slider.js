/**
 * Copyright © Ulmod. All rights reserved.
 * See LICENSE.txt for license details.
 */
 
define([
        'jquery',
        'Ulmod_Productslider/js/lib/owl.carousel.min'
    ],
    function($) {
        return function(config){			
            $(document).ready(function(){
				var selector = ".product-slider"+ config.sliderId;
				var breakpointSmall = config.breakpointSmall;
				var breakpointMedium = config.breakpointMedium;
				var breakpointLarge = config.breakpointLarge;
				
				var sliderOptions = {
					dots: config.dots,
					loop: config.infinite,
					slideBy: config.slidesToScroll,
					smartSpeed: config.speed,
					autoplay: config.autoplay,
					autoplayTimeout: config.autoplaySpeed,
					rtl: config.rtl,			
					margin: 10,
					nav: config.nav,
					navText: [
						"<em class='fa fa-arrow-circle-left'></em>",
						"<em class='fa fa-arrow-circle-right'></em>"
					],
				};
				
				sliderOptions['responsive'] = {};
				sliderOptions['responsive'][breakpointSmall] = {};
				sliderOptions['responsive'][breakpointSmall]['items'] = config.smallSlidesToShow;
				sliderOptions['responsive'][breakpointSmall]['slideBy'] = config.smallSlidesToScroll;				
				sliderOptions['responsive'][breakpointMedium] = {};
				sliderOptions['responsive'][breakpointMedium]['items'] = config.mediumSlidesToShow;
				sliderOptions['responsive'][breakpointMedium]['slideBy'] = config.mediumSlidesToScroll;				
				sliderOptions['responsive'][breakpointLarge] = {};
				sliderOptions['responsive'][breakpointLarge]['items'] = config.largeSlidesToShow;
				sliderOptions['responsive'][breakpointLarge]['slideBy'] = config.largeSlidesToScroll;
				
				$(selector).owlCarousel(sliderOptions);	
			});
        }
    }
);



