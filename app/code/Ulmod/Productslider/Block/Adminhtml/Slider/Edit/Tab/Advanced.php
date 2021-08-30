<?php
/**
 * Copyright © Ulmod. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Ulmod\Productslider\Block\Adminhtml\Slider\Edit\Tab;

use Ulmod\Productslider\Model\ProductSlider;
use \Magento\Store\Model\ScopeInterface as Scope;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\Data\FormFactory;
use Magento\Config\Model\Config\Source\Yesno as SourceYesno;

/**
 * Class Advanced
 * @package Ulmod\Productslider\Block\Adminhtml\Slider\Edit\Tab
 */
class Advanced extends \Magento\Backend\Block\Widget\Form\Generic
{
    /**
     * Config path for default slider settings
     */
    const XML_PATH_PRODUCT_SLIDER_DEFAULT_VALUES = 'productslider/slider_settings/' ;

    /**
     * @var SourceYesno
     */
    protected $yesNo;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param SourceYesno $yesNo
     * @param ScopeConfigInterface $scopeConfig
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        SourceYesno $yesNo,
        array $data = []
    ) {
        $this->yesNo = $yesNo;
        $this->scopeConfig = $context->getScopeConfig();
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        $form = $this->_formFactory->create();

        $productSlider = $this->_coreRegistry->registry('product_slider');
        $yesno = $this->yesNo->toOptionArray();
     
        $fieldset = $form->addFieldset(
            'slider_fieldset_navigation',
            ['legend' => __('Slider Navigation')]
        );
        
        $fieldset->addField(
            'navigation_enable',
            'select',
            [
                'name' => 'navigation_enable',
                'label' => __('Enable Navigation'),
                'title' => __('Enable Navigation'),
                'note' => __('If Yes, navigation arrows will show on the slider'),
                'values' => $yesno
            ]
        );
     
        $fieldset = $form->addFieldset(
            'slider_fieldset_pagination',
            ['legend' => __('Slider Pagination')]
        );
        
        $fieldset->addField(
            'pagination_enable',
            'select',
            [
                'name' => 'pagination_enable',
                'label' => __('Enable Pagination'),
                'title' => __('Enable Pagination'),
                'note' => __('If Yes, pagination dots will show on the slider'),
                'values' => $yesno
            ]
        );

        $fieldset = $form->addFieldset(
            'slider_fieldset_effects',
            ['legend' => __('Slider Effects')]
        );
        
        $fieldset->addField(
            'infinite',
            'select',
            [
                'name' => 'infinite',
                'label' => __('Infinite loop sliding'),
                'title' => __('Infinite loop sliding'),
                'note' => __('Inifnity loop'),
                'values' => $yesno
            ]
        );

        $fieldset->addField(
            'slides_to_show',
            'text',
            [
                'name' => 'slides_to_show',
                'label' => __('Slides to show'),
                'title' => __('Number of slides to show')
            ]
        );

        $fieldset->addField(
            'slides_to_scroll',
            'text',
            [
                'name' => 'slides_to_scroll',
                'label' => __('Slides to scroll'),
                'title' => __('Number of slides to scroll')
            ]
        );

        $fieldset->addField(
            'speed',
            'text',
            [
                'name' => 'speed',
                'label' => __('Speed'),
                'title' => __('Speed'),
                'note' => __('Slide animation speed')
            ]
        );

        $fieldset->addField(
            'autoplay',
            'select',
            [
                'name' => 'autoplay',
                'label' => __('Autoplay'),
                'title' => __('Autoplay'),
                'values' => $yesno
            ]
        );

        $fieldset->addField(
            'autoplay_speed',
            'text',
            [
                'name' => 'autoplay_speed',
                'label' => __('Autoplay speed'),
                'title' => __('Autoplay speed')
            ]
        );

        $fieldset->addField(
            'rtl',
            'select',
            [
                'name' => 'rtl',
                'label' => __('Right to left'),
                'title' => __('Right to left'),
                'note' => __('Change the slider direction to become right-to-left'),
                'values' => $yesno
            ]
        );

        $fieldset = $form->addFieldset(
            'slider_fieldset_large',
            ['legend' => __('Large display settings (For responsive web design)')]
        );

        $fieldset->addField(
            'breakpoint_large',
            'text',
            [
                'name' => 'breakpoint_large',
                'label' => __('Breakpoint large screen'),
                'title' => __('Breakpoint large screen')
            ]
        );

        $fieldset->addField(
            'large_slides_to_show',
            'text',
            [
                'name' => 'large_slides_to_show',
                'label' => __('Slides to show on large breakpoint'),
                'title' => __('Slides to show on large breakpoint')
            ]
        );

        $fieldset->addField(
            'large_slides_to_scroll',
            'text',
            [
                'name' => 'large_slides_to_scroll',
                'label' => __('Slides to scroll on large breakpoint'),
                'title' => __('Slides to scroll on large breakpoint')
            ]
        );

        $fieldset = $form->addFieldset(
            'slider_fieldset_medium',
            ['legend' => __('Medium display settings (For responsive web design)')]
        );

        $fieldset->addField(
            'breakpoint_medium',
            'text',
            [
                'name' => 'breakpoint_medium',
                'label' => __('Breakpoint medium screen'),
                'title' => __('Breakpoint medium screen')
            ]
        );

        $fieldset->addField(
            'medium_slides_to_show',
            'text',
            [
                'name' => 'medium_slides_to_show',
                'label' => __('Slides to show on medium breakpoint'),
                'title' => __('Slides to show on medium breakpoint')
            ]
        );

        $fieldset->addField(
            'medium_slides_to_scroll',
            'text',
            [
                'name' => 'medium_slides_to_scroll',
                'label' => __('Slides to scroll on medium breakpoint'),
                'title' => __('Slides to scroll on medium breakpoint')
            ]
        );

        $fieldset = $form->addFieldset(
            'slider_fieldset_small',
            ['legend' => __('Small display settings (For responsive web design)')]
        );

        $fieldset->addField(
            'breakpoint_small',
            'text',
            [
                'name' => 'breakpoint_small',
                'label' => __('Breakpoint small screen'),
                'title' => __('Breakpoint small screen')
            ]
        );

        $fieldset->addField(
            'small_slides_to_show',
            'text',
            [
                'name' => 'small_slides_to_show',
                'label' => __('Slides to show on small breakpoint'),
                'title' => __('Slides to show on small breakpoint')
            ]
        );

        $fieldset->addField(
            'small_slides_to_scroll',
            'text',
            [
                'name' => 'small_slides_to_scroll',
                'label' => __('Slides to scroll on small breakpoint'),
                'title' => __('Slides to scroll on small breakpoint')
            ]
        );
        
    // set default values
        $defaultData = [
            'navigation_enable' => 1,
            'pagination_enable' => 1,
            'pagination_show' => 'always',
            'infinite' => 0,
            'slides_to_show' => 5,
            'slides_to_scroll' => 2,
            'pagination_enable' => 1,
            'speed' => 500,
            'autoplay' => 1,
            'autoplay_speed' => 1000,
            'breakpoint_large' => 1024,
            'large_slides_to_show' => 5,
            'large_slides_to_scroll' => 2,
            'breakpoint_medium' => 768,
            'medium_slides_to_show' => 2,
            'medium_slides_to_scroll' => 1,
            'breakpoint_small' => 480,
            'small_slides_to_show' => 2,
            'small_slides_to_scroll' => 1,
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
