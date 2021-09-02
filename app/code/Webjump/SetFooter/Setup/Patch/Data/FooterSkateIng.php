<?php

declare(strict_types=1);

namespace Webjump\SetFooter\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Store\Model\Store;

/**
 * Patch to apply creation of the block Charges and fees
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
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
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param \Magento\Cms\Api\BlockRepositoryInterface $blockRepository
     * @param \Magento\Cms\Api\Data\BlockInterfaceFactory $blockFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        \Magento\Cms\Api\BlockRepositoryInterface $blockRepository,
        \Magento\Cms\Api\Data\BlockInterfaceFactory $blockFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->blockRepository = $blockRepository;
        $this->blockFactory = $blockFactory;
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
        <style>#html-body [data-pb-style=GCVNC35],#html-body [data-pb-style=TKKVXYH]{justify-content:flex-start;display:flex;flex-direction:column;background-position:left top;background-size:cover;background-repeat:no-repeat;background-attachment:scroll}#html-body [data-pb-style=GCVNC35]{width:25%;align-self:stretch}#html-body [data-pb-style=HFFMCGS]{text-align:left;border-style:none}#html-body [data-pb-style=AJ5AXRF],#html-body [data-pb-style=D0AB0E0]{max-width:100%;height:auto}#html-body [data-pb-style=MASVHIB],#html-body [data-pb-style=T3IYDNV],#html-body [data-pb-style=VPW8AU4]{justify-content:flex-start;display:flex;flex-direction:column;background-position:left top;background-size:cover;background-repeat:no-repeat;background-attachment:scroll;width:25%;align-self:stretch}@media only screen and (max-width: 768px) { #html-body [data-pb-style=HFFMCGS]{border-style:none} }</style><div data-content-type="row" data-appearance="full-width" data-enable-parallax="0" data-parallax-speed="0.5" data-background-images="{}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="main" data-pb-style="TKKVXYH"><div class="row-full-width-inner" data-element="inner"><div class="pagebuilder-column-group" style="display: flex;" data-content-type="column-group" data-grid-size="12" data-element="main"><div class="pagebuilder-column" data-content-type="column" data-appearance="full-height" data-background-images="{}" data-element="main" data-pb-style="GCVNC35"><figure data-content-type="image" data-appearance="full-width" data-element="main" data-pb-style="HFFMCGS"><a href="http://ibcskate.localhost/" target="" data-link-type="default" title="" data-element="link"><img class="pagebuilder-mobile-hidden" src="{{media url=wysiwyg/IBCSkateLogoFooter.png}}" alt="" title="" data-element="desktop_image" data-pb-style="AJ5AXRF"><img class="pagebuilder-mobile-only" src="{{media url=wysiwyg/IBCSkateLogoFooter.png}}" alt="" title="" data-element="mobile_image" data-pb-style="D0AB0E0"></a></figure></div><div class="pagebuilder-column" data-content-type="column" data-appearance="full-height" data-background-images="{}" data-element="main" data-pb-style="T3IYDNV"><div data-content-type="text" data-appearance="default" data-element="main"><p><a href="http://ibcskate.localhost/catalog/category/view/s/complete-skateboards/id/40/">Complete Skateboards</a></p></div><div data-content-type="text" data-appearance="default" data-element="main"><p><a tabindex="0" href="http://ibcskate.localhost/catalog/category/view/s/wheels/id/50/">Wheels</a></p></div><div data-content-type="text" data-appearance="default" data-element="main"><p><a tabindex="0" href="http://ibcskate.localhost/catalog/category/view/s/shapes/id/60/">Shapes</a></p></div><div data-content-type="text" data-appearance="default" data-element="main"><p><a href="http://ibcskate.localhost/catalog/category/view/s/sandpaper/id/70/">Sandpaper</a></p></div><div data-content-type="text" data-appearance="default" data-element="main"><p><a tabindex="0" href="http://ibcskate.localhost/catalog/category/view/s/trucks/id/80/">Trucks</a></p></div><div data-content-type="text" data-appearance="default" data-element="main"><p><a tabindex="0" href="http://ibcskate.localhost/catalog/category/view/s/acessories/id/90/">Accessories</a></p></div></div><div class="pagebuilder-column" data-content-type="column" data-appearance="full-height" data-background-images="{}" data-element="main" data-pb-style="VPW8AU4"><div data-content-type="text" data-appearance="default" data-element="main"><p id="KORTHSY"><a tabindex="0" href="http://ibcskate.localhost/politica-de-privacidade">Privacy Politicies</a></p></div><div data-content-type="text" data-appearance="default" data-element="main"><p><a tabindex="0" href="http://ibcskate.localhost/fale-conosco">Contact Us</a></p></div><div data-content-type="text" data-appearance="default" data-element="main"><p><a tabindex="0" href="http://ibcskate.localhost/quem-somos">About Us</a></p></div></div><div class="pagebuilder-column last-column" data-content-type="column" data-appearance="full-height" data-background-images="{}" data-element="main" data-pb-style="MASVHIB"><div data-content-type="text" data-appearance="default" data-element="main"><p>E-mail: <a tabindex="0" href="mailto:ibcskate@gmail.com">ibcskate@gmail.com</a></p></div><div data-content-type="text" data-appearance="default" data-element="main"><p>Phone: (11) 2020-2020</p></div><div data-content-type="text" data-appearance="default" data-element="main"><p>Customer Service:</p></div><div data-content-type="text" data-appearance="default" data-element="main"><p id="BHVEI9H">8 AM - 8 PM</p></div><div data-content-type="text" data-appearance="default" data-element="main"><p>Monday to Monday</p></div></div></div></div></div>        
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
        return $this->blockFactory->create()
            ->setTitle(self::TITLE)
            ->setIdentifier(self::IDENTIFIER)
            ->setIsActive(\Magento\Cms\Model\Block::STATUS_ENABLED)
            ->setStores(['2'])
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
