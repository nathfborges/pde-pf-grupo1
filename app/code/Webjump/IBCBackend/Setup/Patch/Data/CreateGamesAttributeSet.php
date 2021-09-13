<?php

namespace Webjump\IBCBackend\Setup\Patch\Data;

use Magento\Catalog\Model\Product;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Catalog\Setup\CategorySetupFactory;
use Magento\Catalog\Setup\CategorySetup;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;

/**
 * @codeCoverageIgnore
 */
class CreateGamesAttributeSet implements DataPatchInterface
{
    const ATTRIBUTE_SET_ID = 'Games';

    /**
     * @var AttributeSetFactory
     */
    private $attributeSetFactory;

    /**
     * @var CategorySetupFactory
     */
    private $categorySetupFactory;

    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * AttributeSetData constructor.
     * @param AttributeSetFactory
     * @param CategorySetupFactory
     * @param ModuleDataSetupInterface
     * 
     * @return void
     */
    public function __construct(
        AttributeSetFactory $attributeSetFactory,
        CategorySetupFactory $categorySetupFactory,
        ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->attributeSetFactory = $attributeSetFactory;
        $this->categorySetupFactory = $categorySetupFactory;
        $this->moduleDataSetup = $moduleDataSetup;
    }

    /**
     * Create Games Attribute Set
     * {@inheritdoc}
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        /** @var CategorySetup */
        $categorySetup = $this->categorySetupFactory->create(['setup' => $this->moduleDataSetup]);

        $attributeSet = $this->attributeSetFactory->create();
        $entityTypeId = $categorySetup->getEntityTypeId(Product::ENTITY);
        $attributeSetId = $categorySetup->getDefaultAttributeSetId($entityTypeId);
        $data = [
            'attribute_set_name' => self::ATTRIBUTE_SET_ID,
            'entity_type_id' => $entityTypeId,
            'sort_order' => 200,
        ];

        $attributeSet->setData($data);
        $attributeSet->validate();
        $attributeSet->save();
        $attributeSet->initFromSkeleton($attributeSetId);
        $attributeSet->save();

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
