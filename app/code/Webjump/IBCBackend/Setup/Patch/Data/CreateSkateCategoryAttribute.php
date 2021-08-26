<?php

namespace Webjump\IBCBackend\Setup\Patch\Data;

use Magento\Catalog\Api\ProductAttributeManagementInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Eav\Setup\EavSetup;
use Magento\Catalog\Model\Category;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;


class CreateSkateCategoryAttribute implements DataPatchInterface, PatchRevertableInterface
{
    const ATTRIBUTE_CODE_1 = 'teste_1';
    const ATTRIBUTE_CODE_2 = 'teste_2';

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
            Category::ENTITY,
            self::ATTRIBUTE_CODE_1,
            [
                'type' => 'text',
                'label' => 'Teste 2',
                'input' => 'select',
                'sort_order' => 100,
                'source' => '',
                'global' => 1,
                'visible' => true,
                'required' => false,
                'user_defined' => false,
                'default' => null,
                'group' => '',
                'backend' => '',
                'option' => ['values' => ['Yes', 'No']]
            ]
        );

        // $attributeSetId = $eavSetup->getAttributeSetId(Category::ENTITY, CreateSkateAttributeSet::ATTRIBUTE_SET_ID);
        // $attributeSet = $this->attributeSetFactory->create();
        // $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);
        // $sortOrder = 50;
        // $this->productAttributeManagement
        //     ->assign($attributeSetId, $attributeGroupId, self::ATTRIBUTE_CODE_1, $sortOrder);

        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $eavSetup->addAttribute(
            Category::ENTITY,
            self::ATTRIBUTE_CODE_2,
            [
                'type' => 'text',
                'label' => 'Teste 1',
                'input' => 'select',
                'sort_order' => 100,
                'source' => '',
                'global' => 1,
                'visible' => true,
                'required' => false,
                'user_defined' => false,
                'default' => null,
                'group' => '',
                'backend' => '',
                'option' => ['values' => ['Yes', 'No']]
            ]
        );

        // $attributeSetId = $eavSetup->getAttributeSetId(Category::ENTITY, CreateSkateAttributeSet::ATTRIBUTE_SET_ID);
        // $attributeSet = $this->attributeSetFactory->create();
        // $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);
        // $sortOrder = 50;
        // $this->productAttributeManagement
        //     ->assign($attributeSetId, $attributeGroupId, self::ATTRIBUTE_CODE_2, $sortOrder);

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    public function revert()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $eavSetup->removeAttribute(
            Category::ENTITY,
            self::ATTRIBUTE_CODE_1
        );

        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $eavSetup->removeAttribute(
            Category::ENTITY,
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
