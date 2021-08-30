<?php
/**
 * Copyright © Ulmod. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Ulmod\Productslider\Block\Adminhtml;

/**
 * Class Slider
 * @package Ulmod\Productslider\Block\Adminhtml
 */
class Slider extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Modify header & button labels
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_blockGroup = 'Ulmod_Productslider';
        $this->_controller = 'adminhtml';
        $this->_headerText = 'Slider';
        $this->_addButtonLabel = __('Create New Slider');
        parent::_construct();
    }
}
