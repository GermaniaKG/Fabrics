<?php
namespace Germania\Fabrics;

class SameValueFilterIterator extends \FilterIterator{

    public $field;
    public $search;
    public $strict = false;

    public function __construct( \Traversable $fabrics, string $field, string $search, bool $strict = false )
    {
        $this->field = $field;
        $this->search = $search;
        $this->strict = $strict;

        parent::__construct( new \IteratorIterator($fabrics));
    }

    public function accept( )
    {
        $fabric = $this->current();


        if (is_array($fabric)
        or $fabric instanceOf \ArrayAccess)
            return $this->strict 
                ? $fabric[ $this->field ] === $this->search
                : $fabric[ $this->field ] == $this->search;

        if (is_object($fabric) and isset($fabric->{$this->field})):
            return  $this->strict 
                ? $fabric->{$this->field} === $this->search
                : $fabric->{$this->field} == $this->search;
        endif;

        return false;
    }
}
