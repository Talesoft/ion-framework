<?php
declare(strict_types=1);

namespace Ion\Reader;

trait PositionTrait
{

    protected $position = 0;

    /**
     * @return int
     */
    public function getPosition(): int
    {

        return $this->position;
    }
}