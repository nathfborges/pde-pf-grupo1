<?php
namespace Webjump\IBCBackend\Setup\Patch\Data;

use Magento\Catalog\Model\CategoryFactory;
use Magento\Catalog\Model\CategoryRepository;
use Magento\Catalog\Setup\CategorySetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Store\Api\StoreRepositoryInterface;

/**
 * @codeCoverageIgnore
 */
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
     * @var StoreRepositoryInterface
     */
    private $storeRepositoryInterface;
    
    /**
     * PatchInitial constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param CategoryRepository $categoryRepository
     * @param CategoryFactory $categoryFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CategoryRepository       $categoryRepository,
        CategoryFactory          $categoryFactory,
        StoreRepositoryInterface $storeRepositoryInterface
    )
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->categoryRepository = $categoryRepository;
        $this->categoryFactory = $categoryFactory;
        $this->storeRepositoryInterface = $storeRepositoryInterface;
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $skate_store_id = $this->storeRepositoryInterface->get(ConfigureStores::IBC_SKATE_STORE_2_CODE)->getId();

        $categoriaSkateCom = $this->categoryRepository->get(40, $skate_store_id);
        $categoriaSkateCom->setStoreId($skate_store_id)
            ->setName('Complete Skateboards')
            ->save();

        $categoriaRodas = $this->categoryRepository->get(50, $skate_store_id);
        $categoriaRodas->setStoreId($skate_store_id)
            ->setName('Wheels')
            ->save();

        $categoriaLixas= $this->categoryRepository->get(70, $skate_store_id);
        $categoriaLixas->setStoreId($skate_store_id)
            ->setName('Sandpaper')
            ->save();

        $categoriaAcessorios= $this->categoryRepository->get(90, $skate_store_id);
        $categoriaAcessorios->setStoreId($skate_store_id)
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
