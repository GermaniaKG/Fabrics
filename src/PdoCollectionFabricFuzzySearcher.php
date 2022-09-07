<?php

namespace Germania\Fabrics;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Psr\Log\LoggerAwareTrait;

/**
 * Fetches any fabric (Stoff) that matches a given search term.
 *
 * The result will be an ArrayIterator with keys indexed by fabric_number.
 */
class PdoCollectionFabricFuzzySearcher
{
    use PleatsTablesTrait;
    use LoggerAwareTrait;


    /**
     * @var string
     */
    public $default_collection_name;


    /**
     * @var FQDN
     */
    public $php_fabric_class = Fabric::class;

    /**
     * @var \PDOStatement
     */
    public $stmt;




    public function __construct(\PDO $pdo, string $default_collection_name, string $fabrics_table, string $colors_table, string $fabrics_colors_table, LoggerInterface $logger = null)
    {
        $this->setLogger($logger ?: new NullLogger());
        $this->default_collection_name = $default_collection_name;

        $fabric_fields = implode(",", array_map(function ($f) {
            return "F.$f";
        }, FabricInterface::FABRIC_FIELDS));


        //
        // Build SQL
        //
        $sql = "SELECT
        -- Used for array keys
        F.fabric_number,
        $fabric_fields

        -- Make it filterable:
        -- Concat assigned color names with space character
        , GROUP_CONCAT(DISTINCT C.slug SEPARATOR ' ') AS colors
        -- Concat assigned pleat widths with comma
        -- (as used with 'slat_available_widths' field)
        , GROUP_CONCAT(DISTINCT P.width SEPARATOR ',') AS pleat_available_widths


        FROM $fabrics_table F
        LEFT JOIN $fabrics_colors_table FC   ON F.id = FC.fabric_id
        LEFT JOIN $colors_table         C    ON FC.color_id = C.id

        LEFT JOIN {$this->fabrics_pleats_table}  FP ON F.id = FP.fabric_id
        LEFT JOIN {$this->pleats_table}          P  ON FP.pleatwidth_id = P.id

        WHERE (F.collection_slug = :collection_name
           OR F.collection_name = :collection_name)
        AND (  F.fabric_number            LIKE concat('%', :search, '%')
            OR F.fabric_name              LIKE concat('%', :search, '%')
            OR F.pattern                  LIKE concat('%', :search, '%')
            OR F.keywords                 LIKE concat('%', :search, '%')
            OR F.fabric_lieferschein_name LIKE concat('%', :search, '%')
            OR F.fabric_transparency      LIKE concat('%', :search, '%')
            -- OR colors                     LIKE concat('%', :search, '%')
        )
        -- This line is important
        GROUP BY F.id";

        $this->stmt = $pdo->prepare($sql);
        $this->stmt->setFetchMode(\PDO::FETCH_CLASS, $this->php_fabric_class);
    }


    /**
     * @param  string $search           Search term
     * @param  string $collection_name  Collection name
     * @param  string $sort_field       Optional: Sort field
     *
     * @return \ArrayIterator
     */
    public function __invoke(string $search, string $collection_name = null, string $sort_field = null): iterable
    {
        $bool = $this->stmt->execute([
            ':collection_name' => $collection_name ?: $this->default_collection_name,
            ':search' => $search
        ]);

        $fabrics = $this->stmt->fetchAll(\PDO::FETCH_UNIQUE);

        return empty($sort_field)
        ? new \ArrayIterator($fabrics)
        : SortedArrayIterator::fromArray($fabrics, $sort_field);
    }
}
