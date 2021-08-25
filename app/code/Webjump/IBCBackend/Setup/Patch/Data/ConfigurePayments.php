<?php

namespace Webjump\IBCBackend\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\App\Config\ConfigResource\ConfigInterface;


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

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        ConfigInterface $configInterface
    )
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->configInterface = $configInterface;
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

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
