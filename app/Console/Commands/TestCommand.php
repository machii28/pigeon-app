<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use League\Csv\Reader;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $csv = Reader::createFromPath('enrollee_page_timer.csv');
        $data = [];

        foreach ($csv as $key => $row) {
            if ($key === 0) {
                continue;
            }

            $data[] = [
                'enrollee_id' => $row[0],
                'provider_id' => $row[1],
                'lv_duration' => $row[2],
                'ca_duration' => $row[3]
            ];
        }

        $data = collect($data);

        $enrolleesWithoutCACallsRecorded = $data->where('ca_duration', null)->count();
        $enrolleesWithDifferentDurations = $data->filter(function ($row) {
            return $row['ca_duration'] !== $row['lv_duration'] && $row['ca_duration'] !== '';
        });
        $enrolleesWithCorrectDurations = $data->filter(function ($row) {
            return $row['ca_duration'] === $row['lv_duration'];
        })->count();

        dump(
            'Enrollees without ca call recorded: ' . $enrolleesWithoutCACallsRecorded,
            'Enrollees with different duration recorded: ' . $enrolleesWithDifferentDurations->count(),
            'Enrollees with correct duration recorded: ' . $enrolleesWithCorrectDurations
        );
    }
}
