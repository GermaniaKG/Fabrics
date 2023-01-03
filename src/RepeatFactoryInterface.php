<?php

namespace Germania\Fabrics;

interface RepeatFactoryInterface
{

    /**
     * @param RepeatInterface|\ArrayAccess|mixed[] $repeat_data
     */
    public function __invoke( $repeat_data) : RepeatInterface;
}
