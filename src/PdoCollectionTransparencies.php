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
class PdoCollectionTransparencies
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
        fabric_transparency AS id,
        fabric_transparency
        FROM `$fabrics_table`
        WHERE collection_slug = :collection_name
        OR collection_name = :collection_name";

        $this->stmt = $pdo->prepare($sql);
    }


    /**
     * @param  string $collection_name Collection nameor slug
     * @return \ArrayIterator
     */
    public function __invoke(string $collection_name): iterable
    {
        $bool = $this->stmt->execute([
            ':collection_name' => $collection_name
        ]);

        $fabrics = $this->stmt->fetchAll(\PDO::FETCH_ASSOC);
        return new \ArrayIterator($fabrics);
    }
}
