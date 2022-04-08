<?php
namespace tests\Database;

use Germania\Fabrics\PdoCollectionFabricFinder;
use Germania\Fabrics\FabricInterface;
use Germania\Fabrics\FabricNotFoundException;
use Germania\Fabrics\FabricFactoryInterface;

class PdoCollectionFabricFinderTest extends \PHPUnit\Framework\TestCase
{
	public $pdo;

	public function setUp() : void 
	{
		parent::setUp();
		$this->pdo = new \PDO( $GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'] );
	}

	public function testInstantiation()
	{
		$sut = new PdoCollectionFabricFinder( $this->pdo, 
			$GLOBALS['DEFAULT_COLLECTION'],
			$GLOBALS['FABRICS_TABLE'],
			$GLOBALS['COLORS_TABLE'],
			$GLOBALS['FABRICS_COLORS_TABLE']
		);

		$this->assertIsCallable($sut);
		$this->assertInstanceOf(FabricFactoryInterface::class, $sut);

		return $sut;
	}

	/**
	 * @depends testInstantiation
	 */
	public function testExistingFabric( $sut )
	{
        $fabric_number = $GLOBALS['DEFAULT_FABRIC'];
        $result = $sut($fabric_number);

		$this->assertInstanceOf(FabricInterface::class, $result);
	}

	/**
	 * @depends testInstantiation
	 */
	public function testWithNotExistingFabric( $sut )
	{
		$this->expectException( FabricNotFoundException::class );
		$result = $sut("WillNotExist");
	}


}
