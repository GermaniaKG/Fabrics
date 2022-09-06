<?php

namespace Germania\Fabrics;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Psr\Log\LoggerAwareTrait;

/**
 * Fetches ALL fabrics (Stoffe) belonging to a certain collection (Kollektion).
 *
 * The result will be an ArrayIterator with keys indexed by fabric_number.
 */
class PdoCollectionsInUse
{
    use LoggerAwareTrait;


    /**
     * @var \PDOStatement
     */
    public $stmt;




    /**
     * @param \PDO                 $pdo
     * @param string               $fabrics_table
     * @param LoggerInterface|null $logger
     */
    public function __construct(\PDO $pdo, string $fabrics_table, LoggerInterface $logger = null)
    {
        $this->setLogger($logger ?: new NullLogger());

        $sql = "SELECT DISTINCT
        C.collection_slug,
        C.collection_slug,
        C.collection_name,
        COUNT(*) AS fabrics_count

        FROM `$fabrics_table` C
        WHERE C.enabled > 0
        GROUP BY C.collection_slug";

        $this->stmt = $pdo->prepare($sql);
    }


    /**
     * @return \ArrayIterator
     */
    public function __invoke(): iterable
    {
        $bool = $this->stmt->execute();

        $collections = $this->stmt->fetchAll(\PDO::FETCH_ASSOC | \PDO::FETCH_UNIQUE);
        return new \ArrayIterator($collections);
    }
}
