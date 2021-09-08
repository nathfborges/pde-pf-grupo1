<?php

namespace Webjump\IBCBackend\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Webjump\IBCBackend\Setup\Patch\Data\ConfigureStores;
use Magento\Catalog\Model\Category;
use Magento\Catalog\Model\CategoryFactory;
use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Store\Api\StoreRepositoryInterface;
use Magento\Store\Model\GroupFactory;
use Magento\Store\Model\ResourceModel\Group;

class InstallRefactoredCategories implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepositoryInterface;

    /**
     * @var CategoryFactory
     */
    private $categoryFactory;

    /**
     * @var GroupFactory
     */
    private $groupFactory;

    /**
     * @var Group
     */
    private $groupResourceModel;

    /**
     * @var StoreRepositoryInterface
     */
    private $storeRepositoryInterface;

    /**
     * @var array
     */
    private $entities;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param CategoryRepositoryInterface $categoryRepositoryInterface
     * @param CategoryFactory $categoryFactory
     * @param GroupFactory $groupFactory
     * @param Group $groupResourceModel
     * @param StoreRepositoryInterface $storeRepositoryInterface
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CategoryRepositoryInterface $categoryRepositoryInterface,
        CategoryFactory $categoryFactory,
        GroupFactory $groupFactory,
        Group $groupResourceModel,
        StoreRepositoryInterface $storeRepositoryInterface
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->categoryRepositoryInterface = $categoryRepositoryInterface;
        $this->categoryFactory = $categoryFactory;
        $this->groupFactory = $groupFactory;
        $this->groupResourceModel = $groupResourceModel;
        $this->storeRepositoryInterface = $storeRepositoryInterface;
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $categories = [];
        $categories[] = Category::TREE_ROOT_ID;

        // $entities = [];

        $data = $this->getData();

        foreach ($data as $key) {
            $category = $this->categoryFactory->create();
            $category->setName($key['name'])
                ->setIsActive(true)
                ->setParentId($categories[$key['parent_ref']])
                ->setMetaTitle($key['meta']);

            $this->categoryRepositoryInterface->save($category);

            $categories[] = $category->getId();

            $this->entities[] = $category->getEntityId();
        }

        // SKATE GROUP
        $skate = $this->groupFactory->create();
        $this->groupResourceModel
            ->load($skate, ConfigureStores::IBC_SKATE_GROUP_CODE, 'code');
        $skate->setRootCategoryId($categories[1]);
        $this->groupResourceModel->save($skate);

        // GAMES GROUP
        $games = $this->groupFactory->create();
        $this->groupResourceModel
            ->load($games, ConfigureStores::IBC_GAMES_GROUP_CODE, 'code');
        $games->setRootCategoryId($categories[8]);
        $this->groupResourceModel->save($games);

        $this->moduleDataSetup->getConnection()->endSetup();


        // UPGRADE SKATE_VIEW_2 CATEGORIES TO ENGLISH
        $skate_store_2_id = $this->storeRepositoryInterface->get(ConfigureStores::IBC_SKATE_STORE_2_CODE)->getId();

        $data2 = $this->getData2();
        foreach ($data2 as $eID) {
            $categories2 = $this->categoryRepositoryInterface->get($eID['entity'], $skate_store_2_id);
            $categories2->setName($eID['name'])
                ->setMetaTitle($eID['meta-title'])
                ->setUrlKey($eID['url-key'])
                ->save();
        }
    }

    private function getData()
    {
        return [
            // SKATE STORE 1 ROOT
            [
                'name' => 'Skate',
                'parent_ref' => 0,
                'meta' => ''
            ],
            // SKATE STORE CAREGORIES | REF: 1
            [
                'name' => 'Skates Completos',
                'parent_ref' => 1,
                'meta' => 'IBC Skate | Skates Completos'
            ],
            [
                'name' => 'Rodas',
                'parent_ref' => 1,
                'meta' => 'IBC Skate | Rodas'
            ],
            [
                'name' => 'Shapes',
                'parent_ref' => 1,
                'meta' => 'IBC Skate | Shapes'
            ],
            [
                'name' => 'Lixas',
                'parent_ref' => 1,
                'meta' => 'IBC Skate | Lixas'
            ],
            [
                'name' => 'Trucks',
                'parent_ref' => 1,
                'meta' => 'IBC Skate | Trucks'
            ],
            [
                'name' => 'Acessórios',
                'parent_ref' => 1,
                'meta' => 'IBC Skate | Acessórios'
            ]
            // GAMES STORE ROOT
            ,
            [
                'name' => 'Games',
                'parent_ref' => 0,
                'meta' => ''
            ],
            // GAMES STORE CAREGORIES | REF: 8
            [
                'name' => 'Luta',
                'parent_ref' => 8,
                'meta' => 'IBC Games | Luta'
            ],
            [
                'name' => 'Simulação',
                'parent_ref' => 8,
                'meta' => 'IBC Games | Simulação'
            ],
            [
                'name' => 'Aventura',
                'parent_ref' => 8,
                'meta' => 'IBC Games | Aventura'
            ],
            [
                'name' => 'Terror',
                'parent_ref' => 8,
                'meta' => 'IBC Games | Terror'
            ],
            [
                'name' => 'Esporte',
                'parent_ref' => 8,
                'meta' => 'IBC Games | Esporte'
            ],
            [
                'name' => 'Estratégia',
                'parent_ref' => 8,
                'meta' => 'IBC Games | Estratégia'
            ]
        ];
    }

    private function getData2()
    {
        return [
            [
                'entity' => $this->entities[1],
                'name' => 'Complete Skateboards',
                'meta-title' => 'IBC Skate | Complete Skateboards',
                'url-key' => 'complete-skateboard'
            ],
            [
                'entity' => $this->entities[2],
                'name' => 'Wheels',
                'meta-title' => 'IBC Skate | Wheels',
                'url-key' => 'wheels'
            ],
            [
                'entity' => $this->entities[3],
                'name' => 'Deck',
                'meta-title' => 'IBC Skate | Deck',
                'url-key' => 'deck'
            ],
            [
                'entity' => $this->entities[4],
                'name' => 'Sandpaper',
                'meta-title' => 'IBC Skate | Sandpaper',
                'url-key' => 'sandpaper'
            ],
            [
                'entity' => $this->entities[5],
                'name' => 'Trucks',
                'meta-title' => 'IBC Skate | Trucks',
                'url-key' => 'trucks-en'
            ],
            [
                'entity' => $this->entities[6],
                'name' => 'Acessories',
                'meta-title' => 'IBC Skate | Acessories',
                'url-key' => 'acessories'
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * {@inheritDoc}
     */
    public static function getDependencies()
    {
        return [
            ConfigureStores::class
        ];
    }
}
