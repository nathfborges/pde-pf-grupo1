<?php
/*
 *
 * @author      Webjump Core Team <dev@webjump.com.br>
 * @copyright   2021 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br Copyright
 * @link        http://www.webjump.com.br
 *
 */

declare(strict_types=1);

namespace Webjump\SetupContents\Setup\Patch\Data;

use Magento\Cms\Model\PageFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchInterface;
use Magento\Store\Model\ResourceModel\Website;
use Magento\Store\Model\WebsiteFactory;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class PrivacyPolicySkate implements DataPatchInterface
{

    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var Website
     */
    private $website;

    /**
     * @var WriterInterface
     */
    private $writerInterface;

    /**
     * @var WebsiteFactory
     */
    private $websiteFactory;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var PageFactory
     */
    private $pageFactory;
    /**
     * @var \Magento\Cms\Model\ResourceModel\Page
     */
    private $pageResource;

    /**
     * const CODE_WEBSITE
     */
    const CODE_WEBSITE = ['skate_ibc'];

    /**
     * AddNewCmsPage constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param PageFactory $pageFactory
     * @param \Magento\Cms\Model\ResourceModel\Page $pageResource
     * @param Website $website
     * @param WriterInterface $writerInterface
     * @param WebsiteFactory $websiteFactory
     * @param StoreManager $storeManager
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        PageFactory $pageFactory,
        \Magento\Cms\Model\ResourceModel\Page $pageResource,
        Website $website,
        WriterInterface $writerInterface,
        WebsiteFactory $websiteFactory,
        StoreManagerInterface $storeManager
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->pageFactory = $pageFactory;
        $this->pageResource = $pageResource;
        $this->website = $website;
        $this->writerInterface = $writerInterface;
        $this->websiteFactory = $websiteFactory;
        $this->storeManager = $storeManager;
    }

    /**
     * @param \Magento\Store\Model\Website $website
     */
    private function setPrivacyPolicy(\Magento\Store\Model\Website $website): void
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $content = <<<HTML
        <style>#html-body [data-pb-style=OKNUH3T]{justify-content:flex-start;display:flex;flex-direction:column;background-position:left top;background-size:cover;background-repeat:no-repeat;background-attachment:scroll}</style><div data-content-type="row" data-appearance="contained" data-element="main"><div data-enable-parallax="0" data-parallax-speed="0.5" data-background-images="{}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="inner" data-pb-style="OKNUH3T"><h2 data-content-type="heading" data-appearance="default" data-element="main">Política de Privacidade</h2><div data-content-type="text" data-appearance="default" data-element="main"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec lectus purus, bibendum vitae neque aliquam, placerat ornare nulla. Nullam nec augue nunc. Nulla elementum, mauris ac molestie dapibus, velit quam luctus tellus, eget feugiat arcu justo eget leo. Suspendisse potenti. Integer eget ultricies tellus, molestie rutrum tortor. Mauris aliquam eleifend sem et dignissim. Praesent vitae diam non dui aliquet rutrum. Nullam malesuada a quam a auctor. Vivamus auctor dui non quam gravida, id sodales tellus mollis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut ac euismod sapien. Nullam nec sollicitudin odio, ac condimentum ipsum. Mauris lectus augue, euismod ullamcorper massa vitae, congue tempor erat. Curabitur ut suscipit eros, sed mattis odio. Curabitur felis nunc, convallis vitae lacus eget, vulputate cursus orci.</p>
        <p>Nulla facilisi. Donec quam eros, iaculis non ante quis, pretium sagittis risus. Integer sit amet bibendum lectus. Quisque quis tristique ipsum, quis tempor eros. Morbi porttitor, neque vel euismod tempus, lacus nibh maximus arcu, eget ullamcorper arcu ex sit amet dolor. Nulla sollicitudin et diam non sollicitudin. Sed quis neque nec sapien lobortis efficitur. Sed eget sapien aliquet, sagittis diam non, scelerisque nunc. Sed luctus, urna sit amet laoreet dapibus, leo libero suscipit nibh, vitae scelerisque mauris sapien quis ante.</p>
        <p>Donec ante lorem, semper vitae metus vel, iaculis consequat nisi. Maecenas a consectetur arcu, sed laoreet mi. Quisque aliquam risus et erat condimentum scelerisque. Sed scelerisque tortor eget mauris bibendum porttitor. Nam tincidunt, tortor quis auctor bibendum, dolor est dapibus leo, in egestas augue arcu et diam. Donec fringilla in nisl a ornare. Nulla hendrerit rutrum tortor, molestie auctor mi. Nullam tortor nulla, cursus sit amet nibh iaculis, tincidunt suscipit tortor. Cras nisi augue, lobortis quis tellus nec, lobortis aliquet turpis. Cras volutpat maximus enim, at pulvinar erat molestie et. Cras porttitor magna nulla, at tempus metus ultricies non.</p>
        <p>Nullam sed purus sit amet odio tempus fringilla. Etiam tempor est eget tortor aliquet vulputate. Nunc ac lorem justo. Nunc et quam vitae ipsum consequat luctus ut eu ante. Integer quis pellentesque quam. In mollis ante metus. Suspendisse et mi at lacus tincidunt posuere. Nullam imperdiet metus eget est sollicitudin, sit amet ornare diam vestibulum.</p>
        <p>Cras odio sem, tristique quis condimentum non, sagittis eu elit. Vivamus vitae tellus mauris. Mauris orci dui, porta ut sodales vel, mollis congue odio. Nulla a diam mollis, molestie mauris vel, aliquam elit. Praesent quis quam eu ex convallis sollicitudin. Morbi placerat placerat arcu ac tempus. Nullam neque odio, fringilla ac pulvinar at, ornare vitae mauris. Fusce eget est vitae orci sodales ultricies vestibulum eget tellus. Fusce vel vulputate est. Aliquam erat volutpat.</p></div></div></div>
        HTML;

        $pageIdentifier = 'politica-de-privacidade';
        $cmsPageModel = $this->pageFactory->create()->load($pageIdentifier, 'title');
        $cmsPageModel->setIdentifier('politica-de-privacidade');
        $cmsPageModel->setStores($website->getStoreIds());
        $cmsPageModel->setTitle('Política de Privacidade');
        $cmsPageModel->setContentHeading('Política de Privacidade');
        $cmsPageModel->setPageLayout('1column');
        $cmsPageModel->setIsActive(1);
        $cmsPageModel->setContent($content)->save();

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {

        $websites = $this->storeManager->getWebsites();
        foreach ($websites as $web) {
            if (in_array($web->getCode(), self::CODE_WEBSITE)) {
                $website = $this->websiteFactory->create();
                $website->load($web->getCode());
                $this->setPrivacyPolicy($website);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}
