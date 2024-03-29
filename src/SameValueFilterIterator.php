<?php

namespace Germania\Fabrics;

class SameValueFilterIterator extends \FilterIterator{

    /**
     * @var string
     */
    public $field;

    /**
     * @var string
     */
    public $search;

    /**
     * @var bool
     */
    public $strict = false;



    /**
     * @param \Traversable<mixed[]|object> $fabrics
     */
    public function __construct( \Traversable $fabrics, string $field, string $search, bool $strict = false )
    {
        $this->field = $field;
        $this->search = $search;
        $this->strict = $strict;

        parent::__construct(new \IteratorIterator($fabrics));
    }

    public function accept(): bool
    {
        $fabric = $this->current();


        if (is_array($fabric)
        or $fabric instanceof \ArrayAccess) {
            return $this->strict
                ? $fabric[ $this->field ] === $this->search
                : $fabric[ $this->field ] == $this->search;
        }

        if (is_object($fabric) and isset($fabric->{$this->field})):
            return  $this->strict
                ? $fabric->{$this->field} === $this->search
                : $fabric->{$this->field} == $this->search;
        endif;

        return false;
    }
}
