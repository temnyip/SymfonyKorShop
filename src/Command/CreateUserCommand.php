<?php


namespace App\Command;


use App\Controller\Product\ParseProductController;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUserCommand extends Command
{
    private $productController;

    protected static $defaultName = 'app:update-empty';

    public function __construct(ParseProductController $productController)
    {
        $this->productController = $productController;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('added a new product.')
            ->setHelp('this command allows you to create a product...');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->productController->parseEmptyCells();
    }
}