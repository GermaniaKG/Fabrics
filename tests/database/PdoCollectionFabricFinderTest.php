<?php
namespace tests\Database;

use Germania\Fabrics\PdoCollectionFabricFinder;
use Germania\Fabrics\RepeatInterface;
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
	 * @dataProvider provideExistingFabricNumbers
     * @depends testInstantiation
	 */
	public function testExistingFabric( $fabric_number, $sut )
	{
        $result = $sut($fabric_number);

		$this->assertInstanceOf(FabricInterface::class, $result);

        if ($repeat = $result->getRepeat())
        {
            $this->assertInstanceOf(RepeatInterface::class, $repeat);
        }
	}

    public function provideExistingFabricNumbers() : array
    {
        $default = $GLOBALS['DEFAULT_FABRIC'];
        return array(
            $default => [ $GLOBALS['DEFAULT_FABRIC'] ],
            "4-4805" => [ "4-4805" ]
        );
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
