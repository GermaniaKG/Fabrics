<?php

namespace Germania\Fabrics;

class Repeat extends RepeatAbstract
{
    public function __toString() {
        $width = $this->getWidth();
        $height = $this->getHeight();

        if (is_null($width)
        and is_null($height)) {
            return "";
        }

        if (!is_null($width)
        and !is_null($height)) {
            return sprintf("%s×%s", $width, $height);
        }

        if (!is_null($width)) {
            return sprintf("%s wide", $width);
        }

        if (!is_null($height)) {
            return sprintf("%s high", $height);
        }
    }

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
