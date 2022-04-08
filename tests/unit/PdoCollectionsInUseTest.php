<?php
namespace tests\Unit;

use tests\MockPdoTrait;
use Germania\Fabrics\PdoCollectionsInUse;


class PdoCollectionsInUseTest extends \PHPUnit\Framework\TestCase 
{
    use MockPdoTrait;

	public function testInstantiation()
	{
		$pdo = $this->createMockPdo();

		$sut = new PdoCollectionsInUse( $pdo, "fabrics_table");
		// $sut = new PdoCollectionsInUse( $pdo, "fabrics_table", "colors_table", "fabrics_colors_table");

		$this->assertIsCallable($sut);

		return $sut;
	}	
}