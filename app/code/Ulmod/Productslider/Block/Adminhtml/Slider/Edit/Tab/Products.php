<?php
/**
 * Copyright © Ulmod. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Ulmod\Productslider\Block\Adminhtml\Slider\Edit\Tab;

use Magento\Store\Model\ScopeInterface;
use Magento\Directory\Model\Currency as ModelCurrency;
use Magento\Backend\Block\Template\Context;
use Magento\Catalog\Model\ProductFactory;
use Magento\Store\Model\WebsiteFactory;
use Magento\Backend\Helper\Data as HelperData;
use Magento\Framework\Registry;
use Magento\Framework\App\ResourceConnection;
use Magento\Catalog\Model\Product\Visibility as CatalogProductVisibility;

/**
 * Class Products
 */
class Products extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * @var ProductFactory
     */
    protected $productFactory;

    /**
     * @var ResourceConnection
     */
    protected $resource;

    /**
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * @var CatalogProductVisibility
     */
    protected $catalogProductVisibility;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var WebsiteFactory
     */
    protected $websiteFactory;

    /**
     * @param Context $context
     * @param ProductFactory $productFactory
     * @param WebsiteFactory $websiteFactory
     * @param HelperData $helper
     * @param Registry $coreRegistry
     * @param ResourceConnection $resource
     * @param CatalogProductVisibility $catalogProductVisibility
     * @param array $data
     */
    public function __construct(
        Context $context,
        ProductFactory $productFactory,
        WebsiteFactory $websiteFactory,
        HelperData $helper,
        Registry $coreRegistry,
        ResourceConnection $resource,
        CatalogProductVisibility $catalogProductVisibility,
        array $data = []
    ) {
        $this->productFactory = $productFactory;
        $this->websiteFactory = $websiteFactory;
        $this->coreRegistry = $coreRegistry;
        $this->resource = $resource;
        $this->catalogProductVisibility = $catalogProductVisibility;
        $this->storeManager = $context->getStoreManager();
        parent::__construct($context, $helper, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('products_grid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * @param \Magento\Backend\Block\Widget\Grid\Column $column
     * @return $this
     */
    protected function _addColumnFilterToCollection($column)
    {
        // Set custom filter for in slider flag
        $columnId = $column->getId();
        if ($columnId == 'in_slider') {
            $productIds = $this->_getSelectedProducts();
            if (empty($productIds)) {
                $productIds = 0;
            }
            
            $columnValue = $column->getFilter()->getValue();
            if ($columnValue) {
                $this->getCollection()
                    ->addFieldToFilter(
                        'entity_id',
                        ['in' => $productIds]
                    );
            } elseif (!empty($productIds)) {
                $this->getCollection()
                    ->addFieldToFilter(
                        'entity_id',
                        ['nin' => $productIds]
                    );
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        
        return $this;
    }

    /**
     * Retrieve product slider object
     *
     * @return \Ulmod\Productslider\Model\ProductSlider
     */
    public function getSlider()
    {
        return $this->coreRegistry
            ->registry('product_slider');
    }
    
    /**
     * @return \Magento\Backend\Block\Widget\Grid
     */
    protected function _prepareCollection()
    {
        $sliderId = $this->getSlider()->getSliderId();
        if ($sliderId) {
            $this->setDefaultFilter(['in_slider' => 1]);
        }

        $inCatalogIds = $this->catalogProductVisibility
            ->getVisibleInCatalogIds();
            
        $collection = $this->productFactory->create()
            ->getCollection();
        $collection->addAttributeToSelect('name')
            ->addAttributeToSelect('sku')
            ->addAttributeToSelect('price')
            ->addAttributeToFilter(
                'visibility',
                ['in' => $inCatalogIds]
            )
            ->joinField(
                'position',
                'ulmod_productslider_products',
                'position',
                'product_id=entity_id',
                'slider_id=' . (int)$this->getRequest()
                    ->getParam('id', 0),
                'left'
            );

        $this->setCollection($collection);
        
        $this->getCollection()->addWebsiteNamesToResult();

        return  parent::_prepareCollection();
    }

    /**
     * @return \Magento\Backend\Block\Widget\Grid\Extended
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'in_slider',
            [
                'type' => 'checkbox',
                'name' => 'in_slider',
                'index' => 'entity_id',
                'header_css_class' => 'col-select col-massaction',
                'column_css_class' => 'col-select col-massaction',
                'values' => $this->_getSelectedProducts()
            ]
        );

        $this->addColumn(
            'entity_id',
            [
                 'header' => __('ID'),
                 'index' => 'entity_id',
                 'header_css_class' => 'col-id',
                 'column_css_class' => 'col-id',
                 'sortable' => true
             ]
        );
        
        $this->addColumn(
            'sku',
            [
                 'header' => __('SKU'),
                 'index' => 'sku'
                 ]
        );

         $this->addColumn(
             'name',
             [
                 'header' => __('Name'),
                 'index' => 'name'
             ]
         );
             $this->addColumn(
                 'price',
                 [
                 'header' => __('Price'),
                 'type' => 'currency',
                 'currency_code' => (string)$this->_scopeConfig->getValue(
                     ModelCurrency::XML_PATH_CURRENCY_BASE,
                     ScopeInterface::SCOPE_STORE
                 ),
                 'index' => 'price'
                 ]
             );

        $singleStoreMode = $this->storeManager->isSingleStoreMode();
        if (!$singleStoreMode) {
            $this->addColumn(
                'websites',
                [
                    'header' => __('Websites'),
                    'index' => 'websites',
                    'type' => 'options',
                    'sortable' => false,
                    'options' => $this->websiteFactory->create()
                        ->getCollection()->toOptionHash(),
                    'header_css_class' => 'col-websites',
                    'column_css_class' => 'col-websites'
                ]
            );
        }

        $this->addColumn(
            'position',
            [
                'header' => __('Position'),
                'type' => 'number',
                'index' => 'position',
                'editable' => true
            ]
        );

        return parent::_prepareColumns();
    }

    /**
     * Get selected slider products
     *
     * @return array
     */
    public function getSelectedSliderProducts()
    {
        $slider_id = $this->getRequest()->getParam('id');

        $select = $this->resource->getConnection()->select()
        ->from(
            'ulmod_productslider_products',
            ['product_id', 'position']
        )->where(
            'slider_id = :slider_id'
        );
        $bind = ['slider_id' => (int)$slider_id];

        return $this->resource->getConnection()
            ->fetchPairs($select, $bind);
    }

    /**
     * Get selected products
     *
     * @return array|mixed
     */
    protected function _getSelectedProducts()
    {
        $products = $this->getRequest()
            ->getParam('selected_products');
        if ($products === null) {
            $products = $this->getSlider()
                ->getSelectedSliderProducts();
            return array_keys($products);
        }
        
        return $products;
    }

    /**
     * Retrieve grid reload url
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl(
            '*/*/productsgrid',
            ['_current' => true]
        );
    }
}
