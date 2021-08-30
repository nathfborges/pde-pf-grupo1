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


class CreateCategoryAttributes implements DataPatchInterface, PatchRevertableInterface
{
    const ATTRIBUTE_CODE_1 = 'violence';
    const ATTRIBUTE_CODE_2 = 'is_mounted';

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
     * Constructor of CreateCategoryAttributes class.
     * @param EavSetupFactory
     * @param ModuleDataSetupInterface
     * @param AttributeSetFactory
     * @param ProductAttributeManagementInterface
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
     * Create the categories attributes.
     * {@inheritdoc}
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        /** @var EavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $eavSetup->addAttribute(
            Category::ENTITY,
            self::ATTRIBUTE_CODE_1,
            [
                'type' => 'int',
                'label' => 'Os jogos dessa categoria possuem violência?',
                'input' => 'boolean',
                'sort_order' => 100,
                'source' => '',
                'global' => ScopedAttributeInterface::SCOPE_WEBSITE,
                'visible' => true,
                'required' => false,
                'user_defined' => false,
                'default' => null,
                'group' => '',
                'backend' => ''
            ]
        );

        /** @var EavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $eavSetup->addAttribute(
            Category::ENTITY,
            self::ATTRIBUTE_CODE_2,
            [
                'type' => 'int',
                'label' => 'Os skates dessa categoria já vem montados?',
                'input' => 'boolean',
                'sort_order' => 100,
                'source' => '',
                'global' => ScopedAttributeInterface::SCOPE_WEBSITE,
                'visible' => true,
                'required' => false,
                'user_defined' => false,
                'default' => null,
                'group' => '',
                'backend' => ''
            ]
        );

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * Revert the creation of categories attributes.
     * {@inheritdoc}
     */
    public function revert(): void
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
