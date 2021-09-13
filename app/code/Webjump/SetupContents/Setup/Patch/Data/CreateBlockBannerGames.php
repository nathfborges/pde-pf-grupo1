<?php
declare(strict_types=1);
namespace Webjump\SetupContents\Setup\Patch\Data;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Store\Model\Store;
use Webjump\IBCBackend\Setup\Patch\Data\ConfigureStores;
use Magento\Store\Api\StoreRepositoryInterface;

/**
 * Patch to apply creation of the block Charges and fees
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class CreateBlockBannerGames implements DataPatchInterface
{
    /**
     * @var string IDENTIFIER
     */
    const IDENTIFIER = 'home_banner_games';
    /**
     * @var string TITLE
     */
    const TITLE = 'banner_games';
    /**
     * @var ModuleDataSetupInterface $moduleDataSetup
     */
    private $moduleDataSetup;
    /**
     * @var BlockRepositoryInterface $blockRepository
     */
    private $blockRepository;
    /**
     * @var BlockInterfaceFactory $blockFactory
     */
    private $blockFactory;

    /**
     * @var StoreRepositoryInterface
     */
    private $storeRepositoryInterface;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param \Magento\Cms\Api\BlockRepositoryInterface $blockRepository
     * @param \Magento\Cms\Api\Data\BlockInterfaceFactory $blockFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        \Magento\Cms\Api\BlockRepositoryInterface $blockRepository,
        \Magento\Cms\Api\Data\BlockInterfaceFactory $blockFactory,
        StoreRepositoryInterface $storeRepositoryInterface
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->blockRepository = $blockRepository;
        $this->blockFactory = $blockFactory;
        $this->storeRepositoryInterface = $storeRepositoryInterface;
    }
    /**
     * Do Upgrade
     *
     * @return void
     */
    public function apply(): void
    {
        $this->moduleDataSetup->startSetup();
        $content = <<<HTML
            <style>#html-body [data-pb-style=AA9PSMV]{justify-content:center;display:flex;flex-direction:column;background-position:left top;background-size:cover;background-repeat:no-repeat;background-attachment:scroll}#html-body [data-pb-style=X6RIW1M]{min-height:300px}#html-body [data-pb-style=UJY37B2]{background-position:center center;background-size:cover;background-repeat:no-repeat;min-height:550px}#html-body [data-pb-style=K7CAN85]{min-height:550px;background-color:transparent}#html-body [data-pb-style=QYMADTW]{background-position:center center;background-size:cover;background-repeat:no-repeat;min-height:550px}#html-body [data-pb-style=M2QGAO3]{min-height:550px;background-color:transparent}#html-body [data-pb-style=TXBCSEY]{background-position:center center;background-size:cover;background-repeat:no-repeat;min-height:550px}#html-body [data-pb-style=PEOVA9S]{min-height:550px;background-color:transparent}#html-body [data-pb-style=RW8WO5W]{background-position:center center;background-size:cover;background-repeat:no-repeat;min-height:550px}#html-body [data-pb-style=AEPLS61]{min-height:550px;background-color:transparent}#html-body [data-pb-style=QO2C66F]{background-position:center center;background-size:cover;background-repeat:no-repeat;min-height:550px}#html-body [data-pb-style=TP5BRL2]{min-height:550px;background-color:transparent}</style><div data-content-type="row" data-appearance="full-bleed" data-enable-parallax="0" data-parallax-speed="0.5" data-background-images="{}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="main" data-pb-style="AA9PSMV"><div class="pagebuilder-slider" data-content-type="slider" data-appearance="default" data-autoplay="true" data-autoplay-speed="4000" data-fade="true" data-infinite-loop="true" data-show-arrows="false" data-show-dots="false" data-element="main" data-pb-style="X6RIW1M"><div data-content-type="slide" data-slide-name="" data-appearance="poster" data-show-button="never" data-show-overlay="never" data-element="main"><div data-element="empty_link"><div class="pagebuilder-slide-wrapper" data-background-images="{\&quot;desktop_image\&quot;:\&quot;{{media url=wysiwyg/gta5_1.jpg}}\&quot;}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="wrapper" data-pb-style="UJY37B2"><div class="pagebuilder-overlay pagebuilder-poster-overlay" data-overlay-color="" data-element="overlay" data-pb-style="K7CAN85"><div class="pagebuilder-poster-content"><div data-element="content"></div></div></div></div></div></div><div data-content-type="slide" data-slide-name="" data-appearance="poster" data-show-button="never" data-show-overlay="never" data-element="main"><div data-element="empty_link"><div class="pagebuilder-slide-wrapper" data-background-images="{\&quot;desktop_image\&quot;:\&quot;{{media url=wysiwyg/battlefieldV_1.jpg}}\&quot;}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="wrapper" data-pb-style="QYMADTW"><div class="pagebuilder-overlay pagebuilder-poster-overlay" data-overlay-color="" data-element="overlay" data-pb-style="M2QGAO3"><div class="pagebuilder-poster-content"><div data-element="content"></div></div></div></div></div></div><div data-content-type="slide" data-slide-name="" data-appearance="poster" data-show-button="never" data-show-overlay="never" data-element="main"><div data-element="empty_link"><div class="pagebuilder-slide-wrapper" data-background-images="{\&quot;desktop_image\&quot;:\&quot;{{media url=wysiwyg/lol_1.png}}\&quot;}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="wrapper" data-pb-style="TXBCSEY"><div class="pagebuilder-overlay pagebuilder-poster-overlay" data-overlay-color="" data-element="overlay" data-pb-style="PEOVA9S"><div class="pagebuilder-poster-content"><div data-element="content"></div></div></div></div></div></div><div data-content-type="slide" data-slide-name="" data-appearance="poster" data-show-button="never" data-show-overlay="never" data-element="main"><div data-element="empty_link"><div class="pagebuilder-slide-wrapper" data-background-images="{\&quot;desktop_image\&quot;:\&quot;{{media url=wysiwyg/minecraft_1.jpg}}\&quot;}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="wrapper" data-pb-style="RW8WO5W"><div class="pagebuilder-overlay pagebuilder-poster-overlay" data-overlay-color="" data-element="overlay" data-pb-style="AEPLS61"><div class="pagebuilder-poster-content"><div data-element="content"></div></div></div></div></div></div><div data-content-type="slide" data-slide-name="" data-appearance="poster" data-show-button="never" data-show-overlay="never" data-element="main"><div data-element="empty_link"><div class="pagebuilder-slide-wrapper" data-background-images="{\&quot;desktop_image\&quot;:\&quot;{{media url=wysiwyg/valorant_1.jpg}}\&quot;}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="wrapper" data-pb-style="QO2C66F"><div class="pagebuilder-overlay pagebuilder-poster-overlay" data-overlay-color="" data-element="overlay" data-pb-style="TP5BRL2"><div class="pagebuilder-poster-content"><div data-element="content"></div></div></div></div></div></div></div></div>
            
        HTML;
        $this->blockRepository->save($this->getCmsBlock($content));
        $this->moduleDataSetup->endSetup();
    }
    /**
     * Method create CMS block
     *
     * @return \Magento\Cms\Api\Data\BlockInterface
     */
    private function getCmsBlock($content): \Magento\Cms\Api\Data\BlockInterface
    {
        
        $games_store_1_id = $this->storeRepositoryInterface->get(ConfigureStores::IBC_GAMES_STORE_CODE)->getId();

        
        return $this->blockFactory->create()
            ->load(self::IDENTIFIER, 'identifier')
            ->setTitle(self::TITLE)
            ->setIdentifier(self::IDENTIFIER)
            ->setIsActive(\Magento\Cms\Model\Block::STATUS_ENABLED)
            ->setStores([$games_store_1_id])
            ->setContent($content);
    }
  /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }
}