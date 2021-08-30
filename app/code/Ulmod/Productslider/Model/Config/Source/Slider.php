<?php
/**
 * Copyright © Ulmod. All rights reserved.
 * See LICENSE.txt for license details.
 */
 
namespace Ulmod\Productslider\Model\Config\Source;

use Ulmod\Productslider\Model\ProductSliderFactory;

/**
 * Class Slider
 * @package Ulmod\Productslider\Model\Config\Source
 */
class Slider implements \Magento\Framework\Option\ArrayInterface
{
   /**
    * @var ProductSliderFactory
    */
    protected $productsliderFactory;
    
    /**
     * @param ProductSliderFactory $productsliderFactory
     */
    public function __construct(
        ProductSliderFactory $productsliderFactory
    ) {
        $this->productsliderFactory = $productsliderFactory;
    }
    
    /**
     * Get sliders
     * @return void
     */
    public function getSliders()
    {
        $sliderModel = $this->productsliderFactory->create();
        return $sliderModel->getCollection()->getData();
    }
    
    /**
     * To option array
     * @return array
     */
    public function toOptionArray()
    {
        $sliders = [];
        foreach ($this->getSliders() as $slider) {
            array_push($sliders, [
                'value' => $slider['slider_id'],
                'label' => $slider['title']
            ]);
        }
        return $sliders;
    }
}
