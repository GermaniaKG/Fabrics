<?php
namespace tests\Database;

use Germania\Fabrics\PdoCollectionTransparencies;

class PdoCollectionTransparenciesTest extends \PHPUnit\Framework\TestCase
{
    public $pdo;

    public function setUp() : void
    {
        parent::setUp();
        $this->pdo = new \PDO( $GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'] );
    }

    public function testInstantiation()
    {
        $sut = new PdoCollectionTransparencies( 
            $this->pdo,
            $GLOBALS['FABRICS_TABLE']
        );

        $this->assertIsCallable($sut);

        return $sut;
    }

    /**
     * @depends testInstantiation
     */
    public function testExistingCollectionName( $sut )
    {
        $collection_slug = $GLOBALS['DEFAULT_COLLECTION'];
        $result = $sut( $collection_slug );

        $this->assertIsIterable($result);
    }

    /**
     * @depends testInstantiation
     */
    public function testWithNotExistingCollectionName( $sut )
    {
        $result = $sut( "Will not exist" );

        $this->assertEquals(0, iterator_count($result));
        $this->assertEquals(0, count($result));
    }


}
