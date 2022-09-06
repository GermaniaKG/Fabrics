<?php

namespace Germania\Fabrics;

abstract class FabricAbstract implements FabricInterface
{
    public $id;
    public $enabled;
    public $lieferbar;

    // public $collection_id;
    public $collection_slug;
    public $collection_name;
    public $collection_page;

    public $keywords;
    public $price_group;
    public $fabric_number;
    public $fabric_transparency;
    public $fabric_lieferschein_name;
    public $fabric_name;
    public $pattern;

    public $roll_max_width;
    public $fabric_max_width;

    /**
     * @var RepeatInterface|null
     */
    public $repeat;

    public $photo;
    public $in_kompaktkollektion;

    public $pleat_width;
    public $paneltrack;
    public $topar;
    public $dustblock;
    public $thickness;

    public $material;
    public $weight;
    public $easy_clean;
    public $washable;
    public $moist_room;
    public $light_resistance;
    public $flame_resistance;
    public $screen_suitable;
    public $green_guard;
    public $halogen_free;
    public $pvc_free;
    public $oekotex;
    public $seatex;
    public $cradle_to_cradle;

    public $light_reflection;
    public $light_transmission;
    public $light_absorption;
    public $solar_reflection;
    public $solar_transmission;
    public $solar_absorption;

    public $uv_class;
    public $energy_class_summer;
    public $energy_class_winter;
    public $sound_class;

    public $slat_available_widths; // DEPRECATED

    /**
     * Pleat widths, comma-separated, e.g. `20,25,32`
     * @var string|null
     */
    public $pleat_available_widths;


    /**
     * Assignerd color slugs, space-separated, e.g. `green olive blue`
     * @var string|null
     */
    public $colors;





    public function getFabricNumber()
    {
        return $this->fabric_number;
    }

    public function getFabricName()
    {
        return $this->fabric_name;
    }

    public function getPattern()
    {
        return $this->pattern;
    }




    public function getRepeat() : ?RepeatInterface
    {
        return $this->repeat;
    }


    public function getPleatWidth()
    {
        return $this->pleat_width;
    }


    public function getPriceGroup()
    {
        return $this->price_group;
    }

    public function getKeywords()
    {
        return $this->keywords;
    }

    public function isEnabled(): bool
    {
        return $this->intToBool($this->enabled);
    }

    public function isAvailable(): bool
    {
        return $this->intToBool($this->lieferbar);
    }



    public function isInKompaktKollektion(): bool
    {
        return $this->intToBool($this->in_kompaktkollektion);
    }


    public function isAvailableForPanelTracks(): bool
    {
        return $this->intToBool($this->paneltrack);
    }


    public function isHalogenFree(): bool
    {
        return $this->intToBool($this->halogen_free);
    }

    public function isPvcFree(): bool
    {
        return $this->intToBool($this->pvc_free);
    }

    public function isGreenGuard(): bool
    {
        return $this->intToBool($this->green_guard);
    }


    public function isTopar(): bool
    {
        return $this->intToBool($this->topar);
    }


    public function isDustblock(): bool
    {
        return $this->intToBool($this->dustblock);
    }


    public function isEasyClean(): bool
    {
        return $this->intToBool($this->easy_clean);
    }


    public function isWashable(): bool
    {
        return $this->intToBool($this->washable);
    }


    public function isMoistRoom(): bool
    {
        return $this->intToBool($this->moist_room);
    }


    public function isScreenSuitable(): bool
    {
        return $this->intToBool($this->screen_suitable);
    }


    public function isOekoTex(): bool
    {
        return $this->intToBool($this->oekotex);
    }


    public function isSeaTex(): bool
    {
        return $this->intToBool($this->seatex);
    }



    /**
     * Converts integer-like values to Boolean
     * @param  mixed $var
     * @return bool
     */
    protected function intToBool($var): bool
    {
        return ((int) $var > 0);
    }
}
