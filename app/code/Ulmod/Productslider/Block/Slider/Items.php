<?php
/**
 * Copyright © Ulmod. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Ulmod\Productslider\Block\Slider;

use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Model\ResourceModel\Product\Collection as ProductCollection;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductsCollectionFactory;
use Magento\Catalog\Model\Product\Visibility as CatalogProductVisibility;
use Magento\Reports\Model\ResourceModel\Product\CollectionFactory as ReportsCollectionFactory;
use Ulmod\Productslider\Model\ProductSliderFactory;
use Magento\Framework\Stdlib\DateTime\DateTime as StdlibDateTime;
use Magento\Reports\Model\Event\TypeFactory as EventTypeFactory;
use Magento\Framework\Url\Helper\Data as UrlHelper;
use Magento\Framework\Data\Helper\PostHelper;
use Magento\Wishlist\Helper\Data as WishlistHelper;
use Magento\Catalog\Helper\Product\Compare as CompareHelper;
    
/**
 * Class Items
 */
class Items extends \Magento\Catalog\Block\Product\AbstractProduct
{
    /**
     * Max number of products in slider
     */
    const MAX_PRODUCTS_COUNT = 30;
    
    /**
     * Product slider template
     */
    protected $_template = 'Ulmod_Productslider::slider/items.phtml';
    
    /**
     * Render
     */
    protected $renderer;

    /**
     * Product number
     */
    protected $productsNumber;
    
    /**
     * @var ProductSliderFactory
     */
    protected $sliderFactory;
    
    /**
     * @var int
     */
    protected $_sliderId;
    
    /**
     * @var \Ulmod\Productslider\Model\ProductSlider
     */
    protected $slider;
    
    /**
     * Events type factory
     *
     * @var EventTypeFactory
     */
    protected $eventTypeFactory;
    
    /**
     * @var CatalogProductVisibility
     */
    protected $catalogProductVisibility;
    
    /**
     * @var ProductsCollectionFactory
     */
    protected $productsCollectionFactory;
    
    /**
     * Product reports collection factory
     *
     * @var ReportsCollectionFactory
     */
    protected $reportsCollectionFactory;
    
    /**
     * @var StdlibDateTime
     */
    protected $dateTime;
    
    /**
     * Store manager
     *
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var UrlHelper
     */
    protected $urlHelper;

    /**
     * @var PostHelper
     */
    protected $postHelper;

    /**
     * @var WishlistHelper
     */
    protected $wishlistHelper;

    /**
     * @var CompareHelper
     */
    protected $compareHelper;
    
    /**
     * @param Context $context
     * @param ProductsCollectionFactory $productsCollectionFactory
     * @param CatalogProductVisibility $catalogProductVisibility
     * @param ReportsCollectionFactory $reportsCollectionFactory
     * @param ProductSliderFactory $productSliderFactory
     * @param StdlibDateTime $dateTime
     * @param EventTypeFactory $eventTypeFactory
     * @param UrlHelper $urlHelper
     * @param PostHelper $postHelper
     * @param WishlistHelper $wishlistHelper
     * @param CompareHelper $compareHelper
     * @param array $data
     */
    public function __construct(
        Context $context,
        ProductsCollectionFactory $productsCollectionFactory,
        CatalogProductVisibility $catalogProductVisibility,
        ReportsCollectionFactory $reportsCollectionFactory,
        ProductSliderFactory $productSliderFactory,
        StdlibDateTime $dateTime,
        EventTypeFactory $eventTypeFactory,
        UrlHelper $urlHelper,
        PostHelper $postHelper,
        WishlistHelper $wishlistHelper,
        CompareHelper $compareHelper,
        array $data = []
    ) {
        $this->productCollectionFactory = $productsCollectionFactory;
        $this->reportsCollectionFactory = $reportsCollectionFactory;
        $this->catalogProductVisibility = $catalogProductVisibility;
        $this->sliderFactory = $productSliderFactory;
        $this->dateTime = $dateTime;
        $this->eventTypeFactory = $eventTypeFactory;
        $this->storeManager = $context->getStoreManager();
        $this->urlHelper = $urlHelper;
        $this->postHelper = $postHelper;
        $this->wishlistHelper = $wishlistHelper;
        $this->compareHelper = $compareHelper;
        parent::__construct($context, $data);
    }

    /**
     * Get featured slider products
     *
     * @param ProductCollection $collection
     * @return ProductCollection
     */
    protected function _getSliderFeaturedProducts($collection)
    {
        $collection = $this->_addProductAttributesAndPrices($collection);
        $collection->getSelect()
            ->join(
                ['slider_products' => $collection->getTable('ulmod_productslider_products')],
                'e.entity_id = slider_products.product_id AND slider_products.slider_id = '.$this->getSliderId(),
                ['position']
            )->order('slider_products.position');

        $collection->addStoreFilter($this->getStoreId())
                    ->setPageSize($this->getProductsCount())
                    ->setCurPage(1);

        $this->productsNumber = $this->getProductsCount() - $collection->count();
        
        return $collection;
    }
    
    /**
     * Get slider products
     *
     * @param $type
     * @return Collection|ProductCollection|string
     */
    public function getSliderProducts($type)
    {
        $collection = "";
        switch ($type) {
            case 'new':
                $collection =  $this->_getNewProducts(
                    $this->productCollectionFactory->create()
                );
                break;
            case 'bestsellers':
                $collection = $this->_getBestsellersProducts(
                    $this->productCollectionFactory->create()
                );
                break;
            case 'mostviewed':
                $collection =  $this->_getMostViewedProducts(
                    $this->productCollectionFactory->create()
                );
                break;
            case 'onsale':
                $collection =  $this->_getOnSaleProducts(
                    $this->productCollectionFactory->create()
                );
                break;
            case 'featured':
                $collection =  $this->_getSliderFeaturedProducts(
                    $this->productCollectionFactory->create()
                );
                break;
            case 'autorelated':
                $collection =  $this->_getAutoRelatedProducts(
                    $this->productCollectionFactory->create()
                );
                break;
        }
        return $collection;
    }
    
    /**
     * Get product slider items based on type
     *
     * @param ProductCollection $collection
     * @return ProductCollection
     */
    protected function _getNewProducts($collection)
    {
        $collection->setVisibility(
            $this->catalogProductVisibility->getVisibleInCatalogIds()
        );
        $collection = $this->_addProductAttributesAndPrices($collection)
            ->addAttributeToFilter(
                'news_from_date',
                ['date' => true, 'to' => $this->getEndOfDayDate()],
                'left'
            )
            ->addAttributeToFilter(
                'news_to_date',
                [
                    'or' => [
                        0 => ['date' => true, 'from' => $this->getStartOfDayDate()],
                        1 => ['is' => new \Zend_Db_Expr('null')],
                    ]
                ],
                'left'
            )
            ->addAttributeToSort(
                'news_from_date',
                'desc'
            )
             ->addStoreFilter($this->getStoreId())
             ->setPageSize($this->getProductsCount())
             ->setCurPage(1);
             
        return $collection;
    }

    /**
     * Get best selling products
     *
     * @param ProductCollection $collection
     * @return ProductCollection
     */
    protected function _getBestsellersProducts($collection)
    {
        $collection->setVisibility(
            $this->catalogProductVisibility->getVisibleInCatalogIds()
        );
        $collection = $this->_addProductAttributesAndPrices($collection);
        $collection->getSelect()
            ->join(
                ['bestsellers' => $collection->getTable('sales_bestsellers_aggregated_yearly')],
                'e.entity_id = bestsellers.product_id AND bestsellers.store_id = '.$this->getStoreId(),
                ['qty_ordered','rating_pos']
            )
            ->order('rating_pos');
        $collection->addStoreFilter($this->getStoreId())
                    ->setPageSize($this->getProductsCount())
                    ->setCurPage(1);
                    
        return $collection;
    }
    
    /**
     * Get most viewed products
     *
     * @param ProductCollection $collection
     * @return ProductCollection
     */
    protected function _getMostViewedProducts($collection)
    {
        $reportCollection = $this->reportsCollectionFactory->create();
        
        // Getting event type id for catalog_product_view event
        $eventTypes = $this->eventTypeFactory->create()
            ->getCollection();
        foreach ($eventTypes as $eventType) {
            if ($eventType->getEventName() == 'catalog_product_view') {
                $productViewEvent = (int)$eventType->getId();
                break;
            }
        }
        
        $inCatalogIds = $this->catalogProductVisibility->getVisibleInCatalogIds();
        $collection->setVisibility($inCatalogIds);
        
        $reportEvent = $reportCollection->getTable('report_event');
        $prodEntTabname = $reportCollection->getProductEntityTableName();
        $prodAttrSetid = $reportCollection->getProductAttributeSetId();
        $collection = $this->_addProductAttributesAndPrices($collection);
        $collection->getSelect()->reset()
            ->from(
                ['report_table_views' => $reportEvent],
                ['views' => 'COUNT(report_table_views.event_id)']
            )->join(
                ['e' => $prodEntTabname],
                $reportCollection->getConnection()->quoteInto(
                    'e.entity_id = report_table_views.object_id',
                    $prodAttrSetid
                )
            )->where(
                'report_table_views.event_type_id = ?',
                $productViewEvent
            )->group(
                'e.entity_id'
            )->order(
                'views DESC'
            )->having(
                'COUNT(report_table_views.event_id) > ?',
                0
            );
            
        $collection->addStoreFilter($this->getStoreId())
            ->setPageSize($this->getProductsCount())
            ->setCurPage(1);
       // ->addViewsCount()

        return $collection;
    }
  
    /**
     * Get auto related products
     *
     * @param $collection
     * @return ProductCollection
     */
    protected function _getAutoRelatedProducts($collection)
    {
        $product = $this->getProduct();
        if (!$product) {
            return;
        }
        $categories = $this->getProduct()->getCategoryIds();
        $collection->setVisibility(
            $this->catalogProductVisibility->getVisibleInCatalogIds()
        );
        
        $collection = $this->_addProductAttributesAndPrices($collection);
        $collection->addCategoriesFilter(['in' => $categories]);
        $collection->addStoreFilter($this->getStoreId())
                    ->setPageSize($this->getProductsCount())
                    ->setCurPage(1);
        $collection->addAttributeToFilter(
            'entity_id',
            ['neq' => $product->getId()]
        );
        $collection->getSelect()->order('rand()');
        
        return $collection;
    }
    
    /**
     * Get on sale slider products
     *
     * @param ProductCollection $collection
     * @return ProductCollection
     */
    protected function _getOnSaleProducts($collection)
    {
        $inCatalogIds = $this->catalogProductVisibility->getVisibleInCatalogIds();
        $collection->setVisibility($inCatalogIds);
        
        $collection = $this->_addProductAttributesAndPrices($collection)
            ->addAttributeToFilter(
                'special_from_date',
                ['date' => true, 'to' => $this->getEndOfDayDate()],
                'left'
            )
            ->addAttributeToFilter(
                'special_to_date',
                [
                    'or' => [
                        0 => ['date' => true, 'from' => $this->getStartOfDayDate()],
                        1 => ['is' => new \Zend_Db_Expr('null')],
                    ]
                ],
                'left'
            )
             ->addAttributeToSort(
                 'news_from_date',
                 'desc'
             )
             ->addStoreFilter($this->getStoreId())
             ->setPageSize($this->getProductsCount())
             ->setCurPage(1);
             
            return $collection;
    }
    
    /**
     * Get slider products including additional products
     *
     * @return array
     */
    public function getSliderProductsCollection()
    {
        $collection = [];
        $type = $this->slider->getType();
        
        $featuredProducts = $this->getSliderProducts("featured");
        if (count($featuredProducts)>0) {
            $collection['featured'] = $featuredProducts;
        }
        
        if ($type !== "featured") {
            if ($this->productsNumber > 0) {
                $sliderProds = $this->getSliderProducts($type);
                if (count($sliderProds)>0) {
                    $collection['products'] = $sliderProds;
                }
            }
        }
        
        return $collection;
    }
    
    /**
     * Create import services form select element
     *
     * @return \Magento\Framework\View\Element\AbstractBlock
     */
    protected function _prepareLayout()
    {
        $sliderId = $this->getSliderId();
        
        return parent::_prepareLayout();
    }
  
    /**
     * Get end of day date
     *
     * @return string
     */
    public function getEndOfDayDate()
    {
        return $this->_localeDate->date()
            ->setTime(23, 59, 59)
            ->format('Y-m-d H:i:s');
    }
  
     /**
      * Get start of day date
      *
      * @return string
      */
    public function getStartOfDayDate()
    {
        return $this->_localeDate->date()
            ->setTime(0, 0, 0)
            ->format('Y-m-d H:i:s');
    }
    
    /**
     * Get slider id
     *
     * @return int
     */
    public function getSliderId()
    {
        if (!$this->slider) {
            return $this->_coreRegistry
             ->registry('slider_id');
        }

        return $this->slider->getId();
    }

    /**
     * Set slider model
     *
     * @param \Ulmod\Productslider\Model\ProductSlider $slider
     *
     * @return this
     */
    public function setSlider($slider)
    {
        $this->slider = $slider;
        
        return $this;
    }
    
    /**
     * Get slider
     *
     * @return \Ulmod\Productslider\Model\ProductSlider
     */
    public function getSlider()
    {
        return $this->slider;
    }
    
    /**
     * @param int
     * @return this
     */
    public function setSliderId($sliderId)
    {
        $this->sliderId = $sliderId;
        $slider = $this->sliderFactory->create()
            ->load($sliderId);
        if ($slider->getId()) {
            $this->setSlider($slider);
            $this->setTemplate($this->_template);
        }
        return $this;
    }
    
    /**
     * @return string
     */
    public function getSliderDisplayId()
    {
        return $this->dateTime->timestamp().$this->getSliderId();
    }
    
    /**
     * @return int
     */
    public function getStoreId()
    {
        return $this->storeManager
            ->getStore()->getId();
    }
    
    /**
     * @return int
     */
    public function getProductsCount()
    {
        $items = self::MAX_PRODUCTS_COUNT;

        if (!$this->productsNumber) {
            if ($this->slider->getProductsNumber() > 0
                && $this->slider->getProductsNumber() <= self::MAX_PRODUCTS_COUNT
            ) {
                $items = $this->slider->getProductsNumber();
            }
        } else {
            $items = $this->productsNumber;
        }
        
        return $items;
    }

    /**
     * Get details renderer
     *
     * @param null $type
     * @return bool|\Magento\Framework\View\Element\AbstractBlock
     */
    public function getDetailsRenderer($type = null)
    {
        if ($type === null) {
            $type = 'default';
        }
        
        $rendererList = $this->getDetailsRendererList();
        if ($rendererList) {
            return $rendererList->getRenderer(
                $type,
                'default'.$this->getSliderId()
            );
        }
        
        return null;
    }
    
    /**
     * Get post parameters
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return string
     */
    public function getAddToCartPostParams(\Magento\Catalog\Model\Product $product)
    {
        $url = $this->getAddToCartUrl($product);
        return [
            'action' => $url,
            'data' => [
                'product' => $product->getEntityId(),
                \Magento\Framework\App\ActionInterface::PARAM_NAME_URL_ENCODED =>
                    $this->urlHelper->getEncodedUrl($url),
            ]
        ];
    }
    
    /**
     * Return compare params
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return string
     */
    public function getComparePostDataParams($product)
    {
        return $this->compareHelper->getPostDataParams($product);
    }
    
    /**
     * Is wish list allowed
     *
     * @return bool
     */
    public function isWishlistAllowed()
    {
        if ($this->wishlistHelper->isAllow()) {
            return true;
        }
        
        return false;
    }

    /**
     * Get add cart post parameters
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return string
     */
    public function getAddCartPostParams($product)
    {
        $postData = $this->postHelper->getPostData(
            $this->getAddToCartUrl($product),
            ['product' => $product->getEntityId()]
        );
        
        return $postData;
    }
    
    /**
     * Get slider type
     *
     * @param  \Ulmod\Productslider\Model\ProductSlider $slider
     * @return string
     */
    public function getSliderType($slider)
    {
        $sliderType = "Ulmod_Productslider/js/um-slick-slider";
        if ($slider->getTemplateType() == "owl") {
            $sliderType = "Ulmod_Productslider/js/um-owl-slider";
        }
        
        return $sliderType;
    }
    
    /**
     * Retrieve product details html
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return mixed
     */
    public function getProductsliderProductDetailsHtml(
        \Magento\Catalog\Model\Product $product
    ) {
    
        $renderer = $this->getDetailsRenderer(
            $product->getTypeId().$this->getSliderId()
        );
        if ($renderer) {
            $renderer->setProduct($product);
            return $renderer->toHtml();
        }
        
        return '';
    }
    
    /**
     * Get details renderer list
     *
     * @return \Magento\Framework\View\Element\RendererList
     */
    protected function getDetailsRendererList()
    {
        return $this->getDetailsRendererListName() ? $this->getLayout()->getBlock(
            $this->getDetailsRendererListName()
        ) : $this->getChildBlock('details.renderers'.$this->getSliderId());
    }
}
