<?php
namespace Germania\Fabrics;

abstract class FabricDecoratorAbstract implements FabricInterface
{


    /**
     * @var FabricInterface
     */
    public $fabric;


    /**
     * @param FabricInterface $document The fabric instance to decorate
     */
    public function __construct(FabricInterface $fabric)
    {
        $this->fabric = $fabric;
    }


    public function getPleatWidth() {
        return $this->fabric->getPleatWidth();
    }


    public function getFabricNumber() {
        return $this->fabric->getFabricNumber();
    }


    public function getFabricName() 
    {
        return $this->fabric->getFabricName();
    }

    public function getPattern()
    {
        return $this->fabric->getPattern();
    }


    public function getPriceGroup() {
        return $this->fabric->getPriceGroup();
    }



    public function isEnabled() : bool
    {
        return $this->fabric->isEnabled();
    }
    public function isAvailable() : bool
    {
        return $this->fabric->isAvailable();
    }



    public function getKeywords()
    {
        return $this->fabric->getKeywords();
    }


    public function isInKompaktKollektion() : bool
    {
        return $this->fabric->isInKompaktKollektion();
    }


    public function isAvailableForPanelTracks() : bool
    {
        return $this->fabric->isAvailableForPanelTracks();
    }


    public function isTopar() : bool
    {
        return $this->fabric->isTopar();
    }


    public function isDustblock() : bool
    {
        return $this->fabric->isDustblock();
    }


    public function isEasyClean() : bool
    {
        return $this->fabric->isEasyClean();
    }


    public function isWashable() : bool
    {
        return $this->fabric->isWashable();
    }


    public function isMoistRoom() : bool
    {
        return $this->fabric->isMoistRoom();
    }


    public function isScreenSuitable() : bool
    {
        return $this->fabric->isScreenSuitable();
    }


    public function isOekoTex() : bool
    {
        return $this->fabric->isOekoTex();
    }


    public function isSeaTex() : bool   
    {
        return $this->fabric->isSeaTex();
    }


    public function isHalogenFree() : bool
    {
        return $this->fabric->isHalogenFree();
    }

    public function isPvcFree() : bool
    {
        return $this->fabric->isPvcFree();
    }

    public function isGreenGuard() : bool
    {
        return $this->fabric->isGreenGuard();
    }


}
