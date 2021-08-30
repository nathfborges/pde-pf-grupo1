<?php
/**
 * Copyright © Ulmod. All rights reserved.
 * See LICENSE.txt for license details.
 */
 
namespace Ulmod\Productslider\Controller\Adminhtml\Slider;

/**
 * Class Save
 * @package Ulmod\Productslider\Controller\Adminhtml\Slider
 */
class Save extends \Ulmod\Productslider\Controller\Adminhtml\Slider
{
    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        
        $sliderFormData = $this->getRequest()->getPostValue();
        if ($sliderFormData) {
            try {
                $productSlider = $this->sliderFactory->create();
                $sliderId = $this->getRequest()->getParam('slider_id');
                if ($sliderId !== null) {
                    $productSlider->load($sliderId);
                }

                $productSlider->setData($sliderFormData);

                // Check for additional slider products
                if (isset($sliderFormData['slider_products'])
                    && is_string($sliderFormData['slider_products'])
                ) {
                    $products = json_decode(
                        $sliderFormData['slider_products'],
                        true
                    );
                    $productSlider->setPostedProducts($products);
                    $productSlider->unsetData('slider_products');
                }
                
                $productSlider->save();

                if (!$sliderId) {
                    $sliderId = $productSlider->getSliderId();
                }

                $this->messageManager->addSuccess(
                    __('Product slider has been successfully saved.')
                );
                
                $this->_getSession()->setFormData(false);
                
                $backParam = $this->getRequest()->getParam('back');
                if ($backParam == 'edit') {
                    return $resultRedirect->setPath(
                        '*/*/edit',
                        ['id' => $sliderId]
                    );
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError(
                    $e->getMessage()
                );
                $this->messageManager->addException(
                    $e,
                    __('Error occurred during slider saving.')
                );
            }
            
            $this->_getSession()->setFormData($sliderFormData);

            return $resultRedirect->setPath(
                '*/*/edit',
                ['id' => $sliderId]
            );
        }
    }
}
