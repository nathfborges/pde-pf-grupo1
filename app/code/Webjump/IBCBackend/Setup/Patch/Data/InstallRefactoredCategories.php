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

/**
 * @codeCoverageIgnore
 */
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
                ->setMetaTitle($key['meta'])
                ->setUrlKey($key['url-key']);

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
        foreach ($data2 as $eIDskate2) {
            $categories2 = $this->categoryRepositoryInterface->get($eIDskate2['entity'], $skate_store_2_id);
            $categories2->setName($eIDskate2['name'])
                ->setMetaTitle($eIDskate2['meta-title'])
                ->setUrlKey($eIDskate2['url-key'])
                ->save();
        }

        // SETTING URL KEY TO GAMES STORE
        $games_store_id = $this->storeRepositoryInterface->get(ConfigureStores::IBC_GAMES_STORE_CODE)->getId();

        $data3 = $this->getData3();
        foreach ($data3 as $eIDgames) {
            $categories3 = $this->categoryRepositoryInterface->get($eIDgames['entity'], $games_store_id);
            $categories3->setUrlKey($eIDgames['url-key'])
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
                'meta' => '',
                'url-key' => '',
            ],
            // SKATE STORE CAREGORIES | REF: 1
            [
                'name' => 'Skates Completos',
                'parent_ref' => 1,
                'meta' => 'IBC Skate | Skates Completos',
                'url-key' => 'skates-completos',
            ],
            [
                'name' => 'Rodas',
                'parent_ref' => 1,
                'meta' => 'IBC Skate | Rodas',
                'url-key' => 'rodas',
            ],
            [
                'name' => 'Shapes',
                'parent_ref' => 1,
                'meta' => 'IBC Skate | Shapes',
                'url-key' => 'shapes',
            ],
            [
                'name' => 'Lixas',
                'parent_ref' => 1,
                'meta' => 'IBC Skate | Lixas',
                'url-key' => 'lixas',
            ],
            [
                'name' => 'Trucks',
                'parent_ref' => 1,
                'meta' => 'IBC Skate | Trucks',
                'url-key' => 'trucks',
            ],
            [
                'name' => 'Acessórios',
                'parent_ref' => 1,
                'meta' => 'IBC Skate | Acessórios',
                'url-key' => 'acessorios',

            ]
            // GAMES STORE ROOT
            ,
            [
                'name' => 'Games',
                'parent_ref' => 0,
                'meta' => '',
                'url-key' => '',
            ],
            // GAMES STORE CAREGORIES | REF: 8
            [
                'name' => 'Luta',
                'parent_ref' => 8,
                'meta' => 'IBC Games | Luta',
                'url-key' => 'luta',
            ],
            [
                'name' => 'Simulação',
                'parent_ref' => 8,
                'meta' => 'IBC Games | Simulação',
                'url-key' => 'simulacao',

            ],
            [
                'name' => 'Aventura',
                'parent_ref' => 8,
                'meta' => 'IBC Games | Aventura',
                'url-key' => 'aventura',
            ],
            [
                'name' => 'Terror',
                'parent_ref' => 8,
                'meta' => 'IBC Games | Terror',
                'url-key' => 'terror',
            ],
            [
                'name' => 'Esporte',
                'parent_ref' => 8,
                'meta' => 'IBC Games | Esporte',
                'url-key' => 'esporte',
            ],
            [
                'name' => 'Estratégia',
                'parent_ref' => 8,
                'meta' => 'IBC Games | Estratégia',
                'url-key' => 'estrategia',
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
                'name' => 'Decks',
                'meta-title' => 'IBC Skate | Decks',
                'url-key' => 'decks'
            ],
            [
                'entity' => $this->entities[4],
                'name' => 'Grip Tape',
                'meta-title' => 'IBC Skate | Grip Tape',
                'url-key' => 'gripe-tape'
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
            ]
        ];
    }

    private function getData3()
    {
        return [
            [
                'entity' => $this->entities[8],
                'url-key' => 'luta'
            ],
            [
                'entity' => $this->entities[9],
                'url-key' => 'simulacao'
            ],
            [
                'entity' => $this->entities[10],
                'url-key' => 'aventura'
            ],
            [
                'entity' => $this->entities[11],
                'url-key' => 'terror'
            ],
            [
                'entity' => $this->entities[12],
                'url-key' => 'esporte'
            ],
            [
                'entity' => $this->entities[13],
                'url-key' => 'estrategia'
            ]
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
