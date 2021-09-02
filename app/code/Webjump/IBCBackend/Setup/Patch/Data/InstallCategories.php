<?php

namespace Webjump\IBCBackend\Setup\Patch\Data;

use Magento\Catalog\Model\Category;
use Magento\Catalog\Setup\CategorySetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchVersionInterface;
use Magento\Store\Api\GroupRepositoryInterface;
use Magento\Store\Api\StoreRepositoryInterface;
use Magento\Store\Model\ResourceModel\Group;
use Magento\Store\Model\GroupFactory;


/**
 * @codeCoverageIgnore
 */
class InstallCategories implements DataPatchInterface, PatchVersionInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var CategorySetupFactory
     */
    private $categorySetup;

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
     * PatchInitial constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param CategorySetupFactory $categorySetup
     * @param GroupFactory $groupFactory
     * @param Group $group
     * @param StoreRepositoryInterface $storeRepositoryInterface
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CategorySetupFactory     $categorySetup,
        GroupFactory             $groupFactory,
        Group                   $group,
        StoreRepositoryInterface $storeRepositoryInterface
    )
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->categorySetupFactory = $categorySetup;
        $this->groupFactory = $groupFactory;
        $this->groupResourceModel = $group;
        $this->storeRepositoryInterface = $storeRepositoryInterface;
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        /** @var CategorySetupFactory $categorySetup */

        $categorySetup = $this->categorySetupFactory->create(['setup' => $this->moduleDataSetup]);
        $rootCategoryId = Category::TREE_ROOT_ID;

        $skate_store_view_1_id = $this->storeRepositoryInterface->get(ConfigureStores::IBC_SKATE_STORE_1_CODE)->getId();
        $games_store_view_id = $this->storeRepositoryInterface->get(ConfigureStores::IBC_GAMES_STORE_CODE)->getId();


        // Create Root Catalog Node
        $categorySetup->createCategory()
            ->load($rootCategoryId)
            ->setId($rootCategoryId)
            ->setPath($rootCategoryId)
            ->setStoreId(0)
            ->setLevel(3)
            ->setPosition(0)
            ->setName('Root Category')
            ->save();


        // Create Jogos Category
        $categoryJogos = $categorySetup->createCategory();
        $categoryJogos->load(2)
            ->setId(2)
            ->setStoreId($games_store_view_id)
            ->setName('Jogos')
            ->setParentId($rootCategoryId)
            ->setPath($rootCategoryId . '/' . $categoryJogos->getId())
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(1)
            ->setInitialSetupFlag(true)
            ->save();

        $category = $categorySetup->createCategory();
        $category->load(3)
            ->setId(3)
            ->setStoreId($games_store_view_id)
            ->setParentId($categoryJogos->getId())
            ->setPath($rootCategoryId . '/' . $categoryJogos->getId() . '/' . 3)
            ->setName('Luta')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(2)
            ->setInitialSetupFlag(true)
            ->save();

        $category = $categorySetup->createCategory();
        $category->load(4)
            ->setId(4)
            ->setStoreId($games_store_view_id)
            ->setParentId($categoryJogos->getId())
            ->setPath($rootCategoryId . '/' . $categoryJogos->getId() . '/' . 4)
            ->setName('Simulação')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(2)
            ->setInitialSetupFlag(true)
            ->save();

        $category = $categorySetup->createCategory();
        $category->load(5)
            ->setId(5)
            ->setStoreId($games_store_view_id)
            ->setParentId($categoryJogos->getId())
            ->setPath($rootCategoryId . '/' . $categoryJogos->getId() . '/' . 5)
            ->setName('Aventura')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(2)
            ->setInitialSetupFlag(true)
            ->save();

        $category = $categorySetup->createCategory();
        $category->load(6)
            ->setParentId($categoryJogos->getId())
            ->setId(6)
            ->setStoreId($games_store_view_id)
            ->setPath($rootCategoryId . '/' . $categoryJogos->getId() . '/' . 6)
            ->setName('Terror')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(2)
            ->save();

        $category = $categorySetup->createCategory();
        $category->load(7)
            ->setParentId($categoryJogos->getId())
            ->setId(7)
            ->setStoreId($games_store_view_id)
            ->setPath($rootCategoryId . '/' . $categoryJogos->getId() . '/' . 7)
            ->setName('Esporte')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(2)
            ->setInitialSetupFlag(true)
            ->save();

        $category = $categorySetup->createCategory();
        $category->load(9)
            ->setParentId($categoryJogos->getId())
            ->setId(9)
            ->setStoreId($games_store_view_id)
            ->setPath($rootCategoryId . '/' . $categoryJogos->getId() . '/' . 9)
            ->setName('Estratégia')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(2)
            ->setInitialSetupFlag(true)
            ->save();

        // Create Skate Category
        $categorySkate = $categorySetup->createCategory();
        $categorySkate->load(20)
            ->setStoreId($skate_store_view_1_id)
            ->setId(20)
            ->setParentId($rootCategoryId)
            ->setPath($rootCategoryId . '/' . $categorySkate->getId())
            ->setName('Skate')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(1)
            ->setInitialSetupFlag(true)
            ->save();


        $categorySkatesCom = $categorySetup->createCategory();
        $categorySkatesCom->load(40)
            ->setStoreId($skate_store_view_1_id)
            ->setId(40)
            ->setParentId($categorySkate->getId())
            ->setPath($rootCategoryId . '/' . $categorySkate->getId() . '/' . 40)
            ->setName('Skates Completos')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(2)
            ->setInitialSetupFlag(true)
            ->save();

        $categoryRodas = $categorySetup->createCategory();
        $categoryRodas->load(50)
            ->setStoreId($skate_store_view_1_id)
            ->setId(50)
            ->setParentId($categorySkate->getId())
            ->setPath($rootCategoryId . '/' . $categorySkate->getId() . '/' . 50)
            ->setName('Rodas')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(2)
            ->setInitialSetupFlag(true)
            ->save();

        $categoryShapes = $categorySetup->createCategory();
        $categoryShapes->load(60)
            ->setStoreId($skate_store_view_1_id)
            ->setId(60)
            ->setParentId($categorySkate->getId())
            ->setPath($rootCategoryId . '/' . $categorySkate->getId() . '/' . 60)
            ->setName('Shapes')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(2)
            ->setInitialSetupFlag(true)
            ->save();

        $categoryLixas = $categorySetup->createCategory();
        $categoryLixas->load(70)
            ->setStoreId($skate_store_view_1_id)
            ->setId(70)
            ->setParentId($categorySkate->getId())
            ->setPath($rootCategoryId . '/' . $categorySkate->getId() . '/' . 70)
            ->setName('Lixas')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(2)
            ->setInitialSetupFlag(true)
            ->save();

        $categoryTrucks = $categorySetup->createCategory();
        $categoryTrucks->load(80)
            ->setStoreId($skate_store_view_1_id)
            ->setId(80)
            ->setParentId($categorySkate->getId())
            ->setPath($rootCategoryId . '/' . $categorySkate->getId() . '/' . 80)
            ->setName('Trucks')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(2)
            ->setInitialSetupFlag(true)
            ->save();

        $categoryAcessorios = $categorySetup->createCategory();
        $categoryAcessorios->load(90)
            ->setStoreId($skate_store_view_1_id)
            ->setId(90)
            ->setParentId($categorySkate->getId())
            ->setPath($rootCategoryId . '/' . $categorySkate->getId() . '/' . 90)
            ->setName('Acessórios')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(2)
            ->setInitialSetupFlag(true)
            ->save();

        $group = $this->groupFactory->create();
        $this->groupResourceModel->load($group, ConfigureStores::IBC_SKATE_GROUP_CODE, 'code');
        
        $group->setRootCategoryId($categorySkate->getId());

        $this->groupResourceModel->save($group);

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    public static function getVersion()
    {
        return '2.0.0';
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }

    public static function getDependencies()
    {
        return [
            ConfigureStores::class
        ];
    }
}
