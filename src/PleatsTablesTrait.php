<?php

namespace Germania\Fabrics;

trait PleatsTablesTrait
{


    /**
     * @var string
     */
    public $pleats_table         = "germania_pleatwidths";

    /**
     * @var string
     */
    public $fabrics_pleats_table = "germania_fabrics_pleatwidths";



    public function setPleatsTables(string $pleats_table, string $fabrics_pleats_table): self
    {
        $this->pleats_table = $pleats_table;
        $this->fabrics_pleats_table = $fabrics_pleats_table;
        return $this;
    }
}
