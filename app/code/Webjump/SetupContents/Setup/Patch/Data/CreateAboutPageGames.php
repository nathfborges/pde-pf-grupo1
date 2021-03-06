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

class CreateAboutPageGames implements DataPatchInterface
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
    const CODE_WEBSITE =  [ConfigureStores::IBC_GAMES_WEBSITE_CODE];    /**
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
        <style>#html-body [data-pb-style=JD3LDUR]{justify-content:flex-start;display:flex;flex-direction:column;background-position:left top;background-size:cover;background-repeat:no-repeat;background-attachment:scroll}</style><div data-content-type="row" data-appearance="contained" data-element="main"><div data-enable-parallax="0" data-parallax-speed="0.5" data-background-images="{}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="inner" data-pb-style="JD3LDUR"><div data-content-type="html" data-appearance="default" data-element="main">&lt;span&gt;A Jump Games surgiu em 2021, por um grupo de jovens que se uniu por um mesmo prop??sito: expandir a cultura gamer e sua acessibilidade para todos. N??s acreditamos ser de extrema import??ncia que todos tenham acesso ao mundo dos jogos digitais, pois os mesmos s??o uma enorme fonte de lazer, entretenimento e aprendizado.&lt;/span&gt;
        &lt;div class="missao-visao-valores"&gt;
        &lt;div class="conteudo-missao-visao-valores"&gt;
        &lt;h3&gt;Miss??o&lt;/h3&gt;
        &lt;p&gt;Nossa miss??o ?? expandir a cultura gamer e a acessibilidade da mesma, de forma que os jogos digitais sejam acess??veis para todos os jovens, adultos e idosos interessados no assunto.&lt;/p&gt;
        &lt;/div&gt;
        &lt;div class="conteudo-missao-visao-valores"&gt;
        &lt;h3&gt;Vis??o&lt;/h3&gt;
        &lt;p&gt;Visamos melhorar a experi??ncia de nossos clientes com a compra de jogos digitais, crescendo como o maior e-commerce de jogos digitais do Brasil.&lt;/p&gt;
        &lt;/div&gt;
        &lt;div class="conteudo-missao-visao-valores"&gt;
        &lt;h3&gt;Valores&lt;/h3&gt;
        &lt;p&gt;Tecnologia, cultura, lazer, experi??ncia e satisfa????o do cliente, acessibilidade, agilidade.&lt;/p&gt;
        &lt;/div&gt;
        &lt;/div&gt;</div></div></div>    
        HTML;

        $pageIdentifier = 'quem-somos-games';
        $cmsPageModel = $this->pageFactory->create()->load($pageIdentifier, 'title');
        $cmsPageModel->setIdentifier('quem-somos-games');
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