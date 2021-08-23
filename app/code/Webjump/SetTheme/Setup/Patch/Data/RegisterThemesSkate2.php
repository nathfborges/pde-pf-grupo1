<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Webjump\SetTheme\Setup\Patch\Data;

use Magento\Theme\Model\Theme\Registration;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\App\Config\ConfigResource\ConfigInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Store\Model\ScopeInterface;


/**
 * Class RegisterThemes
 * @package Magento\Theme\Setup\Patch
 */
class RegisterThemesSkate2 implements DataPatchInterface
{
    /**
     * @var ConfigInterface
     */
    private $configInterface;

    private StoreManagerInterface $storeManager;
    /**
     * RegisterThemes constructor.
     * @param \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup
     * @param Registration $themeRegistration
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        ConfigInterface $configInterface
    ) {

        $this->storeManager = $storeManager;
        $this->configInterface = $configInterface;
    }
    /**
     * {@inheritdoc}
     */
    public function apply()
    {

        $ibcSkate2Id = $this->storeManager->getStore('skate_ibc_2')->getId();
        $this->configInterface->saveConfig(
            'design/theme/theme_id',
            6,
            ScopeInterface::SCOPE_STORES,
            $ibcSkate2Id
        );
    }
    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }
    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}
