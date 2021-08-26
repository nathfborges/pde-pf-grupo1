<?php
/*
 * PHP version 7
 * @author      Webjump Core Team <dev@webjump.com.br>
 * @copyright   2021 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br  Copyright
 * @link        http://www.webjump.com.br
*/

declare(strict_types=1);

namespace Webjump\SetupContents\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchInterface;
use Magento\Cms\Model\PageRepository;
use Magento\Cms\Model\PageFactory;

/**
 * Class HomePageUpdate
*/

class CreateBanner implements DataPatchInterface {

    /** @var ModuleDataSetupInterface */

    private $moduleDataSetup;

    /** @var PageFactory */

    private $pageFactory;

    /** @var PageRepository */

    private $pageRepository;

    const PAGE_IDENTIFIER = 'home';

    /**
     * HomePageUpdate Construct
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param PageFactory $pageFactory
     * @param PageRepository $pageRepository
     */

    public function __construct(

        ModuleDataSetupInterface $moduleDataSetup,
        
        PageFactory $pageFactory,
        
        PageRepository $pageRepository
    ) {

        $this->moduleDataSetup = $moduleDataSetup;

        $this->pageFactory = $pageFactory;

        $this->pageRepository = $pageRepository;

    }

    /**
     * {@inheritdoc}
    */

    public function apply(): void

    {

        $this->moduleDataSetup->getConnection()->startSetup();

        $content = <<<HTML
            <style>#html-body [data-pb-style=VFA7GGV]{justify-content:flex-start;display:flex;flex-direction:column}#html-body [data-pb-style=DBU1OWU],#html-body [data-pb-style=VFA7GGV]{background-position:left top;background-size:cover;background-repeat:no-repeat;background-attachment:scroll}#html-body [data-pb-style=XYLB52V]{border-radius:0;min-height:300px;background-color:transparent}</style><div data-content-type="html" data-appearance="default" data-element="main">&lt;div class="containerBanner"&gt;
            &lt;img id="bannerIBCSkate" src="https://www.pixel4k.com/wp-content/uploads/2018/10/skateboard-skateboarder-hobby-4k_1540062063.jpg"&gt;
            &lt;label id="textoBanner"&gt;Inspired by challenge.&lt;/label&gt;
            &lt;/div&gt;
            </div><div data-content-type="row" data-appearance="contained" data-element="main"><div data-enable-parallax="0" data-parallax-speed="0.5" data-background-images="{}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="inner" data-pb-style="VFA7GGV"><div data-content-type="banner" data-appearance="poster" data-show-button="never" data-show-overlay="never" data-element="main"><div data-element="empty_link"><div class="pagebuilder-banner-wrapper" data-background-images="{\&quot;desktop_image\&quot;:\&quot;{{media url=wysiwyg/guys-skate-in-the-pool_1.jpg}}\&quot;}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="wrapper" data-pb-style="DBU1OWU"><div class="pagebuilder-overlay pagebuilder-poster-overlay" data-overlay-color="" data-element="overlay" data-pb-style="XYLB52V"><div class="pagebuilder-poster-content"><div data-element="content"></div></div></div></div></div></div></div></div>
        HTML;

        $cmsPage = $this->pageFactory->create()->load(self::PAGE_IDENTIFIER, 'identifier');

        if ($cmsPage->getId()) {
            $cmsPage->setContent($content);
            $this->pageRepository->save($cmsPage);
        }
        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * {@inheritdoc}
    */

    public static function getDependencies(): array

    {
        return [];
    }

    /**
     * {@inheritdoc}
    */

    public function getAliases(): array

    {
        return [];
    }
}