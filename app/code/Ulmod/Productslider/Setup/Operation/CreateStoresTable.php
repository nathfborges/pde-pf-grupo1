<?php
/**
 * Copyright © Ulmod. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Ulmod\Productslider\Setup\Operation;

use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table as DdlTable;

/**
 * Class CreateStoresTable
 */
class CreateStoresTable
{
    /**
     * @param SchemaSetupInterface $setup
     */
    public function execute(SchemaSetupInterface $setup)
    {
        $installer = $setup;
 
         /**
         * Create table 'ulmod_productslider_stores'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('ulmod_productslider_stores')
        )->addColumn(
            'slider_id',
            DdlTable::TYPE_INTEGER,
            null,
            ['nullable' => false, 'unsigned' => true, 'primary' => true],
            'Slider ID'
        )->addColumn(
            'store_id',
            DdlTable::TYPE_SMALLINT,
            null,
            ['unsigned' => true, 'nullable' => false, 'primary' => true],
            'Store ID'
        )->addIndex(
            $installer->getIdxName('ulmod_productslider_stores', ['store_id']),
            ['store_id']
        )->addForeignKey(
            $installer->getFkName(
                'ulmod_productslider_stores',
                'slider_id',
                'ulmod_productslider',
                'slider_id'
            ),
            'slider_id',
            $installer->getTable('ulmod_productslider'),
            'slider_id',
            DdlTable::ACTION_CASCADE
        )->addForeignKey(
            $installer->getFkName(
                'ulmod_productslider_stores',
                'store_id',
                'store',
                'store_id'
            ),
            'store_id',
            $installer->getTable('store'),
            'store_id',
            DdlTable::ACTION_CASCADE
        )->setComment('Ulmod Product slider store table');

        $installer->getConnection()->createTable($table);
    }
}
