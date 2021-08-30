<?php
/**
 * Copyright © Ulmod. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Ulmod\Productslider\Model\Slider;

use Magento\Framework\Option\ArrayInterface;
use Ulmod\Productslider\Model\ProductSlider;

/**
 * Class Location
 */
class Location implements ArrayInterface
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
            self::SLIDER_LOCATION_DEFAULT => '--- No location ---',
            self::CATEGORY_CONTENT_TOP => __('Category Content Top'),
            self::CATEGORY_CONTENT_BOTTOM => __('Category Content Bottom'),
            self::CONTENT_TOP => __('Content Top'),
            self::CONTENT_BOTTOM => __('Content Bottom'),
            self::HOMEPAGE_CONTENT_TOP => __('Homepage Content Top'),
            self::HOMEPAGE_CONTENT_BOTTOM => __('Homepage Content Bottom'),
            self::PRODUCT_CONTENT_TOP => __('Product Content Top'),
            self::PRODUCT_CONTENT_BOTTOM => __('Product Content Bottom'),
            self::PRODUCT_SIDEBAR_ADDITIONAL_TOP => __('Product Sidebar Additional Top'),
            self::PRODUCT_SIDEBAR_ADDITIONAL_BOTTOM => __('Product Sidebar Additional Bottom'),
            self::SIDEBAR_ADDITIONAL_TOP => __('Sidebar Additional Top'),
            self::SIDEBAR_ADDITIONAL_BOTTOM => __('Sidebar Additional Bottom'),
            self::CATEGORY_SIDEBAR_ADDITIONAL_TOP => __('Category Sidebar Additional Top'),
            self::CATEGORY_SIDEBAR_ADDITIONAL_BOTTOM => __('Category Sidebar Additional Bottom'),
            self::CUSTOMER_CONTENT_TOP => __('Customer Content Top'),
            self::CUSTOMER_CONTENT_BOTTOM => __('Customer Content Bottom'),
            self::CUSTOMER_SIDEBAR_ADDITIONAL_TOP => __('Customer Sidebar Additional Top'),
            self::CUSTOMER_SIDEBAR_ADDITIONAL_BOTTOM => __('Customer Sidebar Additional Bottom'),
            self::CART_CONTENT_TOP => __('Cart Content Top'),
            self::CART_CONTENT_BOTTOM => __('Cart Content Bottom'),
            self::CHECKOUT_CONTENT_TOP => __('Checkout Content Top'),
            self::CHECKOUT_CONTENT_BOTTOM => __('Checkout Content Bottom'),
        ];
    }
}
