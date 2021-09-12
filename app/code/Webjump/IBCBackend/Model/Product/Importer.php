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
use Magento\Framework\App\State;

class Importer
{
    const IMPORT_CSV = [
        0 => [
            'entity' => 'catalog_product',
            'behavior' => 'add_update',
            'file' => 'productsGames.csv'
        ],
        1 => [
            'entity' => 'stock_sources',
            'behavior' => 'append',
            'file' => 'stockGames.csv'
        ],
        2 => [
            'entity' => 'catalog_product',
            'behavior' => 'add_update',
            'file' => 'productsSkate.csv'
        ],
        3 => [
            'entity' => 'catalog_product',
            'behavior' => 'delete',
            'file' => 'otherTypesProducts.csv'
        ],
        4 => [
            'entity' => 'catalog_product',
            'behavior' => 'add_update',
            'file' => 'otherTypesProducts.csv'
        ],
        5 => [
            'entity' => 'stock_sources',
            'behavior' => 'append',
            'file' => 'stockSkate.csv'
        ],
        6 => [
            'entity' => 'catalog_product',
            'behavior' => 'add_update',
            'file' => 'website-productsSkate.csv'
        ]
    ];

    Const GROUPED_DATA = [
        0 => [
            'entity' => 'catalog_product',
            'behavior' => 'add_update',
            'file' => 'productsGames.csv'

    ]

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
    private $productRepository;

    public function __construct(
        ImportFactory $importFactory,
        File $file,
        CsvFactory $csvFactory,
        ReadFactory $readFactory,
        ConsoleOutput $output,
        State $state,
        ProductLinkInterfaceFactory $productLinkInterfaceFactory,
        ProductRepositoryInterface $productRepository
    )
    {
        $this->importFactory = $importFactory;
        $this->file = $file;
        $this->csvFactory = $csvFactory;
        $this->readFactory = $readFactory;
        $this->output = $output;
        $this->state = $state;
        $this->productLinkInterfaceFactory = $productLinkInterfaceFactory;
        $this->productRepository = $productRepository;
    }

    /**
     * @return void
     */
    public function execute(): void
    {
        foreach (self::IMPORT_DATA as $data) {
            $this->importData(
                $data['file'],
                $data['entity'],
                $data['behavior']
            );
        }
//        $this->associateSkuWithGroupedProducts();
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

    private function associateSkuWithGroupedProducts()
    {
        $this->settingAreaCode();

        $productLinkGrouped1 = $this->productLinkInterfaceFactory->create();
        $productLinkGrouped1->setSku('SK-KIT-2')
            ->setLinkedProductSku('SKT-TK-3')
            ->setLinkType('associated')
            ->setLinkedProductType('simple')
            ->setQty('1');

        $productLinkGrouped2 = $this->productLinkInterfaceFactory->create();
        $productLinkGrouped2->setSku('SK-KIT-2')
            ->setLinkedProductSku('SKT-LX-1')
            ->setLinkType('associated')
            ->setLinkedProductType('simple')
            ->setQty('1');

        $productLinkGrouped3 = $this->productLinkInterfaceFactory->create();
        $productLinkGrouped3->setSku('SK-KIT-2')
            ->setLinkedProductSku('SKT-RO-1')
            ->setLinkType('associated')
            ->setLinkedProductType('simple')
            ->setQty('1');

        $productLinkGrouped4 = $this->productLinkInterfaceFactory->create();
        $productLinkGrouped4->setSku('SK-KIT-2')
            ->setLinkedProductSku('SKT-SH-2')
            ->setLinkType('associated')
            ->setLinkedProductType('simple')
            ->setQty('1');

        $productLinkGrouped5 = $this->productLinkInterfaceFactory->create();
        $productLinkGrouped5->setSku('SK-KIT-2')
            ->setLinkedProductSku('SKT-RO-1')
            ->setLinkType('associated')
            ->setLinkedProductType('simple')
            ->setQty('1');

        $groupedKit2 = $this->productRepository->get('SK-KIT-2', true);
        $groupedKit2->setProductLinks([
            $productLinkGrouped1,
            $productLinkGrouped2,
            $productLinkGrouped3,
            $productLinkGrouped4,
            $productLinkGrouped5
        ])
            ->save();
    }
}
