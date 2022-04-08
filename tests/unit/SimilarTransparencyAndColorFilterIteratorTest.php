<?php
namespace tests\Unit;

use Germania\Fabrics\SimilarTransparencyAndColorFilterIterator;

class SimilarTransparencyAndColorFilterIteratorTest extends  \PHPUnit\Framework\TestCase
{
    public function testInstantiation()
    {
        $sut = new SimilarTransparencyAndColorFilterIterator( new \EmptyIterator, "transparency", "color" );
        $this->assertInstanceOf( \FilterIterator::class, $sut);
        return $sut;
    }

}
