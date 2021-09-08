<?php

namespace Webjump\IBCBackend\Setup\Patch\Data;

use Magento\Catalog\Api\ProductAttributeRepositoryInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Api\Data\AttributeOptionLabelInterfaceFactory;
use Magento\Eav\Api\Data\AttributeOptionInterfaceFactory;
use Magento\Eav\Api\AttributeOptionManagementInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Store\Api\StoreRepositoryInterface;

class TranslateSkateProductAttributeOptions implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var ProductAttributeRepositoryInterface
     */
    private $productAttributeRepository;

    /**
     * @var AttributeOptionLabelInterfaceFactory
     */
    private $attributeOptionLabelFactory;

    /**
     * @var AttributeOptionInterfaceFactory
     */
    private $attributeOptionFactory;

    /**
     * @var AttributeOptionManagementInterface
     */
    private $attributeOptionManagement;

    /**
     * @var StoreRepositoryInterface
     */
    private $storeRepository;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        ProductAttributeRepositoryInterface $productAttributeRepository,
        AttributeOptionLabelInterfaceFactory $attributeOptionLabelFactory,
        AttributeOptionInterfaceFactory $attributeOptionFactory,
        AttributeOptionManagementInterface $attributeOptionManagement,
        StoreRepositoryInterface $storeRepository

    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->productAttributeRepository = $productAttributeRepository;
        $this->attributeOptionLabelFactory = $attributeOptionLabelFactory;
        $this->attributeOptionFactory = $attributeOptionFactory;
        $this->attributeOptionManagement = $attributeOptionManagement;
        $this->storeRepository = $storeRepository;
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $data = [
            'maple' => [
                'Maple',
                'Maple'
            ],
            'fibra' => [
                'Fibra',
                'Fiber'
            ],
            'marfin' => [
                'Marfin',
                'Ivory'
            ]
        ];

        $sortOrder = 0;
        foreach ($data as $optionValues) {
            $optionLabel = $this->attributeOptionLabelFactory->create();
            $optionLabel->setStoreId($this->storeRepository->get(ConfigureStores::IBC_SKATE_STORE_2_CODE)->getId());
            $optionLabel->setLabel($optionValues[1]);

            $option = $this->attributeOptionFactory->create();
            $option->setLabel($optionValues[0]);
            $option->setStoreLabels([$optionLabel]);
            $option->setSortOrder($sortOrder);
            $option->setIsDefault(false);

            $this->attributeOptionManagement->add(
                \Magento\Catalog\Model\Product::ENTITY,
                CreateSkateProductAttribute::ATTRIBUTE_CODE_2,
                $option
            );
            $sortOrder++;
        }





        $this->moduleDataSetup->getConnection()->endSetup();
    }

    public function getAliases()
    {
        return [];
    }

    public static function getDependencies()
    {
        return [
            CreateSkateProductAttribute::class
        ];
    }
}
