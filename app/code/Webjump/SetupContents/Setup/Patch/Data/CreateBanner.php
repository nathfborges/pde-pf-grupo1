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
            <div data-content-type="block" data-appearance="default" data-element="main">{{widget type="Magento\Cms\Block\Widget\Block" template="widget/static_block/default.phtml" block_id="1" type_name="CMS Static Block"}}</div><div data-content-type="block" data-appearance="default" data-element="main">{{widget type="Magento\Cms\Block\Widget\Block" template="widget/static_block/default.phtml" block_id="3" type_name="CMS Static Block"}}</div>
            <div data-content-type="block" data-appearance="default" data-element="main">{{widget type="Magento\Cms\Block\Widget\Block" template="widget/static_block/default.phtml" block_id="2" type_name="CMS Static Block"}}</div><div data-content-type="block" data-appearance="default" data-element="main">{{widget type="Magento\Cms\Block\Widget\Block" template="widget/static_block/default.phtml" block_id="4" type_name="CMS Static Block"}}</div>
            <style>#html-body [data-pb-style=SM07R2G]{justify-content:flex-start;display:flex;flex-direction:column;background-position:left top;background-size:cover;background-repeat:no-repeat;background-attachment:scroll}</style><div data-content-type="row" data-appearance="contained" data-element="main"><div data-enable-parallax="0" data-parallax-speed="0.5" data-background-images="{}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="inner" data-pb-style="SM07R2G"><div data-content-type="text" data-appearance="default" data-element="main"><p>Somos a maior empresa de skate da América Latina</p></div></div></div>
            <style>#html-body [data-pb-style=N7KLKU3]{justify-content:flex-start;display:flex;flex-direction:column;background-position:left top;background-size:cover;background-repeat:no-repeat;background-attachment:scroll}</style><div data-content-type="row" data-appearance="contained" data-element="main"><div data-enable-parallax="0" data-parallax-speed="0.5" data-background-images="{}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="inner" data-pb-style="N7KLKU3"><div data-content-type="text" data-appearance="default" data-element="main"><p>Somo a maior empresa de games da América Latina.</p></div></div></div>
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