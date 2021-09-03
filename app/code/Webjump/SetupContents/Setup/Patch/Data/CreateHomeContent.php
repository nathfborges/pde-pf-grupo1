<?php
/**
 *
 *  PHP version 7
 * @author      Webjump Core Team <dev@webjump.com.br>
 * @copyright   2021 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br  Copyright
 *
 * @link        http://www.webjump.com.br
 */
declare(strict_types=1);
namespace Webjump\SetupContents\Setup\Patch\Data;
use Magento\Cms\Model\PageFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchInterface;
use Magento\Cms\Model\PageRepository;
use Magento\Cms\Model\ResourceModel\Block as BlockResourceModel;
use Magento\Cms\Model\BlockFactory;

/**
 * Class HomePageUpdate
 */
class CreateHomeContent implements DataPatchInterface {
    /** @var ModuleDataSetupInterface */
    private $moduleDataSetup;
      /**
     * @var BlockResourceModel $blockResourceModel
     */
    private $blockResourceModel;
       /**
     * @var BlockFactory $blockFactory
     */
    private $blockFactory;
    /** @var PageFactory */
    private $pageFactory;
    /** @var PageRepository */
    private $pageRepository;
    const PAGE_IDENTIFIER = 'home';
    /**
     * HomePageUpdate Construct
     *
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param PageFactory $pageFactory
     * @param PageRepository $pageRepository
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        PageFactory $pageFactory,
        PageRepository $pageRepository,
        BlockFactory $blockFactory,
        BlockResourceModel $blockResourceModel
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->pageFactory = $pageFactory;
        $this->pageRepository = $pageRepository;
        $this->blockFactory = $blockFactory;
        $this->blockResourceModel = $blockResourceModel;
    }
    /**
     * {@inheritdoc}
     */
    public function apply(): void
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $blockBannerSkate = $this->blockFactory->create();
        $this->blockResourceModel->load($blockBannerSkate, 'home_banner_skate', 'identifier');
        $blockBannerSkateId = $blockBannerSkate->getId();

        $blockBannerGames = $this->blockFactory->create();
        $this->blockResourceModel->load($blockBannerGames, 'home_banner_games', 'identifier');
        $blockBannerGamesId = $blockBannerGames->getId();

        $blockCarroselSkateEn = $this->blockFactory->create();
        $this->blockResourceModel->load($blockCarroselSkateEn, 'carrosel_skate_en', 'identifier');
        $blockCarroselSkateEnId = $blockCarroselSkateEn->getId();

        $blockCarroselSkatePt = $this->blockFactory->create();
        $this->blockResourceModel->load($blockCarroselSkatePt, 'carrosel_skate_pt', 'identifier');
        $blockCarroselSkatePtId = $blockCarroselSkatePt->getId();

        $blockCarroselGames = $this->blockFactory->create();
        $this->blockResourceModel->load($blockCarroselGames, 'carrosel_games', 'identifier');
        $blockCarroselGamesId = $blockCarroselGames->getId();

        $content = <<<HTML
            <div data-content-type="block" data-appearance="default" data-element="main">{{widget type="Magento\Cms\Block\Widget\Block" template="widget/static_block/default.phtml" block_id=$blockBannerSkateId type_name="CMS Static Block"}}</div>
            <div data-content-type="block" data-appearance="default" data-element="main">{{widget type="Magento\Cms\Block\Widget\Block" template="widget/static_block/default.phtml" block_id=$blockBannerGamesId type_name="CMS Static Block"}}</div>
            <div data-content-type="block" data-appearance="default" data-element="main">{{widget type="Magento\Cms\Block\Widget\Block" template="widget/static_block/default.phtml" block_id=$blockCarroselSkateEnId type_name="CMS Static Block"}}</div>
            <div data-content-type="block" data-appearance="default" data-element="main">{{widget type="Magento\Cms\Block\Widget\Block" template="widget/static_block/default.phtml" block_id=$blockCarroselSkatePtId type_name="CMS Static Block"}}</div>
            <div data-content-type="block" data-appearance="default" data-element="main">{{widget type="Magento\Cms\Block\Widget\Block" template="widget/static_block/default.phtml" block_id=$blockCarroselGamesId type_name="CMS Static Block"}}</div>
            
        HTML;
         
        $cmsPage = $this->pageFactory->create()->load(self::PAGE_IDENTIFIER, 'identifier');
        if ($cmsPage->getId()) {
            $cmsPage->setStores('0');
            $cmsPage->setPageLayout('1column');
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
        return [
            CreateBlockBannerSkate::class,
            CreateBlockBannerGames::class
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function getAliases(): array
    {
        return [];
    }
}