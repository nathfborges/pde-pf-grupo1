<?php
namespace Webjump\IBCBackend\Model\Product;

use Magento\Framework\Filesystem\Directory\ReadFactory;
use Magento\ImportExport\Model\ImportFactory;
use Magento\Framework\Filesystem\Io\File;
use Magento\ImportExport\Model\Import\Source\CsvFactory;
use Symfony\Component\Console\Output\ConsoleOutput;

class Importer
{
    const IMPORT_DATA = [
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
            'behavior' => 'add_update',
            'file' => 'website-productsSkate.csv'
        ],
        4 => [
            'entity' => 'stock_sources',
            'behavior' => 'append',
            'file' => 'stockSkate.csv'
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
    private $readFile;

    /**
     * @var ConsoleOutput
     */
    private $output;

    public function __construct(
        ImportFactory $importFactory,
        File $file,
        CsvFactory $csvFactory,
        ReadFactory $readFile,
        ConsoleOutput $output
    )
    {
        $this->importFactory = $importFactory;
        $this->file = $file;
        $this->csvFactory = $csvFactory;
        $this->readFile = $readFile;
        $this->output = $output;
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
        $readSetup = $this->readFile->create($import_file["dirname"]);
        $csvSource = $this->csvFactory->create(
            [
                'file' => $import_file['basename'],
                'directory' => $readSetup
            ]
        );
        return $csvSource;
    }

}
