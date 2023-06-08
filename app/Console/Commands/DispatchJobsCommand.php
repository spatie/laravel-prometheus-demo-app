<?php

namespace App\Console\Commands;

use App\Jobs\Job1;
use App\Jobs\Job2;
use App\Jobs\Job3;
use App\Jobs\Job4;
use Illuminate\Console\Command;

class DispatchJobsCommand extends Command
{
    protected $signature = 'app:dispatch-jobs-command';

    public function handle()
    {
        $this->info('Dispatching jobs...');

        $this
            ->dispatchTimes(2000, 2500, Job1::class, 'queue-1')
            ->dispatchTimes(1000, 1200, Job2::class, 'queue-2')
            ->dispatchTimes(1500, 1800, Job3::class, 'queue-3')
            ->dispatchTimes(50, 1000, Job4::class, 'queue-4');

        $this->info('All done!');
    }

    public function dispatchTimes(int $minTimes, int $maxTimes, string $jobClass, string $queue): self
    {
        $times = range($minTimes, $maxTimes);

        $this->comment('Dispatching ' . count($times) . ' jobs on queue ' . $queue);

        foreach($times as $i) {
            dispatch(new $jobClass())->onQueue($queue);
        }

        return $this;
    }
}
