<?php
/**
 * Copyright © Ulmod. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Ulmod\Productslider\Model;

/**
 * Class ProductSlider
 */
class ProductSlider extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Set resource class
     */
    protected function _construct()
    {
        $this->_init(\Ulmod\Productslider\Model\ResourceModel\ProductSlider::class);
    }

    /**
     * Get additional products for current slider
     * @return array
     */
    public function getSelectedSliderProducts()
    {
        if (!$this->getSliderId()) {
            return [];
        }

        $array = $this->getData('slider_products');
        if ($array === null) {
            $array = $this->getResource()->getSliderProducts($this);
            $this->setData('slider_products', $array);
        }
        
        return $array;
    }
}
