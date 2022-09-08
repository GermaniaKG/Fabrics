<?php

namespace Germania\Fabrics;

interface FabricsClientInterface
{
    /**
     * Retrieve all collections in use
     */
    public function collections() : iterable;


    /**
     * Retrieve all fabrics belonging to the given collection.
     *
     * @param  string        $collection   URL slug of a Germania Fabrics Collection
     * @param  string|null   $search       Optional: search term
     * @param  string|null   $sort         Optional: sort by field(s), string or CSV string
     * @return iterable|FabricInterface[]  Iterable with FabricInterface instances
     */
    public function collection(string $collection, string $search = null, string $sort = null): iterable;


    /**
     * Retrieves all fabric transparencies belonging to the given collection.
     *
     * @param  string        $collection   URL slug of a Germania Fabrics Collection
     * @return iterable|FabricInterface[]  Iterable with FabricInterface instances
     */
    public function collectionTransparencies(string $collection): iterable;


    /**
     * Retrieves all color groups belonging to the given collection.
     *
     * @param  string        $collection   URL slug of a Germania Fabrics Collection
     * @return iterable|FabricInterface[]  Iterable with FabricInterface instances
     */
    public function collectionColors(string $collection): iterable;


    /**
     * Retrieves a single fabric from a given collection.
     *
     * @param  string $collection     URL slug of a Germania Fabrics Collection
     * @param  string $fabric_number  Fabric number
     * @return FabricInterface
     */
    public function fabric(string $collection, string $fabric_number): FabricInterface;
}
