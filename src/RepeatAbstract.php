<?php

namespace Germania\Fabrics;

abstract class RepeatAbstract implements RepeatInterface
{
    /**
     * @var null|int
     */
    public $repeat_width;

    /**
     * @var null|int
     */
    public $repeat_height;
    
    /**
     * @var string|null
     */
    public $repeat_type;

    public function getWidth() : ?int
    {
        return $this->repeat_width;
    }
    
    public function getHeight() : ?int
    {
        return $this->repeat_height;
    }
    
    public function getType() : ?string
    {
        return $this->repeat_type;
    }
}
