<?php

namespace Germania\Fabrics;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Psr\Log\LoggerAwareTrait;

/**
 * Fetches SINGLE fabric (Stoff) belonging to the predefined collection (Kollektion).
 */
class PdoCollectionFabricFinder implements FabricFactoryInterface
{
    use PleatsTablesTrait, FabricFactoryAwareTrait, LoggerAwareTrait;


    /**
     * @var string
     */
    public $default_collection_name;


    /**
     * @var \PDOStatement
     */
    public $stmt;


    /**
     * @param \PDO                 $pdo
     * @param string               $default_collection_name
     * @param string               $fabrics_table
     * @param string               $colors_table
     * @param string               $fabrics_colors_table
     * @param LoggerInterface|null $logger
     */
    public function __construct(\PDO $pdo, string $default_collection_name, string $fabrics_table, string $colors_table, string $fabrics_colors_table, LoggerInterface $logger = null)
    {
        $this->setFabricFactory( new FabricFactory );
        $this->setLogger($logger ?: new NullLogger());
        $this->default_collection_name = $default_collection_name;

        $fabric_fields = implode(",", array_map(function ($f) {
            return "F.$f";
        }, FabricInterface::FABRIC_FIELDS));

        //
        // Build SQL
        //
        $sql = "SELECT
        $fabric_fields

        -- Concatenated color names with space character
        -- (see nested SELECT below)
        , MMM.colors

        -- Concat assigned pleat widths with comma
        -- (as used with 'slat_available_widths' field)
        , GROUP_CONCAT(DISTINCT P.width SEPARATOR ',') AS pleat_available_widths

        FROM $fabrics_table F


        -- Make it filterable: 
        -- Concat assigned color names with space character
        LEFT JOIN
        (
          SELECT
            FC.fabric_id,
            GROUP_CONCAT(C.slug SEPARATOR ' ') AS colors
            FROM $fabrics_colors_table FC
            
            LEFT JOIN $colors_table C 
            ON C.id = FC.color_id
            
            GROUP BY FC.fabric_id

        ) MMM
          ON ( F.id = MMM.fabric_id )

        LEFT JOIN {$this->fabrics_pleats_table}  FP ON F.id = FP.fabric_id
        LEFT JOIN {$this->pleats_table}          P  ON FP.pleatwidth_id = P.id

        WHERE (F.collection_slug = :collection_name
           OR F.collection_name = :collection_name)
        AND F.fabric_number = :fabric_number

        GROUP BY F.id
        LIMIT 1";

        $this->stmt = $pdo->prepare($sql);
        $this->stmt->setFetchMode(\PDO::FETCH_ASSOC);
    }


    /**
     * @param  string       $fabric_number    Fabric number (Stoffnummer)
     * @param  string|null  $collection_name  Optional: Override collection
     * @throws FabricNotFoundException        When no fabric can be found
     *
     * @return FabricInterface
     */
    public function __invoke($fabric_number, string $collection_name = null): FabricInterface
    {
        $bool = $this->stmt->execute([
            ':collection_name' => $collection_name ?: $this->default_collection_name,
            ':fabric_number' => $fabric_number
        ]);

        $fabric = $this->stmt->fetch(\PDO::FETCH_ASSOC);
        if ($fabric) {
            return ($this->fabric_factory)($fabric);
        }

        $msg = sprintf("Fabric number '%s' does not exists in collection '%s'.", $fabric_number, $collection_name);
        throw new FabricNotFoundException($msg);
    }
}
