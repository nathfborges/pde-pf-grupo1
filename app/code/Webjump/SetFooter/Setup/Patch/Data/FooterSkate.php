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
class FooterSkate implements DataPatchInterface
{
    /**
     * @var string IDENTIFIER
     */
    const IDENTIFIER = 'skate-footer';
    /**
     * @var string TITLE
     */
    const TITLE = 'Footer Skate';
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
        <style>#html-body [data-pb-style=IUNFRIM],#html-body [data-pb-style=PGOT86I]{justify-content:flex-start;display:flex;flex-direction:column;background-position:left top;background-size:cover;background-repeat:no-repeat;background-attachment:scroll}#html-body [data-pb-style=IUNFRIM]{width:25%;align-self:stretch}#html-body [data-pb-style=YIRJILD]{text-align:left;border-style:none}#html-body [data-pb-style=BG7GN6K],#html-body [data-pb-style=LTQ0EWX]{max-width:100%;height:auto}#html-body [data-pb-style=H9VB3DU],#html-body [data-pb-style=U9OPYF2],#html-body [data-pb-style=WGSV4OW]{justify-content:flex-start;display:flex;flex-direction:column;background-position:left top;background-size:cover;background-repeat:no-repeat;background-attachment:scroll;width:25%;align-self:stretch}@media only screen and (max-width: 768px) { #html-body [data-pb-style=YIRJILD]{border-style:none} }</style><div data-content-type="row" data-appearance="full-width" data-enable-parallax="0" data-parallax-speed="0.5" data-background-images="{}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="main" data-pb-style="PGOT86I"><div class="row-full-width-inner" data-element="inner"><div class="pagebuilder-column-group" style="display: flex;" data-content-type="column-group" data-grid-size="12" data-element="main"><div class="pagebuilder-column" data-content-type="column" data-appearance="full-height" data-background-images="{}" data-element="main" data-pb-style="IUNFRIM"><figure data-content-type="image" data-appearance="full-width" data-element="main" data-pb-style="YIRJILD"><a href="http://ibcskate.localhost/" target="" data-link-type="default" title="" data-element="link"><img class="pagebuilder-mobile-hidden" src="{{media url=wysiwyg/IBCSkateLogoFooter.png}}" alt="" title="" data-element="desktop_image" data-pb-style="LTQ0EWX"><img class="pagebuilder-mobile-only" src="{{media url=wysiwyg/IBCSkateLogoFooter.png}}" alt="" title="" data-element="mobile_image" data-pb-style="BG7GN6K"></a></figure></div><div class="pagebuilder-column" data-content-type="column" data-appearance="full-height" data-background-images="{}" data-element="main" data-pb-style="WGSV4OW"><div data-content-type="text" data-appearance="default" data-element="main"><p><a href="http://ibcskate.localhost/skates-completos.html">Skates Completos</a></p></div><div data-content-type="text" data-appearance="default" data-element="main"><p><a href="http://ibcskate.localhost/rodas.html">Rodas</a></p></div><div data-content-type="text" data-appearance="default" data-element="main"><p><a href="http://ibcskate.localhost/shapes.html">Shapes</a></p></div><div data-content-type="text" data-appearance="default" data-element="main"><p><a tabindex="0" href="http://ibcskate.localhost/lixas.html">Lixas</a></p></div><div data-content-type="text" data-appearance="default" data-element="main"><p><a tabindex="0" href="http://ibcskate.localhost/trucks.html">Trucks</a></p></div><div data-content-type="text" data-appearance="default" data-element="main"><p><a tabindex="0" href="http://ibcskate.localhost/acessorios.html">Acessórios</a></p></div></div><div class="pagebuilder-column" data-content-type="column" data-appearance="full-height" data-background-images="{}" data-element="main" data-pb-style="H9VB3DU"><div data-content-type="text" data-appearance="default" data-element="main"><p id="KORTHSY"><a tabindex="0" href="http://ibcskate.localhost/politica-de-privacidade">Política de Privacidade</a></p></div><div data-content-type="text" data-appearance="default" data-element="main"><p><a href="http://ibcskate.localhost/fale-conosco">Fale Conosco</a></p></div><div data-content-type="text" data-appearance="default" data-element="main"><p><a tabindex="0" href="http://ibcskate.localhost/quem-somos">Quem Somos</a></p></div></div><div class="pagebuilder-column last-column" data-content-type="column" data-appearance="full-height" data-background-images="{}" data-element="main" data-pb-style="U9OPYF2"><div data-content-type="text" data-appearance="default" data-element="main"><p>E-mail: <a tabindex="0" href="mailto:ibcskate@gmail.com">ibcskate@gmail.com</a></p></div><div data-content-type="text" data-appearance="default" data-element="main"><p>Telefone: (11) 2020-2020</p></div><div data-content-type="text" data-appearance="default" data-element="main"><p>Horário de atendimento:</p></div><div data-content-type="text" data-appearance="default" data-element="main"><p id="BHVEI9H">08:00 às 20:00</p></div><div data-content-type="text" data-appearance="default" data-element="main"><p>Segunda a Segunda</p></div></div></div></div></div>
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
            ->setStores(['1'])
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
