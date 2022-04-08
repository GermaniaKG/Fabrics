<?php
namespace tests\Unit;

use Germania\Fabrics\EnabledFabricsFilterIterator;

class EnabledFabricsFilterIteratorTest extends  \PHPUnit\Framework\TestCase
{
    public function testInstantiation()
    {
        $sut = new EnabledFabricsFilterIterator( new \EmptyIterator );
        $this->assertInstanceOf( \FilterIterator::class, $sut);
        return $sut;
    }

    /**
     * @dataProvider provideVariousKindsOfFabricData
     */
    public function testWithArray( $fabrics, $expected_count)
    {
        $sut = new EnabledFabricsFilterIterator( $fabrics );
        $this->assertEquals( $expected_count, iterator_count($sut));
        return $sut;
    }

    public function provideVariousKindsOfFabricData()
    {
        return array(
            'array:       enabled => TRUE'  => [ new \ArrayIterator([array('enabled' => true)]),                1],
            'StdClass:    enabled => TRUE'  => [ new \ArrayIterator([(object) [ 'enabled' => true ]]),          1],
            'ArrayObject: enabled => TRUE'  => [ new \ArrayIterator([new \ArrayObject([ 'enabled' => true ])]), 1],

            'array:       enabled => FALSE'  => [ new \ArrayIterator([array('enabled' => false)]),                0],
            'StdClass:    enabled => FALSE'  => [ new \ArrayIterator([(object) [ 'enabled' => false ]]),          0],
            'ArrayObject: enabled => FALSE'  => [ new \ArrayIterator([new \ArrayObject([ 'enabled' => false ])]), 0],
        );
    }

}
