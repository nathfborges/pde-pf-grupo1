<?php
/**
 * Copyright © Ulmod. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Ulmod\Productslider\Block\Adminhtml\Slider;

use Magento\Backend\Block\Widget\Form\Container;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Registry;

/**
 * Class Edit
 * @package Ulmod\Productslider\Block\Adminhtml\Slider
 */
class Edit extends Container
{
    /**
     * Core registry
     *
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        array $data = []
    ) {
        $this->coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Change buttons label, add button
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = 'id';

        $this->_blockGroup = 'Ulmod_Productslider';
        $this->_controller = 'adminhtml_slider';

        parent::_construct();

        $this->buttonList->update(
            'save',
            'label',
            __('Save Slider')
        );
        $this->buttonList->update(
            'delete',
            'label',
            __('Delete Slider')
        );

        $this->buttonList->add(
            'save_and_continue',
            [
                'label' => __('Save and Continue Edit'),
                'class' => 'save',
                'data_attribute' => [
                    'mage-init' => [
                        'button' => [
                            'event' => 'saveAndContinueEdit',
                            'target' => '#edit_form'
                        ],
                    ],
                ]
            ],
            10
        );
    }
}
