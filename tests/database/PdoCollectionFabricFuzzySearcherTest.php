<?php
namespace tests\Database;

use Germania\Fabrics\PdoCollectionFabricFuzzySearcher;
use Germania\Fabrics\FabricFactory;
use Germania\Fabrics\FabricFactoryInterface;
use Germania\Fabrics\FabricInterface;
use Germania\Fabrics\Fabric;

class PdoCollectionFabricFuzzySearcherTest extends \PHPUnit\Framework\TestCase
{
	public $pdo;

	public function setUp() : void
	{
		parent::setUp();
		$this->pdo = new \PDO( $GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'] );
	}

	public function testInstantiation()
	{
		$sut = new PdoCollectionFabricFuzzySearcher( $this->pdo,
			$GLOBALS['DEFAULT_COLLECTION'],
			$GLOBALS['FABRICS_TABLE'],
			$GLOBALS['COLORS_TABLE'],
			$GLOBALS['FABRICS_COLORS_TABLE']
		);

		$this->assertIsCallable($sut);

		return $sut;
	}


    /**
     * @depends testInstantiation
     */
    public function testPleatsTablesSetter( $sut )
    {
        $fluid = $sut->setPleatsTables(
            $GLOBALS['PLEATS_TABLE'],
            $GLOBALS['FABRICS_PLEATS_TABLE']
        );

        $this->assertEquals($fluid, $sut);

        return $sut;
    }


	/**
     * @dataProvider provideCollectionMethodArguments
	 * @depends testInstantiation
	 */
	public function testExistingFabric( $collection_slug, $search, $sort, $sut )
	{
		$result = $sut( $search, $collection_slug, $search, $sort );

		$this->assertIsIterable($result);
		$this->assertArrayHasKey($search, $result);
	}


    public function provideCollectionMethodArguments()
    {
        $fabric_number = $GLOBALS['DEFAULT_FABRIC'];
        $collection_slug = $GLOBALS['DEFAULT_COLLECTION'];

        return array(
            "$collection_slug/$fabric_number" => [ $collection_slug, $fabric_number, null ],
            "$collection_slug/$fabric_number/pattern" => [ $collection_slug, $fabric_number, "pattern" ],
        );
    }


	/**
	 * @depends testInstantiation
	 */
	public function testWithNotExistingFabric( $sut )
	{
		$result = $sut("WillNotExist");
		$this->assertEquals(0, iterator_count($result));
		$this->assertEquals(0, count($result));
	}


}
