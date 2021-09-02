<?php
namespace Webjump\IBCBackend\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Webjump\IBCBackend\Model\Product\AddProducts;
use Magento\Framework\Console\Cli;

Class AddProductsCommand extends Command
{
    const INPUT_KEY_NAME = 'name';
    const INPUT_KEY_DESCRIPTION = 'description';

    private AddProducts $itemFactory;

    public function __construct(AddProducts $itemFactory)
    {
        $this->itemFactory = $itemFactory;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('ibc:backend');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $item = $this->itemFactory->importProducts();
        var_dump($item);
        return Cli::RETURN_SUCCESS;
    }
}
