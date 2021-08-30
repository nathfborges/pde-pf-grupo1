<?php
/**
 * Copyright © Ulmod. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Ulmod\Productslider\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\InstallSchemaInterface;
use Ulmod\Productslider\Setup\Operation\CreateProductsliderTable;
use Ulmod\Productslider\Setup\Operation\CreateProductsTable;
use Ulmod\Productslider\Setup\Operation\CreateStoresTable;

/**
 * Class InstallSchema
 */
class InstallSchema implements InstallSchemaInterface
{

    /**
     * @var CreateProductsliderTable
     */
    private $createProductsliderTable;

    /**
     * @var CreateProductsTable
     */
    private $createProductsTable;
    
    /**
     * @var CreateStoresTable
     */
    private $createStoresTable;
    
    /**
     * @param CreateProductsliderTable $createProductsliderTable
     * @param CreateProductsTable $createProductsTable
     * @param CreateStoresTable $createStoresTable
     */
    public function __construct(
        CreateProductsliderTable $createProductsliderTable,
        CreateProductsTable $createProductsTable,
        CreateStoresTable $createStoresTable
    ) {
        $this->createProductsliderTable = $createProductsliderTable;
        $this->createProductsTable = $createProductsTable;
        $this->createStoresTable = $createStoresTable;
    }
    
    /**
     * {@inheritdoc}
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        // Drop tables if exists
        $installer->getConnection()->dropTable(
            $installer->getTable('ulmod_productslider')
        );
        $installer->getConnection()->dropTable(
            $installer->getTable('ulmod_productslider_products')
        );
        $installer->getConnection()->dropTable(
            $installer->getTable('ulmod_productslider_stores')
        );

        // Create tables
        $this->createProductsliderTable->execute($setup);
        $this->createProductsTable->execute($setup);
        $this->createStoresTable->execute($setup);
        
        $installer->endSetup();
    }
}
