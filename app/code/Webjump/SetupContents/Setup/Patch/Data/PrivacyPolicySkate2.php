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
use Webjump\IBCBackend\Setup\Patch\Data\ConfigureStores;
use Magento\Store\Api\StoreRepositoryInterface;


/** @codeCoverageIgnore */
class PrivacyPolicySkate2 implements DataPatchInterface
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
     * @var StoreRepositoryInterface $storeRepository
     */
    private $storeRepository;

    /**
     * const CODE_WEBSITE
     */
    const CODE_WEBSITE = [ConfigureStores::IBC_SKATE_WEBSITE_CODE];

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
        StoreManagerInterface $storeManager,
        StoreRepositoryInterface $storeRepository
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->pageFactory = $pageFactory;
        $this->pageResource = $pageResource;
        $this->website = $website;
        $this->writerInterface = $writerInterface;
        $this->websiteFactory = $websiteFactory;
        $this->storeManager = $storeManager;
        $this->storeRepository = $storeRepository;
    }

    /**
     * @param \Magento\Store\Model\Website $website
     */
    private function setPrivacyPolicy(\Magento\Store\Model\Website $website): void
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $skate_in = $this->storeRepository->get(ConfigureStores::IBC_SKATE_STORE_2_CODE);

        $content = <<<HTML
        <style>#html-body [data-pb-style=GQWVQT2]{justify-content:flex-start;display:flex;flex-direction:column;background-position:left top;background-size:cover;background-repeat:no-repeat;background-attachment:scroll}</style><div data-content-type="row" data-appearance="contained" data-element="main"><div data-enable-parallax="0" data-parallax-speed="0.5" data-background-images="{}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="inner" data-pb-style="GQWVQT2"><div data-content-type="html" data-appearance="default" data-element="main">&lt;p&gt;Your privacy is important to us. It is IBC Skate's policy to respect your privacy in relation to any information from you that we may collect on the &lt;a href=google.com&gt;IBC Skate&lt;/a&gt; website, and other websites that we own and operate.&lt;/p&gt; &lt;p&gt; We only ask for personal information when we really need it to provide you with a service. We do this by fair and legal means, with your knowledge and consent. We also let you know why we are collecting it and how it will be used. &lt;/p&gt; &lt;p&gt;We only retain the information collected for as long as it takes to provide the requested service. When we store data, we protect it within commercially acceptable means to prevent loss and theft, as well as unauthorized access, disclosure, copying, use or modification.&lt;/p&gt; &lt;p&gt;We do not share personally identifiable information publicly or with third parties, except as required by law.&lt;/p&gt; &lt;p&gt;Our website may have links to external websites that are not operated by us. Please be aware that we have no control over the content and practices of these sites and cannot accept responsibility for their respective &lt;a href='https://privacidade.me/' target='_BLANK'&gt;privacy policies&lt;/a&gt;. &lt;/p&gt; &lt;p&gt;You are free to decline our request for personal information, understanding that we may not be able to provide some of the services you desire.&lt;/p&gt; &lt;p&gt;Continued use of our site will be deemed acceptance of our practices around privacy and personal information. If you have any questions about how we handle user data and personal information, please contact us.&lt;/p&gt; &lt;h2&gt;IBC Skate Cookies Policy&lt;/h2&gt; &lt;h3&gt;What are cookies?&lt;/h3&gt; &lt;p&gt;As is common practice on almost all professional websites, this website uses cookies, which are small files downloaded to your computer, to improve your experience. This page describes what information they collect, how we use it, and why we sometimes need to store these cookies. We will also share how you can prevent these cookies from being stored, however this may downgrade or 'break' certain elements of the site's functionality.&lt;/p&gt; &lt;h3&gt;How do we use cookies?&lt;/h3&gt; &lt;p&gt; We use cookies for a variety of reasons, detailed below. Unfortunately, in most cases, there are no industry standard options for disabling cookies without completely disabling the functionality and features they add to this site. It is recommended that you leave all cookies if you are unsure whether or not you need them, if they are used ​​to provide a service that you use.&lt;/p&gt; &lt;h3&gt;Disable Cookies&lt;/h3&gt; &lt;p&gt;You can opt out setting cookies by adjusting your browser settings (see your browser's Help to learn how to do this). Please be aware that disabling cookies will affect the functionality of this and many other websites you visit. Disabling cookies will generally result in the disabling of certain functionality and features of this website. We therefore recommend that you do not disable cookies.&lt;/p&gt; &lt;h3&gt;Cookies We Set&lt;/h3&gt; &lt;ul&gt; &lt;li&gt; Account Related Cookies&lt;br&gt;&lt;br&gt; If you create an account with us, we will use cookies for managing the application process and general administration. These cookies will generally be deleted when you log out, however in some cases they may remain later to remember your site preferences when you log out.&lt;br&gt;&lt;br&gt; &lt;/li&gt; &lt;li&gt; Login-related cookies&lt;br &lt;br&gt; We use cookies when you are logged in so that we can remember this action. This saves you from having to log in every time you visit a new page. These cookies are normally removed or cleared when you log out to ensure that you can only access restricted features and areas when you log in.&lt;br&gt;&lt;br&gt; &lt;/li&gt; &lt;li&gt; Cookies related to email bulletins&lt;br &lt;br&gt; This site offers newsletter or email subscription services and cookies can be used ​​to remind you if you are already registered and if you should show certain notifications valid only for registered / non-subscribed users.&lt;br&gt; &lt;br&gt; &lt;/li&gt; &lt;li&gt; Orders processing related cookies&lt;br&gt;&lt;br&gt; This site offers e-commerce or payment facilities and some cookies are essential to ensure that your order is remembered between pages so that we can process it. it properly.&lt;br&gt;&lt;br&gt; &lt;/li&gt; &lt;li&gt; Cookies Related to Surveys&lt;br&gt;&lt;br&gt; From time to time, we offer surveys and questionnaires to provide interesting information, useful tools, or to understand our user base more accurately. These surveys may use cookies to remember who has already participated in a survey or to provide accurate results after changing pages.&lt;br&gt;&lt;br&gt; &lt;/li&gt; &lt;li&gt; Cookies related to forms&lt;br&gt;&lt;br&gt; When you submit data through a form such as those found on the contact pages or comment forms, cookies can be set to remember the user's details for future correspondence.&lt;br&gt;&lt;br&gt; &lt;/li&gt; &lt;li&gt; Preferences cookies site&lt;br&gt;&lt;br&gt; To provide you with a great experience on this site, we provide the functionality to set your preferences for how this site performs when you use it. To remember your preferences, we need to set cookies so that this information can be called whenever you interact with a page that is affected by your preferences.&lt;br&gt; &lt;/li&gt; &lt;/ul&gt; &lt;h3&gt;Third Party Cookies&lt;/h3&gt; &lt;p&gt;In some special cases, we also use cookies provided by trusted third parties. The following section details which third party cookies you may encounter through this website.&lt;/p&gt; &lt;ul&gt; &lt;li&gt; This website uses Google Analytics, which is one of the most widespread and reliable analytics solutions on the web, for help us understand how you use the site and how we can improve your experience. These cookies may track items such as how much time you spend on the site and which pages you visit, so that we can continue to produce compelling content. &lt;/li&gt; &lt;/ul&gt; &lt;p&gt;For more information about Google Analytics cookies, see the official Google Analytics page.&lt;/p&gt; &lt;ul&gt; &lt;li&gt; Third-party analytics are used to track and measure usage of this site so that we can continue to produce compelling content. These cookies may track things like how much time you spend on the site or which pages you visit, which helps us understand how we can improve the site for you.&lt;/li&gt; &lt;li&gt; From time to time, we test new features and make subtle changes to the way how the site presents itself. When we're still testing new features, these cookies can be used ​​to ensure you receive a consistent experience while on the site, while we understand which optimizations our users appreciate the most.&lt;/li&gt; &lt;li&gt; As we sell products, It's important that we understand statistics about how many visitors to our site actually buy, and therefore this is the type of data these cookies will track. This is important to you as it means we can accurately make business predictions that allow us to analyze our advertising and product costs to ensure the best possible price.&lt;/li&gt; &lt;/ul&gt; &lt;h3&gt;User Engagement&lt;/h3&gt; &lt;p&gt;The user undertakes to make proper use of the contents and information that IBC Skate offers on the website and with an enunciative, but not limiting, character:&lt;/p&gt; &lt;ul&gt; &lt;li&gt;A) Not to engage in activities that are illegal or contrary to good faith and public order;&lt;/li&gt; &lt;li&gt;B) Not to spread propaganda or content of a racist, xenophobic nature, or bookmakers, games of chance, any type of illegal pornography, of apology for terrorism or against human rights;&lt;/li&gt; &lt;li&gt;C) Do not damage the physical (hardware) and logical (software) systems of IBC Skate, its suppliers or third parties, to introduce or spread computer viruses or any other other hardware or software systems that are capable of causing the aforementioned damage.&lt;/li&gt; &lt;/ul&gt; &lt;h3&gt;More information&lt;/h3&gt; &lt;p&gt;We hope you are clear and, as mentioned earlier, if there is anything you do not sure if you need it or not, it's generally safer to leave cookies enabled, interact with one of the features you use on our site.&lt;/p&gt; &lt;p&gt;This policy is effective from &lt;strong&gt;Sep&lt;/strong&gt;/&lt;strong&gt;2021&lt;/strong&gt;.&lt;/p&gt;</div></div></div>
        HTML;

        $pageIdentifier = 'privacy-policy-skate';
        $cmsPageModel = $this->pageFactory->create()->load($pageIdentifier, 'title');
        $cmsPageModel->setIdentifier('privacy-policy-skate');
        $cmsPageModel->setStores([$skate_in->getId()]);
        $cmsPageModel->setTitle('Privacy Policy');
        $cmsPageModel->setContentHeading('Privacy Policy');
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
        return [
            ConfigureStores::class
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}
