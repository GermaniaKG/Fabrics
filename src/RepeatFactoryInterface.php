<?php

namespace Germania\Fabrics;

interface RepeatFactoryInterface
{

    /**
     * @param  RepeatInterface|\ArrayAccess|array $repeat_data
     */
    public function __invoke( $repeat_data) : RepeatInterface;
}
