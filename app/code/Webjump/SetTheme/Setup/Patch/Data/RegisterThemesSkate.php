<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Webjump\SetTheme\Setup\Patch\Data;

use Magento\Theme\Model\Theme\Registration;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\App\Config\ConfigResource\ConfigInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Theme\Model\ThemeFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Theme\Model\ResourceModel\Theme as ThemeResourceModel;
use Webjump\IBCBackend\Setup\Patch\Data\ConfigureStores;

/**
 * Class RegisterThemes
 * @package Magento\Theme\Setup\Patch
 */
class RegisterThemesSkate implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetupInterface;

    /**
     * @var ConfigInterface
     */
    private $configInterface;

    /**
     * @var StoreManagerInterface
     */
    private StoreManagerInterface $storeManager;

    /**
     * @var ThemeFactory
     */
    private $themeFactory;

    /**
     * @var ThemeResourceModel
     */
    private $themeResourceModel;

    /**
     * RegisterThemes constructor.
     * @param ModuleDataSetupInterface
     * @param StoreManagerInterface
     * @param Registration
     * @param ThemeFactory
     * @param ThemeResourceModel
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetupInterface,
        StoreManagerInterface $storeManager,
        ConfigInterface $configInterface,
        ThemeFactory $themeFactory,
        ThemeResourceModel $themeResourceModel

    ) {
        $this->moduleDataSetupInterface = $moduleDataSetupInterface;
        $this->storeManager = $storeManager;
        $this->configInterface = $configInterface;
        $this->themeFactory = $themeFactory;
        $this->themeResourceModel = $themeResourceModel;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        $this->moduleDataSetupInterface->getConnection()->startSetup();
        
        $ibcSkateTheme = $this->themeFactory->create();
        $this->themeResourceModel->load($ibcSkateTheme, 'IBC_Skate/tema_principal', 'theme_path');
        $ibcSkateId = $this->storeManager->getStore(ConfigureStores::IBC_SKATE_STORE_1_CODE)->getId();
        $this->configInterface->saveConfig(
            'design/theme/theme_id',
            $ibcSkateTheme->getThemeId(),
            ScopeInterface::SCOPE_STORES,
            $ibcSkateId
        );

        $this->moduleDataSetupInterface->getConnection()->endSetup();
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

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}
