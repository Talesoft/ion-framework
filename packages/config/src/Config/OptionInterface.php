<?php
declare(strict_types=1);

namespace Ion\Config;

interface OptionInterface
{

    public function hasOption(string $key): bool;
    public function getOption(string $key, $default = null);
    public function setOption(string $key, $value): OptionInterface;

    public function mergeOptions(array $options, bool $recursive = false, bool $prepend = false): OptionInterface;
    public function appendOptions(array $options, bool $recursive = false): OptionInterface;
    public function prependOptions(array $options, bool $recursive = false): OptionInterface;

    public function defineOptions(array $options, array $userOptions = null): OptionInterface;
    public function defineDefaults(array $defaults): OptionInterface;
}