<?php
/**
 * Copyright © Ulmod. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Ulmod\Productslider\Controller\Adminhtml\Slider;

/**
 * Class Delete
 * @package Ulmod\Productslider\Controller\Adminhtml\Slider
 */
class Delete extends \Ulmod\Productslider\Controller\Adminhtml\Slider
{
    /**
     * Delete slider page
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $sliderId = $this->getRequest()->getParam('id');
        $slider = $this->sliderFactory->create();
        $slider->load($sliderId);
        if ($slider->getSliderId()) {
            try {
                $slider->delete();
                $this->messageManager->addSuccess(
                    __('The slider has been deleted.')
                );
                $this->_getSession()->setFormData(false);
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/');
    }
}
