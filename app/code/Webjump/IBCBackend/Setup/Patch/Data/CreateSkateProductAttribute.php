<?php
namespace Webjump\IBCBackend\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Eav\Setup\EavSetup;
use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;

class CreateSkateProductAttribute implements DataPatchInterface, PatchRevertableInterface
{
    const ATTRIBUTE_CODE = 'shape_size';

    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * @var ModuleDataSetup
     */
    private $moduleDataSetup;

    public function __construct(EavSetupFactory $eavSetupFactory, ModuleDataSetupInterface $moduleDataSetup)
    {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->moduleDataSetup = $moduleDataSetup;
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $eavSetup->addAttribute(
            Product::ENTITY,
            self::ATTRIBUTE_CODE,
            [
                'attribute_set' => 'Skate',
                'user_defined' => true,
                'type' => 'decimal',
				'label' => 'Shape Size',
				'input' => 'select',
				'required' => false,
				'global' => ScopedAttributeInterface::SCOPE_STORE,
                'used_in_product_listing' => true,
                'system' => false,
                'visible_on_front' => false,
                'option' => ['values' => ['7.5', '7.75', '8.0', '8.25', '8.5']]
            ]
        );

        $eavSetup->updateAttributeSet(
            Product::ENTITY,
            'Skate',
            'General',
            self::ATTRIBUTE_CODE,
            301
        )

        $eavSetup->addAttributeToSet(
            Product::ENTITY,
            $eavSetup->getAttributeSetId(Product::ENTITY, CreateSkateAttributeSet::ATTRIBUTE_SET_ID),
            'General',
            self::ATTRIBUTE_CODE,
            301
        );

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    public function revert()
        {
            $this->moduleDataSetup->getConnection()->startSetup();
            
            $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
            $eavSetup->removeAttribute(
                Product::ENTITY,
                self::ATTRIBUTE_CODE
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
