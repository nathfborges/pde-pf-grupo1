<?php
/**
 * Copyright © Ulmod. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Ulmod\Productslider\Model\ResourceModel;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class ProductSlider
 * @package Ulmod\Productslider\Model\ResourceModel
 */
class ProductSlider extends AbstractDb
{
    /**
     * Slider stores table
     */
    const SLIDER_STORES_TABLE = 'ulmod_productslider_stores';
    
    /**
     * Additional slider products table
     */
    const SLIDER_PRODUCTS_TABLE = 'ulmod_productslider_products';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('ulmod_productslider', 'slider_id');
    }

    /**
     * Additional (featured) products for current slider
     *
     * @param \Ulmod\Productslider\Model\ProductSlider $slider
     * @return array
     */
    public function getSliderProducts($slider)
    {
        $select = $this->getConnection()->select()
            ->from(
                $this->getTable('ulmod_productslider_products'),
                ['product_id', 'position']
            )->where(
                'slider_id = :slider_id'
            );

        $bind = [
            'slider_id' => (int)$slider->getSliderId()
        ];

        return $this->getConnection()
            ->fetchPairs($select, $bind);
    }

    /**
     * Perform actions after object (slider) save
     *
     * @param AbstractModel $object
     * @return $this
     */
    protected function _afterSave(AbstractModel $object)
    {
        $this->_updateSliderProducts($object);
        $this->_updateSliderStores($object);
        
        return parent::_afterSave($object);
    }

    /**
     * Additional slider products table getter
     *
     * @return string
     */
    public function getSliderProductsTable()
    {
        return $this->getTable(self::SLIDER_PRODUCTS_TABLE);
    }
    
    /**
     * Update (save new or delete old) additional slider products
     *
     * @param AbstractModel $object
     * @return $this
     */
    protected function _updateSliderProducts($slider)
    {
        $id = $slider->getSliderId();

        // new slider-product relationships and example of re-save slider
        $products = $slider->getPostedProducts();
        if ($products === null) {
            return $this;
        }

        // old slider-product relationships
        $oldProducts = $slider->getSelectedSliderProducts();

        $connection = $this->getConnection();
        
        // Delete products from slider
        $delete = array_diff_key($oldProducts, $products);
        if (!empty($delete)) {
            $condition = [
                'product_id IN(?)' => array_keys($delete),
                'slider_id=?' => $id
            ];
            $connection->delete(
                $this->getSliderProductsTable(),
                $condition
            );
        }

        // Add products to slider
        $insert = array_diff_key($products, $oldProducts);
        if (!empty($insert)) {
            $data = [];
            foreach ($insert as $productId => $position) {
                $data[] = [
                    'slider_id' => (int)$id,
                    'product_id' => (int)$productId,
                    'position' => (int)$position,
                ];
            }
            $connection->insertMultiple(
                $this->getSliderProductsTable(),
                $data
            );
        }
    
        /**
         * Find product ids which are presented in both arrays
         * and saved before (check $oldProducts array)
         */
        $update = array_intersect_key($products, $oldProducts);
        $update = array_diff_assoc($update, $oldProducts);

        // Update product positions in category
        if (!empty($update)) {
            foreach ($update as $productId => $position) {
                $where = [
                    'slider_id = ?' => (int)$id,
                    'product_id = ?' => (int)$productId
                ];
                $bind = ['position' => (int)$position];
                $connection->update(
                    $this->getSliderProductsTable(),
                    $bind,
                    $where
                );
            }
        }

        return $this;
    }

    /**
     * Get store ids to which specified item is assigned
     *
     * @param int $id
     * @return array
     */
    public function lookupStoreIds($id)
    {
        $connection = $this->getConnection();
        $select = $connection->select()
            ->from(
                $this->getTable(self::SLIDER_STORES_TABLE),
                'store_id'
            )->where(
                'slider_id = :slider_id'
            );

        $binds = [':slider_id' => (int)$id];

        return $connection->fetchCol($select, $binds);
    }

    /**
     * Perform operations after object load
     *
     * @param AbstractModel $object
     * @return $this
     */
    protected function _afterLoad(AbstractModel $object)
    {
        if ($object->getId()) {
            $stores = $this->lookupStoreIds(
                $object->getId()
            );
            $object->setData('store_id', $stores);
        }

        return parent::_afterLoad($object);
    }

    /**
     * @param AbstractModel $object
     * @return $this
     */
    protected function _updateSliderStores(AbstractModel $object)
    {
        $oldStores = $this->lookupStoreIds($object->getId());
        
        $newStores = (array)$object->getStores();
        if (empty($newStores)) {
            $newStores = (array)$object->getStoreId();
        }

        $table = $this->getTable(self::SLIDER_STORES_TABLE);
        
        $delete = array_diff($oldStores, $newStores);
        if ($delete) {
            $where = [
                'slider_id = ?' => (int)$object->getId(),
                'store_id IN (?)' => $delete
            ];
            $this->getConnection()
                ->delete($table, $where);
        }
        
        $insert = array_diff($newStores, $oldStores);
        if ($insert) {
            $data = [];
            foreach ($insert as $storeId) {
                $data[] = [
                    'slider_id' => (int)$object->getId(),
                    'store_id' => (int)$storeId
                ];
            }
            $this->getConnection()
                ->insertMultiple($table, $data);
        }

        return parent::_afterSave($object);
    }
}
