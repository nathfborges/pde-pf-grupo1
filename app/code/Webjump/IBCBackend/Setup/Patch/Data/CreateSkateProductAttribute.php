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

/**
 * @codeCoverageIgnore
 */
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

    /**
     * CreateGamesProductAtribute contructor.
     * 
     * @param EavSetupFactory
     * @param ModuleDataSetupInterface
     * @param ProductAttributeManagementInterface
     * @param AttributeSetFactory
     * 
     * @return void
     */
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

    /**
     * Create Games products attributes.
     * {@inheritdoc}
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        /** @var EavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $eavSetup->addAttribute(
            Product::ENTITY,
            self::ATTRIBUTE_CODE_1,
            [
                'attribute_set' => 'Skate',
                'user_defined' => true,
                'type' => 'text',
                'label' => 'Tamanho do Shape',
                'input' => 'select',
                'required' => false,
                'global' => ScopedAttributeInterface::SCOPE_WEBSITE,
                'used_in_product_listing' => true,
                'system' => false,
                'visible_on_front' => true,
                'option' => ['values' => ['7.5', '7.75', '8.0', '8.25', '8.5']]
            ]
        );

        $attributeSetId = $eavSetup->getAttributeSetId(Product::ENTITY, CreateSkateAttributeSet::ATTRIBUTE_SET_ID);
        $attributeSet = $this->attributeSetFactory->create();
        $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);
        $sortOrder = 50;
        $this->productAttributeManagement
            ->assign($attributeSetId, $attributeGroupId, self::ATTRIBUTE_CODE_1, $sortOrder);

        $eavSetup->addAttribute(
            Product::ENTITY,
            self::ATTRIBUTE_CODE_2,
            [
                'attribute_set' => 'Skate',
                'user_defined' => true,
                'type' => 'text',
                'label' => 'Tipo de shape',
                'input' => 'select',
                'required' => false,
                'global' => ScopedAttributeInterface::SCOPE_WEBSITE,
                'used_in_product_listing' => true,
                'system' => false,
                'visible_on_front' => true,
            ]
        );

        $sortOrderTwo = 51;
        $this->productAttributeManagement
            ->assign($attributeSetId, $attributeGroupId, self::ATTRIBUTE_CODE_2, $sortOrderTwo);

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * Revert the Skate attriutes creation.
     * {@inheritdoc}
     */
    public function revert()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        /** @var EavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $eavSetup->removeAttribute(
            Product::ENTITY,
            self::ATTRIBUTE_CODE_1
        );
        $eavSetup->removeAttribute(
            Product::ENTITY,
            self::ATTRIBUTE_CODE_2
        );

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [
            CreateSkateAttributeSet::class
        ];
    }
}
