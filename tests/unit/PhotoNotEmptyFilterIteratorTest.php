<?php
namespace tests\Unit;

use Germania\Fabrics\PhotoNotEmptyFilterIterator;

class PhotoNotEmptyFilterIteratorTest extends  \PHPUnit\Framework\TestCase
{
    public function testInstantiation()
    {
        $sut = new PhotoNotEmptyFilterIterator( new \EmptyIterator );
        $this->assertInstanceOf( \FilterIterator::class, $sut);
        return $sut;
    }

}
