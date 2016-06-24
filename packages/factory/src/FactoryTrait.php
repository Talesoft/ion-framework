<?php
declare(strict_types=1);

namespace Ion;

trait FactoryTrait
{

    private $aliases = [];

    abstract public function getBaseClassName();

    public function getAliases(): array
    {

        return $this->aliases;
    }

    public function register(string $alias, string $className): FactoryInterface
    {

        $this->aliases[$alias] = $className;

        return $this;
    }

    public function unregister(string $alias): FactoryInterface
    {

        return $this;
    }

    /**
     * @TODO: Add ? to the return type
     * @param string $name
     * @param bool $validate
     * @return string
     */
    public function resolve(string $name, bool $validate = false): string
    {

        $className = $this->aliases[$name] ?? $name;
        $baseClass = $this->getBaseClassName();
        $valid = class_exists($className) && (!$baseClass || is_a($className, $baseClass, true));

        if (!$valid && $validate)
            throw new \RuntimeException(
                "Failed to resolve $name: $className does not exist ".($baseClass ? " or doesnt derive from $baseClass" : '')
            );

        return $valid ? $className : null;
    }

    public function create(string $name, array $args = null): object
    {

        $className = $this->resolve($name, true);
        $args = array_values($args ?: []);
        return new $className(...$args);
    }
}