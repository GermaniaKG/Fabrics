<?php
namespace tests\Unit;

use tests\MockPdoTrait;
use Germania\Fabrics\PdoFabricsClient;
use Germania\Fabrics\FabricsClientInterface;

class PdoFabricsClientTest extends \PHPUnit\Framework\TestCase 
{
    use MockPdoTrait;

	public function testInstantiation()
	{
		$pdo = $this->createMockPdo();

		$sut = new PdoFabricsClient( $pdo, "fabrics_table", "colors_table", "fabrics_colors_table");

		$this->assertInstanceOf(FabricsClientInterface::class, $sut);

		return $sut;
	}	
}