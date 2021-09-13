<?php

declare(strict_types=1);

namespace Webjump\SetFooter\Setup\Patch\Data;

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
class FooterSkateIng implements DataPatchInterface
{
    /**
     * @var string IDENTIFIER
     */
    const IDENTIFIER = 'skate-footer-ing';

    /**
     * @var string TITLE
     */
    const TITLE = 'Footer Skate Ing';

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
     * @var StoreRepositoryInterface $storeRepositoryInterface
     */
    private $storeRepositoryInterface;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param \Magento\Cms\Api\BlockRepositoryInterface $blockRepository
     * @param \Magento\Cms\Api\Data\BlockInterfaceFactory $blockFactory
     * @param StoreRepositoryInterface
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
        <style>#html-body [data-pb-style=G0IA7HT],#html-body [data-pb-style=K5LOM5G]{justify-content:flex-start;display:flex;flex-direction:column;background-position:left top;background-size:cover;background-repeat:no-repeat;background-attachment:scroll}#html-body [data-pb-style=G0IA7HT]{width:25%;align-self:stretch}#html-body [data-pb-style=G2AFTPO]{text-align:left;border-style:none}#html-body [data-pb-style=E5JV0PJ],#html-body [data-pb-style=NXGKQHO]{max-width:100%;height:auto}#html-body [data-pb-style=CSDS2IH],#html-body [data-pb-style=H5MYMU2],#html-body [data-pb-style=V3I9Y4Y]{justify-content:flex-start;display:flex;flex-direction:column;background-position:left top;background-size:cover;background-repeat:no-repeat;background-attachment:scroll;width:25%;align-self:stretch}@media only screen and (max-width: 768px) { #html-body [data-pb-style=G2AFTPO]{border-style:none} }</style><div data-content-type="row" data-appearance="full-width" data-enable-parallax="0" data-parallax-speed="0.5" data-background-images="{}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="main" data-pb-style="K5LOM5G"><div class="row-full-width-inner" data-element="inner"><div class="pagebuilder-column-group" style="display: flex;" data-content-type="column-group" data-grid-size="12" data-element="main"><div class="pagebuilder-column" data-content-type="column" data-appearance="full-height" data-background-images="{}" data-element="main" data-pb-style="G0IA7HT"><figure data-content-type="image" data-appearance="full-width" data-element="main" data-pb-style="G2AFTPO"><a href="http://ibcskate.localhost/" target="" data-link-type="default" title="" data-element="link"><img class="pagebuilder-mobile-hidden" src="{{media url=wysiwyg/IBCSkateLogoFooter.png}}" alt="" title="" data-element="desktop_image" data-pb-style="NXGKQHO"><img class="pagebuilder-mobile-only" src="{{media url=wysiwyg/IBCSkateLogoFooter.png}}" alt="" title="" data-element="mobile_image" data-pb-style="E5JV0PJ"></a></figure></div><div class="pagebuilder-column" data-content-type="column" data-appearance="full-height" data-background-images="{}" data-element="main" data-pb-style="H5MYMU2"><div data-content-type="text" data-appearance="default" data-element="main"><p><a tabindex="0" href="http://ibcskate.localhost/complete-skateboards.html">Complete Skateboards</a></p></div><div data-content-type="text" data-appearance="default" data-element="main"><p><a tabindex="0" href="http://ibcskate.localhost/wheels.html">Wheels</a></p></div><div data-content-type="text" data-appearance="default" data-element="main"><p><a tabindex="0" href="http://ibcskate.localhost/decks.html">Decks</a></p></div><div data-content-type="text" data-appearance="default" data-element="main"><p><a tabindex="0" href="http://ibcskate.localhost/grip-tape.html">Grip Tape</a></p></div><div data-content-type="text" data-appearance="default" data-element="main"><p><a tabindex="0" href="http://ibcskate.localhost/trucks.html">Trucks</a></p></div><div data-content-type="text" data-appearance="default" data-element="main"><p><a tabindex="0" href="http://ibcskate.localhost/acessories.html">Accessories</a></p></div></div><div class="pagebuilder-column" data-content-type="column" data-appearance="full-height" data-background-images="{}" data-element="main" data-pb-style="CSDS2IH"><div data-content-type="text" data-appearance="default" data-element="main"><p id="KORTHSY"><a tabindex="0" href="http://ibcskate.localhost/privacy-policy-skate">Privacy Policies</a></p></div><div data-content-type="text" data-appearance="default" data-element="main"><p><a tabindex="0" href="http://ibcskate.localhost/about-us-skate">About Us</a></p></div></div><div class="pagebuilder-column last-column" data-content-type="column" data-appearance="full-height" data-background-images="{}" data-element="main" data-pb-style="V3I9Y4Y"><div data-content-type="text" data-appearance="default" data-element="main"><p>E-mail: <a tabindex="0" href="mailto:ibcskate@gmail.com">ibcskate@gmail.com</a></p></div><div data-content-type="text" data-appearance="default" data-element="main"><p>Phone: (11) 2020-2020</p></div><div data-content-type="text" data-appearance="default" data-element="main"><p>Customer Service:</p></div><div data-content-type="text" data-appearance="default" data-element="main"><p id="BHVEI9H">8 AM - 8 PM</p></div><div data-content-type="text" data-appearance="default" data-element="main"><p>Monday to Monday</p></div></div></div></div></div>
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
        $skate_store_2_id = $this->storeRepositoryInterface->get(ConfigureStores::IBC_SKATE_STORE_2_CODE)->getId();

        return $this->blockFactory->create()
            ->setTitle(self::TITLE)
            ->setIdentifier(self::IDENTIFIER)
            ->setIsActive(\Magento\Cms\Model\Block::STATUS_ENABLED)
            ->setStores([$skate_store_2_id])
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
