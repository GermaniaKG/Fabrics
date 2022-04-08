<?php
namespace Germania\Fabrics;

class EnabledFabricsFilterIterator extends \FilterIterator{

    public $field = 'enabled';

    public function accept( )
    {
        $fabric = $this->current();


        if (is_array($fabric)
        or $fabric instanceOf \ArrayAccess)
            return !empty($fabric[ $this->field ]);

        if (is_object($fabric) and isset($fabric->{$this->field})):
            return $fabric->{$this->field} > 0;
        endif;

        return false;
    }
}
