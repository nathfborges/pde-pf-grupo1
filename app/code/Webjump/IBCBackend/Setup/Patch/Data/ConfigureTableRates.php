<?php
namespace Webjump\IBCBackend\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\App\Config\ConfigResource\ConfigInterface;

class ConfigureTableRates implements DataPatchInterface
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
     * ConfigureTableRates Constructor
     * 
     * @param ModuleDataSetupInterface
     * @param ConfigInterface
     */
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
            'carriers/tablerate/active',
            '1' // receive 0 or 1 in admin
        );

        $this->configInterface->saveConfig(
            'carriers/tablerate/title',
            'Entrega Ninja'
        );

        $this->configInterface->saveConfig(
            'carriers/tablerate/name',
            'Método de Entrega Ninja'
        );

        $this->configInterface->saveConfig(
            'carriers/tablerate/condition_name',
            'package_value_with_discount'
        );

        $this->configInterface->saveConfig(
            'carriers/tablerate/include_virtual_price',
            true
        );

        $this->configInterface->saveConfig(
            'carriers/tablerate/handling_type',
            'F'
        );

        $this->configInterface->saveConfig(
            'carriers/tablerate/handling_fee',
            '5.0'
        );

        $this->configInterface->saveConfig(
            'carriers/tablerate/specificerrmsg',
            'Desculpe! Este método de envio não está disponível. :('
        );

        $this->configInterface->saveConfig(
            'carriers/tablerate/sallowspecific',
            true
        );

        $this->configInterface->saveConfig(
            'carriers/tablerate/specificcountry',
            'BR,US,CA'
        );

        $this->configInterface->saveConfig(
            'carriers/tablerate/sort_order',
            '0'
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
