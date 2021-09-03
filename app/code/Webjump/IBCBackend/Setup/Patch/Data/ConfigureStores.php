<?php

namespace Webjump\IBCBackend\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

use Magento\Store\Model\ResourceModel\Website;
use Magento\Store\Model\WebsiteFactory;

use Magento\Store\Model\ResourceModel\Group;
use Magento\Store\Model\GroupFactory;

use Magento\Store\Model\ResourceModel\Store;
use Magento\Store\Model\StoreFactory;

/**
 * @codeCoverageIgnore
 */
class ConfigureStores implements DataPatchInterface
{

    const IBC_SKATE_WEBSITE_CODE = 'skate_ibc';
    const IBC_SKATE_STORE_1_CODE = 'skate_ibc_1';
    const IBC_SKATE_STORE_2_CODE = 'skate_ibc_2';
    const IBC_SKATE_GROUP_CODE = 'skate_ibc_group';

    const IBC_GAMES_WEBSITE_CODE = 'games_ibc';
    const IBC_GAMES_STORE_CODE = 'games_ibc_view';
    const IBC_GAMES_GROUP_CODE = 'games_ibc_group';

    private $moduleDataSetup;

    private $websiteFactory;

    private $websiteResourceModel;

    private $storeFactory;

    private $storeResourceModel;

    private $groupFactory;

    private $groupResourceModel;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param WebsiteFactory $websiteFactory
     * @param Website $websiteResourceModel
     * @param StoreFactory $storeFactory
     * @param Store $storeResourceModel
     * @param GroupFactory $groupFactory
     * @param Group $groupResourceModel
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        WebsiteFactory $websiteFactory,
        Website $websiteResourceModel,
        StoreFactory $storeFactory,
        Store $storeResourceModel,
        GroupFactory $groupFactory,
        Group $groupResourceModel)
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->websiteFactory = $websiteFactory;
        $this->websiteResourceModel = $websiteResourceModel;
        $this->storeFactory = $storeFactory;
        $this->storeResourceModel = $storeResourceModel;
        $this->groupFactory = $groupFactory;
        $this->groupResourceModel = $groupResourceModel;
    }

    public function getData(): array
    {
        return [
            'skate_ibc' => [
                'website' => [
                    'code' => self::IBC_SKATE_WEBSITE_CODE,
                    'name' => 'Skate IBC Website',
                    'sort_order' => '1',
                    'is_default' => '1'
                ],
                'group' => [
                    'name' => 'Skate IBC Group',
                    'root_category_id' => '2',
                    'code' => self::IBC_SKATE_GROUP_CODE,
                    'default_store_id' => '0'
                ],
                'store' => [
                    'skate_ibc_1' => [
                        'code' => self::IBC_SKATE_STORE_1_CODE,
                        'name' => 'Skate IBC Store - Português',
                        'sort_order' => '1',
                        'is_active' => '1'
                    ],
                    'skate_ibc_2' => [
                        'code' => self::IBC_SKATE_STORE_2_CODE,
                        'name' => 'Skate IBC Store - English',
                        'sort_order' => '2',
                        'is_active' => '1'
                    ]
                ]
            ],
            'games_ibc' => [
                'website' => [
                    'code' => self::IBC_GAMES_WEBSITE_CODE,
                    'name' => 'Games IBC Website',
                    'sort_order' => '2',
                    'is_default' => '0'
                ],
                'group' => [
                    'name' => 'Games IBC Group',
                    'root_category_id' => '2',
                    'code' => self::IBC_GAMES_GROUP_CODE,
                    'default_store_id' => '0'
                ],
                'store' => [
                    'games_ibc' => [
                        'code' => self::IBC_GAMES_STORE_CODE,
                        'name' => 'Games IBC Store',
                        'sort_order' => '2',
                        'is_active' => '1'
                    ]
                ]
            ]
        ];
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $data = $this->getData();

        foreach ($data as $value) {
            $website = $this->websiteFactory->create();
            $this->websiteResourceModel->load($website, $value['website']['code'], 'code');
            
            if(!$website->getId()){
            
                // Setting Website
                $website->setCode($value['website']['code'])
                    ->setName($value['website']['name'])
                    ->setSortOrder($value['website']['sort_order'])
                    ->setDefaultGroupId(0)
                    ->setIsDefault($value['website']['is_default']);

                    $this->websiteResourceModel->save($website);

                // Setting Group
                $group = $this->groupFactory->create();
                $group->setWebsiteId($website->getId())
                ->setName($value['group']['name'])
                ->setRootCategoryId($value['group']['root_category_id'])
                ->setDefaultStoreId($value['group']['default_store_id'])
                ->setCode($value['group']['code']);

                $this->groupResourceModel->save($group);
                
                // Setting GroupId to Website
                $this->websiteResourceModel->load($website, $value['website']['code'], 'code');
                $website->setDefaultGroupId($group->getId());
                $this->websiteResourceModel->save($website);
                
                // Saving Ids from Stores
                $aux = [];
                $i = 0;

                // Setting Store
                foreach ($value['store'] as $storeIterator) {
                    $store = $this->storeFactory->create();

                    $store->setCode($storeIterator['code'])
                    ->setWebsiteId($website->getId())
                    ->setGroupId($group->getId())
                    ->setName($storeIterator['name'])
                    ->setSortOrder($storeIterator['sort_order'])
                    ->setIsActive($storeIterator['is_active']);

                    $aux[$i] = $store->getId();
                    $i++;

                    $this->storeResourceModel->save($store);
                }

                // Saving Result to Group
                $this->groupResourceModel->load($group, $value['group']['code'], 'code');
                $group->setDefaultStoreId($aux[0]);
                $this->groupResourceModel->save($group);
            }
        }

        $this->moduleDataSetup->getConnection()->endSetup();
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
