<?php
namespace Webjump\IBCBackend\Console\Command;

use Magento\Setup\Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Webjump\IBCBackend\Model\Product\Importer;
use Magento\Framework\Console\Cli;

Class ImporterCommand extends Command
{
    private Importer $importer;

    public function __construct(Importer $importer)
    {
        $this->importer = $importer;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('ibc:csv:products');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $item = $this->importer->execute();
        return Cli::RETURN_SUCCESS;
    }
}

