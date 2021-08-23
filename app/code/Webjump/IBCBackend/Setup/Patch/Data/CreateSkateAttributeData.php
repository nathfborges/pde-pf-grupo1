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


class CreateSkateAttributeData implements DataPatchInterface
{
    const SHAPE_SIZE = 'shape_size';

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
            'attribute_set_name' => 'Skate',
            'entity_type_id' => $entityTypeId,
            'sort_order' => 199,
        ];

        $attributeSet->setData($data);
        $attributeSet->validate();
        $attributeSet->save();
        $attributeSet->initFromSkeleton($attributeSetId);
        $attributeSet->save();

        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->setup]);
        $this->createAttributeShapeSize($eavSetup);
        $costumerSetup = $this->customerSetupFactory->create(['setup' => $this->setup]);
        $this->defineRelationshipAttributeShapeSize($costumerSetup);

        $this->setup->getConnection()->endSetup();
    }

    private function createAttributeShapeSize(EavSetup $eavSetup)
    {
        $eavSetup->addAttribute(
            Customer::ENTITY,
            self::SHAPE_SIZE,
            [
                'type' => 'float',
                'source' => '',
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'backend' => '',
                'label' => 'Select Shape Size',
                'input' => 'select',
                'required' => false,
                'visible' => true,
                'user_defined' => true,
                'sort_order' => 130,
                'position' => 130,
                'system' => 0,
                'options' => [
                    7.5,
                    7.75,
                    8.0,
                    8.25,
                    8.5
                ]
            ]
        );
    }

    private function defineRelationshipAttributeShapeSize(CustomerSetup $customerSetup): void
    {
        $customerEntity = $customerSetup->getEavConfig()->getEntityType(Customer::ENTITY);
        $attributeSetId = $customerEntity->getDefaultAttributeSetId();

        $attributeSet = $this->attributeSetFactory->create();
        $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);
        $attribute = $customerSetup->getEavConfig()
            ->getAttribute(
                Customer::ENTITY,
                self::SHAPE_SIZE
            )
            ->addData(
                [
                    'attribute_set_id' => $attributeSetId,
                    'attribute_group_id' => $attributeGroupId,
                    'used_in_forms' => ['adminhtml_customer','adminhtml_checkout','customer_account_create','customer_account_edit'],
                ]
            );
        $attribute->save();
    }

    public function revert()
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->setup]);
        $eavSetup->removeAttribute(
            Customer::ENTITY,
            self::SHAPE_SIZE
        );
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
