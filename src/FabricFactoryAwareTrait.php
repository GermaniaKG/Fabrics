<?php

namespace Germania\Fabrics;

trait FabricFactoryAwareTrait
{
    /**
     * @var FabricFactoryInterface|null
     */
    public $fabric_factory;


    public function getFabricFactory() : ?FabricFactoryInterface
    {
        return $this->fabric_factory;
    }


    public function setFabricFactory(FabricFactoryInterface $fabric_factory) : self
    {
        $this->fabric_factory = $fabric_factory;
        return $this;
    }

}
