<?php

namespace Webjump\IBCBackend\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\SalesRule\Api\Data\RuleInterfaceFactory;
use Magento\SalesRule\Api\RuleRepositoryInterface;
use Magento\SalesRule\Api\Data\ConditionInterfaceFactory;
use Magento\SalesRule\Api\Data\ConditionInterface;
use Magento\SalesRule\Model\Data\Condition;
use Magento\SalesRule\Model\Rule\Condition\Address;
use Magento\Rule\Model\Condition\Combine;

class InstallSaleRule implements DataPatchInterface
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
     * @var RuleRepositoryInterface
     */
    private $ruleRepository;

    /**
     * @var ConditionInterfaceFactory
     */
    private $conditionFactory;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        RuleInterfaceFactory $ruleFactory,
        RuleRepositoryInterface $ruleRepository,
        ConditionInterfaceFactory $conditionFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->ruleFactory = $ruleFactory;
        $this->ruleRepository = $ruleRepository;
        $this->conditionFactory = $conditionFactory;
    }

    public function generateCondition(array $data)
    {
        /** @var ConditionInterface */
        $condition = $this->conditionFactory->create();
        $condition2 = $this->conditionFactory->create();

        $condition2
            ->setConditionType(Address::class)
            ->setAttributeName($data['condition']['attribute'])
            ->setOperator($data['condition']['operator'])
            ->setValue($data['condition']['value']);


        $condition->setAttributeName($data['attribute'])
            ->setOperator($data['operator'])
            ->setValue($data['value'])
            ->setAggregatorType($data['aggregator'])
            ->setConditionType(Combine::class)
            ->setConditions([$condition2]);


        return $condition;
    }

    public function getData(): array
    {
        return [
            'name' => '5 More Items - 10% Discount',
            'description' => '5 Items or more will have 10% discount',
            'websiteids' => ['1', '2'],
            'groups' => ['0', '1', '2', '3'],
            'active' => 1,
            'priority' => 1,
            'condition' => [
                'attribute' => null,
                'operator' => null,
                'value' => 1,
                'aggregator' => ConditionInterface::AGGREGATOR_TYPE_ALL,
                'condition' => [
                    'attribute' => 'total_qty',
                    'operator' => '>=',
                    'value' => 5,
                ]
            ],
            'simple_action' => 'by_percent',
            'discount' => 10
        ];
    }

    /**
     *  {@inheritDoc}
     */
    public function apply()
    {

        $this->moduleDataSetup->getConnection()->startSetup();

        $data = $this->getData();

        $setcondition = $this->generateCondition($data['condition']);

        $cartRule = $this->ruleFactory->create();
        $cartRule
            ->setName($data['name'])
            ->setDescription($data['description'])
            ->setWebsiteIds($data['websiteids'])
            ->setCustomerGroupIds($data['groups'])
            ->setIsActive($data['active'])
            ->setIsActive($data['priority'])
            ->setCondition($setcondition)
            ->setDiscountAmount($data['discount'])
            ->setSimpleAction($data['simple_action']);

        $this->ruleRepository->save($cartRule);

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
