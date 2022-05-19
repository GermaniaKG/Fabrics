<?php
namespace Germania\Fabrics;

class PhotoNotEmptyFilterIterator extends \FilterIterator{

    public $field = 'photo';
    

    #[\ReturnTypeWillChange]
    public function accept( )
    {
        $fabric = $this->current();


        if (is_array($fabric)
        or $fabric instanceOf \ArrayAccess)
            return !empty($fabric[$this->field ]);

        if (is_object($fabric) and isset($fabric->{$this->field})):
            return !empty($fabric->{$this->field});
        endif;

        return false;
    }
}
