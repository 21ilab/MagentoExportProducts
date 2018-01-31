<?php
/**
 * Created by Afroze.S.
 * Date: 30/1/18
 * Time: 12:07 PM
 */

namespace Twentyone\ExportProducts\Console;

use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Store\Model\StoreFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class ExportProductsCommand extends Command
{

    protected $path, $storeId, $attributes, $labels, $delimiter, $encapsulator, $collectionFactory;

    /**
     * Inject CollectionFactory(products) so to query products of magento and filter
     *
     * ExportProductsCommand constructor.
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(CollectionFactory $collectionFactory) {
        $this->collectionFactory = $collectionFactory;
        parent::__construct();
    }

    /**
     * Configure console command and arguments and options required
     */
    protected function configure() {
        $this->setName('Twentyone:ExportProducts');
        $this->setDescription('Export products from magento catalog');
        $this->setHelp("This command helps to export products in CSV format");
        $this->addArgument('path', InputArgument::REQUIRED, 'Path to save csv file');
        $this->addArgument('store', InputArgument::REQUIRED, 'Magento store');
        $this->addArgument('attributes', InputArgument::REQUIRED, 'Magento produt attribtes');
        $this->addArgument('labels', InputArgument::REQUIRED, 'Labels to be used in CSV');
        $this->addArgument('delimiter', InputArgument::REQUIRED, 'Delimiter to be used in CSV');
        $this->addArgument('encapsulator', InputArgument::REQUIRED, 'Encapsulator');
    }

    /**
     * This function is executed after the console command is types in terminal
     * get the user entered arguments and options and do the magic
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output) {
        $attributes = $input->getArgument('attributes');
        $this->path = $input->getArgument('path');
        $this->storeId = $input->getArgument('store');
        $this->attributes = $input->getArgument('attributes');
        $this->labels = $input->getArgument('labels');
        $this->delimiter = $input->getArgument('delimiter');
        $this->encapsulator = $input->getArgument('encapsulator');
        $this->getProducts($this->storeId);
        var_dump(get_class($this->getStore()));
        $output->writeln(explode(',', $attributes));
        $output->writeln("test");
    }

    /**
     * Get products by store ID
     * from CollectionFactory and return Collection of products
     *
     * @param int $storeId
     * @return Collection
     */
    private function getProducts($storeId) {
        $collection = $this->collectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->addStoreFilter($storeId);
        /*
        $collection->setPage(1, 2);
        foreach ($collection as $product) {
            var_dump($product->getData());die;
            //
        }
        */
        return $collection;
    }

}