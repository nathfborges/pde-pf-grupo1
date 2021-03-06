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

        $skate_ptbr = $this->storeRepository->get(ConfigureStores::IBC_SKATE_STORE_1_CODE);

        $content = <<<HTML
        <style>#html-body [data-pb-style=MUE3LR1]{justify-content:flex-start;display:flex;flex-direction:column;background-position:left top;background-size:cover;background-repeat:no-repeat;background-attachment:scroll}</style><div data-content-type="row" data-appearance="contained" data-element="main"><div data-enable-parallax="0" data-parallax-speed="0.5" data-background-images="{}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="inner" data-pb-style="MUE3LR1"><div data-content-type="html" data-appearance="default" data-element="main">&lt;p&gt;A sua privacidade ?? importante para n??s. ?? pol??tica do IBC Skate respeitar a sua privacidade em rela????o a qualquer informa????o sua que possamos coletar no site &lt;a href=google.com&gt;IBC Skate&lt;/a&gt;, e outros sites que possu??mos e operamos.&lt;/p&gt; &lt;p&gt;Solicitamos informa????es pessoais apenas quando realmente precisamos delas para lhe fornecer um servi??o. Fazemo-lo por meios justos e legais, com o seu conhecimento e consentimento. Tamb??m informamos por que estamos coletando e como ser?? usado. &lt;/p&gt; &lt;p&gt;Apenas retemos as informa????es coletadas pelo tempo necess??rio para fornecer o servi??o solicitado. Quando armazenamos dados, protegemos dentro de meios comercialmente aceit??veis ??????para evitar perdas e roubos, bem como acesso, divulga????o, c??pia, uso ou modifica????o n??o autorizados.&lt;/p&gt; &lt;p&gt;N??o compartilhamos informa????es de identifica????o pessoal publicamente ou com terceiros, exceto quando exigido por lei.&lt;/p&gt; &lt;p&gt;O nosso site pode ter links para sites externos que n??o s??o operados por n??s. Esteja ciente de que n??o temos controle sobre o conte??do e pr??ticas desses sites e n??o podemos aceitar responsabilidade por suas respectivas &lt;a href='https://privacidade.me/' target='_BLANK'&gt;pol??ticas de privacidade&lt;/a&gt;. &lt;/p&gt; &lt;p&gt;Voc?? ?? livre para recusar a nossa solicita????o de informa????es pessoais, entendendo que talvez n??o possamos fornecer alguns dos servi??os desejados.&lt;/p&gt; &lt;p&gt;O uso continuado de nosso site ser?? considerado como aceita????o de nossas pr??ticas em torno de privacidade e informa????es pessoais. Se voc?? tiver alguma d??vida sobre como lidamos com dados do usu??rio e informa????es pessoais, entre em contato conosco.&lt;/p&gt; &lt;h2&gt;Pol??tica de Cookies IBC Skate&lt;/h2&gt; &lt;h3&gt;O que s??o cookies?&lt;/h3&gt; &lt;p&gt;Como ?? pr??tica comum em quase todos os sites profissionais, este site usa cookies, que s??o pequenos arquivos baixados no seu computador, para melhorar sua experi??ncia. Esta p??gina descreve quais informa????es eles coletam, como as usamos e por que ??s vezes precisamos armazenar esses cookies. Tamb??m compartilharemos como voc?? pode impedir que esses cookies sejam armazenados, no entanto, isso pode fazer o downgrade ou 'quebrar' certos elementos da funcionalidade do site.&lt;/p&gt; &lt;h3&gt;Como usamos os cookies?&lt;/h3&gt; &lt;p&gt;Utilizamos cookies por v??rios motivos, detalhados abaixo. Infelizmente, na maioria dos casos, n??o existem op????es padr??o do setor para desativar os cookies sem desativar completamente a funcionalidade e os recursos que eles adicionam a este site. ?? recomend??vel que voc?? deixe todos os cookies se n??o tiver certeza se precisa ou n??o deles, caso sejam usados ??????para fornecer um servi??o que voc?? usa.&lt;/p&gt; &lt;h3&gt;Desativar cookies&lt;/h3&gt; &lt;p&gt;Voc?? pode impedir a configura????o de cookies ajustando as configura????es do seu navegador (consulte a Ajuda do navegador para saber como fazer isso). Esteja ciente de que a desativa????o de cookies afetar?? a funcionalidade deste e de muitos outros sites que voc?? visita. A desativa????o de cookies geralmente resultar?? na desativa????o de determinadas funcionalidades e recursos deste site. Portanto, ?? recomend??vel que voc?? n??o desative os cookies.&lt;/p&gt; &lt;h3&gt;Cookies que definimos&lt;/h3&gt; &lt;ul&gt; &lt;li&gt; Cookies relacionados ?? conta&lt;br&gt;&lt;br&gt; Se voc?? criar uma conta conosco, usaremos cookies para o gerenciamento do processo de inscri????o e administra????o geral. Esses cookies geralmente ser??o exclu??dos quando voc?? sair do sistema, por??m, em alguns casos, eles poder??o permanecer posteriormente para lembrar as prefer??ncias do seu site ao sair.&lt;br&gt;&lt;br&gt; &lt;/li&gt; &lt;li&gt; Cookies relacionados ao login&lt;br&gt;&lt;br&gt; Utilizamos cookies quando voc?? est?? logado, para que possamos lembrar dessa a????o. Isso evita que voc?? precise fazer login sempre que visitar uma nova p??gina. Esses cookies s??o normalmente removidos ou limpos quando voc?? efetua logout para garantir que voc?? possa acessar apenas a recursos e ??reas restritas ao efetuar login.&lt;br&gt;&lt;br&gt; &lt;/li&gt; &lt;li&gt; Cookies relacionados a boletins por e-mail&lt;br&gt;&lt;br&gt; Este site oferece servi??os de assinatura de boletim informativo ou e-mail e os cookies podem ser usados ??????para lembrar se voc?? j?? est?? registrado e se deve mostrar determinadas notifica????es v??lidas apenas para usu??rios inscritos / n??o inscritos.&lt;br&gt;&lt;br&gt; &lt;/li&gt; &lt;li&gt; Pedidos processando cookies relacionados&lt;br&gt;&lt;br&gt; Este site oferece facilidades de com??rcio eletr??nico ou pagamento e alguns cookies s??o essenciais para garantir que seu pedido seja lembrado entre as p??ginas, para que possamos process??-lo adequadamente.&lt;br&gt;&lt;br&gt; &lt;/li&gt; &lt;li&gt; Cookies relacionados a pesquisas&lt;br&gt;&lt;br&gt; Periodicamente, oferecemos pesquisas e question??rios para fornecer informa????es interessantes, ferramentas ??teis ou para entender nossa base de usu??rios com mais precis??o. Essas pesquisas podem usar cookies para lembrar quem j?? participou numa pesquisa ou para fornecer resultados precisos ap??s a altera????o das p??ginas.&lt;br&gt;&lt;br&gt; &lt;/li&gt; &lt;li&gt; Cookies relacionados a formul??rios&lt;br&gt;&lt;br&gt; Quando voc?? envia dados por meio de um formul??rio como os encontrados nas p??ginas de contacto ou nos formul??rios de coment??rios, os cookies podem ser configurados para lembrar os detalhes do usu??rio para correspond??ncia futura.&lt;br&gt;&lt;br&gt; &lt;/li&gt; &lt;li&gt; Cookies de prefer??ncias do site&lt;br&gt;&lt;br&gt; Para proporcionar uma ??tima experi??ncia neste site, fornecemos a funcionalidade para definir suas prefer??ncias de como esse site ?? executado quando voc?? o usa. Para lembrar suas prefer??ncias, precisamos definir cookies para que essas informa????es possam ser chamadas sempre que voc?? interagir com uma p??gina for afetada por suas prefer??ncias.&lt;br&gt; &lt;/li&gt; &lt;/ul&gt; &lt;h3&gt;Cookies de Terceiros&lt;/h3&gt; &lt;p&gt;Em alguns casos especiais, tamb??m usamos cookies fornecidos por terceiros confi??veis. A se????o a seguir detalha quais cookies de terceiros voc?? pode encontrar atrav??s deste site.&lt;/p&gt; &lt;ul&gt; &lt;li&gt; Este site usa o Google Analytics, que ?? uma das solu????es de an??lise mais difundidas e confi??veis ??????da Web, para nos ajudar a entender como voc?? usa o site e como podemos melhorar sua experi??ncia. Esses cookies podem rastrear itens como quanto tempo voc?? gasta no site e as p??ginas visitadas, para que possamos continuar produzindo conte??do atraente. &lt;/li&gt; &lt;/ul&gt; &lt;p&gt;Para mais informa????es sobre cookies do Google Analytics, consulte a p??gina oficial do Google Analytics.&lt;/p&gt; &lt;ul&gt; &lt;li&gt; As an??lises de terceiros s??o usadas para rastrear e medir o uso deste site, para que possamos continuar produzindo conte??do atrativo. Esses cookies podem rastrear itens como o tempo que voc?? passa no site ou as p??ginas visitadas, o que nos ajuda a entender como podemos melhorar o site para voc??.&lt;/li&gt; &lt;li&gt; Periodicamente, testamos novos recursos e fazemos altera????es subtis na maneira como o site se apresenta. Quando ainda estamos testando novos recursos, esses cookies podem ser usados ??????para garantir que voc?? receba uma experi??ncia consistente enquanto estiver no site, enquanto entendemos quais otimiza????es os nossos usu??rios mais apreciam.&lt;/li&gt; &lt;li&gt; ?? medida que vendemos produtos, ?? importante entendermos as estat??sticas sobre quantos visitantes de nosso site realmente compram e, portanto, esse ?? o tipo de dados que esses cookies rastrear??o. Isso ?? importante para voc??, pois significa que podemos fazer previs??es de neg??cios com precis??o que nos permitem analizar nossos custos de publicidade e produtos para garantir o melhor pre??o poss??vel.&lt;/li&gt; &lt;/ul&gt; &lt;h3&gt;Compromisso do Usu??rio&lt;/h3&gt; &lt;p&gt;O usu??rio se compromete a fazer uso adequado dos conte??dos e da informa????o que o IBC Skate oferece no site e com car??ter enunciativo, mas n??o limitativo:&lt;/p&gt; &lt;ul&gt; &lt;li&gt;A) N??o se envolver em atividades que sejam ilegais ou contr??rias ?? boa f?? a ?? ordem p??blica;&lt;/li&gt; &lt;li&gt;B) N??o difundir propaganda ou conte??do de natureza racista, xenof??bica, ou casas de apostas, jogos de sorte e azar, qualquer tipo de pornografia ilegal, de apologia ao terrorismo ou contra os direitos humanos;&lt;/li&gt; &lt;li&gt;C) N??o causar danos aos sistemas f??sicos (hardwares) e l??gicos (softwares) do IBC Skate, de seus fornecedores ou terceiros, para introduzir ou disseminar v??rus inform??ticos ou quaisquer outros sistemas de hardware ou software que sejam capazes de causar danos anteriormente mencionados.&lt;/li&gt; &lt;/ul&gt; &lt;h3&gt;Mais informa????es&lt;/h3&gt; &lt;p&gt;Esperemos que esteja esclarecido e, como mencionado anteriormente, se houver algo que voc?? n??o tem certeza se precisa ou n??o, geralmente ?? mais seguro deixar os cookies ativados, caso interaja com um dos recursos que voc?? usa em nosso site.&lt;/p&gt; &lt;p&gt;Esta pol??tica ?? efetiva a partir de &lt;strong&gt;Sep&lt;/strong&gt;/&lt;strong&gt;2021&lt;/strong&gt;.&lt;/p&gt; </div></div></div>
        HTML;

        $pageIdentifier = 'politica-de-privacidade';
        $cmsPageModel = $this->pageFactory->create()->load($pageIdentifier, 'title');
        $cmsPageModel->setIdentifier('politica-de-privacidade');
        $cmsPageModel->setStores([$skate_ptbr->getId()]);
        $cmsPageModel->setTitle('Pol??tica de Privacidade');
        $cmsPageModel->setContentHeading('Pol??tica de Privacidade');
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
