<?php
namespace tests\Unit;

use Germania\Fabrics\FabricFactory;
use Germania\Fabrics\FabricFactoryInterface;
use Germania\Fabrics\FabricInterface;
use Germania\Fabrics\Fabric;
use Germania\Fabrics\FabricInvalidArgumentException;
use Germania\Fabrics\FabricExceptionInterface;

class FabricFactoryTest extends  \PHPUnit\Framework\TestCase
{
	public function testInstantiation()
	{
		$sut = new FabricFactory;
		$this->assertInstanceOf( FabricFactoryInterface::class, $sut);
		return $sut;
	}

	/**
	 * @dataProvider provideInvalidFactoryData
	 * @depends testInstantiation
	 */
	public function testInvalidArgumentException( $invalidData, $sut )
	{
		$this->expectException( FabricExceptionInterface::class );
		$this->expectException( FabricInvalidArgumentException::class );
		$sut( 1 );
	}

	public function provideInvalidFactoryData()
	{
		return array(
			[ 1 ],
			[ "string" ]
		);
	}


	/**
	 * @dataProvider provideFactoryData
	 * @depends testInstantiation
	 * 
	 */
	public function testFabricMethodWithVariousDataTypes( $data, $sut )
	{
		$result = $sut($data);
		$this->assertInstanceOf(FabricInterface::class, $result);
	}

	public function provideFactoryData()
	{
		return array(
			"with fabric_number" => [ array('fabric_number' => '1-2345') ],
            "with fabricNumber" => [ array('fabricNumber' => '1-2345') ],
			"Fabric instance mock" => [ ($this->prophesize( Fabric::class ))->reveal() ],
			"FabricInterface mock" =>[ ($this->prophesize( FabricInterface::class ))->reveal() ],
		);
	}

}
