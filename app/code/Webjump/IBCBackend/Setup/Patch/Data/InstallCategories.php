<?php

namespace Webjump\IBCBackend\Setup\Patch\Data;

use Magento\Catalog\Model\Category;
use Magento\Catalog\Setup\CategorySetup;
use Magento\Catalog\Setup\CategorySetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchVersionInterface;
use Magento\Catalog\Helper\DefaultCategoryFactory;


class InstallCategories implements DataPatchInterface, PatchVersionInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var CategorySetupFactory
     */
    private $categorySetupFactory;

    /**
     * @var DefaultCategoryFactory
     */
    private $defaultCategory;


    /**
     * PatchInitial constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param CategorySetupFactory $categorySetupFactory
     * @param DefaultCategoryFactory $defaultCategoryFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CategorySetupFactory     $categorySetupFactory,
        DefaultCategoryFactory   $defaultCategoryFactory,
    )
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->categorySetupFactory = $categorySetupFactory;
        $this->defaultCategoryFactory = $defaultCategoryFactory;
    }

    public function apply()
    {

        /** @var CategorySetup $categorySetup */
        /** @var DefaultCategoryFactory $defaultCategory */
        $categorySetup = $this->categorySetupFactory->create(['setup' => $this->moduleDataSetup]);
        $rootCategoryId = Category::TREE_ROOT_ID;
        $defaultCategory = $this->defaultCategoryFactory->create();
        $defaultCategoryId = $defaultCategory->getId();

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
        $category = $categorySetup->createCategory();
        $category->load($defaultCategoryId)
            ->setId(2)
            ->setStoreId(3)
            ->setName('Jogos')
            ->setParentId($rootCategoryId)
            ->setPath($rootCategoryId . '/' . $defaultCategoryId)
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(1)
            ->setInitialSetupFlag(true)
            ->save();

        $category = $categorySetup->createCategory();
        $category->load(3)
            ->setId(3)
            ->setStoreId(3)
            ->setParentId($defaultCategoryId)
            ->setPath($rootCategoryId . '/' . $defaultCategoryId . '/' . 3)
            ->setName('Luta')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(2)
            ->setPosition(3)
            ->setInitialSetupFlag(true)
            ->save();

        $category = $categorySetup->createCategory();
        $category->load(4)
            ->setId(4)
            ->setStoreId(3)
            ->setParentId($defaultCategoryId)
            ->setPath($rootCategoryId . '/' . $defaultCategoryId . '/' . 4)
            ->setName('Simulação')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(2)
            ->setInitialSetupFlag(true)
            ->save();

        $category = $categorySetup->createCategory();
        $category->load(5)
            ->setId(5)
            ->setStoreId(3)
            ->setParentId($defaultCategoryId)
            ->setPath($rootCategoryId . '/' . $defaultCategoryId . '/' . 5)
            ->setName('Aventura')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(2)
            ->setInitialSetupFlag(true)
            ->save();

        $category = $categorySetup->createCategory();
        $category->load(6)
            ->setParentId($defaultCategoryId)
            ->setId(6)
            ->setStoreId(3)
            ->setPath($rootCategoryId . '/' . $defaultCategoryId . '/' . 6)
            ->setName('Terror')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(2)
            ->save();

        $category = $categorySetup->createCategory();
        $category->load(7)
            ->setParentId($defaultCategoryId)
            ->setId(7)
            ->setStoreId(3)
            ->setPath($rootCategoryId . '/' . $defaultCategoryId . '/' . 7)
            ->setName('Esporte')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(2)
            ->setInitialSetupFlag(true)
            ->save();

        $category = $categorySetup->createCategory();
        $category->load(9)
            ->setParentId($defaultCategoryId)
            ->setId(9)
            ->setStoreId(3)
            ->setPath($rootCategoryId . '/' . $defaultCategoryId . '/' . 9)
            ->setStoreId(3)
            ->setName('Estratégia')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(2)
            ->setInitialSetupFlag(true)
            ->save();

        // Create Skate Category
        $categorySkate = $categorySetup->createCategory();
        $categorySkate->load(20)
            ->setStoreId(1)
            ->setId(20)
            ->setParentId($rootCategoryId)
            ->setPath($rootCategoryId . '/' . 20)
            ->setName('Skate')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(1)
            ->setInitialSetupFlag(true)
            ->save();

        $categorySkatesCom = $categorySetup->createCategory();
        $categorySkatesCom->load(40)
            ->setStoreId(1)
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
            ->setStoreId(1)
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
            ->setStoreId(1)
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
            ->setStoreId(1)
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
            ->setStoreId(1)
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
            ->setStoreId(1)
            ->setId(90)
            ->setParentId($categorySkate->getId())
            ->setPath($rootCategoryId . '/' . $categorySkate->getId() . '/' . 90)
            ->setName('Acessórios')
            ->setDisplayMode('PRODUCTS')
            ->setIsActive(1)
            ->setLevel(2)
            ->setInitialSetupFlag(true)
            ->save();
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
        return [];
    }
}
