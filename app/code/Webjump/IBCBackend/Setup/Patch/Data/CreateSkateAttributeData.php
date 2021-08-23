<?php

namespace Webjump\IBCBackend\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Catalog\Setup\CategorySetupFactory;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Customer\Setup\CustomerSetup;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Customer\Model\Customer;
use Magento\Eav\Model\Attribute\Data\Select;
use Magento\Customer\Model\ResourceModel\Attribute;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;


class CreateSkateAttributeData implements DataPatchInterface
{
    private $attributeSetFactory;
    private $attributeSet;
    private $categorySetupFactory;
    /**
     * @var \Magento\Framework\Setup\ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var CustomerSetup
     */
    private $customerSetupFactory;

    /**
     * EavSetupFactory
     *
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * @var Attribute
     */
    private $attributeResource;

    /**
     * AttributeSetData constructor.
     * @
     */
    public function __construct(
        AttributeSetFactory $attributeSetFactory,
        CategorySetupFactory $categorySetupFactory,
        ModuleDataSetupInterface $moduleDataSetup,
        CustomerSetupFactory $customerSetupFactory,
        EavSetupFactory $eavSetupFactory,
        Attribute $attributeResource
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->attributeSetFactory = $attributeSetFactory;
        $this->categorySetupFactory = $categorySetupFactory;
        $this->customerSetupFactory = $customerSetupFactory;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->attributeResource = $attributeResource;
    }

    /**
     * Create Attribute Set
     * {@inheritdoc}
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        $categorySetup = $this->categorySetupFactory->create(['setup' => $this->moduleDataSetup]);

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

        $customerSetup = $this->customerSetupFactory->create(['setup' => $this->moduleDataSetup]);

        /**
         * Add attribute
         */
        $customerSetup->addAttribute(
            Customer::ENTITY,
            'shape_size',
            [
                'type' => 'float',
                'label' => 'Select Shape Size',
                'input' => 'select',
                'options' => [
                    '7.5',
                    '7.75',
                    '8.0',
                    '8.25',
                    '8.50'
                ],
                'backend' => Select::class,
                'position' => 100,
                'required' => false,
                'system' => false,
            ]
        );

        /**
         * Fetch the newly created attribute and set options to be used in forms
         */
        $shapeSizeAttribute = $customerSetup->getEavConfig()->getAttribute(Customer::ENTITY, 'shape_size');

        $shapeSizeAttribute->setData('used_in_forms', [
            'adminhtml_customer',
            'adminhtml_checkout',
            'adminhtml_customer_address',
            'customer_account_edit',
            'customer_address_edit',
            'customer_register_address',
        ]);

        $this->attributeResource->save($shapeSizeAttribute);

        $this->moduleDataSetup->getConnection()->endSetup();
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
