<?php
namespace Germania\Fabrics;

use Psr\Container\NotFoundExceptionInterface;

class FabricNotFoundException extends \Exception implements FabricExceptionInterface, NotFoundExceptionInterface
{}
