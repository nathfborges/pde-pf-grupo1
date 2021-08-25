<?php

namespace Webjump\IBCBackend\Setup\Patch\Data;

use Magento\Catalog\Setup\CategorySetupFactory;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Model\Config as EavConfig;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Customer\Model\Customer;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Customer\Setup\CustomerSetup;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;


class CreateSkateAttributeSet implements DataPatchInterface
{
    const SHAPE_SIZE = 'shape_size';
    const ATTRIBUTE_SET_ID = 'Skate';

    /**
     * @var AttributeSetFactory
     */
    private $attributeSetFactory;
    private $attributeSet;
    private $categorySetupFactory;
    /**
     * @var \Magento\Framework\Setup\ModuleDataSetupInterface
     */
    private $setup;

    /**
     * EavSetupFactory
     *
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * @var EavConfig
     */
    private $eavConfig;

    /**
     * @var CustomerSetupFactory
     */
    protected $customerSetupFactory;

    /**
     * @var Attribute
     */
    private $attributeResource;

    /**
     * AttributeSetData constructor.
     * 
     * @param ModuleDataSetupInterface $setup
     * @param EavSetupFactory $eavSetupFactory
     * @param EavConfig $eavConfig
     * @param CustomerSetupFactory $customerSetupFactory
     * @param AttributeSetFactory $attributeSetFactory
     */
    public function __construct(
        ModuleDataSetupInterface $setup,
        EavSetupFactory $eavSetupFactory,
        EavConfig $eavConfig,
        CustomerSetupFactory $customerSetupFactory,
        AttributeSetFactory $attributeSetFactory,
        CategorySetupFactory $categorySetupFactory
    )
    {
        $this->setup = $setup;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->eavConfig = $eavConfig;
        $this->customerSetupFactory = $customerSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
        $this->categorySetupFactory = $categorySetupFactory;
    }

    /**
     * Create Attribute Set
     * {@inheritdoc}
     */
    public function apply()
    {
        $this->setup->getConnection()->startSetup();
        $categorySetup = $this->categorySetupFactory->create(['setup' => $this->setup]);

        $attributeSet = $this->attributeSetFactory->create();
        $entityTypeId = $categorySetup->getEntityTypeId(\Magento\Catalog\Model\Product::ENTITY);
        $attributeSetId = $categorySetup->getDefaultAttributeSetId($entityTypeId);
        $data = [
            'attribute_set_name' => self::ATTRIBUTE_SET_ID,
            'entity_type_id' => $entityTypeId,
            'sort_order' => 199,
        ];

        $attributeSet->setData($data);
        $attributeSet->validate();
        $attributeSet->save();
        $attributeSet->initFromSkeleton($attributeSetId);
        $attributeSet->save();

        $this->setup->getConnection()->endSetup();
    }

    // private function defineRelationshipAttributeShapeSize(CustomerSetup $customerSetup): void
    // {
    //     $customerEntity = $customerSetup->getEavConfig()->getEntityType(Customer::ENTITY);
    //     $attributeSetId = $customerEntity->getDefaultAttributeSetId();

    //     $attributeSet = $this->attributeSetFactory->create();
    //     $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);
    //     $attribute = $customerSetup->getEavConfig()
    //         ->getAttribute(
    //             Customer::ENTITY,
    //             self::SHAPE_SIZE
    //         )
    //         ->addData(
    //             [
    //                 'attribute_set_id' => $attributeSetId,
    //                 'attribute_group_id' => $attributeGroupId,
    //                 'used_in_forms' => ['adminhtml_customer','adminhtml_checkout','customer_account_create','customer_account_edit'],
    //             ]
    //         );
    //     $attribute->save();
    // }

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
