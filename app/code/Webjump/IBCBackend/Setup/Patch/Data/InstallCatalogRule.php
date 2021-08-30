<?php

namespace Webjump\IBCBackend\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\CatalogRule\Api\Data\RuleInterfaceFactory;
use Magento\CatalogRule\Api\CatalogRuleRepositoryInterface;
use Magento\CatalogRule\Api\CatalogRuleRepository;
use Magento\Customer\Model\Group;

class InstallCatalogRule implements DataPatchInterface
{
    /** @var ModuleDataSetupInterface */
    private $moduleDataSetup;

    /** @var RuleInterfaceFactory */
    private $ruleFactory;

    // /**
    //  * @var CatalogRuleRepositoryInterface
    //  */
    // private $catalogRuleRepository;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param RuleInterfaceFactory $ruleFactory
     * @param CatalogRuleRepositoryInterface $catalogRuleRepository
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        RuleInterfaceFactory $ruleFactory,
        CatalogRuleRepositoryInterface $catalogRuleRepository)
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->ruleFactory = $ruleFactory;
        // $this->catalogRuleRepository = $catalogRuleRepository;
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $catalogRule5Perc = $this->ruleFactory->create();

        $catalogRule5Perc
            ->setName('Discount 5%')
            ->setDescription('5% Discount for Visitors')
            ->setIsActive(1)
            ->setWebsiteIds('1')
            ->setCustomerGroupIds(Group::NOT_LOGGED_IN_ID)
            ->setSimpleAction("by_percent")
            ->setDiscountAmount(5)
            ->setStopRulesProcessing(0)
            ->save();

        // $this->catalogRuleRepository->save($catalogRule5Perc);

        $catalogRule10Perc = $this->ruleFactory->create();
        $catalogRule10Perc
            ->setName('Discount 10%')
            ->setDescription('10% Discount for Visitors')
            ->setIsActive(1)
            ->setWebsiteIds('2')
            ->setCustomerGroupIds(Group::NOT_LOGGED_IN_ID)
            ->setSimpleAction("by_percent")
            ->setDiscountAmount(10)
            ->setStopRulesProcessing(0)
            ->save();

        // $this->catalogRuleRepository->save($catalogRule10Perc);

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     *  {@inheritDoc}
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     *  {@inheritDoc}
     */
    public function getAliases()
    {
        return [];
    }
}
