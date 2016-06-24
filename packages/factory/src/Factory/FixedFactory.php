<?php
declare(strict_types=1);

namespace Ion\Factory;

use Ion\Factory;

class FixedFactory extends Factory
{

    private $instances;

    public function __construct(string $baseClassName)
    {

        parent::__construct($baseClassName);
        
        $this->instances = [];
    }


    public function create(string $name, array $args = null): object
    {
        
        $name = $this->resolve($name, true);

        if (isset($this->instances[$name]))
            return $this->instances[$name];

        $this->instances[$name] = parent::create($name, $args);

        return $this->instances[$name];
    }
}
