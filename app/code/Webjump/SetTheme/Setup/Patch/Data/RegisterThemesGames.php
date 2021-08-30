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
use Magento\Theme\Model\ThemeFactory;
use Magento\Theme\Model\ResourceModel\Theme as ThemeResourceModel;

/**
 * Class RegisterThemes
 * @package Magento\Theme\Setup\Patch
 */
class RegisterThemesGames implements DataPatchInterface
{
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
     * @param \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup
     * @param Registration $themeRegistration
     * @param ThemeFactory
     * @param ThemeResourceModel
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        ConfigInterface $configInterface,
        ThemeFactory $themeFactory,
        ThemeResourceModel $themeResourceModel

    ) {
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
        $ibcGamesTheme = $this->themeFactory->create();
        $this->themeResourceModel->load($ibcGamesTheme, 'IBC_Game/tema_principal', 'theme_path');
        $ibcGamesId = $this->storeManager->getStore('games_ibc')->getId();
        $this->configInterface->saveConfig(
            'design/theme/theme_id',
            $ibcGamesTheme->getThemeId(),
            ScopeInterface::SCOPE_STORES,
            $ibcGamesId
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
