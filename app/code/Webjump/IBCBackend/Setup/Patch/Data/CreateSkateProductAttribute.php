<?php
namespace Webjump\IBCBackend\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Eav\Setup\EavSetup;
use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;

class CreateSkateProductAttribute implements DataPatchInterface
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
                'type' => 'float',
                'source' => '',
                'global' => ScopedAttributeInterface::SCOPE_WEBSITE,
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
                ],
                'attribute_set_id' => 10
            ]
        );

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
