<?php
/**
 * Copyright © Ulmod. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Ulmod\Productslider\Setup\Operation;

use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table as DdlTable;

/**
 * Class CreateProductsliderTable
 */
class CreateProductsliderTable
{
    /**
     * @param SchemaSetupInterface $setup
     */
    public function execute(SchemaSetupInterface $setup)
    {
        $installer = $setup;

        /**
         * Create table 'ulmod_productslider'
         */
          $table = $installer->getConnection()
             ->newTable(
                 $installer->getTable('ulmod_productslider')
             )->addColumn(
                 'slider_id',
                 DdlTable::TYPE_INTEGER,
                 null,
                 [
                    'nullable' => false,
                    'unsigned' => true,
                    'identity' => true,
                    'primary' => true
                 ],
                 'Slider ID'
             )->addColumn(
                 'title',
                 DdlTable::TYPE_TEXT,
                 256,
                 ['nullable' => false, 'default' => ''],
                 'Slider title'
             )->addColumn(
                 'display_title',
                 DdlTable::TYPE_SMALLINT,
                 null,
                 ['nullable' => false, 'default' => '1'],
                 'Display title'
             )
                ->addColumn(
                    'status',
                    DdlTable::TYPE_SMALLINT,
                    null,
                    ['nullable' => false, 'default' => '1'],
                    'Slider status'
                )
                ->addColumn(
                    'description',
                    DdlTable::TYPE_TEXT,
                    null,
                    [],
                    'Description'
                )
                ->addColumn(
                    'type',
                    DdlTable::TYPE_TEXT,
                    256,
                    ['nullable' => false, 'default' => ''],
                    'Slider type'
                )
                ->addColumn(
                    'template_type',
                    DdlTable::TYPE_TEXT,
                    256,
                    ['nullable' => false, 'default' => ''],
                    'Template type'
                )
                ->addColumn(
                    'exclude_from_cart',
                    DdlTable::TYPE_SMALLINT,
                    null,
                    ['nullable' => false, 'default' => '0'],
                    'Don\'t display slider on cart page '
                )
                ->addColumn(
                    'exclude_from_checkout',
                    DdlTable::TYPE_SMALLINT,
                    null,
                    ['nullable' => false, 'default' => '0'],
                    'Don\'t display slider on checkout '
                )
                ->addColumn(
                    'location',
                    DdlTable::TYPE_TEXT,
                    256,
                    ['nullable' => false, 'default' => ''],
                    'Slider location or position'
                )
                ->addColumn(
                    'start_time',
                    DdlTable::TYPE_DATETIME,
                    null,
                    ['nullable' => true],
                    'Slider start time'
                )
                   ->addColumn(
                       'end_time',
                       DdlTable::TYPE_DATETIME,
                       null,
                       ['nullable' => true],
                       'Slider end time'
                   )
                    ->addColumn(
                        'navigation_enable',
                        DdlTable::TYPE_SMALLINT,
                        null,
                        ['nullable' => false, 'default' => '1'],
                        'Slider Enable Navigation'
                    )
                    ->addColumn(
                        'navigation_show',
                        DdlTable::TYPE_TEXT,
                        100,
                        ['nullable' => false, 'default' => 'hover'],
                        'Slider Show Navigation'
                    )
                    ->addColumn(
                        'navigation_position',
                        DdlTable::TYPE_TEXT,
                        100,
                        ['nullable' => false, 'default' => 'bothsides'],
                        'Slider Navigation Position'
                    )
                   ->addColumn(
                       'navigation_hover',
                       DdlTable::TYPE_TEXT,
                       32,
                       ['nullable' => true, 'default' => '#666666'],
                       'Slider Navigation Hover Color'
                   )
                   ->addColumn(
                       'pagination_enable',
                       DdlTable::TYPE_SMALLINT,
                       null,
                       ['nullable' => false, 'default' => '1'],
                       'Slider Enable Pagination'
                   )
                    ->addColumn(
                        'pagination_show',
                        DdlTable::TYPE_TEXT,
                        100,
                        ['nullable' => false, 'default' => 'always'],
                        'Slider Show Pagination'
                    )
                   ->addColumn(
                       'pagination_hover',
                       DdlTable::TYPE_TEXT,
                       32,
                       ['nullable' => true, 'default' => '#cccccc'],
                       'Slider Pagination Hover Color'
                   )
                ->addColumn(
                    'infinite',
                    DdlTable::TYPE_BOOLEAN,
                    null,
                    ['nullable' => false, 'default' => '1'],
                    'Infinite loop'
                )
                ->addColumn(
                    'slides_to_show',
                    DdlTable::TYPE_SMALLINT,
                    null,
                    ['nullable' => false, 'default' => '5'],
                    'Slides to show'
                )
                ->addColumn(
                    'slides_to_scroll',
                    DdlTable::TYPE_SMALLINT,
                    null,
                    ['nullable' => false, 'default' => '2'],
                    'Slides to scroll'
                )
                ->addColumn(
                    'speed',
                    DdlTable::TYPE_SMALLINT,
                    null,
                    ['nullable' => false, 'default' => '500'],
                    'Speed in ms'
                )
                ->addColumn(
                    'autoplay',
                    DdlTable::TYPE_BOOLEAN,
                    null,
                    ['nullable' => false, 'default' => '1'],
                    'Autoplay'
                )
                ->addColumn(
                    'autoplay_speed',
                    DdlTable::TYPE_SMALLINT,
                    null,
                    ['nullable' => false, 'default' => '1000'],
                    'Autoplay speed'
                )
                ->addColumn(
                    'rtl',
                    DdlTable::TYPE_BOOLEAN,
                    null,
                    ['nullable' => false, 'default' => '0'],
                    'Right to left'
                )
                ->addColumn(
                    'breakpoint_large',
                    DdlTable::TYPE_SMALLINT,
                    null,
                    ['nullable' => false, 'default' => '1024'],
                    'Large breakpoint'
                )
                ->addColumn(
                    'large_slides_to_show',
                    DdlTable::TYPE_SMALLINT,
                    null,
                    ['nullable' => false, 'default' => '5'],
                    'Slides to show for large'
                )
                ->addColumn(
                    'large_slides_to_scroll',
                    DdlTable::TYPE_SMALLINT,
                    null,
                    ['nullable' => false, 'default' => '2'],
                    'Slides to scroll for large'
                )
                ->addColumn(
                    'breakpoint_medium',
                    DdlTable::TYPE_SMALLINT,
                    null,
                    ['nullable' => false, 'default' => '768'],
                    'Medium breakpoint'
                )
                ->addColumn(
                    'medium_slides_to_show',
                    DdlTable::TYPE_SMALLINT,
                    null,
                    ['nullable' => false, 'default' => '2'],
                    'Slides to show for medium'
                )
                ->addColumn(
                    'medium_slides_to_scroll',
                    DdlTable::TYPE_SMALLINT,
                    null,
                    ['nullable' => false, 'default' => '1'],
                    'Slides to scroll for Medium'
                )
                ->addColumn(
                    'breakpoint_small',
                    DdlTable::TYPE_SMALLINT,
                    null,
                    ['nullable' => false, 'default' => '480'],
                    'Small breakpoint'
                )
                ->addColumn(
                    'small_slides_to_show',
                    DdlTable::TYPE_SMALLINT,
                    null,
                    ['nullable' => false, 'default' => '2'],
                    'Slides to show for small'
                )
                ->addColumn(
                    'small_slides_to_scroll',
                    DdlTable::TYPE_SMALLINT,
                    null,
                    ['nullable' => false, 'default' => '1'],
                    'Slides to scroll for small'
                )
                ->addColumn(
                    'display_price',
                    DdlTable::TYPE_SMALLINT,
                    null,
                    ['unsigned' => true, 'nullable' => false, 'default' => '1'],
                    'Display product price'
                )
                ->addColumn(
                    'display_cart',
                    DdlTable::TYPE_SMALLINT,
                    null,
                    ['unsigned' => true, 'nullable' => false, 'default' => '1'],
                    'Display add to cart button'
                )
                ->addColumn(
                    'display_wishlist',
                    DdlTable::TYPE_SMALLINT,
                    null,
                    ['unsigned' => true, 'nullable' => false, 'default' => '1'],
                    'Display add to wish list'
                )
                ->addColumn(
                    'display_compare',
                    DdlTable::TYPE_SMALLINT,
                    null,
                    ['unsigned' => true, 'nullable' => false, 'default' => '1'],
                    'Display add to compare'
                )
                ->addColumn(
                    'products_number',
                    DdlTable::TYPE_SMALLINT,
                    null,
                    ['unsigned' => true, 'nullable' => false],
                    'Number of products in slider'
                )
                ->addColumn(
                    'enable_swatches',
                    DdlTable::TYPE_SMALLINT,
                    null,
                    ['unsigned' => true, 'nullable' => false],
                    'Enable color swatches'
                )
                ->addColumn(
                    'enable_ajaxcart',
                    DdlTable::TYPE_SMALLINT,
                    null,
                    ['unsigned' => true, 'nullable' => false],
                    'Enable ajax add to cart'
                )->addIndex(
                    $installer->getIdxName('ulmod_productslider', ['slider_id']),
                    ['slider_id']
                )->setComment('Ulmod Main Product Slider Table');
               $installer->getConnection()->createTable($table);
    }
}
