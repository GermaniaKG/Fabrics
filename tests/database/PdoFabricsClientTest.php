<?php
namespace tests\Database;

use Germania\Fabrics\PdoFabricsClient;
use Germania\Fabrics\FabricsClientInterface;
use Germania\Fabrics\FabricInterface;

class PdoFabricsClientTest extends \PHPUnit\Framework\TestCase
{
    public $pdo;

    public function setUp() : void
    {
        parent::setUp();
        $this->pdo = new \PDO( $GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'] );
    }

    public function testInstantiation()
    {
        $sut = new PdoFabricsClient(
            $this->pdo,
            $GLOBALS['FABRICS_TABLE'],
            $GLOBALS['COLORS_TABLE'],
            $GLOBALS['FABRICS_COLORS_TABLE']
        );

        $this->assertInstanceOf(FabricsClientInterface::class, $sut);

        return $sut;
    }


    /**
     * @depends testInstantiation
     */
    public function testReadAllCollections($sut )
    {
        $result = $sut->collections();
        $this->assertIsIterable($result);
    }


    /**
     * @dataProvider provideCollectionMethodArguments
     * @depends testInstantiation
     */
    public function testReadAllFabrics( $collection_slug, $search, $sort, $sut )
    {
        $result = $sut->collection( $collection_slug, $search, $sort );
        $this->assertIsIterable($result);
    }



    public function provideCollectionMethodArguments()
    {
        $collection_slug = $GLOBALS['DEFAULT_COLLECTION'];
        return array(
            "$collection_slug only" => [ $collection_slug, null,    null ],
            "$collection_slug Alago / no pattern" => [ $collection_slug, "Alago", null ],
            "$collection_slug with pattern" => [ $collection_slug, null,    "pattern" ],
        );
    }


    /**
     * @depends testInstantiation
     */
    public function testRetrieveTransparenciesUsedInCollection( $sut )
    {
        $collection_slug = $GLOBALS['DEFAULT_COLLECTION'];
        $result = $sut->collectionTransparencies( $collection_slug );

        $this->assertIsIterable($result);
    }



    /**
     * @depends testInstantiation
     */
    public function testRetrieveColorsUsedInCollection( $sut )
    {
        $collection_slug = $GLOBALS['DEFAULT_COLLECTION'];
        $result = $sut->collectionColors( $collection_slug );

        $this->assertIsIterable($result);
    }



    /**
     * @depends testInstantiation
     */
    public function testRetrieveSingleFabric( $sut )
    {
        $collection_slug = $GLOBALS['DEFAULT_COLLECTION'];
        $fabric_number = $GLOBALS['DEFAULT_FABRIC'];
        $result = $sut->fabric( $collection_slug, $fabric_number );

        $this->assertInstanceOf(FabricInterface::class, $result);
    }


    /**
     * @depends testInstantiation
     */
    public function testWithNotExistingCollectionName( $sut )
    {
        $result = $sut->collection( "Will not exist" );

        $this->assertEquals(0, iterator_count($result));
        $this->assertEquals(0, count($result));
    }


}
