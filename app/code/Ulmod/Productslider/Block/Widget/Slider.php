<?php
/**
 * Copyright © Ulmod. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Ulmod\Productslider\Block\Widget;

/**
 * Class Slider
 * @package Ulmod\Productslider\Block\Widget
 */
class Slider extends \Magento\Framework\View\Element\Template
{
    /**
     * Default template to use for slider widget
     */
    const DEFAULT_SLIDER_TEMPLATE = 'widget/slider.phtml';

    /**
     * set slider widget template
     */
    public function _construct()
    {
        if (!$this->hasData('template')) {
            $this->setData('template', self::DEFAULT_SLIDER_TEMPLATE);
        }
        return parent::_construct();
    }
}
