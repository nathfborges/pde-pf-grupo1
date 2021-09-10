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

/** @codeCoverageIgnore */
class PrivacyPolicyGames implements DataPatchInterface
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
    const CODE_WEBSITE = ['games_ibc'];

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
        <style>#html-body [data-pb-style=Q4KRROV]{justify-content:flex-start;display:flex;flex-direction:column;background-position:left top;background-size:cover;background-repeat:no-repeat;background-attachment:scroll}</style><div data-content-type="row" data-appearance="contained" data-element="main"><div data-enable-parallax="0" data-parallax-speed="0.5" data-background-images="{}" data-background-type="image" data-video-loop="true" data-video-play-only-visible="true" data-video-lazy-load="true" data-video-fallback-src="" data-element="inner" data-pb-style="Q4KRROV"><div data-content-type="html" data-appearance="default" data-element="main">&lt;p&gt;A sua privacidade é importante para nós. É política do Jump Games respeitar a sua privacidade em relação a qualquer informação sua que possamos coletar no site &lt;a href=https://google.com&gt;Jump Games&lt;/a&gt;, e outros sites que possuímos e operamos.&lt;/p&gt; &lt;p&gt;Solicitamos informações pessoais apenas quando realmente precisamos delas para lhe fornecer um serviço. Fazemo-lo por meios justos e legais, com o seu conhecimento e consentimento. Também informamos por que estamos coletando e como será usado. &lt;/p&gt; &lt;p&gt;Apenas retemos as informações coletadas pelo tempo necessário para fornecer o serviço solicitado. Quando armazenamos dados, protegemos dentro de meios comercialmente aceitáveis ​​para evitar perdas e roubos, bem como acesso, divulgação, cópia, uso ou modificação não autorizados.&lt;/p&gt; &lt;p&gt;Não compartilhamos informações de identificação pessoal publicamente ou com terceiros, exceto quando exigido por lei.&lt;/p&gt; &lt;p&gt;O nosso site pode ter links para sites externos que não são operados por nós. Esteja ciente de que não temos controle sobre o conteúdo e práticas desses sites e não podemos aceitar responsabilidade por suas respectivas &lt;a href='https://privacidade.me/' target='_BLANK'&gt;políticas de privacidade&lt;/a&gt;. &lt;/p&gt; &lt;p&gt;Você é livre para recusar a nossa solicitação de informações pessoais, entendendo que talvez não possamos fornecer alguns dos serviços desejados.&lt;/p&gt; &lt;p&gt;O uso continuado de nosso site será considerado como aceitação de nossas práticas em torno de privacidade e informações pessoais. Se você tiver alguma dúvida sobre como lidamos com dados do usuário e informações pessoais, entre em contato conosco.&lt;/p&gt; &lt;h2&gt;Política de Cookies Jump Games&lt;/h2&gt; &lt;h3&gt;O que são cookies?&lt;/h3&gt; &lt;p&gt;Como é prática comum em quase todos os sites profissionais, este site usa cookies, que são pequenos arquivos baixados no seu computador, para melhorar sua experiência. Esta página descreve quais informações eles coletam, como as usamos e por que às vezes precisamos armazenar esses cookies. Também compartilharemos como você pode impedir que esses cookies sejam armazenados, no entanto, isso pode fazer o downgrade ou 'quebrar' certos elementos da funcionalidade do site.&lt;/p&gt; &lt;h3&gt;Como usamos os cookies?&lt;/h3&gt; &lt;p&gt;Utilizamos cookies por vários motivos, detalhados abaixo. Infelizmente, na maioria dos casos, não existem opções padrão do setor para desativar os cookies sem desativar completamente a funcionalidade e os recursos que eles adicionam a este site. É recomendável que você deixe todos os cookies se não tiver certeza se precisa ou não deles, caso sejam usados ​​para fornecer um serviço que você usa.&lt;/p&gt; &lt;h3&gt;Desativar cookies&lt;/h3&gt; &lt;p&gt;Você pode impedir a configuração de cookies ajustando as configurações do seu navegador (consulte a Ajuda do navegador para saber como fazer isso). Esteja ciente de que a desativação de cookies afetará a funcionalidade deste e de muitos outros sites que você visita. A desativação de cookies geralmente resultará na desativação de determinadas funcionalidades e recursos deste site. Portanto, é recomendável que você não desative os cookies.&lt;/p&gt; &lt;h3&gt;Cookies que definimos&lt;/h3&gt; &lt;ul&gt; &lt;li&gt; Cookies relacionados à conta&lt;br&gt;&lt;br&gt; Se você criar uma conta conosco, usaremos cookies para o gerenciamento do processo de inscrição e administração geral. Esses cookies geralmente serão excluídos quando você sair do sistema, porém, em alguns casos, eles poderão permanecer posteriormente para lembrar as preferências do seu site ao sair.&lt;br&gt;&lt;br&gt; &lt;/li&gt; &lt;li&gt; Cookies relacionados ao login&lt;br&gt;&lt;br&gt; Utilizamos cookies quando você está logado, para que possamos lembrar dessa ação. Isso evita que você precise fazer login sempre que visitar uma nova página. Esses cookies são normalmente removidos ou limpos quando você efetua logout para garantir que você possa acessar apenas a recursos e áreas restritas ao efetuar login.&lt;br&gt;&lt;br&gt; &lt;/li&gt; &lt;li&gt; Cookies relacionados a boletins por e-mail&lt;br&gt;&lt;br&gt; Este site oferece serviços de assinatura de boletim informativo ou e-mail e os cookies podem ser usados ​​para lembrar se você já está registrado e se deve mostrar determinadas notificações válidas apenas para usuários inscritos / não inscritos.&lt;br&gt;&lt;br&gt; &lt;/li&gt; &lt;li&gt; Pedidos processando cookies relacionados&lt;br&gt;&lt;br&gt; Este site oferece facilidades de comércio eletrônico ou pagamento e alguns cookies são essenciais para garantir que seu pedido seja lembrado entre as páginas, para que possamos processá-lo adequadamente.&lt;br&gt;&lt;br&gt; &lt;/li&gt; &lt;li&gt; Cookies relacionados a pesquisas&lt;br&gt;&lt;br&gt; Periodicamente, oferecemos pesquisas e questionários para fornecer informações interessantes, ferramentas úteis ou para entender nossa base de usuários com mais precisão. Essas pesquisas podem usar cookies para lembrar quem já participou numa pesquisa ou para fornecer resultados precisos após a alteração das páginas.&lt;br&gt;&lt;br&gt; &lt;/li&gt; &lt;li&gt; Cookies relacionados a formulários&lt;br&gt;&lt;br&gt; Quando você envia dados por meio de um formulário como os encontrados nas páginas de contacto ou nos formulários de comentários, os cookies podem ser configurados para lembrar os detalhes do usuário para correspondência futura.&lt;br&gt;&lt;br&gt; &lt;/li&gt; &lt;li&gt; Cookies de preferências do site&lt;br&gt;&lt;br&gt; Para proporcionar uma ótima experiência neste site, fornecemos a funcionalidade para definir suas preferências de como esse site é executado quando você o usa. Para lembrar suas preferências, precisamos definir cookies para que essas informações possam ser chamadas sempre que você interagir com uma página for afetada por suas preferências.&lt;br&gt; &lt;/li&gt; &lt;/ul&gt; &lt;h3&gt;Cookies de Terceiros&lt;/h3&gt; &lt;p&gt;Em alguns casos especiais, também usamos cookies fornecidos por terceiros confiáveis. A seção a seguir detalha quais cookies de terceiros você pode encontrar através deste site.&lt;/p&gt; &lt;ul&gt; &lt;li&gt; Este site usa o Google Analytics, que é uma das soluções de análise mais difundidas e confiáveis ​​da Web, para nos ajudar a entender como você usa o site e como podemos melhorar sua experiência. Esses cookies podem rastrear itens como quanto tempo você gasta no site e as páginas visitadas, para que possamos continuar produzindo conteúdo atraente. &lt;/li&gt; &lt;/ul&gt; &lt;p&gt;Para mais informações sobre cookies do Google Analytics, consulte a página oficial do Google Analytics.&lt;/p&gt; &lt;ul&gt; &lt;li&gt; As análises de terceiros são usadas para rastrear e medir o uso deste site, para que possamos continuar produzindo conteúdo atrativo. Esses cookies podem rastrear itens como o tempo que você passa no site ou as páginas visitadas, o que nos ajuda a entender como podemos melhorar o site para você.&lt;/li&gt; &lt;li&gt; Periodicamente, testamos novos recursos e fazemos alterações subtis na maneira como o site se apresenta. Quando ainda estamos testando novos recursos, esses cookies podem ser usados ​​para garantir que você receba uma experiência consistente enquanto estiver no site, enquanto entendemos quais otimizações os nossos usuários mais apreciam.&lt;/li&gt; &lt;li&gt; À medida que vendemos produtos, é importante entendermos as estatísticas sobre quantos visitantes de nosso site realmente compram e, portanto, esse é o tipo de dados que esses cookies rastrearão. Isso é importante para você, pois significa que podemos fazer previsões de negócios com precisão que nos permitem analizar nossos custos de publicidade e produtos para garantir o melhor preço possível.&lt;/li&gt; &lt;/ul&gt; &lt;h3&gt;Compromisso do Usuário&lt;/h3&gt; &lt;p&gt;O usuário se compromete a fazer uso adequado dos conteúdos e da informação que o Jump Games oferece no site e com caráter enunciativo, mas não limitativo:&lt;/p&gt; &lt;ul&gt; &lt;li&gt;A) Não se envolver em atividades que sejam ilegais ou contrárias à boa fé a à ordem pública;&lt;/li&gt; &lt;li&gt;B) Não difundir propaganda ou conteúdo de natureza racista, xenofóbica, ou casas de apostas, jogos de sorte e azar, qualquer tipo de pornografia ilegal, de apologia ao terrorismo ou contra os direitos humanos;&lt;/li&gt; &lt;li&gt;C) Não causar danos aos sistemas físicos (hardwares) e lógicos (softwares) do Jump Games, de seus fornecedores ou terceiros, para introduzir ou disseminar vírus informáticos ou quaisquer outros sistemas de hardware ou software que sejam capazes de causar danos anteriormente mencionados.&lt;/li&gt; &lt;/ul&gt; &lt;h3&gt;Mais informações&lt;/h3&gt; &lt;p&gt;Esperemos que esteja esclarecido e, como mencionado anteriormente, se houver algo que você não tem certeza se precisa ou não, geralmente é mais seguro deixar os cookies ativados, caso interaja com um dos recursos que você usa em nosso site.&lt;/p&gt; &lt;p&gt;Esta política é efetiva a partir de &lt;strong&gt;Sep&lt;/strong&gt;/&lt;strong&gt;2021&lt;/strong&gt;.&lt;/p&gt;</div></div></div>
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
