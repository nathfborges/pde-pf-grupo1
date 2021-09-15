<?php

namespace Webjump\IBCBackend\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\App\Config\ConfigResource\ConfigInterface;
use Magento\Store\Api\StoreRepositoryInterface;

/**
 * @codeCoverageIgnore
 */
class ConfigurePayments implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var ConfigInterface
     */
    private $configInterface;

    /**
     * @var StoreRepositoryInterface
     */
    private $storeRepositoryInterface;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        ConfigInterface $configInterface,
        StoreRepositoryInterface $storeRepositoryInterface
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->configInterface = $configInterface;
        $this->storeRepositoryInterface = $storeRepositoryInterface;
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        // GENERAL CONFIG

        $this->configInterface->saveConfig(
            'payment/banktransfer/active',
            true
        );

        $this->configInterface->saveConfig(
            'payment/checkmo/active',
            true
        );

        $this->configInterface->saveConfig(
            'payment/purchaseorder/active',
            true
        );

        // IBC Skate Store 1

        $ibc_skate_store_1_id = $this->storeRepositoryInterface->get(ConfigureStores::IBC_SKATE_STORE_1_CODE)->getId();

        $this->configInterface->saveConfig(
            'payment/banktransfer/title',
            'Pagamento por Transferência Bancária',
            'stores',
            $ibc_skate_store_1_id
        );

        $this->configInterface->saveConfig(
            'payment/checkmo/title',
            'Pedido por Boleto',
            'stores',
            $ibc_skate_store_1_id
        );

        $this->configInterface->saveConfig(
            'payment/purchaseorder/title',
            'Ordem de Compra',
            'stores',
            $ibc_skate_store_1_id
        );

        // IBC Games Store

        $ibc_games_store = $this->storeRepositoryInterface->get(ConfigureStores::IBC_GAMES_STORE_CODE)->getId();

        $this->configInterface->saveConfig(
            'payment/banktransfer/title',
            'Pagamento por Transferência Bancária',
            'stores',
            $ibc_games_store
        );

        $this->configInterface->saveConfig(
            'payment/checkmo/title',
            'Pedido por Boleto',
            'stores',
            $ibc_games_store
        );

        $this->configInterface->saveConfig(
            'payment/purchaseorder/title',
            'Ordem de Compra',
            'stores',
            $ibc_games_store
        );

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    public function getAliases()
    {
        return [];
    }

    public static function getDependencies()
    {
        return [];
    }
}
