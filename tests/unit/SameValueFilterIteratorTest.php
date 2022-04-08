<?php
namespace tests;

use Germania\Fabrics\SameValueFilterIterator;

class SameValueFilterIteratorTest extends  \PHPUnit\Framework\TestCase
{
    public function testInstantiation()
    {
        $sut = new SameValueFilterIterator( new \EmptyIterator, "field", "search" );
        $this->assertInstanceOf( \FilterIterator::class, $sut);
        return $sut;
    }

}
