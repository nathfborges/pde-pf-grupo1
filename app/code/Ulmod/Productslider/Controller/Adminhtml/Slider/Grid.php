<?php
/**
 * Copyright © Ulmod. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Ulmod\Productslider\Controller\Adminhtml\Slider;

/**
 * Class Grid
 * @package Ulmod\Productslider\Controller\Adminhtml\Slider
 */
class Grid extends \Ulmod\Productslider\Controller\Adminhtml\Slider
{
    /**
     * Prevent entire page loading
     * @return void
     */
    public function execute()
    {
        $this->_view->loadLayout(false);
        $this->_view->renderLayout();
    }
}
