<?php
/**
 * Copyright © Ulmod. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Ulmod\Productslider\Block;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;
use Ulmod\Productslider\Model\Slider\Status as SliderStatus;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Registry;
use Ulmod\Productslider\Model\ResourceModel\ProductSlider\Collection;
use Ulmod\Productslider\Model\ResourceModel\ProductSlider\CollectionFactory;

/**
 * Class Slider
 */
class Slider extends Template implements BlockInterface
{
    /**
     * Config path to enable extension
     */
    const XML_PATH_PRODUCT_SLIDER_STATUS = "um_productslider/general/enable_productslider";
   
    /**
     * Main template container
     */
    protected $_template = 'Ulmod_Productslider::slider.phtml';
    
    /**
     * Product slider collection factory
     *
     * @var CollectionFactory
     */
    protected $sliderCollectionFactory;
    
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;
    
    /**
     * @var LayoutInterface
     */
    protected $layoutConfig;
    
    /**
     * @var Registry
     */
    protected $coreRegistry;
    
    /**
     * @param Context $context
     * @param CollectionFactory $sliderCollectionFactory
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        Context $context,
        CollectionFactory $sliderCollectionFactory,
        Registry $registry,
        array $data = []
    ) {
        $this->sliderCollectionFactory = $sliderCollectionFactory;
        $this->scopeConfig = $context->getScopeConfig();
        $this->layoutConfig = $context->getLayout();
        $this->coreRegistry = $registry;
        parent::__construct($context, $data);
    }
    
    /**
     * Render block HTML
     * if extension is enabled then render HTML
     *
     * @return string
     */
    protected function _toHtml()
    {
        if ($this->scopeConfig->getValue(
            self::XML_PATH_PRODUCT_SLIDER_STATUS,
            ScopeInterface::SCOPE_STORES
        )) {
            return parent::_toHtml();
        }
        return false;
    }
    
    /**
     *  Set slider location
     *
     * @return void
     */
    public function setSliderLocation($location, $hide = false)
    {
        $todayDateTime = $this->_localeDate->date()
            ->format('Y-m-d H:i:s');

        $cartHandles = ['0'=>'checkout_cart_index'];

        $checkoutHandles = [
            '0'=>'checkout_index_index',
            '1'=>'checkout_onepage_failure',
             "2"=>'checkout_onepage_success'
        ];

        $currentHandles = $this->layoutConfig->getUpdate()
            ->getHandles();

        /** @var Collection  $sliderCollection */
        $sliderCollection = $this->sliderCollectionFactory->create();

        $storeId = $this->_storeManager->getStore()->getId();

        $sliderCollection->setStoreFilters($storeId);
        $sliderCollection->addFieldToFilter(
            'status',
            SliderStatus::STATUS_ENABLED
        )->addFieldToFilter(
            'start_time',
            ['null' => true]
        )->addFieldToFilter(
            'end_time',
            ['null' => true]
        );
            
        // Check to exclude from cart page
        if (array_intersect($cartHandles, $currentHandles)) {
            $sliderCollection->addFieldToFilter('exclude_from_cart', 0);
        }

        // Check to exclude from checkout
        if (array_intersect($checkoutHandles, $currentHandles)) {
            $sliderCollection->addFieldToFilter('exclude_from_checkout', 0);
        }
        $sliderCollection->addFieldToFilter('location', $location);
 
        /** @var Collection $sliderCollectionTimer */
        $sliderCollectionTimer = $this->sliderCollectionFactory->create();
        $sliderCollectionTimer->setStoreFilters($storeId);
        $sliderCollectionTimer->addFieldToFilter(
            'status',
            SliderStatus::STATUS_ENABLED
        )->addFieldToFilter(
            'start_time',
            ['lteq' => $todayDateTime ]
        )->addFieldToFilter(
            'end_time',
            [
                'or' => [
                    0 => ['date' => true, 'from' => $todayDateTime],
                    1 => ['is' => new \Zend_Db_Expr('null')],
                ]
            ]
        );

        // Check to exclude from cart page
        if (array_intersect($cartHandles, $currentHandles)) {
            $sliderCollectionTimer->addFieldToFilter('exclude_from_cart', 0);
        }

        // Check to exclude from checkout
        if (array_intersect($checkoutHandles, $currentHandles)) {
            $sliderCollectionTimer->addFieldToFilter('exclude_from_checkout', 0);
        }

        $sliderCollectionTimer->addFieldToFilter('location', $location);
  
        $this->setSlider($sliderCollection);
        $this->setSlider($sliderCollectionTimer);
    }
    
    /**
     *  Add child sliders block
     *
     * @param Collection $sliderCollection
     * @return $this
     */
    public function setSlider($sliderCollection)
    {
        foreach ($sliderCollection as $slider) :
            $this->coreRegistry->unregister('slider_id');
            $this->coreRegistry->register('slider_id', $slider->getId());

            $this->append($this->getLayout()
                ->createBlock(\Ulmod\Productslider\Block\Slider\Items::class)
                ->setSlider($slider));
        endforeach;

        return $this;
    }
}
