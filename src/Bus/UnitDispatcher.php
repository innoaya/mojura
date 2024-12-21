<?php

namespace InnoAya\Mojura\Bus;

use Error;
use Illuminate\Foundation\Bus\DispatchesJobs;
use InnoAya\Mojura\Core\QueueableJob;

trait UnitDispatcher
{
    use Dispatcher, DispatchesJobs;

    /**
     * Dispatch the given unit with the given arguments.
     *
     * @param  string  $unit
     */
    public function run(mixed $unit, array $arguments = []): mixed
    {
        return $this->dispatchSync($this->getDispatchableUnit($unit, $arguments));
    }

    /**
     * Serve the given unit with arguments in given queue.
     *
     * @param  string  $unit
     *
     * @throws Error
     */
    public function runInQueue(mixed $unit, array $arguments = [], string $queue = 'default'): mixed
    {
        $dispatchableUnit = $this->getDispatchableUnit($unit, $arguments);

        try {
            $dispatchableUnit->onQueue($queue);
        } catch (Error $_) {

            throw new Error('[' . $dispatchableUnit::class . ' does not support queues. Please extends to [' . QueueableJob::class . ']');
        }

        return $this->dispatch($dispatchableUnit);
    }
}
