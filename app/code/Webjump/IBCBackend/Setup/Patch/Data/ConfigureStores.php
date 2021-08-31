<?php
namespace Webjump\IBCBackend\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Store\Api\GroupRepositoryInterface;
use Magento\Store\Api\StoreRepositoryInterface;
use Magento\Store\Api\WebsiteRepositoryInterface;
use Magento\Store\Model\GroupFactory;
use Magento\Store\Model\StoreFactory;
use Magento\Store\Model\WebsiteFactory;

class ConfigureStores implements DataPatchInterface
{

    private $moduleDataSetup;

    private $websiteFactory;

    private $websiteRepositoryInterface;

    private $storeFactory;

    private $storeRepositoryInterface;

    private $groupFactory;

    private $groupRepositoryInterface;


    public function __construct(ModuleDataSetupInterface $moduleDataSetup,
    WebsiteFactory $websiteFactory,
    WebsiteRepositoryInterface $websiteRepositoryInterface,
    StoreFactory $storeFactory,
    StoreRepositoryInterface $storeRepositoryInterface,
    GroupFactory $groupFactory,
    GroupRepositoryInterface $groupRepositoryInterface)
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->websiteFactory = $websiteFactory;
        $this->websiteRepositoryInterface = $websiteRepositoryInterface;
        $this->storeFactory = $storeFactory;
        $this->storeRepositoryInterface = $storeRepositoryInterface;
        $this->groupFactory = $groupFactory;
        $this->groupRepositoryInterface = $groupRepositoryInterface;

    }

    public function getData(): array
    {
        return [
            ['skate_ibc' => [
                'website_id' => '1',
                'code' => 'skate_ibc',
                'name' => 'Skate IBC Website',
                'sort_order' => '1',
                'default_group_id' => '1',
                'is_default' => '1'
            ],
                'games_ibc' => [
                'website_id' => '2',
                'code' => 'games_ibc',
                'name' => 'Games IBC Website',
                'sort_order' => '2',
                'default_group_id' => '2',
                'is_default' => '0'
                ],
            ],
            [   'group_id' => '1',
                'website_id' => '1',
                'name' => 'Skate IBC Group',
                'root_category_id' => '20',
                'default_store_id' => '1',
                'code' => 'skate_ibc'
            ],
            [   'group_id' => '2',
                'website_id' => '2',
                'name' => 'Games IBC Group',
                'root_category_id' => '2',
                'default_store_id' => '3',
                'code' => 'games_ibc'
            ],
            ['skate_ibc_1' => [
                'store_id' => '1',
                'code' => 'skate_ibc_1',
                'website_id' => '1',
                'group_id' => '1',
                'name' => 'Skate IBC Store - Português',
                'sort_order' => '1',
                'is_active' => '1'
            ],
            'skate_ibc_2' => [
                'store_id' => '2',
                'code' => 'skate_ibc_2',
                'website_id' => '1',
                'group_id' => '1',
                'name' => 'Skate IBC Store - English',
                'sort_order' => '1',
                'is_active' => '1'
            ],
            'games_ibc' => [
                'store_id' => '3',
                'code' => 'games_ibc',
                'website_id' => '2',
                'group_id' => '2',
                'name' => 'Games IBC Store',
                'sort_order' => '2',
                'is_active' => '1'
            ]
            ]
        ];
    }

    public function apply()
    {
        $this->moduleDataSetup->startSetup();


        
        $this->moduleDataSetup->endSetup();
        
    }

    /** {@inheritdoc} */
    public static function getDependencies()
    {
        return [];
    }

    /** {@inheritdoc} */
    public function getAliases()
    {
        return [];
        
    }
}
