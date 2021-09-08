<?php

namespace Webjump\IBCBackend\Setup\Patch\Data;

use Magento\Catalog\Api\ProductAttributeRepositoryInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Eav\Api\Data\AttributeFrontendLabelInterfaceFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Store\Api\StoreRepositoryInterface;
use Webjump\IBCBackend\Setup\Patch\Data\CreateSkateProductAttribute;

class TranslateSkateAttributeLabel implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * @var ProductAttributeRepositoryInterface
     */
    private $productAttributeRepository;

    /**
     * @var AttributeFrontendLabelInterfaceFactory
     */
    private $attributeFrontendLabelFactory;

    /**
     * @var StoreRepositoryInterface
     */
    private $storeRepository;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory,
        ProductAttributeRepositoryInterface $productAttributeRepository,
        AttributeFrontendLabelInterfaceFactory $attributeFrontendLabelFactory,
        StoreRepositoryInterface $storeRepository
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->productAttributeRepository = $productAttributeRepository;
        $this->attributeFrontendLabelFactory = $attributeFrontendLabelFactory;
        $this->storeRepository = $storeRepository;
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

        $data = [
            'size' => [
                CreateSkateProductAttribute::ATTRIBUTE_CODE_1,
                'Deck Size'
            ],
            'type' => [
                CreateSkateProductAttribute::ATTRIBUTE_CODE_2,
                'Deck Type'
            ]
        ];

        foreach ($data as $attributeData) {
            $attribute = $this->productAttributeRepository->get($attributeData[0]);
            $sourceModel = $attribute->getSourceModel();
            $frontendLabel = [
                $this->attributeFrontendLabelFactory->create()
                    ->setStoreId($this->storeRepository->get(ConfigureStores::IBC_SKATE_STORE_2_CODE)->getId())
                    ->setLabel($attributeData[1])
            ];
            $attribute->setFrontendLabels($frontendLabel);
            $this->productAttributeRepository->save($attribute);

            if ($sourceModel !== null) {
                $eavSetup->updateAttribute(
                    \Magento\Catalog\Model\Product::ENTITY,
                    $attributeData[0],
                    \Magento\Catalog\Api\Data\EavAttributeInterface::SOURCE_MODEL,
                    $sourceModel
                );
            }
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
