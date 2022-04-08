<?php
namespace tests\Unit;

use Germania\Fabrics\LieferbarFabricsFilterIterator;

class LieferbarFabricsFilterIteratorTest extends  \PHPUnit\Framework\TestCase
{
    public function testInstantiation()
    {
        $sut = new LieferbarFabricsFilterIterator( new \EmptyIterator );
        $this->assertInstanceOf( \FilterIterator::class, $sut);
        return $sut;
    }

}
