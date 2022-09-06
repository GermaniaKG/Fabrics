<?php
namespace tests\Unit;

use Germania\Fabrics;

class RepeatFactoryTest extends  \PHPUnit\Framework\TestCase
{
    public function testInstantiation() : Fabrics\RepeatFactory
    {
        $sut = new Fabrics\RepeatFactory;

        $this->assertIsCallable($sut);

        return $sut;
    }

    /**
     * @dataProvider provideRepeatData
     * @depends testInstantiation
     */
    public function testFactoryMethod( array $repeat_data, $sut ) : void
    {
        $result = $sut($repeat_data);

        $this->assertInstanceOf(Fabrics\RepeatInterface::class, $result);

        $this->assertEquals($result->getWidth(), $repeat_data['repeat_width']);
        $this->assertEquals($result->getHeight(), $repeat_data['repeat_height']);
        $this->assertEquals($result->getType(), $repeat_data['repeat_type']);
    }

    public function provideRepeatData() : array
    {
        return array(
            'Null-repeat' => [ array('repeat_width' => null, 'repeat_height' => null, 'repeat_type' => null) ],
            'Simple repeat' => [ array('repeat_width' => 1000, 'repeat_height' => 2000, 'repeat_type' => "allover") ],
        );
    }

}
