<?php

namespace Webjump\IBCBackend\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\CatalogRule\Api\Data\RuleInterfaceFactory;
use Magento\CatalogRule\Api\CatalogRuleRepositoryInterface;
use Magento\Customer\Model\Group;
use Webjump\IBCBackend\App\State;
use Magento\Framework\App\Area;
use Magento\Store\Api\WebsiteRepositoryInterface;
use Webjump\IBCBackend\Setup\Patch\Data\ConfigureStores;

/**
 * @codeCoverageIgnore
 */
class InstallCatalogRule implements DataPatchInterface
{
    /** @var ModuleDataSetupInterface */
    private $moduleDataSetup;

    /** @var RuleInterfaceFactory */
    private $ruleFactory;

    /** @var CatalogRuleRepositoryInterface */
    private $catalogRuleRepository;

    /** @var State */
    private $state;

    /** @var WebsiteRepositoryInterface */
    private $websiteRepositoryInterface;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param RuleInterfaceFactory $ruleFactory
     * @param CatalogRuleRepositoryInterface $catalogRuleRepository
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        RuleInterfaceFactory $ruleFactory,
        CatalogRuleRepositoryInterface $catalogRuleRepository,
        WebsiteRepositoryInterface $websiteRepositoryInterface,
        State $state)
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->ruleFactory = $ruleFactory;
        $this->catalogRuleRepository = $catalogRuleRepository;
        $this->websiteRepositoryInterface = $websiteRepositoryInterface;
        $this->state = $state;
        if (!$this->state->validateAreaCode()) {
            $this->state->setAreaCode(Area::AREA_ADMINHTML);
           }
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $skate_website_id = $this->websiteRepositoryInterface->get(ConfigureStores::IBC_SKATE_WEBSITE_CODE)->getId();
        $games_website_id = $this->websiteRepositoryInterface->get(ConfigureStores::IBC_GAMES_WEBSITE_CODE)->getId();

        $catalogRule5Perc = $this->ruleFactory->create();
        $catalogRule5Perc
            ->setName('Discount 5%')
            ->setDescription('5% Discount for Visitors')
            ->setIsActive(1)
            ->setCustomerGroupIds(Group::NOT_LOGGED_IN_ID)
            ->setSimpleAction("by_percent")
            ->setDiscountAmount(5)
            ->setStopRulesProcessing(0)
            ->setWebsiteIds($skate_website_id);

        $this->catalogRuleRepository->save($catalogRule5Perc);

        $catalogRule10Perc = $this->ruleFactory->create();
        $catalogRule10Perc
            ->setName('Discount 10%')
            ->setDescription('10% Discount for Visitors')
            ->setIsActive(1)
            ->setCustomerGroupIds(Group::NOT_LOGGED_IN_ID)
            ->setSimpleAction("by_percent")
            ->setDiscountAmount(10)
            ->setStopRulesProcessing(0)
            ->setWebsiteIds($games_website_id);

        $this->catalogRuleRepository->save($catalogRule10Perc);

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     *  {@inheritDoc}
     */
    public static function getDependencies()
    {
        return [
            ConfigureStores::class
        ];
    }

    /**
     *  {@inheritDoc}
     */
    public function getAliases()
    {
        return [];
    }
}
