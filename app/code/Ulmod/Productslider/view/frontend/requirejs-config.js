/**
 * Copyright © Ulmod. All rights reserved.
 * See LICENSE.txt for license details.
 */
var config = {
    map: {
        '*': {
			'um-owl-slider': 'Ulmod_Productslider/js/um-owl-slider',
			'um-slick-slider': 'Ulmod_Productslider/js/um-slick-slider'				
        }
    },
    paths: {
        'slick': 'Ulmod_Productslider/js/lib/slick.min',
        'owlcarousel': 'Ulmod_Productslider/js/lib/owl.carousel.min'	
    },
    shim: {
        'slick': {
            deps: ['jquery']
        },
        'owlcarousel': {
            deps: ['jquery']
        }
    }
};