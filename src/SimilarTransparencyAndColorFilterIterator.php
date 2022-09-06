<?php

namespace Germania\Fabrics;

class SimilarTransparencyAndColorFilterIterator extends \FilterIterator
{
    public $transparency;
    public $color;

    public $transparency_field = "fabric_transparency";
    public $transparency_field_cc = "fabricTransparency";
    public $color_field = "colors";

    public function __construct(\Traversable $fabrics, string $transparency, string $color, bool $strict = false)
    {
        $this->transparency = $transparency;
        $this->color = $color;
        $this->color_array = explode(" ", $color);

        $this->strict = $strict;

        parent::__construct(new \IteratorIterator($fabrics));
    }

    public function accept(): bool
    {
        $fabric = $this->current();

        if (is_array($fabric)
        or $fabric instanceof \ArrayAccess) {
            $ft = $fabric[ $this->transparency_field ] ?? ($fabric[ $this->transparency_field_cc ] ?? "");
            $fc = $fabric[ $this->color_field ] ?? "";
        } elseif (is_object($fabric)
        and isset($fabric->{$this->transparency_field})
        and isset($fabric->{$this->color_field})) {
            $ft = $fabric->{$this->transparency_field};
            $fc = $fabric->{$this->color_field};
        }
        // camelCase
        elseif (is_object($fabric)
        and isset($fabric->{$this->transparency_field_cc})
        and isset($fabric->{$this->color_field})) {
            $ft = $fabric->{$this->transparency_field_cc};
            $fc = $fabric->{$this->color_field};
        } else {
            return false;
        }

        // Evaluate
        $fc_array = explode(" ", $fc);
        $same_color = count(array_intersect($fc_array, $this->color_array));
        $same_transparency = ($ft == $this->transparency);

        return $same_transparency and $same_color;


        return false;
    }
}
