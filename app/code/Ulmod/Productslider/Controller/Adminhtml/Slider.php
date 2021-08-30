<?php
/**
 * Copyright © Ulmod. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Ulmod\Productslider\Controller\Adminhtml;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\View\LayoutFactory;
use Magento\Framework\Controller\Result\RawFactory;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Ulmod\Productslider\Model\ProductSliderFactory;
use Magento\Framework\Registry;

/**
 * Class Slider
 * @package Ulmod\Productslider\Controller\Adminhtml
 */
abstract class Slider extends \Magento\Backend\App\Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var ForwardFactory
     */
    protected $resultForwardFactory;

    /**
     * @var RedirectFactory
     */
    protected $resultRedirectFactory;

    /**
     * @var LayoutFactory
     */
    protected $layoutFactory;

    /**
     * @var RawFactory
     */
    protected $resultRawFactory;

    /**
     * @var ProductSliderFactory
     */
    protected $sliderFactory;

    /**
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param LayoutFactory $layoutFactory
     * @param RawFactory $resultRawFactory
     * @param ForwardFactory $resultForwardFactory
     * @param ProductSliderFactory $productsliderFactory
     * @param Registry $coreRegistry
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        LayoutFactory $layoutFactory,
        RawFactory $resultRawFactory,
        ForwardFactory $resultForwardFactory,
        ProductSliderFactory $productSliderFactory,
        Registry $coreRegistry
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->layoutFactory = $layoutFactory;
        $this->resultRawFactory = $resultRawFactory;
        $this->resultForwardFactory = $resultForwardFactory;
        $this->resultRedirectFactory = $context->getResultRedirectFactory();
        $this->sliderFactory = $productSliderFactory;
        $this->coreRegistry = $coreRegistry;
        parent::__construct($context);
    }

    /**
     * Check if admin has permissions to visit related pages
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(
            'Ulmod_Productslider::manage_sliders'
        );
    }

    /**
     * Initialize and return slider object
     *
     * @param int $sliderId
     * @return ProductsliderFactory
     */
    protected function _initSlider($sliderId)
    {
        $model = $this->sliderFactory->create();

        if ($sliderId) {
            $model->load($sliderId);
        }

        return $model;
    }
}
