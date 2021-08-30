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

class CreateAboutPage implements DataPatchInterface
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
    /**
     * @var \Magento\Cms\Model\ResourceModel\Page
     */
    private $pageResource;    /**
     * const CODE_WEBSITE
     */
    const CODE_WEBSITE =  ['skate_ibc'];    /**
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
        StoreManagerInterface $storeManager
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->pageFactory = $pageFactory;
        $this->pageResource = $pageResource;
        $this->website = $website;
        $this->writerInterface = $writerInterface;
        $this->websiteFactory = $websiteFactory;
        $this->storeManager = $storeManager;
    }    /**
     * @param \Magento\Store\Model\Website $website
     */
    private function setCreateAboutPage(\Magento\Store\Model\Website $website): void
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        
        $content = <<<HTML
        <style>
        #html-body [data-pb-style=W3EVYF9]{justify-content:flex-start;display:flex;flex-direction:column;background-position:left top;background-size:cover;background-repeat:no-repeat;background-attachment:scroll}</style><div data-content-type="row" data-appearance="contained" data-element="main"><div data-enable-parallax="0" data-parallax-speed="0.5" data-background-images="{}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="inner" data-pb-style="W3EVYF9"><div data-content-type="text" data-appearance="default" data-element="main">
            <p>Somos a maior empresa de skate da América Latina</p>
        </div></div></div>
        HTML;
        
        $pageIdentifier = 'quem_somos';
        $cmsPageModel = $this->pageFactory->create()->load($pageIdentifier, 'title');
        $cmsPageModel->setIdentifier('quem_somos');
        $cmsPageModel->setStores($website->getStoreIds());
        $cmsPageModel->setTitle('Quem somos');
        $cmsPageModel->setContentHeading('Quem somos');
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