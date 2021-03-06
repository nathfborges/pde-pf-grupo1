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
class FooterGames implements DataPatchInterface
{
    /**
     * @var string IDENTIFIER
     */
    const IDENTIFIER = 'games-footer';

    /**
     * @var string TITLE
     */
    const TITLE = 'Footer Games';

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
        <style>#html-body [data-pb-style=F8BSQM4]{justify-content:flex-start;display:flex;flex-direction:column;background-position:left top;background-size:cover;background-repeat:no-repeat;background-attachment:scroll}#html-body [data-pb-style=D27FSQ3]{text-align:center;border-style:none}#html-body [data-pb-style=DA1WBMS],#html-body [data-pb-style=N3KRK7V]{max-width:100%;height:auto}#html-body [data-pb-style=DXDRABM],#html-body [data-pb-style=EDTJSE0],#html-body [data-pb-style=XQ9GXB3]{justify-content:flex-start;display:flex;flex-direction:column;background-position:left top;background-size:cover;background-repeat:no-repeat;background-attachment:scroll;width:33.3333%;align-self:stretch}@media only screen and (max-width: 768px) { #html-body [data-pb-style=D27FSQ3]{border-style:none} }</style><div data-content-type="row" data-appearance="contained" data-element="main"><div data-enable-parallax="0" data-parallax-speed="0.5" data-background-images="{}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="inner" data-pb-style="F8BSQM4"><figure data-content-type="image" data-appearance="full-width" data-element="main" data-pb-style="D27FSQ3"><img class="pagebuilder-mobile-hidden" src="{{media url=wysiwyg/JumpLogo.png}}" alt="" title="" data-element="desktop_image" data-pb-style="DA1WBMS"><img class="pagebuilder-mobile-only" src="{{media url=wysiwyg/JumpLogo.png}}" alt="" title="" data-element="mobile_image" data-pb-style="N3KRK7V"></figure></div></div><div class="pagebuilder-column-group" style="display: flex;" data-content-type="column-group" data-grid-size="12" data-element="main"><div class="pagebuilder-column" data-content-type="column" data-appearance="full-height" data-background-images="{}" data-element="main" data-pb-style="XQ9GXB3"><div data-content-type="text" data-appearance="default" data-element="main"><p id="KORTHSY"><a tabindex="0" href="http://ibcgames.localhost/politica-de-privacidade">Pol??tica de Privacidade</a></p></div><div data-content-type="text" data-appearance="default" data-element="main"><p><a tabindex="0" href="http://ibcgames.localhost/quem-somos-games">Quem Somos</a></p></div></div><div class="pagebuilder-column" data-content-type="column" data-appearance="full-height" data-background-images="{}" data-element="main" data-pb-style="DXDRABM"><div data-content-type="text" data-appearance="default" data-element="main"><p><a tabindex="0" href="http://ibcgames.localhost/luta.html">Luta</a></p></div><div data-content-type="text" data-appearance="default" data-element="main"><p><a tabindex="0" href="http://ibcgames.localhost/simulac-o.html">Simula????o</a></p></div><div data-content-type="text" data-appearance="default" data-element="main"><p><a tabindex="0" href="http://ibcgames.localhost/aventura.html">Aventura</a></p></div><div data-content-type="text" data-appearance="default" data-element="main"><p><a href="http://ibcgames.localhost/terror.html">Terror</a></p></div><div data-content-type="text" data-appearance="default" data-element="main"><p><a href="http://ibcgames.localhost/esporte.html">Esporte</a></p></div><div data-content-type="text" data-appearance="default" data-element="main"><p><a tabindex="0" href="http://ibcgames.localhost/estrategia.html">Estrat??gia</a></p></div></div><div class="pagebuilder-column" data-content-type="column" data-appearance="full-height" data-background-images="{}" data-element="main" data-pb-style="EDTJSE0"><div data-content-type="text" data-appearance="default" data-element="main"><p>E-mail: <a tabindex="0" href="mailto:ibcskate@gmail.com">jumpgames@gmail.com</a></p>
        <p>Telefone: (11) 2647-5213</p>
        <p>Hor??rio de atendimento: 08:00 ??s 20:00 - Segunda a Segunda</p></div></div></div>
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
        $games_store_id = $this->storeRepositoryInterface->get(ConfigureStores::IBC_GAMES_STORE_CODE)->getId();
        return $this->blockFactory->create()
            ->setTitle(self::TITLE)
            ->setIdentifier(self::IDENTIFIER)
            ->setIsActive(\Magento\Cms\Model\Block::STATUS_ENABLED)
            ->setStores([$games_store_id])
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
