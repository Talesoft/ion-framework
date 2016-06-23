<?php
declare(strict_types=1);

namespace Ion\Reader;

trait LineOffsetTrait
{

    protected $line = 0;
    protected $offset = 0;

    /**
     * @return int
     */
    public function getLine(): int
    {

        return $this->line;
    }

    /**
     * @return int
     */
    public function getOffset(): int
    {

        return $this->offset;
    }
}