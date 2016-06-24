<?php
declare(strict_types=1);

namespace Ion;

class Factory implements FactoryInterface
{
    use FactoryTrait;

    private $baseClassName;

    public function __construct(string $baseClassName)
    {

        $this->baseClassName = $baseClassName;
    }

    /** @TODO: Add ? to return type */
    public function getBaseClassName(): string
    {

        return $this->baseClassName;
    }
}