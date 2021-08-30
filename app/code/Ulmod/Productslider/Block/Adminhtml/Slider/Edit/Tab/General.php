<?php
/**
 * Copyright © Ulmod. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Ulmod\Productslider\Block\Adminhtml\Slider\Edit\Tab;

use Ulmod\Productslider\Model\Slider\Type as SliderType;
use Ulmod\Productslider\Model\Slider\TemplateType as SliderTemplateType;
use Ulmod\Productslider\Model\Slider\Location as SliderLocation;
use Ulmod\Productslider\Model\Slider\Status as SliderStatus;
use Ulmod\Productslider\Model\Slider\FormattedLocation as SliderFormattedLocation;
use Magento\Store\Model\ScopeInterface as Scope;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\Data\FormFactory;
use Magento\Config\Model\Config\Source\Yesno as SourceYesno;
use Magento\Store\Model\System\Store as SystemStore;
     
/**
 * Class General
 */
class General extends \Magento\Backend\Block\Widget\Form\Generic
{
    /**
     * Config path to default slider settings
     */
    const XML_PATH_PRODUCT_SLIDER_DEFAULT_VALUES = 'productslider/slider_settings/' ;

    /**
     * @var SourceYesno
     */
    protected $yesNo;

    /**
     * @var SystemStore
     */
    protected $systemStore;

    /**
     * @var SliderType
     */
    protected $sliderType;
    
    /**
     * @var SliderTemplateType
     */
    protected $sliderTemplateType;
    
    /**
     * @var SliderLocation
     */
    protected $sliderLocation;

    /**
     * @var SliderStatus
     */
    protected $sliderStatus;

    /**
     * @var SliderFormattedLocation
     */
    protected $sliderFormattedLocation;
    
    /**
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param SourceYesno $yesNo
     * @param SliderType $sliderType
     * @param SliderTemplateType $sliderTemplateType
     * @param SliderLocation $sliderLocation
     * @param SliderFormattedLocation $sliderFormattedLocation
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        SourceYesno $yesNo,
        SystemStore $systemStore,
        SliderType $sliderType,
        SliderTemplateType $sliderTemplateType,
        SliderLocation $sliderLocation,
        SliderStatus $sliderStatus,
        SliderFormattedLocation $sliderFormattedLocation,
        array $data = []
    ) {
        $this->yesNo = $yesNo;
        $this->systemStore = $systemStore;
        $this->sliderType = $sliderType;
        $this->sliderTemplateType = $sliderTemplateType;
        $this->sliderLocation = $sliderLocation;
        $this->sliderStatus = $sliderStatus;
        $this->sliderFormattedLocation = $sliderFormattedLocation;
        parent::__construct(
            $context,
            $registry,
            $formFactory,
            $data
        );
    }

    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        $form = $this->_formFactory->create(
            [
                'data' => [
                    'id' => 'edit_form',
                    'action' => $this->getData('action'),
                    'method' => 'post'
                ]
            ]
        );

        $productSlider = $this->_coreRegistry
            ->registry('product_slider');
        $yesno = $this->yesNo->toOptionArray();

        $fieldset = $form->addFieldset(
            'slider_fieldset_general',
            ['legend' => __('General')]
        );
        
        $prodSliderId = $productSlider->getId();
        if ($prodSliderId) {
            $fieldset->addField(
                'slider_id',
                'hidden',
                [
                    'name' => 'slider_id'
                ]
            );
        }

        $fieldset->addField(
            'status',
            'select',
            [
                'label' => __('Status'),
                'title' => __('Status'),
                'name' => 'status',
                'options' => $this->sliderStatus->toOptionArray(),
                'disabled' => false,
            ]
        );
        
        $fieldset->addField(
            'title',
            'text',
            [
                'name' => 'title',
                'title' => __('Title'),
                'label' => __('Title'),
                'required' => true
            ]
        );

        $fieldset->addField(
            'display_title',
            'select',
            [
                'label' => __('Show title'),
                'title' => __('Show title'),
                'name' => 'display_title',
                'note' => __('If Yes, the title block will appear in the frontend.'),
                'values' => $yesno
            ]
        );
        $fieldset->addField(
            'description',
            'textarea',
            [
                'name' => 'description',
                'label' => __('Description'),
                'title' => __('Description'),
                'note' => __('Define the slider description to appear under the title block. 
				Leave empty to hide the description block'),
            ]
        );

        /**
         * Check if single store mode
         */
        $singleStore = $this->_storeManager->isSingleStoreMode();
        if (!$singleStore) {
            $field = $fieldset->addField(
                'store_id',
                'multiselect',
                [
                    'name' => 'stores[]',
                    'label' => __('Store view'),
                    'title' => __('Store view'),
                    'values' => $this->systemStore
                        ->getStoreValuesForForm(false, true),
                    'required' => true,
                ]
            );

            /** @var \Magento\Backend\Block\Store\Switcher\Form\Renderer\Fieldset\Element $renderer */
            $renderer = $this->getLayout()->createBlock(
                \Magento\Backend\Block\Store\Switcher\Form\Renderer\Fieldset\Element::class
            );
            $field->setRenderer($renderer);
        } else {
            $fieldset->addField(
                'store_id',
                'hidden',
                [
                    'name' => 'stores[]',
                    'value' => $this->_storeManager->getStore(true)
                        ->getId()
                ]
            );
        }
        
        $dateFormat = $this->_localeDate->getDateFormat(
            \IntlDateFormatter::SHORT
        );
        $timeFormat = $this->_localeDate->getTimeFormat(
            \IntlDateFormatter::SHORT
        );
        $fieldset->addField(
            'start_time',
            'date',
            [
                'name' => 'start_time',
                'label' => __('Start time'),
                'title' => __('Start time'),
                'date_format' => $dateFormat,
                'time_format' => $timeFormat,
                'note' => $this->_localeDate->getDateTimeFormat(\IntlDateFormatter::SHORT),
            ]
        );
        $fieldset->addField(
            'end_time',
            'date',
            [
                'name' => 'end_time',
                'label' => __('End time'),
                'title' => __('End time'),
                'date_format' => $dateFormat,
                'time_format' => $timeFormat,
                'note' => $this->_localeDate
                    ->getDateTimeFormat(\IntlDateFormatter::SHORT),
            ]
        );
        
        $fieldset = $form->addFieldset(
            'slider_fieldset_appearance',
            ['legend' => __('Display')]
        );
        
        $fieldset->addField(
            'type',
            'select',
            [
                'label' => __('Slider type'),
                'title' => __('Slider type'),
                'name' => 'type',
                'required' => true,
                'values' => $this->sliderType->toOptionArray(),
                'note' => __('Auto related products available only on product page location.'),
            ]
        );
        
        $fieldset->addField(
            'template_type',
            'select',
            [
                'label' => __('Template'),
                'title' => __('Template'),
                'name' => 'template_type',
                'required' => true,
                'values' => $this->sliderTemplateType->toOptionArray(),
                'note' => __('Select template types : slick carousel slider, owl carousel slider or grid'),
            ]
        );
        
        $fieldset->addField(
            'location',
            'select',
            [
                'label' => __('Position'),
                'title' => __('Position'),
                'name' => 'location',
                'required' => false,
                'values' => $this->sliderFormattedLocation->toOptionArray()
            ]
        );
        $fieldset->addField(
            'products_number',
            'text',
            [
                'name' => 'products_number',
                'label' => __('Max products number'),
                'title' => __('Max products number'),
                'note' => __('Max Number of products displayed in slider. Default is 30 products.'),
            ]
        );

        $fieldset->addField(
            'exclude_from_cart',
            'select',
            [
                'label' => __('Exclude from cart'),
                'title' => __('Exclude from cart'),
                'note'  => __('Don\'t display slider at the cart page'),
                'name' => 'exclude_from_cart',
                'values' => $yesno
            ]
        );

        $fieldset->addField(
            'exclude_from_checkout',
            'select',
            [
                'label' => __('Exclude from checkout'),
                'title' => __('Exclude from cart'),
                'note'  => __('Don\'t display slider at the checkout page'),
                'name' => 'exclude_from_checkout',
                'values' => $yesno
            ]
        );
        
        $fieldset = $form->addFieldset(
            'slider_fieldset_products',
            ['legend' => __('Product Options')]
        );
        $fieldset->addField(
            'display_price',
            'select',
            [
                'label' => __('Show price'),
                'title' => __('Show price'),
                'name' => 'display_price',
                'values' => $yesno
            ]
        );

        $fieldset->addField(
            'display_cart',
            'select',
            [
                'label' => __('Show cart'),
                'title' => __('Show add to cart button'),
                'name' => 'display_cart',
                'values' => $yesno
            ]
        );

        $fieldset->addField(
            'display_wishlist',
            'select',
            [
                'label' => __('Show wishlist'),
                'title' => __('Show add to wishlist'),
                'name' => 'display_wishlist',
                'values' => $yesno
            ]
        );

        $fieldset->addField(
            'display_compare',
            'select',
            [
                'label' => __('Show compare'),
                'title' => __('Show add to compare'),
                'name' => 'display_compare',
                'values' => $yesno
            ]
        );
   
       // set default values
        $defaultData = [
            'status' => 1,
            'products_number' => 8,
            'display_price' => 1,
            'display_cart' => 1,
            'display_compare' => 1,
            'display_wishlist' => 1,
        ];

        if (!$productSlider->getId()) {
            $productSlider->addData($defaultData);
        }
        if ($productSlider->getData()) {
            $form->setValues($productSlider->getData());
        }

        $this->setForm($form);

        return parent::_prepareForm();
    }
}
