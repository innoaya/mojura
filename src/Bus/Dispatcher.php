<?php

namespace InnoAya\Mojura\Bus;

trait Dispatcher
{
    /**
     * Get the dispatchable unit.
     */
    public function getDispatchableUnit(mixed $unit, array $arguments): mixed
    {
        return is_string($unit) ? new $unit(...$arguments) : $unit;
    }
}
