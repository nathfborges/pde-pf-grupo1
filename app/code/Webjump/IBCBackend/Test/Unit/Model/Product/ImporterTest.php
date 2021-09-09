<?php

namespace Webjump\IBCBackend\Test\Unit\Model\Product;

use Magento\Framework\DataObject;
use Magento\ImportExport\Model\Import;
use Magento\ImportExport\Model\ImportFactory;
use PHPUnit\Framework\TestCase;
use Magento\Framework\Filesystem\Directory\ReadFactory;
use Magento\Framework\Filesystem\Io\File;
use Magento\ImportExport\Model\Import\Source\CsvFactory;
use Symfony\Component\Console\Output\ConsoleOutput;
use Webjump\IBCBackend\Model\Product\Importer;
use Magento\Framework\Filesystem\Directory\Read;
use Magento\ImportExport\Model\Import\Source\Csv;

class ImporterTest extends TestCase
{
    private $importFactoryMock;
    private $importMock;
    private $fileMock;
    private $csvFactoryMock;
    private $readFactoryMock;
    private $outputMock;
    private $importer;
    private $readMock;
    private $csvMock;
    private $importerMock;
    /**
     * @var DataObject|mixed|\PHPUnit\Framework\MockObject\MockObject
     */
    private $dataObjectMock;


    protected function setUp(): void
    {

        $this->importFactoryMock = $this->createMock(ImportFactory::class);
        $this->importMock = $this->createMock(Import::class);

        $this->fileMock = $this->createMock(File::class);

        $this->readFactoryMock = $this->createMock(ReadFactory::class);

        $this->readMock = $this->createMock(Read::class);


        $this->csvFactoryMock = $this->createMock(CsvFactory::class);
        $this->csvMock = $this->createMock(Csv::class);
        $this->csvFactoryMock->method('create')->willReturn($this->csvMock);


        $this->outputMock = $this->createMock(ConsoleOutput::class);
        $this->csvMock = $this->createMock(Csv::class);

        $this->dataObjectMock = $this->createMock(DataObject::class);
        $this->importerMock = $this->createMock(Importer::class);
        $this->importerMock->method('getCsv')->willReturn($this->csvMock);
        $this->importer = new Importer($this->importFactoryMock, $this->fileMock, $this->csvFactoryMock, $this->readFactoryMock, $this->outputMock);

    }

    public function testExecute()
    {
        $a = Importer::IMPORT_DATA[0]['entity'];
        $b = Importer::IMPORT_DATA[0]['behavior'];

        $this->importFactoryMock->expects($this->exactly(5))
            ->method('create')
            ->willReturn($this->importMock);

        $this->importMock->expects($this->exactly(5))
            ->method('setData')
            ->with(['entity' => 'catalog_product',
                'behavior' => 'add_update',
                'validation_strategy' => 'validation-stop-on-errors'])
            ->willReturn($this->dataObjectMock);


     $this->importMock->method('validateSource')
         ->with($this->csvMock)
         ->willReturn(true);

     $this->importMock->method('importSource')
         ->withAnyParameters()
         ->willReturn(true);

     $this->outputMock->method('writeln')
         ->with('teste');

     $this->importMock->method('invalidateIndex')
         ->withAnyParameters()
         ->willReturnSelf();

     $this->importer->execute();

    }
}

