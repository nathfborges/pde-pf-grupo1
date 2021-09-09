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