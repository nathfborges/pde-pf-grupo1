<?php
namespace Webjump\IBCBackend\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Mastering\SampleModule\Model\ItemFactory;
use Magento\Framework\Console\Cli;
use Webjump\IBCBackend\Setup\Patch\Data\InstallCategories;


Class Apply extends Command
{

    private InstallCategories $installCategories;

    public function __construct(InstallCategories $installCategories)
    {
        $this->installCategories = $installCategories;
        parent::__construct();
    }

    public function configure()
    {
        $this->setName('ibc:category:add');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->installCategories->apply();
        return Cli::RETURN_SUCCESS;
    }
}
