<?php
/**
 * Copyright © Ulmod. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Ulmod\Productslider\Controller\Adminhtml\Slider;

/**
 * Class Index
 * @package Ulmod\Productslider\Controller\Adminhtml\Slider
 */
class Index extends \Ulmod\Productslider\Controller\Adminhtml\Slider
{
    /**
     * Slider index action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        if ($this->getRequest()->getQuery('ajax')) {
            $resultForward = $this->resultForwardFactory->create();
            $resultForward->forward('grid');
            return $resultForward;
        }

        $resultPage = $this->resultPageFactory->create();
        $resultPage->addBreadcrumb(
            __('Sliders'),
            __('Sliders')
        );

        $resultPage->addBreadcrumb(
            __('Manage Product Sliders'),
            __('Manage Product Sliders')
        );

        return $resultPage;
    }
}
