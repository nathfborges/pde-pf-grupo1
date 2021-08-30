/**
 * Copyright © Ulmod. All rights reserved.
 * See LICENSE.txt for license details.
 */
 
define([
        'jquery',
        'Ulmod_Productslider/js/lib/slick.min'
    ],
    function($) {
        return function(config){			
            $(document).ready(function(){
				var selector = ".product-slider"+ config.sliderId;
				  $(selector).slick({
					  dots: config.dots,
					  infinite: config.infinite,
					  slidesToShow: config.slidesToShow,
					  slidesToScroll: config.slidesToScroll,
					  speed: config.speed,
					  autoplay: config.autoplay,
					  autoplaySpeed: config.autoplaySpeed,
					  cssEase: 'linear',
					  rtl: config.rtl,
					  responsive: [
						  {
						   breakpoint: config.breakpointLarge,
						   settings: {
							 slidesToShow: config.largeSlidesToShow,
							 slidesToScroll: config.largeSlidesToScroll               
							}
						 },
						  {
						   breakpoint: config.breakpointMedium,
						   settings: {
							 slidesToShow: config.mediumSlidesToShow,
							 slidesToScroll: config.mediumSlidesToScroll               
							}
						 },
						  {
						   breakpoint: config.breakpointSmall,
						   settings: {
							 slidesToShow: config.smallSlidesToShow,
							 slidesToScroll: config.smallSlidesToScroll               
							}
						 }
					  ]
				  });            
			});
        }
    }
);



