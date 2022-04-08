<?php
namespace Germania\Fabrics;

interface FabricInterface
{

    /**
     * This field names array reflects the database fields.
     * Use like this:
     *
     *            <?php
     *            $fields = implode(",", FabricInterface::FABRIC_FIELDS);
     */
    const FABRIC_FIELDS = array(
          'id'
        , 'enabled'
        , 'lieferbar'
        , 'collection_slug'
        , 'collection_name'
        , 'fabric_number'
        , 'collection_page'
        , 'fabric_transparency'
        , 'price_group'
        , 'fabric_lieferschein_name'
        , 'keywords'
        , 'fabric_name'
        , 'pattern'
        , 'fabric_max_width'
        , 'photo'
        , 'in_kompaktkollektion'
        , 'paneltrack'
        , 'topar'
        , 'dustblock'
        , 'pleat_width'
        , 'thickness'
        , 'roll_max_width'
        , 'material'
        , 'weight'
        , 'easy_clean'
        , 'washable'
        , 'moist_room'
        , 'light_resistance'
        , 'flame_resistance'
        , 'screen_suitable'
        , 'oekotex'
        , 'halogen_free'
        , 'pvc_free'
        , 'green_guard'
        , 'seatex'
        , 'cradle_to_cradle'
        , 'light_reflection'
        , 'light_transmission'
        , 'light_absorption'
        , 'solar_reflection'
        , 'solar_transmission'
        , 'solar_absorption'
        , 'uv_class'
        , 'energy_class_summer'
        , 'energy_class_winter'
        , 'sound_class'
        , 'slat_available_widths' // DEPRECATED
    );

	public function getFabricNumber();
	public function getFabricName();
	public function getPattern();
    public function getPleatWidth();

	public function getPriceGroup();
	public function getKeywords();

	public function isEnabled() : bool;
	public function isAvailable() : bool;

	public function isInKompaktKollektion() : bool;
	public function isAvailableForPanelTracks() : bool;

    public function isHalogenFree() : bool;
    public function isPvcFree() : bool;
    public function isGreenGuard() : bool;
    public function isOekoTex() : bool;
    public function isSeaTex() : bool;

    public function isTopar() : bool;
	public function isDustblock() : bool;
	public function isEasyClean() : bool;
	public function isWashable() : bool;
	public function isMoistRoom() : bool;

	public function isScreenSuitable() : bool;
}
