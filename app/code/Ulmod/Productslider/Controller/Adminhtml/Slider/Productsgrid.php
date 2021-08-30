<?php
/**
 * Copyright © Ulmod. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Ulmod\Productslider\Controller\Adminhtml\Slider;

/**
 * Class Productsgrid
 * @package Ulmod\Productslider\Controller\Adminhtml\Slider
 */
class Productsgrid extends \Ulmod\Productslider\Controller\Adminhtml\Slider
{
    /**
     * Display list of additional products to current slider type
     *
     * @return \Magento\Framework\Controller\Result\Raw
     */
    public function execute()
    {
        $sliderId = (int)$this->getRequest()->getParam('id', false);

        $slider = $this->_initSlider($sliderId);
        $this->coreRegistry->register('product_slider', $slider);

        /** @var \Magento\Framework\Controller\Result\Raw $resultRaw */
        $resultRaw = $this->resultRawFactory->create();
        return $resultRaw->setContents(
            $this->layoutFactory->create()->createBlock(
                \Ulmod\Productslider\Block\Adminhtml\Slider\Edit\Tab\Products::class,
                'admin.block.slider.tab.products'
            )->toHtml()
        );
    }
}
