<?php
namespace tests\Unit;

use Germania\Fabrics;

class RepeatTest extends  \PHPUnit\Framework\TestCase
{

    public function testInstantiation() : Fabrics\RepeatInterface {
        $sut = new Fabrics\Repeat;

        $this->assertInstanceOf(Fabrics\RepeatInterface::class, $sut);
        $this->assertInstanceOf(\JsonSerializable::class, $sut);

        return $sut;
    }
}
