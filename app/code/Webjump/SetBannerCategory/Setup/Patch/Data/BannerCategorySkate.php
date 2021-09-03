<?php

declare(strict_types=1);

namespace Webjump\SetBannerCategory\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Store\Api\StoreRepositoryInterface;
use Webjump\IBCBackend\Setup\Patch\Data\ConfigureStores;

/**
 * Patch to apply creation of the block Charges and fees
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * 
 * @codeCoverageIgnore
 */
class BannerCategorySkate implements DataPatchInterface
{
    /**
     * @var string IDENTIFIER
     */
    const IDENTIFIER = 'skate-banner-category';
    /**
     * @var string TITLE
     */
    const TITLE = 'Banner Category Skate';
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
        <style>#html-body [data-pb-style=EVKB12R]{justify-content:flex-start;display:flex;flex-direction:column;background-position:left top;background-size:cover;background-repeat:no-repeat;background-attachment:scroll}#html-body [data-pb-style=X57DY6S]{border-style:none}#html-body [data-pb-style=G7F562T],#html-body [data-pb-style=MOUH7YD]{max-width:100%;height:auto}@media only screen and (max-width: 768px) { #html-body [data-pb-style=X57DY6S]{border-style:none} }</style><div data-content-type="row" data-appearance="contained" data-element="main"><div data-enable-parallax="0" data-parallax-speed="0.5" data-background-images="{}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="inner" data-pb-style="EVKB12R"><figure data-content-type="image" class="img__banner--category" data-appearance="full-width" data-element="main" data-pb-style="X57DY6S"><img class="pagebuilder-mobile-hidden" src="{{media url=wysiwyg/pexels-mong-mong-3423896_1.jpg}}" alt="" title="" data-element="desktop_image" data-pb-style="MOUH7YD"><img class="pagebuilder-mobile-only" src="{{media url=wysiwyg/pexels-mong-mong-3423896_1.jpg}}" alt="" title="" data-element="mobile_image" data-pb-style="G7F562T"></figure></div></div>
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
        return [
            ConfigureStores::class
        ];
    }
}
