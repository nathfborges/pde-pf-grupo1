<?php
/**
 * Copyright © Ulmod. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Ulmod\Productslider\Controller\Adminhtml\Slider;

/**
 * Class NewAction
 * @package Ulmod\Productslider\Controller\Adminhtml\Slider
 */
class NewAction extends \Ulmod\Productslider\Controller\Adminhtml\Slider
{
    /**
     * Create new slider action
     *
     * @return \Magento\Backend\Model\View\Result\Forward
     */
    public function execute()
    {
        //Forward to the edit action
        $resultForward = $this->resultForwardFactory->create();
        $resultForward->forward('edit');
        return $resultForward;
    }
}
