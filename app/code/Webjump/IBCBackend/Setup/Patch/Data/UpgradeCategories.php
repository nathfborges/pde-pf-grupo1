<?php
namespace Webjump\IBCBackend\Setup\Patch\Data;

use Magento\Catalog\Model\CategoryFactory;
use Magento\Catalog\Model\CategoryRepository;
use Magento\Catalog\Setup\CategorySetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class UpgradeCategories implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * @var CategoryFactory
     */
    private $categoryFactory;

    /**
     * PatchInitial constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param CategoryRepository $categoryRepository
     * @param CategoryFactory $categoryFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CategoryRepository       $categoryRepository,
        CategoryFactory          $categoryFactory
    )
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->categoryRepository = $categoryRepository;
        $this->categoryFactory = $categoryFactory;
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $categoriaSkateCom = $this->categoryRepository->get(40, 2);
        $categoriaSkateCom->setStoreId(2)
            ->setName('Complete Skateboards')
            ->save();

        $categoriaRodas = $this->categoryRepository->get(50, 2);
        $categoriaRodas->setStoreId(2)
            ->setName('Wheels')
            ->save();

        $categoriaLixas= $this->categoryRepository->get(70, 2);
        $categoriaLixas->setStoreId(2)
            ->setName('Sandpaper')
            ->save();

        $categoriaAcessorios= $this->categoryRepository->get(90, 2);
        $categoriaAcessorios->setStoreId(2)
            ->setName('Acessories')
            ->save();

        $this->moduleDataSetup->getConnection()->endSetup();
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
        return [InstallCategories::class];
    }

}
