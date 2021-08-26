<?php

namespace Webjump\IBCBackend\Setup\Patch\Data;

use Magento\Catalog\Api\ProductAttributeManagementInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Eav\Setup\EavSetup;
use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;


class CreateSkateProductAttribute implements DataPatchInterface, PatchRevertableInterface
{
    const ATTRIBUTE_CODE_1 = 'shape_size';
    const ATTRIBUTE_CODE_2 = 'shape_type';

    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * @var ModuleDataSetup
     */
    private $moduleDataSetup;

    /**
     * @var ProductAttributeManagementInterface
     */
    private $productAttributeManagement;

    /**
     * @var AttributeSetFactory
     */
    private $attributeSetFactory;


    public function __construct(
        EavSetupFactory $eavSetupFactory,
        ModuleDataSetupInterface $moduleDataSetup,
        AttributeSetFactory $attributeSetFactory,
        ProductAttributeManagementInterface $productAttributeManagement
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->moduleDataSetup = $moduleDataSetup;
        $this->attributeSetFactory = $attributeSetFactory;
        $this->productAttributeManagement = $productAttributeManagement;
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $eavSetup->addAttribute(
            Product::ENTITY,
            self::ATTRIBUTE_CODE_1,
            [
                'attribute_set' => 'Skate',
                'user_defined' => true,
                'type' => 'decimal',
                'label' => 'Tamanho do Shape',
                'input' => 'select',
                'required' => false,
                'global' => ScopedAttributeInterface::SCOPE_WEBSITE,
                'used_in_product_listing' => true,
                'system' => false,
                'visible_on_front' => false,
                'option' => ['values' => ['7.5', '7.75', '8.0', '8.25', '8.5']]
            ]
        );

        $attributeSetId = $eavSetup->getAttributeSetId(Product::ENTITY, CreateSkateAttributeSet::ATTRIBUTE_SET_ID);
        $attributeSet = $this->attributeSetFactory->create();
        $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);
        $sortOrder = 50;
        $this->productAttributeManagement
            ->assign($attributeSetId, $attributeGroupId, self::ATTRIBUTE_CODE_1, $sortOrder);

        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $eavSetup->addAttribute(
            Product::ENTITY,
            self::ATTRIBUTE_CODE_2,
            [
                'attribute_set' => 'Skate',
                'user_defined' => true,
                'type' => 'decimal',
                'label' => 'Tipo de shape',
                'input' => 'select',
                'required' => false,
                'global' => ScopedAttributeInterface::SCOPE_WEBSITE,
                'used_in_product_listing' => true,
                'system' => false,
                'visible_on_front' => false,
                'option' => ['values' => ['Maple', 'Fibra', 'Marfin']]
            ]
        );

        $attributeSetId = $eavSetup->getAttributeSetId(Product::ENTITY, CreateSkateAttributeSet::ATTRIBUTE_SET_ID);
        $attributeSet = $this->attributeSetFactory->create();
        $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);
        $sortOrder = 50;
        $this->productAttributeManagement
            ->assign($attributeSetId, $attributeGroupId, self::ATTRIBUTE_CODE_2, $sortOrder);

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    public function revert()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $eavSetup->removeAttribute(
            Product::ENTITY,
            self::ATTRIBUTE_CODE_1
        );

        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $eavSetup->removeAttribute(
            Product::ENTITY,
            self::ATTRIBUTE_CODE_2
        );

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    public function getAliases()
    {
        return [];
    }

    public static function getDependencies()
    {
        return [
            CreateSkateAttributeSet::class
        ];
    }
}
