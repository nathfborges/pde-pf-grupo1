<?php
namespace Webjump\IBCBackend\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Customer\Model\Customer;
use Magento\Catalog\Api\AttributeSetManagementInterface;
use Magento\Eav\Api\Data\AttributeSetInterfaceFactory;
use Magento\Catalog\Api\Data\ProductAttributeInterface;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Catalog\Model\Product;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;


class AttributeSetData implements DataPatchInterface
{
    /**
     * @var Product
     */
    private $product;
    /**
     * @var AttributeSetFactory
     */
    private $attributeSetFactory;
    ///**
    // * @var AttributeSetManagementInterface
    // */
    //private $attributeSetManagement;

    /**
     * @var CustomerSetupFactory
     */
    private $customerSetupFactory;

    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var String
     */
    private $attrSetNameSkate;

    /**
     * @var String
     */
    private $attrSetNameGames;

    

    /**
     * AttributeSetData constructor.
     * @
     */
    public function __construct(AttributeSetFactory $attributeSetFactory, CategorySetupFactory $categorySetupFactory )
       {
           $this->attributeSetFactory = $attributeSetFactory;
           $this->categorySetupFactory = $categorySetupFactory;
       }

    /**
     * Create Attribute Set
     * {@inheritdoc}
     */
    public function apply()
    {
        $customerSetup = $this->customerSetupFactory->create(['setup' => $this->moduleDataSetup]);

        $customerEntity = $customerSetup->getEavConfig()->getEntityType(Customer::ENTITY);
        $attributeSetId = $customerEntity->getDefaultAttributeSetId();

        $attributeSet = $this->attributeSetFactory->create();
        $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);


        //$defaultAttributeSetId = $this->product->getDefaultAttributeSetId();
        //$attributeSet = $this->attributeSetFactory->create();
        //$attributeSet->setAttributeSetName($this->attrSetNameGames);
        //$attributeSet->setEntityTypeId(ProductAttributeInterface::ENTITY_TYPE_CODE);
        //$this->attributeSetManagement->create($attributeSet, $defaultAttributeSetId);
    }

    /**
    * {@inheritdoc}
    */
    public static function getDependencies()
   {
       return [];
   }

   /**
    * {@inheritdoc}
    */
   public function getAliases()
   {
       return [];
   }
}
