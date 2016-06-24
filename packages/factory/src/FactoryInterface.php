<?php
declare(strict_types=1);

namespace Ion;

interface FactoryInterface
{

    /** @TODO: Add ? to the return type */
    public function getBaseClassName(): string;
    public function getAliases(): array;
    public function register(string $alias, string $className): FactoryInterface;
    public function unregister(string $alias): FactoryInterface;
    /** @TODO: Add ? to the return type */
    public function resolve(string $name, bool $validate = false): string;
    public function create(string $name, array $args = null): object;
}