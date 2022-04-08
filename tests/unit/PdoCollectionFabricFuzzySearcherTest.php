<?php
namespace tests\Unit;

use tests\MockPdoTrait;
use Germania\Fabrics\PdoCollectionFabricFuzzySearcher;


class PdoCollectionFabricFuzzySearcherTest extends \PHPUnit\Framework\TestCase 
{
    use MockPdoTrait;

	public function testInstantiation()
	{
		$pdo = $this->createMockPdo();

		$sut = new PdoCollectionFabricFuzzySearcher( $pdo, "default_collection", "fabrics_table", "colors_table", "fabrics_colors_table");

		$this->assertIsCallable($sut);

		return $sut;
	}	
}