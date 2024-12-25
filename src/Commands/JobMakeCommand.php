<?php

namespace InnoAya\Mojura\Commands;

use InnoAya\Mojura\Generators\JobGenerator;

class JobMakeCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    public $signature = 'mojura:job
                        {job : Job}
                        {module : Module}
                        {directory? : Directory}
                        {--Q|queue : Make the job queueable}
                        {--F|force : Overwrite existing files}';

    /**
     * The description the console command.
     *
     * @var string
     */
    public $description = 'Create a new job in a module';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        try {
            $job = $this->argument('job');
            $module = $this->argument('module');
            $directory = $this->argument('directory');
            $queueable = $this->option('queue');
            $force = $this->option('force');

            $output = (new JobGenerator())->generate($job, $module, $directory, $queueable, $force);

            $this->printFileGeneratedOutput($output);
        } catch (\Exception $exception) {
            $this->printFileGenerationErrorOutput($exception->getMessage());
        }

        return 0;
    }
}
