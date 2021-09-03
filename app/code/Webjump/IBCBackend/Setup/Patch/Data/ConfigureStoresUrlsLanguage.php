<?php
namespace Webjump\IBCBackend\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Webjump\IBCBackend\Setup\Patch\Data\ConfigureStores;
use Magento\Framework\App\Config\ConfigResource\ConfigInterface;
use Magento\Store\Api\StoreRepositoryInterface;
use Magento\Store\Api\WebsiteRepositoryInterface;

class ConfigureStoresUrlsLanguage implements DataPatchInterface
{
    /** @var ModuleDataSetupInterface */
    private $moduleDataSetup;

    /** @var ConfigInterface */
    private $configInterface;

    /** @var StoreRepositoryInterface */
    private $storeRepositoryInterface;

    /** @var WebsiteRepositoryInterface */
    private $websiteRepositoryInterface;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        ConfigInterface $configInterface,
        StoreRepositoryInterface $storeRepositoryInterface,
        WebsiteRepositoryInterface $websiteRepositoryInterface
    )
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->configInterface = $configInterface;
        $this->storeRepositoryInterface = $storeRepositoryInterface;
        $this->websiteRepositoryInterface = $websiteRepositoryInterface;
    }

    /** {@inheritdoc} */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $skate_view_2 = $this->storeRepositoryInterface
            ->get(ConfigureStores::IBC_SKATE_STORE_2_CODE)
            ->getId();
        
        // Setting ENG Language to Skate Store View 2
        $this->configInterface->saveConfig(
            'general/locale/code',
            'en_US',
            'stores',
            $skate_view_2
        );

        // Setting CURRENCY to Skate Store View 2
        $this->configInterface->saveConfig(
            'currency/options/allow',
            'USD',
            'stores',
            $skate_view_2
        );

        $this->configInterface->saveConfig(
            'currency/options/default',
            'USD',
            'stores',
            $skate_view_2
        );

        // Setting URL to IBC Skate Website
        $skate_web_id = $this->websiteRepositoryInterface->get(ConfigureStores::IBC_SKATE_WEBSITE_CODE)->getId();

        $this->configInterface->saveConfig(
            'web/unsecure/base_url',
            'http://ibcskate.localhost',
            'websites',
            $skate_web_id
        );

        // Setting URL to IBC Games Website
        $games_web_id = $this->websiteRepositoryInterface->get(ConfigureStores::IBC_GAMES_WEBSITE_CODE)->getId();

        $this->configInterface->saveConfig(
            'web/unsecure/base_url',
            'http://ibcgames.localhost',
            'websites',
            $games_web_id
        );
        
        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /** {@inheritdoc} */
    public static function getDependencies()
    {
        return [
            ConfigureStores::class
        ];
    }

    /** {@inheritdoc} */
    public function getAliases()
    {
        return [];
        
    }
}
