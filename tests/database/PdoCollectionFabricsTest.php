<?php
namespace tests\Database;

use Germania\Fabrics\PdoCollectionFabrics;

class PdoCollectionFabricsTest extends \PHPUnit\Framework\TestCase
{
	public $pdo;

	public function setUp() : void 
	{
		parent::setUp();
		$this->pdo = new \PDO( $GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'] );
	}

	public function testInstantiation()
	{
		$sut = new PdoCollectionFabrics( $this->pdo, 
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
	 * @depends testInstantiation
	 */
	public function testExistingCollectionName( $sut )
	{
		$collection_slug = $GLOBALS['DEFAULT_COLLECTION'];
		$result = $sut( $collection_slug );

		$this->assertIsIterable($result);
	}



	/**
	 * @depends testInstantiation
	 */
	public function testWithNotExistingCollectionName( $sut )
	{
		$result = $sut( "Will not exist" );

		$this->assertEquals(0, iterator_count($result));
		$this->assertEquals(0, count($result));
	}


}
