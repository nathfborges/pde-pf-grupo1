<?php

namespace Webjump\IBCBackend\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Setup\Module\Setup;

/**
 * @codeCoverageIgnore
 */
class ConfigureCurrencyRate implements DataPatchInterface
{

    const API_KEY = '34006f616fb5f1a33b0f';

    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var Setup
     */
    private $setup;

    /**
    * ConfigureCurrencyRate Constructor
    * 
    * @param ModuleDataSetupInterface
    * @param Setup
    */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        Setup $setup
    ) 
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->setup = $setup;
    }

    /**
     * Set values of Currency Rate
     * 
     * {@inheritdoc}
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $this->insertRate();

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * Insert values in "directory_currency_rate" table.
     */
    public function insertRate():void
    {
        $rateData = $this->getData();
        $columns = $rateData[0];
        unset($rateData[0]);
        $rateData = array_values($rateData);

        $this->setup->getConnection()->insertArray('directory_currency_rate', $columns, $rateData);
    }

    /**
     * Set currency rate array data.
     * 
     * @return array
     */
    public function getData(): array
    {
        $rateData = [
            ['currency_from', 'currency_to', 'rate'],
            ['BRL', 'USD', 0.193147000000]
        ];
        return $rateData;
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [
            ConfigureStores::class
        ];
    }
}
