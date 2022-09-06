<?php

namespace Germania\Fabrics;

class Repeat extends RepeatAbstract
{
    public function setWidth( int $width = null) : self
    {
        $this->repeat_width = $width;
        return $this;
    }
    
    public function setHeight(int $height = null) : self
    {
        $this->repeat_height = $height;
        return $this;

    }
    
    public function setType(string $type = null) : self
    {
        $this->repeat_type = $type;
        return $this;
    }
}
