<?php
/**
 * Copyright © Ulmod. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Ulmod\Productslider\Block\Adminhtml\Slider\Edit;

use Magento\Backend\Block\Template\Context;
use Magento\Framework\Json\EncoderInterface;
use Magento\Backend\Model\Auth\Session as AuthSession;
use Magento\Framework\Registry;

/**
 * Class Tabs
 * @package Ulmod\Productslider\Block\Adminhtml\Slider\Edit
 */
class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * Template file for the tabs
     */
    protected $_template = 'widget/tabs.phtml';

    /**
     * JSON Encoder
     *
     * @var EncoderInterface
     */
    protected $jsonEncoder;

    /**
     * @var Registry
     */
    protected $coreRegistry = null;

    /**
     * @param Context $context
     * @param EncoderInterface $jsonEncoder
     * @param AuthSession $authSession
     * @param Registry $registry
     * @param array $data
     */
    public function __construct(
        Context $context,
        EncoderInterface $jsonEncoder,
        AuthSession $authSession,
        Registry $registry,
        array $data = []
    ) {
        $this->jsonEncoder = $jsonEncoder;
        $this->coreRegistry = $registry;
        parent::__construct(
            $context,
            $jsonEncoder,
            $authSession,
            $data
        );
    }

    /**
     * Initialize Tabs
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('product_slider_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Information'));
    }

    /**
     * @return $this
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'general',
            [
                'label' => __('General'),
                'title' => __('General'),
                'content' => $this->getChildHtml('admin.block.slider.tab.general'),
                'active' => true
            ]
        );

            $this->addTab(
                'advanced',
                [
                'label' => __('Behavior'),
                'title' => __('Behavior'),
                'content' => $this->getChildHtml('admin.block.slider.tab.advanced'),
                ]
            );

            $this->addTab(
                'products',
                [
                'label' => __('Products'),
                'title' => __('Products'),
                'content' => $this->getChildHtml('admin.block.slider.tab.products')
                ]
            );

            return parent::_beforeToHtml();
    }

    /**
     * Retrieve product slider object
     *
     * @return \Ulmod\Productslider\Model\ProductSlider
     */
    public function getCurrentSlider()
    {
        return $this->coreRegistry->registry('product_slider');
    }

    /**
     * Retrieve additional slider products
     *
     * @return string
     */
    public function getProductsJson()
    {
        $products = $this->getCurrentSlider()->getSelectedSliderProducts();
        if (!empty($products)) {
            return $this->jsonEncoder->encode($products);
        }
        return '{}';
    }
}
