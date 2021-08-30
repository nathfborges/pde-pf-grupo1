<?php
/**
 * Copyright © Ulmod. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Ulmod\Productslider\Controller\Adminhtml\Slider;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Ulmod\Productslider\Model\ProductSlider;

/**
 * Class MassDelete
 * @package Ulmod\Productslider\Controller\Adminhtml\Slider
 */
class MassDelete extends \Magento\Backend\App\Action
{

    /**
     * Variable.
     *
     * @var ProductSlider
     */
    protected $productSlider;

    /**
     * Construct.
     *
     * @param Context       $context
     * @param ProductSlider $productSlider
     */
    public function __construct(
        Context $context,
        ProductSlider $productSlider
    ) {
         $this->productSlider = $productSlider;
        parent::__construct($context);
    }
    
    /**
     * Mass delete action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        $itemIds = $this->getRequest()->getParam('id');
        if (!is_array($itemIds) || empty($itemIds)) {
            $this->messageManager->addError(__('Please select item(s).'));
        } else {
            try {
                foreach ($itemIds as $itemId) {
                    $post = $this->productSlider->load($itemId);
                    $post->delete();
                }
                $this->messageManager->addSuccess(
                    __(
                        'A total of %1 record(s) have been deleted.',
                        count($itemIds)
                    )
                );
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }
        $resultRedirect = $this->resultFactory
        ->create(ResultFactory::TYPE_REDIRECT);
        
        return $resultRedirect->setPath('*/*/');
    }
}
