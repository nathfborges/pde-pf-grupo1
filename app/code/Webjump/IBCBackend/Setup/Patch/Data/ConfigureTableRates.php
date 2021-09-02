<?php
namespace Webjump\IBCBackend\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\App\Config\ConfigResource\ConfigInterface;
use Magento\Framework\File\Csv;
use Magento\Setup\Module\Setup;
use DomainException;

class ConfigureTableRates implements DataPatchInterface
{
    const TABLE_NAME = 'shipping_tablerate';
    const PATH_CSV = __DIR__ . '/csv/tablerates.csv';

    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var ConfigInterface
     */
    private $configInterface;

    /**
     * @var Csv
     */
    private $csvImport;

    /**
     * @var Setup
     */
    private $setup;

    /**
     * ConfigureTableRates Constructor
     * 
     * @param ModuleDataSetupInterface
     * @param ConfigInterface
     * @param Csv
     * @param Setup
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        ConfigInterface $configInterface,
        Csv $csvImport,
        Setup $setup
    )
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->configInterface = $configInterface;
        $this->csvImport = $csvImport;
        $this->setup = $setup;
    }

    /**
     * Set configs of Table Rate on Admin
     * 
     * {@inheritdoc}
     */
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

        $this->importTableRates();
    }

    /**
     * Get CSV file to a Array and import it to "shipping_tablerate" table.
     */
    public function importTableRates()
    {
        if (!file_exists(self::PATH_CSV)) {
            throw new DomainException('O arquivo de importação dos Table Rates não se encontra na pasta csv');
        }
        $csv = $this->csvImport->getData(self::PATH_CSV);
        $columns = $csv[0];
        unset($csv[0]);
        $csv = array_values($csv);
        $this->setup->getConnection()->insertArray(self::TABLE_NAME, $columns, $csv);
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
        return [];
    }
}
