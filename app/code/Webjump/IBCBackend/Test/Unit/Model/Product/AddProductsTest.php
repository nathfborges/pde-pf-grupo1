<?php

namespace Webjump\IBCBackend\Test\Unit\Model\Product;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\Data\ProductLinkInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\ImportExport\Model\Import;
use Magento\Framework\Filesystem\Directory\ReadFactory;
use Magento\Framework\Filesystem\Directory\Read;
use Magento\ImportExport\Model\Import\Source\CsvFactory;
use Magento\ImportExport\Model\Import\Source\Csv;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\ConsoleOutput;
use Magento\Framework\Filesystem\Io\File;
use Webjump\IBCBackend\App\State;
use Webjump\IBCBackend\Model\Product\AddProducts as Model;

class AddProductsTest extends TestCase
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
    private $readFactory;

    /**
     * @var ConsoleOutput
     */
    private $output;

    /**
     * @var Import
     */
    private $import;

    /**
     * @var Read
     */
    private $read;

    /**
     * @var Csv
     */
    private $csv;

    /**
     * @var State
     */
    private $state;

    /**
     * @var Model
     */
    private $model;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->importFactory = $this
            ->getMockBuilder('Magento\ImportExport\Model\ImportFactory')
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();

        $this->file = $this->createMock(File::class);

        $this->csvFactory = $this
            ->getMockBuilder('Magento\ImportExport\Model\Import\Source\CsvFactory')
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();

        $this->readFactory = $this
            ->getMockBuilder('Magento\Framework\Filesystem\Directory\ReadFactory')
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();

        $this->output = $this->createMock(ConsoleOutput::class);

        $this->import = $this->createMock(Import::class);

        $this->read = $this->createMock(Read::class);

        $this->csv = $this->createMock(Csv::class);

        $this->state = $this->createMock(State::class);
        $this->state->method('validateAreaCode');
        $this->state->method('setAreaCode');

        $this->productLinkInterfaceFactory = $this
            ->getMockBuilder('Magento\Catalog\Api\Data\ProductLinkInterfaceFactory')
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();


        $this->productRepositoryInterface = $this->getMockForAbstractClass(ProductRepositoryInterface::class);
        $this->productInterface = $this->createMock(ProductInterface::class);
        $this->productLinkInterface = $this->createMock(ProductLinkInterface::class);

        $this->model = new Model(
            $this->importFactory,
            $this->file,
            $this->csvFactory,
            $this->readFactory,
            $this->output,
            $this->state,
            $this->productLinkInterfaceFactory,
            $this->productRepositoryInterface
        );
    }



    public function testExecuteShouldImportAndAssociateGroupedProductsWhenValidationSucceeds(): void
    {
        $iterationsOfImportDataConst = count(Model::IMPORT_DATA);
        $pathInfo = [
            'dirname' => 'path/to/file',
            'basename' => 'path/to/file'
        ];


        $this->importFactory->expects($this->exactly($iterationsOfImportDataConst))
            ->method('create')
            ->willReturn($this->import);

        $this->import->expects($this->exactly($iterationsOfImportDataConst))
            ->method('setData');

        $this->import->expects($this->exactly($iterationsOfImportDataConst))
            ->method('validateSource')
            ->willReturn(true);

        $this->file->expects($this->exactly($iterationsOfImportDataConst))
            ->method('getPathInfo')
            ->willReturn($pathInfo);

        $this->readFactory->expects($this->exactly($iterationsOfImportDataConst))
            ->method('create')
            ->willReturn($this->read);

        $this->csvFactory->expects($this->exactly($iterationsOfImportDataConst))
            ->method('create')
            ->willReturn($this->csv);

        $this->import->expects($this->exactly($iterationsOfImportDataConst))
            ->method('importSource')
            ->willReturn(true);

        $this->output->expects($this->exactly($iterationsOfImportDataConst))
            ->method('writeln');

        $this->import->expects($this->exactly($iterationsOfImportDataConst))
            ->method('invalidateIndex')
            ->willReturn(true);

        $this->state->expects($this->exactly(1))
            ->method('validateAreaCode')
            ->willReturn(false);

        $this->state->expects($this->exactly(1))
            ->method('setAreaCode')
            ->willReturn(true);

        $iterationsOfGroupedDataConst = count(Model::GROUPED_DATA);
        $iterationsOfGroupedDataSkus = $this->countGroupedDataConst();

        $this->productLinkInterfaceFactory->expects($this->exactly($iterationsOfGroupedDataSkus))
            ->method('create')
            ->willReturn($this->productLinkInterface);

        $this->productLinkInterface->expects($this->exactly($iterationsOfGroupedDataSkus))
            ->method('setSku')
            ->willReturnSelf();

        $this->productLinkInterface->expects($this->exactly($iterationsOfGroupedDataSkus))
            ->method('setLinkedProductSku')
            ->willReturnSelf();

        $this->productLinkInterface->expects($this->exactly($iterationsOfGroupedDataSkus))
            ->method('setLinkType')
            ->willReturnSelf();

        $this->productLinkInterface->expects($this->exactly($iterationsOfGroupedDataSkus))
            ->method('setLinkedProductType')
            ->willReturnSelf();

        $this->productRepositoryInterface->expects($this->exactly($iterationsOfGroupedDataConst))
            ->method('get')
            ->willReturn($this->productInterface);

        $this->productInterface->expects($this->exactly($iterationsOfGroupedDataConst))
            ->method('setProductLinks');

        $this->productRepositoryInterface->expects($this->exactly($iterationsOfGroupedDataConst))
            ->method('save')
            ->with($this->productInterface);

        $this->model->execute();
    }

    public function testExecuteShouldNotImportWhenValidationFails(): void
    {
        $iterationsOfImportDataConst = count(Model::IMPORT_DATA);
        $pathInfo = [
            'dirname' => 'path/to/file',
            'basename' => 'path/to/file'
        ];

        $this->importFactory->expects($this->exactly($iterationsOfImportDataConst))
            ->method('create')
            ->willReturn($this->import);

        $this->import->expects($this->exactly($iterationsOfImportDataConst))
            ->method('setData');

        $this->import->expects($this->exactly($iterationsOfImportDataConst))
            ->method('validateSource')
            ->willReturn(false);

        $this->file->expects($this->exactly($iterationsOfImportDataConst))
            ->method('getPathInfo')
            ->willReturn($pathInfo);

        $this->readFactory->expects($this->exactly($iterationsOfImportDataConst))
            ->method('create')
            ->willReturn($this->read);

        $this->csvFactory->expects($this->exactly($iterationsOfImportDataConst))
            ->method('create')
            ->willReturn($this->csv);

        $this->import->expects($this->never())
            ->method('importSource')
            ->willReturn(true);

        $this->output->expects($this->never())
            ->method('writeln');

        $this->import->expects($this->never())
            ->method('invalidateIndex');

        $iterationsOfGroupedDataConst = count(Model::GROUPED_DATA);
        $iterationsOfGroupedDataSkus = $this->countGroupedDataConst();

        $this->productLinkInterfaceFactory->expects($this->exactly($iterationsOfGroupedDataSkus))
            ->method('create')
            ->willReturn($this->productLinkInterface);

        $this->productLinkInterface->expects($this->exactly($iterationsOfGroupedDataSkus))
            ->method('setSku')
            ->willReturnSelf();

        $this->productLinkInterface->expects($this->exactly($iterationsOfGroupedDataSkus))
            ->method('setLinkedProductSku')
            ->willReturnSelf();

        $this->productLinkInterface->expects($this->exactly($iterationsOfGroupedDataSkus))
            ->method('setLinkType')
            ->willReturnSelf();

        $this->productLinkInterface->expects($this->exactly($iterationsOfGroupedDataSkus))
            ->method('setLinkedProductType')
            ->willReturnSelf();

        $this->productRepositoryInterface->expects($this->exactly($iterationsOfGroupedDataConst))
            ->method('get')
            ->willReturn($this->productInterface);

        $this->productInterface->expects($this->exactly($iterationsOfGroupedDataConst))
            ->method('setProductLinks');

        $this->productRepositoryInterface->expects($this->exactly($iterationsOfGroupedDataConst))
            ->method('save')
            ->with($this->productInterface);

        $this->model->execute();
    }



    private function countGroupedDataConst(): int
    {
        $totalCount = 0;
        foreach (model::GROUPED_DATA as $data) {
            $count = count($data['simpleSkus']);
            $totalCount = $totalCount + $count;
        }
        return $totalCount;
    }
}
