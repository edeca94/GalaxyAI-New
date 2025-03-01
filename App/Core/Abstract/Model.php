<?php

namespace App\Core;

use ReflectionProperty;
use Exception;

abstract class Model extends Core
{
    protected $db;

    public function __construct()
    {
        Core::__construct();

        $factory = new PDOFactory();
        $pdo = $factory->createPDO();

        $this->db = new Database($pdo);
    }

    public function __call($name, $args)
    {
        $prefix = substr($name, 0, 3);
        $property = lcfirst(substr($name, 3));
        
        if (property_exists($this, $property))
        {
            $reflectionProperty = new ReflectionProperty($this, $property);
            switch ($prefix)
            {
                case KWRD_SET:
                    $reflectionProperty->setValue($this, $args[0]);
                    return $this;
                case KWRD_GET:
                    return $reflectionProperty->getValue($this);
            }
        }
        else
        {
            echo('<pre>'.var_export($this).'</pre>');
        }
        throw new Exception(sprintf($this->translator->translate('method_does_not_exist'), $name));
    }
}