<?php
/**
 * Copyright © Ulmod. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Ulmod\Productslider\Block\Adminhtml\Slider\Edit;

/**
 * Class Form
 * @package Ulmod\Productslider\Block\Adminhtml\Slider\Edit
 */
class Form extends \Magento\Backend\Block\Widget\Form\Generic
{
    /**
     * Prepare form data
     *
     * @return \Magento\Backend\Block\Widget\Form
     */
    protected function _prepareForm()
    {

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            [
                'data' => [
                    'id' => 'edit_form',
                    'action' => $this->getUrl('*/*/save'),
                    'method' => 'post',
                    'enctype' => 'multipart/form-data',
                ],
            ]
        );

        $form->addField(
            'in_slider_products',
            'hidden',
            [
                'name' => 'slider_products',
                'no_span' => true,
                'data_ui_id' => false,
                'value' => '{}'
            ]
        );

        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
