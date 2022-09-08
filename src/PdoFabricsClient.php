<?php

namespace Germania\Fabrics;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Psr\Log\LoggerAwareTrait;

class PdoFabricsClient implements FabricsClientInterface
{
    use LoggerAwareTrait;


    /**
     * @var \PDO
     */
    public $pdo;

    /**
     * @var string
     */
    public $fabrics_table;

    /**
     * @var string
     */
    public $colors_table;

    /**
     * @var string
     */
    public $fabrics_colors_table;


    /**
     * @var PdoCollectionFabricFinder|null
     */
    protected $fabric_finder;

    /**
     * @var PdoCollectionFabrics|null
     */
    protected $collection_reader;

    /**
     * @var PdoCollectionsInUse|null
     */
    protected $collections_in_use_reader;

    /**
     * @var PdoCollectionFabricFuzzySearcher|null
     */
    protected $collection_searcher;

    /**
     * @var PdoCollectionColors|null
     */
    protected $colors_reader;

    /**
     * @var PdoCollectionTransparencies|null
     */
    protected $transparencies_reader;



    /**
     * @param \PDO                 $pdo                  PDO handler
     * @param string               $fabrics_table        Fabrics table name
     * @param string               $colors_table         Colors table name
     * @param string               $fabrics_colors_table Fabrics and Colors assigments table
     * @param LoggerInterface|null $logger               Optional: PSR-3 Logger
     */
    public function __construct(\PDO $pdo, string $fabrics_table, string $colors_table, string $fabrics_colors_table, LoggerInterface $logger = null)
    {
        $this->pdo = $pdo;
        $this->fabrics_table = $fabrics_table;
        $this->colors_table = $colors_table;
        $this->fabrics_colors_table = $fabrics_colors_table;

        $this->setLogger($logger ?: new NullLogger());
    }



    /**
     * Retrieve all collections in use
     *
     * @inheritDoc
     */
    public function collections(): iterable
    {
        $collections_in_use_reader = $this->getCollectionsInUseReader();
        return $collections_in_use_reader();
    }


    /**
     * Retrieve all fabrics belonging to the given collection.
     *
     * @inheritDoc
     */
    public function collection(string $collection, string $search = null, string $sort = null): iterable
    {
        if (empty($search)) {
            $collection_reader = $this->getCollectionReader();
            return $collection_reader($collection, $sort);
        }

        $collection_reader = $this->getCollectionSearcher();
        return $collection_reader($search, $collection, $sort);
    }


    /**
     * Retrieves all fabric transparencies belonging to the given collection.
     *
     * @inheritDoc
     */
    public function collectionTransparencies(string $collection): iterable
    {
        $transparencies_reader = $this->getTransparenciesReader();
        return $transparencies_reader($collection);
    }


    /**
     * Retrieves all color groups belonging to the given collection.
     *
     * @inheritDoc
     */
    public function collectionColors(string $collection): iterable
    {
        $colors_reader = $this->getColorsReader();
        return $colors_reader($collection);
    }


    /**
     * Retrieves a single fabric from a given collection.
     *
     * @inheritDoc
     */
    public function fabric(string $collection, string $fabric_number): FabricInterface
    {
        $fabric_finder = $this->getFabricFinder();
        return $fabric_finder($fabric_number, $collection);
    }






    protected function getTransparenciesReader(): PdoCollectionTransparencies
    {
        if (!$this->transparencies_reader):
            $this->transparencies_reader = new PdoCollectionTransparencies(
                $this->pdo,
                $this->fabrics_table,
                $this->logger
            );
        endif;

        return $this->transparencies_reader;
    }


    protected function getColorsReader(): PdoCollectionColors
    {
        if (!$this->colors_reader):
            $this->colors_reader = new PdoCollectionColors(
                $this->pdo,
                $this->fabrics_table,
                $this->colors_table,
                $this->fabrics_colors_table,
                $this->logger
            );
        endif;

        return $this->colors_reader;
    }



    protected function getFabricFinder(): PdoCollectionFabricFinder
    {
        if (!$this->fabric_finder):
            $this->fabric_finder = new PdoCollectionFabricFinder(
                $this->pdo,
                "defaultCollection", // Just to feed the ctor argument
                $this->fabrics_table,
                $this->colors_table,
                $this->fabrics_colors_table,
                $this->logger
            );
        endif;

        return $this->fabric_finder;
    }


    protected function getCollectionsInUseReader(): PdoCollectionsInUse
    {
        if (!$this->collections_in_use_reader):
            $this->collections_in_use_reader = new PdoCollectionsInUse(
                $this->pdo,
                $this->fabrics_table,
                $this->logger
            );
        endif;

        return $this->collections_in_use_reader;
    }


    protected function getCollectionReader(): PdoCollectionFabrics
    {
        if (!$this->collection_reader):
            $this->collection_reader = new PdoCollectionFabrics(
                $this->pdo,
                $this->fabrics_table,
                $this->colors_table,
                $this->fabrics_colors_table,
                $this->logger
            );
        endif;

        return $this->collection_reader;
    }


    protected function getCollectionSearcher(): PdoCollectionFabricFuzzySearcher
    {
        if (!$this->collection_searcher):
            $this->collection_searcher = new PdoCollectionFabricFuzzySearcher(
                $this->pdo,
                "defaultCollection", // Just to feed the ctor argument
                $this->fabrics_table,
                $this->colors_table,
                $this->fabrics_colors_table,
                $this->logger
            );
        endif;

        return $this->collection_searcher;
    }
}
