<?php
namespace Webjump\IBCBackend\Model\Product;

use Magento\Framework\Filesystem\Directory\ReadFactory;
use Magento\ImportExport\Model\Import;
use Magento\ImportExport\Model\ImportFactory;
use Magento\Framework\Filesystem\Io\File;
use Magento\ImportExport\Model\Import\Source\CsvFactory;


class AddProducts
{
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

    public function __construct(
        ImportFactory $importFactory,
        File $file,
        CsvFactory $csvFactory,
        ReadFactory $readFile
    )
    {
        $this->importFactory = $importFactory;
        $this->file = $file;
        $this->csvFactory = $csvFactory;
        $this->readFile = $readFile;
    }

    public function importProducts()
    {
        $import = $this->importFactory->create();
        $aaaa = 'aaaaaaaaaa';
        $fileType = 'catalog_product';
        $import->setData(
            [
                'entity' => 'catalog_product',
                'behavior' => 'add_update',
                'validation_strategy' => 'validation-stop-on-errors'
            ]
        );

        $validate = $import->validateSource($this->getCsv());
        if (!$validate) {
            var_dump($aaaa);
        }

        $result = $import->importSource();
        if ($result) {
            $import->invalidateIndex();
            }

    }

    public function getCsv()
    {
        $import_file = $this->file->getPathInfo(__DIR__ . '/csv/simpleProducts.csv');
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
