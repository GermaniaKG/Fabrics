<?php

namespace Germania\Fabrics;

class RepeatFactory implements RepeatFactoryInterface
{
    /**
     * FQDN of Repeat instances
     * @var string
     */
    public $php_class;


    /**
     * @param string|null $php_class FQDN of Repeat class or RepeatInterface
     */
    public function __construct(string $php_class = null)
    {
        $this->php_class = $php_class ?: Repeat::class;
    }


    /**
     * @inheritDoc
     */
    public function __invoke( $repeat_data) : RepeatInterface
    {
        if ($repeat_data instanceof RepeatInterface) {
            return $repeat_data;
        } elseif (!is_array($repeat_data) and !$repeat_data instanceof \ArrayAccess) {
            throw new FabricInvalidArgumentException("RepeatInterface, array or ArrayAccess expected");
        }

        $php_class = $this->php_class;
        $result = new $php_class();

        $result->repeat_width  = $repeat_data['repeat_width']  ?? ($repeat_data['repeatWidth'] ?? null);
        $result->repeat_height = $repeat_data['repeat_height'] ?? ($repeat_data['repeatHeight'] ?? null);
        $result->repeat_type   = $repeat_data['repeat_type']   ?? ($repeat_data['repeatType'] ?? null);

        return $result;

    }
}
