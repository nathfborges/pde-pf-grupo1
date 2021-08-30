<?php
/**
 * Copyright © Ulmod. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Ulmod\Productslider\Model\Slider;

use Magento\Framework\Data\OptionSourceInterface;
use Ulmod\Productslider\Model\ProductSlider;

/**
 * Class TemplateType
 * @package Ulmod\Productslider\Model\Slider
 */
class TemplateType implements OptionSourceInterface
{
    /**
     *  Template types constants
     */
    const TEMPLATE_TYPE_SLICK = 'slick';
    const TEMPLATE_TYPE_OWL = 'owl';
    const TEMPLATE_TYPE_GRID = 'grid';
    
    /**
     * Return template type options
     * @return array
     */
    public function toOptionArray()
    {
        return [
            [
                'value' => self::TEMPLATE_TYPE_SLICK,
                'label' => __('Slick (Items in Slick Carousel Slider)')
            ],
            [
                'value' => self::TEMPLATE_TYPE_OWL,
                'label' => __('Owl (Items in OWL Carousel Slider)')
            ],
            [
                'value' => self::TEMPLATE_TYPE_GRID,
                'label' => __('Grid (Items in Grid, without Sider)')
            ],
        ];
    }
}
