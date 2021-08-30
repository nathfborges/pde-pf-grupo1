<?php
/**
 * Copyright © Ulmod. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Ulmod\Productslider\Model\Slider;

use Magento\Framework\Option\ArrayInterface;
use Ulmod\Productslider\Model\ProductSlider;

/**
 * Class FormattedLocation
 */
class FormattedLocation implements ArrayInterface
{
    /**
     * Slider locations/positions displayed on frontend
     */
    const PRODUCT_CONTENT_TOP = 'product-content-top';
    const PRODUCT_CONTENT_BOTTOM = 'product-content-bottom';
    const PRODUCT_SIDEBAR_ADDITIONAL_TOP = 'product-sidebar-additional-top';
    const PRODUCT_SIDEBAR_ADDITIONAL_BOTTOM = 'product-sidebar-additional-bottom';
    const CART_CONTENT_TOP = 'cart-content-top';
    const CART_CONTENT_BOTTOM = 'cart-content-bottom';
    const CHECKOUT_CONTENT_TOP = 'checkout-content-top';
    const CHECKOUT_CONTENT_BOTTOM = 'checkout-content-bottom';
    const SLIDER_LOCATION_DEFAULT = "";
    const HOMEPAGE_CONTENT_TOP = 'homepage-content-top';
    const HOMEPAGE_CONTENT_BOTTOM = 'homepage-content-bottom';
    const CONTENT_TOP = 'content-top';
    const CONTENT_BOTTOM = 'content-bottom';
    const SIDEBAR_ADDITIONAL_TOP = 'sidebar-additional-top';
    const SIDEBAR_ADDITIONAL_BOTTOM = 'sidebar-additional-bottom';
    const CATEGORY_CONTENT_TOP = 'category-content-top';
    const CATEGORY_CONTENT_BOTTOM = 'category-content-bottom';
    const CATEGORY_SIDEBAR_ADDITIONAL_TOP = 'category-sidebar-additional-top';
    const CATEGORY_SIDEBAR_ADDITIONAL_BOTTOM = 'category-sidebar-additional-bottom';
    const CUSTOMER_CONTENT_TOP = 'customer-content-top';
    const CUSTOMER_CONTENT_BOTTOM = 'customer-content-bottom';
    const CUSTOMER_SIDEBAR_ADDITIONAL_TOP = 'customer-sidebar-additional-top';
    const CUSTOMER_SIDEBAR_ADDITIONAL_BOTTOM = 'customer-sidebar-additional-bottom';
    
    /**
     * Return Not formatted slider locations
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['label' => __('--- Select slider location --') ,
            'value' => self::SLIDER_LOCATION_DEFAULT ],
            [
                'label' => __('Home page'),
                'value' => [
                    ['label' => __('Homepage Content Top'),
                    'value' => self::HOMEPAGE_CONTENT_TOP],
                    ['label' => __('Homepage Content Bottom'),
                    'value' => self::HOMEPAGE_CONTENT_BOTTOM],
                ]
            ],
            [
                'label' => __('Category page'),
                'value' => [
                    [
                        'label' => __('Category Content Top'),
                        'value' => self::CATEGORY_CONTENT_TOP
                    ],
                    [
                        'label' => __('Category Content Bottom'),
                        'value' => self::CATEGORY_CONTENT_BOTTOM
                    ],
                    [
                        'label' => __('Category Sidebar Additional Top'),
                        'value' => self::CATEGORY_SIDEBAR_ADDITIONAL_TOP
                    ],
                    [
                        'label' => __('Category Sidebar Additional Bottom'),
                        'value' => self::CATEGORY_SIDEBAR_ADDITIONAL_BOTTOM
                    ],
                ]
            ],
            [
                'label' => __('Display on all pages'),
                'value' =>  [
                    [
                        'label' => __('Content Top'),
                        'value' => self::CONTENT_TOP
                    ],
                    [
                        'label'  => __('Content Bottom'),
                        'value' => self::CONTENT_BOTTOM
                    ],
                    [
                        'label'  => __('Sidebar Additional Top'),
                        'value' => self::SIDEBAR_ADDITIONAL_TOP
                    ],
                    [
                        'label'  => __('Sidebar Additional Bottom'),
                        'value' => self::SIDEBAR_ADDITIONAL_BOTTOM
                    ],
                ]
            ],
            [
                'label' => __('Product page'),
                'value' => [
                    [
                        'label' => __('Product Content Top'),
                        'value' => self::PRODUCT_CONTENT_TOP
                    ],
                    [
                        'label' => __('Product Content Bottom'),
                        'value' => self::PRODUCT_CONTENT_BOTTOM
                    ],
                    ['label' => __('Product Sidebar Additional Top'),
                    'value' => self::PRODUCT_SIDEBAR_ADDITIONAL_TOP],
                    ['label' => __('Product Sidebar Additional Bottom'),
                    'value' => self::PRODUCT_SIDEBAR_ADDITIONAL_BOTTOM],
                ]
            ],
            [
                'label' => __('Customer page'),
                'value' => [
                    [
                        'label' => __('Customer Content Top'),
                        'value' => self::CUSTOMER_CONTENT_TOP
                    ],
                    [
                        'label' => __('Customer Content Bottom'),
                        'value' => self::CUSTOMER_CONTENT_BOTTOM
                    ],
                    [
                        'label' => __('Customer Sidebar Additional Top'),
                        'value' => self::CUSTOMER_SIDEBAR_ADDITIONAL_TOP
                    ],
                    [
                        'label' => __('Customer Sidebar Additional Bottom'),
                        'value' => self::CUSTOMER_SIDEBAR_ADDITIONAL_BOTTOM
                    ],
                ]
            ],
            [
                'label' => __('Cart, checkout and customer page'),
                'value' => [
                    [
                        'label' => __('Cart Content Top'),
                        'value' => self::CART_CONTENT_TOP
                    ],
                    [
                        'label' => __('Cart Content Bottom'),
                        'value' => self::CART_CONTENT_BOTTOM
                    ],
                    [
                        'label' => __('Checkout Content Top'),
                        'value' => self::CHECKOUT_CONTENT_TOP
                    ],
                    [
                        'label' => __('Checkout Content Bottom'),
                        'value' => self::CHECKOUT_CONTENT_BOTTOM
                    ],
                ]
            ],
        ];
    }
}
