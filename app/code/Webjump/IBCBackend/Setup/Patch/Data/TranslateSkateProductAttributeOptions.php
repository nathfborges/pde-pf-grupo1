<?php

namespace Webjump\IBCBackend\Setup\Patch\Data;

use Magento\Catalog\Api\ProductAttributeRepositoryInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Api\Data\AttributeOptionLabelInterfaceFactory;
use Magento\Eav\Api\Data\AttributeOptionInterfaceFactory;
use Magento\Eav\Api\AttributeOptionManagementInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Store\Api\StoreRepositoryInterface;

/**
 * @codeCoverageIgnore
 */
class TranslateSkateProductAttributeOptions implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

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

    /**
     * Constructor of TranslateSkateProductAttributeOptions class.
     * 
     * @param ModuleDataSetupInterface
     * @param AttributeOptionLabelInterfaceFactory
     * @param AttributeOptionInterfaceFactory
     * @param AttributeOptionManagementInterface
     * @param StoreRepositoryInterface
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        AttributeOptionLabelInterfaceFactory $attributeOptionLabelFactory,
        AttributeOptionInterfaceFactory $attributeOptionFactory,
        AttributeOptionManagementInterface $attributeOptionManagement,
        StoreRepositoryInterface $storeRepository

    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->attributeOptionLabelFactory = $attributeOptionLabelFactory;
        $this->attributeOptionFactory = $attributeOptionFactory;
        $this->attributeOptionManagement = $attributeOptionManagement;
        $this->storeRepository = $storeRepository;
    }

    /**
     * Create options on $data array to a especific atribute code on a specific store.
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $data = [
            'maple' => [
                'Maple',
                'Maple',
                CreateSkateProductAttribute::ATTRIBUTE_CODE_2
            ],
            'fibra' => [
                'Fibra',
                'Fiber',
                CreateSkateProductAttribute::ATTRIBUTE_CODE_2
            ],
            'marfin' => [
                'Marfin',
                'Ivory',
                CreateSkateProductAttribute::ATTRIBUTE_CODE_2
            ],
            'azul' => [
                'Azul',
                'Blue',
                CreateSkateProductAttribute::ATTRIBUTE_CODE_3
            ],
            'braco' => [
                'Branco',
                'White',
                CreateSkateProductAttribute::ATTRIBUTE_CODE_3
            ],
            'preto' => [
                'Preto',
                'Black',
                CreateSkateProductAttribute::ATTRIBUTE_CODE_3
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
                $optionValues[2],
                $option
            );
            $sortOrder++;
        }

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
            CreateSkateProductAttribute::class
        ];
    }
}
