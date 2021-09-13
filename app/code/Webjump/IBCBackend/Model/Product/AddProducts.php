<?php
namespace Webjump\IBCBackend\Model\Product;

use Magento\Catalog\Api\Data\ProductLinkInterfaceFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Filesystem\Directory\ReadFactory;
use Magento\ImportExport\Model\ImportFactory;
use Magento\Framework\Filesystem\Io\File;
use Magento\ImportExport\Model\Import\Source\CsvFactory;
use Symfony\Component\Console\Output\ConsoleOutput;
use Magento\Framework\App\Area;
use Webjump\IBCBackend\App\State;


class AddProducts
{
    const IMPORT_DATA = [
        0 => [
            'entity' => 'catalog_product',
            'behavior' => 'add_update',
            'file' => 'productsGames.csv'
        ],
        1 => [
            'entity' => 'catalog_product',
            'behavior' => 'add_update',
            'file' => 'productsSkate.csv'
        ],
        2 => [
            'entity' => 'catalog_product',
            'behavior' => 'delete',
            'file' => 'otherTypesProducts.csv'
        ],
        3 => [
            'entity' => 'catalog_product',
            'behavior' => 'add_update',
            'file' => 'otherTypesProducts.csv'
        ],
        4 => [
            'entity' => 'stock_sources',
            'behavior' => 'append',
            'file' => 'stockSkate.csv'
        ],
        5 => [
            'entity' => 'stock_sources',
            'behavior' => 'append',
            'file' => 'stockGames.csv'
        ],
        6 => [
            'entity' => 'catalog_product',
            'behavior' => 'add_update',
            'file' => 'website-productsSkate.csv'
        ]
    ];

    Const GROUPED_DATA = [
        0 => [
            'groupedSku' => 'SK-KIT-2',
            'simpleSkus' => [
                'Sku1' => 'SKT-RO-1',
                'Sku2' => 'SKT-TK-3',
                'Sku3' => 'SKT-LX-1',
                'Sku4' => 'SKT-SH-2'
            ]
        ],
        1 => [
                'groupedSku' => 'JG-KIT-LUTA',
                'simpleSkus' => [
                    'Sku1' => 'JG-LT-MK11-1',
                    'Sku2' => 'JG-LT-UFC-1',
                    'Sku3' => 'JG-LT-IG-1',
                ]
        ]
    ];

    /**
     * @var ImportFactory
     */
    private $importFactory;

    /**
     * @var File
     */
    private $file;

    /**
     * @var CsvFactory
     */
    private $csvFactory;

    /**
     * @var ReadFactory
     */
    private $readFactory;

    /**
     * @var ConsoleOutput
     */
    private $output;

    /**
     * @var State
     */
    private $state;

    /**
     * @var ProductLinkInterfaceFactory
     */
    private $productLinkInterfaceFactory;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepositoryInterface;

    public function __construct(
        ImportFactory $importFactory,
        File $file,
        CsvFactory $csvFactory,
        ReadFactory $readFactory,
        ConsoleOutput $output,
        State $state,
        ProductLinkInterfaceFactory $productLinkInterfaceFactory,
        ProductRepositoryInterface $productRepositoryInterface
    )
    {
        $this->importFactory = $importFactory;
        $this->file = $file;
        $this->csvFactory = $csvFactory;
        $this->readFactory = $readFactory;
        $this->output = $output;
        $this->state = $state;
        $this->productLinkInterfaceFactory = $productLinkInterfaceFactory;
        $this->productRepositoryInterface = $productRepositoryInterface;
    }


    public function execute(): void
    {
        foreach (self::IMPORT_DATA as $data) {
            $this->importData(
                $data['file'],
                $data['entity'],
                $data['behavior']
            );
        }

        $this->settingAreaCode();

        foreach (self::GROUPED_DATA as $data) {
            $this->associateSkuWithGroupedProducts(
                $data['groupedSku'],
                $data['simpleSkus']
            );
        }
    }

    private function importData($fileName, $entity, $behavior)
    {
        $import = $this->importFactory->create();
        $import->setData(
            [
                'entity' => $entity,
                'behavior' => $behavior,
                'validation_strategy' => 'validation-stop-on-errors'
            ]
        );

        $validate = $import->validateSource($this->getCsv($fileName));
        if ($validate) {
            $result = $import->importSource();
            $this->output->writeln("O arquivo $fileName foi importado com sucesso.");
            if ($result) {
                $import->invalidateIndex();
            }
        }
    }

    public function getCsv($fileName)
    {
        $import_file = $this->file->getPathInfo(__DIR__ . '/csv/'. $fileName);
        $readSetup = $this->readFactory->create($import_file['dirname']);
        $csvSource = $this->csvFactory->create(
            [
                'file' => $import_file['basename'],
                'directory' => $readSetup
            ]
        );
        return $csvSource;
    }

    private function settingAreaCode()
    {
        if (!$this->state->validateAreaCode()) {
            $this->state->setAreaCode(Area::AREA_ADMINHTML);
        }
    }

    private function associateSkuWithGroupedProducts($groupedSku, $simpleSkus)
    {
        $arrayOfAllSimpleProductLinks = [];

        foreach ($simpleSkus as $skus) {
            $productLink = $this->productLinkInterfaceFactory->create();
            $productLink->setSku($groupedSku)
                ->setLinkedProductSku($skus)
                ->setLinkType('associated')
                ->setLinkedProductType('simple');
            $arrayOfAllSimpleProductLinks[] = $productLink;
        }

        $groupedProduct = $this->productRepositoryInterface->get($groupedSku, true);
        $groupedProduct->setProductLinks($arrayOfAllSimpleProductLinks);
        $this->productRepositoryInterface->save($groupedProduct);
    }
}
