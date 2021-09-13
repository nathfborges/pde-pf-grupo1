<?php
namespace Webjump\IBCBackend\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Webjump\IBCBackend\Model\Product\AddProducts;
use Magento\Framework\Console\Cli;

/** @codeCoverageIgnore */
Class AddProductsCommand extends Command
{
    private AddProducts $addProducts;

    public function __construct(AddProducts $addProducts)
    {
        $this->addProducts = $addProducts;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('ibc:csv:products');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->addProducts->execute();
        return Cli::RETURN_SUCCESS;
    }
}

