<?php

namespace Germania\Fabrics;

interface FabricFactoryInterface
{
    /**
     * Creates a FabricInterface instance from data.
     *
     * Throws FabricExceptionInterface when failing.
     *
     * @param  mixed $fabric_data Any data needed to create a FabricInterface instance.
     * @return FabricInterface
     * @throws FabricExceptionInterface
     */
    public function __invoke($fabric_data): FabricInterface;
}
