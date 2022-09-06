<?php

namespace Germania\Fabrics;

class FabricFactory implements FabricFactoryInterface
{
    /**
     * FQDN of Fabric instances
     * @var string
     */
    public $php_class;

    /**
     * @var RepeatFactoryInterface
     */
    protected $repeat_factory;


    /**
     * @param string|null $php_class FQDN of Fabric class or FabricInterface
     */
    public function __construct(string $php_class = null)
    {
        $this->php_class = $php_class ?: Fabric::class;
        $this->setRepeatFactory(new RepeatFactory);
    }


    public function setRepeatFactory( RepeatFactoryInterface $repeat_factory) : self
    {
        $this->repeat_factory = new RepeatFactory;
        return $this;
    }



    /**
     * Creates FabricInterface instance from array data.
     * If instance of FabricInterface is passed, that very instance will be returned.
     *
     * @param   \ArrayAccess|array|FabricInterface $fabric_data  Fabric raw data
     * @return  FabricInterface Fabric
     * @throws  FabricInvalidArgumentException
     */
    public function __invoke($fabric_data): FabricInterface
    {
        if ($fabric_data instanceof FabricInterface) {
            return $fabric_data;
        } elseif (!is_array($fabric_data) and !$fabric_data instanceof \ArrayAccess) {
            throw new FabricInvalidArgumentException("FabricInterface, array or ArrayAccess expected");
        }

        $php_class = $this->php_class;
        $result = new $php_class();

        // Object Attribute                 // from database notation ...            ... OR camelCase if existant
        $result->id                       = $fabric_data['id']                       ?? null;
        $result->enabled                  = $fabric_data['enabled']                  ?? null;
        $result->lieferbar                = $fabric_data['lieferbar']                ?? null;
        $result->collection_slug          = $fabric_data['collection_slug']          ?? ($fabric_data['collectionSlug'] ?? null);
        $result->collection_name          = $fabric_data['collection_name']          ?? ($fabric_data['collectionName'] ?? null);
        $result->fabric_number            = $fabric_data['fabric_number']            ?? ($fabric_data['fabricNumber'] ?? null);
        $result->collection_page          = $fabric_data['collection_page']          ?? ($fabric_data['collectionPage'] ?? null);
        $result->fabric_transparency      = $fabric_data['fabric_transparency']      ?? ($fabric_data['fabricTransparency'] ?? null);
        $result->colors                   = $fabric_data['colors']                   ?? null;
        $result->price_group              = $fabric_data['price_group']              ?? ($fabric_data['priceGroup'] ?? null);
        $result->fabric_lieferschein_name = $fabric_data['fabric_lieferschein_name'] ?? ($fabric_data['fabricLieferscheinName'] ?? null);
        $result->keywords                 = $fabric_data['keywords']                 ?? null;
        $result->fabric_name              = $fabric_data['fabric_name']              ?? ($fabric_data['fabricName'] ?? null);
        $result->pattern                  = $fabric_data['pattern']                  ?? null;
        $result->fabric_max_width         = $fabric_data['fabric_max_width']         ?? ($fabric_data['fabricMaxWidth'] ?? null);
        $result->photo                    = $fabric_data['photo']                    ?? null;
        $result->in_kompaktkollektion     = $fabric_data['in_kompaktkollektion']     ?? ($fabric_data['inKompaktkollektion'] ?? null);
        $result->paneltrack               = $fabric_data['paneltrack']               ?? null;
        $result->topar                    = $fabric_data['topar']                    ?? null;
        $result->dustblock                = $fabric_data['dustblock']                ?? null;
        $result->pleat_width              = $fabric_data['pleat_width']              ?? ($fabric_data['pleatWidth'] ?? null);
        $result->thickness                = $fabric_data['thickness']                ?? null;
        $result->roll_max_width           = $fabric_data['roll_max_width']           ?? ($fabric_data['rollMaxWidth'] ?? null);


        $repeat_data = array(
            'repeat_width'  => $fabric_data['repeat_width']   ?? ($fabric_data['repeatWidth'] ?? null),
            'repeat_height' => $fabric_data['repeat_height']  ?? ($fabric_data['repeatHeight'] ?? null),
            'repeat_type'   => $fabric_data['repeat_type']    ?? ($fabric_data['repeatType'] ?? null)
        );
        $result->repeat = $this->createRepeatOrNull($repeat_data);

        $result->material                 = $fabric_data['material']                 ?? null;
        $result->weight                   = $fabric_data['weight']                   ?? null;
        $result->easy_clean               = $fabric_data['easy_clean']               ?? ($fabric_data['easyClean'] ?? null);
        $result->washable                 = $fabric_data['washable']                 ?? null;
        $result->moist_room               = $fabric_data['moist_room']               ?? ($fabric_data['moistRoom'] ?? null);
        $result->light_resistance         = $fabric_data['light_resistance']         ?? ($fabric_data['lightResistance'] ?? null);
        $result->flame_resistance         = $fabric_data['flame_resistance']         ?? ($fabric_data['flameResistance'] ?? null);
        $result->screen_suitable          = $fabric_data['screen_suitable']          ?? ($fabric_data['screenSuitable'] ?? null);
        $result->oekotex                  = $fabric_data['oekotex']                  ?? null;
        $result->seatex                   = $fabric_data['seatex']                   ?? null;
        $result->cradle_to_cradle         = $fabric_data['cradle_to_cradle']         ?? ($fabric_data['cradleToCradle'] ?? null);
        $result->light_reflection         = $fabric_data['light_reflection']         ?? ($fabric_data['lightReflection'] ?? null);
        $result->light_transmission       = $fabric_data['light_transmission']       ?? ($fabric_data['lightTransmission'] ?? null);
        $result->light_absorption         = $fabric_data['light_absorption']         ?? ($fabric_data['lightAbsorption'] ?? null);
        $result->solar_reflection         = $fabric_data['solar_reflection']         ?? ($fabric_data['solarReflection'] ?? null);
        $result->solar_transmission       = $fabric_data['solar_transmission']       ?? ($fabric_data['solarTransmission'] ?? null);
        $result->solar_absorption         = $fabric_data['solar_absorption']         ?? ($fabric_data['solarAbsorption'] ?? null);
        $result->uv_class                 = $fabric_data['uv_class']                 ?? ($fabric_data['uvClass'] ?? null);
        $result->energy_class_summer      = $fabric_data['energy_class_summer']      ?? ($fabric_data['energyClassSummer'] ?? null);
        $result->energy_class_winter      = $fabric_data['energy_class_winter']      ?? ($fabric_data['energyClassWinter'] ?? null);
        $result->sound_class              = $fabric_data['sound_class']              ?? ($fabric_data['soundClass'] ?? null);
        $result->slat_available_widths    = $fabric_data['slat_available_widths']    ?? ($fabric_data['slatAvailableWidths'] ?? null);
        $result->pleat_available_widths   = $fabric_data['pleat_available_widths']   ?? ($fabric_data['pleatAvailableWidths'] ?? null);

        return $result;
    }

    protected function createRepeatOrNull( $fabric_data ) : ?RepeatInterface
    {
        $repeat_data = array(
            'repeat_width'  => $fabric_data['repeat_width']   ?? null,
            'repeat_height' => $fabric_data['repeat_height']  ?? null,
            'repeat_type'   => $fabric_data['repeat_type']    ?? null
        );

        if (!is_null($repeat_data['repeat_width'])
        and !is_null($repeat_data['repeat_height'])
        and !is_null($repeat_data['repeat_type'])) {
            return ($this->repeat_factory)($repeat_data);
        }
        return null;
    }
}
