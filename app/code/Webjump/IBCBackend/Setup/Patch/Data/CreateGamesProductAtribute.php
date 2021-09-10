<?php

namespace Webjump\IBCBackend\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Eav\Setup\EavSetup;
use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;
use Magento\Catalog\Api\ProductAttributeManagementInterface;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;

/**
 * @codeCoverageIgnore
 */
class CreateGamesProductAtribute implements DataPatchInterface, PatchRevertableInterface
{
    const ATTRIBUTE_CODE_1 = 'age_rating';
    const ATTRIBUTE_CODE_2 = 'multiplayer';
    const ATTRIBUTE_CODE_3 = 'cor';

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
        ProductAttributeManagementInterface $productAttributeManagement,
        AttributeSetFactory $attributeSetFactory
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->moduleDataSetup = $moduleDataSetup;
        $this->productAttributeManagement = $productAttributeManagement;
        $this->attributeSetFactory = $attributeSetFactory;
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
                'attribute_set' => 'Games',
                'user_defined' => true,
                'type' => 'text',
                'label' => 'Faixa Etária',
                'input' => 'select',
                'required' => false,
                'global' => ScopedAttributeInterface::SCOPE_WEBSITE,
                'used_in_product_listing' => true,
                'system' => false,
                'visible_on_front' => true,
                'option' => ['values' => ['Livre', '12', '14', '16', '18']]
            ]
        );

        $attributeSetId = $eavSetup->getAttributeSetId(Product::ENTITY, CreateGamesAttributeSet::ATTRIBUTE_SET_ID);
        $attributeSet = $this->attributeSetFactory->create();
        $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);
        $sortOrder = 50;
        $this->productAttributeManagement
            ->assign($attributeSetId, $attributeGroupId, self::ATTRIBUTE_CODE_1, $sortOrder);

        $eavSetup->addAttribute(
            Product::ENTITY,
            self::ATTRIBUTE_CODE_3,
            [
                'attribute_set' => 'Games',
                'user_defined' => true,
                'type' => 'text',
                'label' => 'Edição',
                'input' => 'select',
                'required' => false,
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'used_in_product_listing' => true,
                'system' => false,
                'visible_on_front' => true,
                'option' => ['values' => [
                    'Padrão',
                    'Champions']]
            ]
        );

        $sortOrderThree = 51;
        $this->productAttributeManagement
            ->assign($attributeSetId, $attributeGroupId, self::ATTRIBUTE_CODE_3, $sortOrderThree);

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * Revert the Games attriutes creation.
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
            CreateGamesAttributeSet::class
        ];
    }
}
