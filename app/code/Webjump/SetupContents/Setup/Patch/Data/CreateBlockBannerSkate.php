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
class CreateBlockBannerSkate implements DataPatchInterface
{
    /**
     * @var string IDENTIFIER
     */
    const IDENTIFIER = 'home_banner_skate';
    /**
     * @var string TITLE
     */
    const TITLE = 'banner_skate';
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
            <style>#html-body [data-pb-style=L4WHL2T]{justify-content:center;display:flex;flex-direction:column;background-position:left top;background-size:cover;background-repeat:no-repeat;background-attachment:scroll;text-align:left}#html-body [data-pb-style=N5L214E]{min-height:300px}#html-body [data-pb-style=YEL6IFO]{background-position:left top;background-size:cover;background-repeat:no-repeat;min-height:550px;padding-top:200px;text-align:left}#html-body [data-pb-style=MVU50HW]{background-color:transparent}#html-body [data-pb-style=CA57G8G]{min-height:550px}#html-body [data-pb-style=K9DMSB2]{background-position:left top;background-size:cover;background-repeat:no-repeat;min-height:550px;padding-top:300px;text-align:left}#html-body [data-pb-style=H725RYT]{background-color:transparent}</style><div class="bannerSkate" data-content-type="row" data-appearance="full-bleed" data-enable-parallax="0" data-parallax-speed="0.5" data-background-images="{}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="main" data-pb-style="L4WHL2T"><div class="pagebuilder-slider" data-content-type="slider" data-appearance="default" data-autoplay="true" data-autoplay-speed="4000" data-fade="true" data-infinite-loop="true" data-show-arrows="false" data-show-dots="false" data-element="main" data-pb-style="N5L214E"><div data-content-type="slide" data-slide-name="" data-appearance="collage-right" data-show-button="never" data-show-overlay="never" data-element="main"><div data-element="empty_link"><div class="pagebuilder-slide-wrapper" data-background-images="{\&quot;desktop_image\&quot;:\&quot;{{media url=wysiwyg/banner_3.jpg}}\&quot;}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="wrapper" data-pb-style="YEL6IFO"><div class="pagebuilder-overlay" data-overlay-color="" data-element="overlay" data-pb-style="MVU50HW"><div class="pagebuilder-collage-content"><div data-element="content"><h3 style="text-align: right;"><span style="color: #ffffff;"><strong><span style="font-size: 34px; line-height: 24px;">Inspired by Challenge</span></strong></span></h3></div></div></div></div></div></div><div data-content-type="slide" data-slide-name="" data-appearance="collage-left" data-show-button="never" data-show-overlay="never" data-element="main" data-pb-style="CA57G8G"><div data-element="empty_link"><div class="pagebuilder-slide-wrapper" data-background-images="{\&quot;desktop_image\&quot;:\&quot;{{media url=wysiwyg/teenager-having-fun-with-skateboard-at-the-park-silhouette_3.jpg}}\&quot;}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="wrapper" data-pb-style="K9DMSB2"><div class="pagebuilder-overlay" data-overlay-color="" data-element="overlay" data-pb-style="H725RYT"><div class="pagebuilder-collage-content"><div data-element="content"></div></div></div></div></div></div></div></div>
            
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

        $skate_store_1_id = $this->storeRepositoryInterface->get(ConfigureStores::IBC_SKATE_STORE_1_CODE)->getId();
        $skate_store_2_id = $this->storeRepositoryInterface->get(ConfigureStores::IBC_SKATE_STORE_2_CODE)->getId();

        return $this->blockFactory->create()
            ->load(self::IDENTIFIER, 'identifier')
            ->setTitle(self::TITLE)
            ->setIdentifier(self::IDENTIFIER)
            ->setIsActive(\Magento\Cms\Model\Block::STATUS_ENABLED)
            ->setStores([$skate_store_1_id, $skate_store_2_id])
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