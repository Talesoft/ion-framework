<?php
declare(strict_types=1);

namespace Ion\Config;

trait OptionTrait
{
    
    protected $options = [];
    
    public function hasOption(string $key): bool
    {
        
        return isset($this->options[$key]);
    }
    
    public function getOption(string $key, $default = null)
    {
        
        return $this->options[$key] ?? $default;
    }
    
    public function setOption(string $key, $value)
    {
        
        $this->options[$key] = $value;
        
        return $this;
    }

    public function mergeOptions(array $options, bool $recursive = false, bool $prepend = false): OptionInterface
    {

        $func = 'array_replace';

        if ($recursive)
            $func .= '_recursive';

        if ($prepend)
            $this->options = $func($options, $this->options);
        else
            $this->options = $func($this->options, $options);

        return $this;
    }

    public function appendOptions(array $options, bool $recursive = false): OptionInterface
    {
        
        return $this->mergeOptions($options, $recursive);
    }
    
    public function prependOptions(array $options, bool $recursive = false): OptionInterface
    {
        
        return $this->mergeOptions($options, $recursive, true);
    }

    public function defineOptions(array $options, array $userOptions = null): OptionInterface
    {

        $this->prependOptions($options);

        if ($userOptions)
            $this->appendOptions($userOptions);

        return $this;
    }
}