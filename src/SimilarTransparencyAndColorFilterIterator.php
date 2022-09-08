<?php
namespace Germania\Fabrics;

class SimilarTransparencyAndColorFilterIterator extends \FilterIterator{

    /**
     * @var string
     */
    public $transparency;

    /**
     * @var string
     */
    public $color;

    /**
     * @var string[]
     */
    public $color_array;

    /**
     * @var bool
     */
    public $strict;


    /**
     * @var string
     */
    public $transparency_field = "fabric_transparency";

    /**
     * @var string
     */
    public $transparency_field_cc = "fabricTransparency";

    /**
     * @var string
     */
    public $color_field = "colors";


    /**
     * @param \Traversable<mixed[]|object> $fabrics
     */
    public function __construct( \Traversable $fabrics, string $transparency, string $color, bool $strict = false )
    {
        $this->transparency = $transparency;
        $this->color = $color;
        $this->color_array = explode(" ", $color);

        $this->strict = $strict;

        parent::__construct( new \IteratorIterator($fabrics));
    }

    public function accept( ) : bool
    {
        $fabric = $this->current();

        if (is_array($fabric)
        or $fabric instanceOf \ArrayAccess) {
            $ft = $fabric[ $this->transparency_field ] ?? ($fabric[ $this->transparency_field_cc ] ?? "");
            $fc = $fabric[ $this->color_field ] ?? "";
        }

        elseif (is_object($fabric)
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
        }
        else {
            return false;
        }

        // Evaluate
        $fc_array = explode(" ", $fc);
        $same_color = count(array_intersect($fc_array, $this->color_array));
        $same_transparency = ($ft == $this->transparency);

        return $same_transparency and $same_color;
    }
}
