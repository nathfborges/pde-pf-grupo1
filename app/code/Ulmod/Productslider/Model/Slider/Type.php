<?php
/**
 * Copyright © Ulmod. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Ulmod\Productslider\Model\Slider;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Type
 */
class Type implements OptionSourceInterface
{
    /**
     * Slider types constants
     */
    const SLIDER_TYPE_DEFAULT = "";
    const SLIDER_TYPE_NEW = 'new';
    const SLIDER_TYPE_BESTSELLERS = 'bestsellers';
    const SLIDER_TYPE_MOSTVIEWED = 'mostviewed';
    const SLIDER_TYPE_ONSALE = 'onsale';
    const SLIDER_TYPE_FEATURED = 'featured';
    const SLIDER_TYPE_AUTORELATED = 'autorelated';
    
    /**
     * To option slider types array
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => self::SLIDER_TYPE_DEFAULT, 'label' => __('--- Select Slider Type --')],
            ['value' => self::SLIDER_TYPE_NEW,  'label' => __('New Products')],
            ['value' => self::SLIDER_TYPE_BESTSELLERS, 'label' => __('Bestsellers Products')],
            ['value' => self::SLIDER_TYPE_MOSTVIEWED, 'label' => __('Most Viewed Products')],
            ['value' => self::SLIDER_TYPE_ONSALE, 'label' => __('On Sale Products')],
            ['value' => self::SLIDER_TYPE_FEATURED,  'label' => __('Featured Products')],
            ['value' => self::SLIDER_TYPE_AUTORELATED,  'label' => __('Auto Related Products')],
        ];
    }
}
