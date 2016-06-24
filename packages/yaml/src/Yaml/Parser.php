<?php
declare(strict_types=1);

namespace Ion\Yaml;

use Ion\Reader\StringReader;

class Parser
{

    private $encoding;    
    private $reader;
    
    public function __construct(string $encoding = null)
    {
        
        $this->encoding = $encoding;
        $this->reader = null;
    }
    
    public function parse(string $input)
    {
        
        $this->reader = new StringReader($input, $this->encoding);
    }
}