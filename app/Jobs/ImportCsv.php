<?php

namespace App\Jobs;

use App\Events\JobProcessed;
use App\Models\Import;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportCsv implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use Batchable;

    public $tries = 10;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public Import $import, public string $model, public array $chunk, public array $columns, public $totalRows = 0)
    {}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $chunkWithKeys = [];

        foreach ($this->chunk as $row) {
            // Combine columns and values to create an associative array
            $chunkWithKeys[] = array_combine($this->columns, $row);
        }

        $affectedRows = $this->model::upsert(
            $chunkWithKeys,
            ['id'],
            collect($this->columns)->diff('id')->values()->toArray()
        );

        $this->import->processed_rows++;
        $this->import->save();

        sleep(1);
    }
}
