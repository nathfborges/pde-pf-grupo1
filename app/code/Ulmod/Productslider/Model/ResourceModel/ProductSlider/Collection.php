<?php
/**
 * Copyright © Ulmod. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Ulmod\Productslider\Model\ResourceModel\ProductSlider;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Ulmod\Productslider\Model\ResourceModel\ProductSlider;

/**
 * Class Collection
 * @package Ulmod\Productslider\Model\ResourceModel\ProductSlider
 */
class Collection extends AbstractCollection
{

    /**
     * Variable.
     *
     * @var string
     */
    protected $_idFieldName = 'slider_id';
    
    /**
     * Initialize resources
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Ulmod\Productslider\Model\ProductSlider::class,
            \Ulmod\Productslider\Model\ResourceModel\ProductSlider::class
        );
    }

    public function setStoreFilters($storeId)
    {
        $stores = [
            \Magento\Store\Model\Store::DEFAULT_STORE_ID,
            $storeId
        ];
        $this->getSelect()
          ->joinLeft(
              ['trs' => $this->getTable(ProductSlider::SLIDER_STORES_TABLE)],
              'main_table.slider_id = trs.slider_id',
              []
          )->where('trs.store_id IN (?)', $stores);
    }
}
