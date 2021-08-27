<?php

namespace Webjump\IBCBackend\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\CatalogRule\Api\Data\RuleInterfaceFactory;
use Magento\CatalogRule\Model\CatalogRuleRepository;
use Magento\Customer\Model\Group;

class InstallCatalogRule implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var RuleInterfaceFactory
     */
    private $ruleFactory;

    /**
     * @var CatalogRuleRepository
     */
    private $catalogRuleRepository;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param Rule $rule
     */
    public function __construct(ModuleDataSetupInterface $moduleDataSetup, RuleInterfaceFactory $ruleFactory, CatalogRuleRepository $catalogRuleRepository)
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->ruleFactory = $ruleFactory;
        $this->catalogRuleRepository = $catalogRuleRepository;
    }

    /**
     *  {@inheritDoc}
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $catalogRule5Perc = $this->ruleFactory->create();

        $catalogRule5Perc
            ->setName('Discount 5%')
            ->setDescription('5% Discount for Visitors')
            ->setIsActive(1)
            ->setSortOrder(1)
            ->setSimpleAction("by_percent")
            ->setDiscountAmount(5)
            ->setWebsiteIds('1')
            ->setCustomerGroupIds(Group::NOT_LOGGED_IN_ID)
            ->setStopRulesProcessing(0);

        $this->catalogRuleRepository->save($catalogRule5Perc);

        $catalogRule10Perc = $this->ruleFactory->create();
        $catalogRule10Perc
            ->setName('Discount 10%')
            ->setDescription('10% Discount for Visitors')
            ->setIsActive(1)
            ->setSortOrder(2)
            ->setSimpleAction("by_percent")
            ->setDiscountAmount(10)
            ->setWebsiteIds('2')
            ->setCustomerGroupIds(Group::NOT_LOGGED_IN_ID)
            ->setStopRulesProcessing(0);

        $this->catalogRuleRepository->save($catalogRule10Perc);

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
