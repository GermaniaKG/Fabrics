<img src="https://static.germania-kg.com/logos/ga-logo-2016-web.svgz" width="250px">

------




# Germania KG · Fabrics



## Interfaces and classes

### Basics

- FabricInterface
- FabricAbstract
- Fabric

### FabricsClientInterface

See [**PdoFabricsClient**](#PdoFabricsClient) for an implementation using PDO database.

```php
<?php
namespace Germania\Fabrics;

interface FabricsClientInterface
{

    /**
     * Retrieve all fabrics belonging to the given collection.
     *
     * @param  string        $collection   URL slug of a Germania Fabrics Collection
     * @param  string|null   $search       Optional: search term
     * @param  string|null   $sort         Optional: sort by field(s), string or CSV string
     * @return iterable|FabricInterface[]  Iterable with FabricInterface instances
     */
    public function collection( string $collection, string $search = null, string $sort = null) : iterable;


    /**
     * Retrieves all fabric transparencies belonging to the given collection.
     *
     * @param  string        $collection   URL slug of a Germania Fabrics Collection
     * @return iterable|FabricInterface[]  Iterable with FabricInterface instances
     */
    public function collectionTransparencies( string $collection) : iterable;


    /**
     * Retrieves all color groups belonging to the given collection.
     *
     * @param  string        $collection   URL slug of a Germania Fabrics Collection
     * @return iterable|FabricInterface[]  Iterable with FabricInterface instances
     */
    public function collectionColors( string $collection) : iterable;


    /**
     * Retrieves a single fabric from a given collection.
     *
     * @param  string $collection     URL slug of a Germania Fabrics Collection
     * @param  string $fabric_number  Fabric number
     * @return FabricInterface
     */
    public function fabric( string $collection, string $fabric_number ) : FabricInterface;
}

```





## Factory

```php
<?php
use Germania\Fabrics\FabricFactory;

$factory = new FabricFactory;

$fabric = $factory( [
	'fabric_number' => "1234",
  'collection_slug' => "someCollection"
]);
```

Per default, the factory creates instances of `Germania\Fabrics\Fabric`. You may override the class with a constructor parameter:

```php
use MyApp\SepcialFabric;
$factory = new FabricFactory( SepcialFabric::class );
```





## Decorator

Any concrete Decator class extended from **FabricDecoratorAbstract** implements *FabricInterface* and accepts any *FabricInterface* instance in constructor:

```php
<?php
use Germania\Fabrics\Fabric;
use Germania\Fabrics\FabricDecoratorAbstract;

class MyDecorator extends FabricDecoratorAbstract
{
  // ...
}

$fabric = new Fabric;
$my_fabric = new MyDecorator( $fabric );
```





## Filter iterators

Filter the ArrayIterators from *PdoCollectionFabrics* and *PdoCollectionFabricFuzzySearcher*:

```php
<?php
use Germania\Fabrics\PhotoNotEmptyFilterIterator;
use Germania\Fabrics\SameValueFilterIterator,
use Germania\Fabrics\LieferbarFabricsFilterIterator;
use Germania\Fabrics\EnabledFabricsFilterIterator;
```



## PdoFabricsClient

The **PdoFabricsClient** implements *[FabricsClientInterface](#FabricsClientInterface)*. Its constructor accepts an optional PSR-3 Logger.

```php
<?php
use Germania\Fabrics\PdoFabricsClient;

$pdo = ... // Your PDO handler
$fabrics_table = "germania_fabrics";
$colors_table = "germania_color_groups";
$fabrics_colors_table = "germania_fabrics_colors";
$logger = // optional

$client = new PdoFabricsClient(
  $pdo, 
  $fabrics_table, 
  $colors_table, 
  $fabrics_colors_table, 
  $logger);
```

**As of Release v4.5**, the class provides a `collections` method:

```php
$collections = $client->collections();
print_r($collections);

//ArrayIterator Object
//(
//    [storage:ArrayIterator:private] => Array
//        (
//            [duette2014] => Array
//                (
//                    [collection_slug] => duette2014
//                    [collection_name] => DU-2014
//                    [fabrics_count] => 33
//                )
//            [jalousie2016] => Array
//                (
//                    [collection_slug] => jalousie2016
//                    [collection_name] => JAL-2016
//                    [fabrics_count] => 177
//                )
```





## Unit tests

Copy `phpunit.xml.dist` to `phpunit.xml` and adapt to your needs. Run [PhpUnit](https://phpunit.de/) test or composer scripts like this:

```bash
$ composer test:unit
$ composer test:database
```

