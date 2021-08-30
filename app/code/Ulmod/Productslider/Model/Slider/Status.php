<?php
/**
 * Copyright © Ulmod. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Ulmod\Productslider\Model\Slider;

use Magento\Framework\Option\ArrayInterface;

/**
 * Class Status
 */
class Status implements ArrayInterface
{
    /**
     * Slider statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    
    /**
     * To option slider statuses array
     * @return array
     */
    public function toOptionArray()
    {
        return [
            self::STATUS_ENABLED => 'Enabled',
            self::STATUS_DISABLED => 'Disabled',
        ];
    }
}
