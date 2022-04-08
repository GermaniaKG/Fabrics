<?php
namespace tests\Database;

use Germania\Fabrics\PdoCollectionsInUse;

class PdoCollectionsInUseTest extends \PHPUnit\Framework\TestCase
{
    public $pdo;

    public function setUp() : void
    {
        parent::setUp();
        $this->pdo = new \PDO( $GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'] );
    }

    public function testInstantiation()
    {
        $sut = new PdoCollectionsInUse( $this->pdo,
            $GLOBALS['FABRICS_TABLE']
        );

        $this->assertIsCallable($sut);

        return $sut;
    }

    /**
     * @depends testInstantiation
     */
    public function testInvokation( $sut )
    {
        $result = $sut();

        $this->assertIsIterable($result);
    }



}
