<?php
namespace Germania\Fabrics;

class SortedArrayIterator extends \ArrayIterator
{


    public static function fromIterator( \Traversable $items, string $field, bool $ascending = true)
    {
        $items = iterator_to_array( new \IteratorIterator($items) );
        return static::fromArray($items, $field, $ascending);
    }


    public static function fromIterable( iterable $items, string $field, bool $ascending = true)
    {
        if ($items instanceOf \Traversable ) {
            return static::fromIterator($items, $field, $ascending);
        }
        if (!is_array($items)) {
            throw new \InvalidArgumentException("Iterable, Array or Traversable expected", 1);
        }
        return static::fromArray($items, $field, $ascending);
    }


    public static function fromArray( array $items, string $field, bool $ascending = true)
    {
        $sorted = new static( $items );
        $sorted->uasort(function($a, $b) use ($field, $ascending) {
            if ($a->{$field} == $b->{$field}) {
                return 0;
            }

            return $ascending
            ? (($a->{$field} < $b->{$field}) ? -1 : 1)
            : (($a->{$field} > $b->{$field}) ? -1 : 1);
        });

        return $sorted;
    }
}
