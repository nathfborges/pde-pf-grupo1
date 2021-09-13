<?php

namespace Webjump\SetupContents\Setup\Patch\Data;use Magento\Cms\Model\PageFactory;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchInterface;
use Magento\Store\Model\ResourceModel\Website;
use Magento\Store\Model\WebsiteFactory;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Webjump\IBCBackend\Setup\Patch\Data\ConfigureStores;
use Magento\Store\Api\StoreRepositoryInterface;

class CreateAboutPageSkateEn implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;    /**
     * @var Website
     */
    private $website;    /**
     * @var WriterInterface
     */
    private $writerInterface;    /**
     * @var WebsiteFactory
     */
    private $websiteFactory;    /**
     * @var StoreManagerInterface
     */
    private $storeManager;    /**
     * @var PageFactory
     */
    private $pageFactory;

    private $storeRepository;

    /**
     * @var \Magento\Cms\Model\ResourceModel\Page
     */
    private $pageResource;    /**
     * const CODE_WEBSITE
     */
    const CODE_WEBSITE =  [ConfigureStores::IBC_SKATE_WEBSITE_CODE];    /**
     * AddNewCmsPage constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param PageFactory $pageFactory
     * @param \Magento\Cms\Model\ResourceModel\Page $pageResource
     * @param Website $website
     * @param WriterInterface $writerInterface
     * @param WebsiteFactory $websiteFactory
     * @param StoreManager $storeManager
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        PageFactory $pageFactory,
        \Magento\Cms\Model\ResourceModel\Page $pageResource,
        Website $website,
        WriterInterface $writerInterface,
        WebsiteFactory $websiteFactory,
        StoreManagerInterface $storeManager,
        StoreRepositoryInterface $storeRepository
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->pageFactory = $pageFactory;
        $this->pageResource = $pageResource;
        $this->website = $website;
        $this->writerInterface = $writerInterface;
        $this->websiteFactory = $websiteFactory;
        $this->storeManager = $storeManager;
        $this->storeRepository = $storeRepository;
    }    /**
     * @param \Magento\Store\Model\Website $website
     */
    private function setCreateAboutPage(\Magento\Store\Model\Website $website): void
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        
        $skate_in = $this->storeRepository->get(ConfigureStores::IBC_SKATE_STORE_2_CODE);

        $content = <<<HTML
        <style>#html-body [data-pb-style=S9699QY]{justify-content:flex-start;display:flex;flex-direction:column;background-position:left top;background-size:cover;background-repeat:no-repeat;background-attachment:scroll}</style><div data-content-type="row" data-appearance="contained" data-element="main"><div data-enable-parallax="0" data-parallax-speed="0.5" data-background-images="{}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="inner" data-pb-style="S9699QY"><div data-content-type="html" data-appearance="default" data-element="main">&lt;span&gt;Created in 2021, IBC Skate is a platform that is concerned about urban culture and intends to become the pure representation of skateboarding lifestyle. We intend to make accessible a sport that is marginalized and that is so important for those who practice it.&lt;/span&gt;
        &lt;div class="missao-visao-valores"&gt;
        &lt;div class="conteudo-missao-visao-valores"&gt;
        &lt;h3&gt;Mission&lt;/h3&gt;
        &lt;p&gt;Our goal is to expand access to skateboard accessories around the world, and to interest new people and influence them to meet this beautiful universe.&lt;/p&gt;
        &lt;/div&gt;
        &lt;div class="conteudo-missao-visao-valores"&gt;
        &lt;h3&gt;Vision&lt;/h3&gt;
        &lt;p&gt;We want to make the experience of our customers the best possible, in addition to become part of their daily routine.&lt;/p&gt;
        &lt;/div&gt;
        &lt;div class="conteudo-missao-visao-valores"&gt;
        &lt;h3&gt;Values&lt;/h3&gt;
        &lt;p&gt;To become a reference inside the world of Skate and sell the best experiences to our customers.&lt;/p&gt;
        &lt;/div&gt;
        &lt;/div&gt;</div></div></div>
        HTML;

        $pageIdentifier = 'about-us-skate';
        $cmsPageModel = $this->pageFactory->create()->load($pageIdentifier, 'title');
        $cmsPageModel->setIdentifier('about-us-skate');
        $cmsPageModel->setStores([$skate_in->getId()]);
        $cmsPageModel->setTitle('About Us');
        $cmsPageModel->setContentHeading('About Us');
        $cmsPageModel->setPageLayout('1column');
        $cmsPageModel->setIsActive(1);
        $cmsPageModel->setContent($content)->save();
        
        $this->moduleDataSetup->getConnection()->endSetup();
    }    /**
     * {@inheritdoc}
     */
    public function apply()
    {        $websites = $this->storeManager->getWebsites();
        foreach ($websites as $web) {
            if (in_array($web->getCode(), self::CODE_WEBSITE)) {
                $website = $this->websiteFactory->create();
                $website->load($web->getCode());
                var_dump($website->getStoreId());
                $this->setCreateAboutPage($website);
            }
        }    }    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}