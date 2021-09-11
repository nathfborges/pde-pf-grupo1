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

class CreateAboutPageSkate implements DataPatchInterface
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
    private $pageResource;    
    
    private $storeRepository;
    /**
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
        
        $skate_ptbr = $this->storeRepository->get(ConfigureStores::IBC_SKATE_STORE_1_CODE);

        $content = <<<HTML
        <style>#html-body [data-pb-style=HVMUOFE]{justify-content:flex-start;display:flex;flex-direction:column;background-position:left top;background-size:cover;background-repeat:no-repeat;background-attachment:scroll}</style><div data-content-type="row" data-appearance="contained" data-element="main"><div data-enable-parallax="0" data-parallax-speed="0.5" data-background-images="{}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="inner" data-pb-style="HVMUOFE"><div data-content-type="html" data-appearance="default" data-element="main">&lt;span&gt;Criada em 2021, a IBC Skate é uma plataforma que se preocupa com a cultura urbana e pretende se tornar a representação pura do estilo de vida skatista. Pretendemos tornar acessível um esporte que é marginalizado e que possui suma importância na vida de quem o pratica.&lt;/span&gt;
        &lt;div class="missao-visao-valores"&gt;
        &lt;div class="conteudo-missao-visao-valores"&gt;
        &lt;h3&gt;Missão&lt;/h3&gt;
        &lt;p&gt;Possuímos como objetivo expandir o acesso aos acessórios de skate em todo o mundo, além de interessar novas pessoas e as influenciar para conhecer esse universo tão lindo.&lt;/p&gt;
        &lt;/div&gt;
        &lt;div class="conteudo-missao-visao-valores"&gt;
        &lt;h3&gt;Visão&lt;/h3&gt;
        &lt;p&gt;Queremos tornar a experiência de nossos clientes a melhor possível, além de passar a fazer parte de suas vidas diariamente.&lt;/p&gt;
        &lt;/div&gt;
        &lt;div class="conteudo-missao-visao-valores"&gt;
        &lt;h3&gt;Valores&lt;/h3&gt;
        &lt;p&gt;Nos tornar uma referência dentro do universo do Skate, vender as melhores experiências aos nossos clientes.&lt;/p&gt;
        &lt;/div&gt;
        &lt;/div&gt;</div></div></div>
        HTML;

        $pageIdentifier = 'quem-somos-skate';
        $cmsPageModel = $this->pageFactory->create()->load($pageIdentifier, 'title');
        $cmsPageModel->setIdentifier('quem-somos-skate');
        $cmsPageModel->setStores([$skate_ptbr->getId()]);
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
        return [
            ConfigureStores::class
        ];
    }    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}