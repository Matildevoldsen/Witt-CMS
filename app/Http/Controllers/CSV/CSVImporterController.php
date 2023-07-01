<?php

namespace App\Http\Controllers\CSV;

use App\Events\JobProcessed;
use App\Helpers\ChunkIterator;
use App\Http\Controllers\Controller;
use App\Jobs\ImportCsv;
use App\Models\Import;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Cookie;

class CSVImporterController extends Controller
{
    public $model;
    public $totalRows;

    public function __construct()
    {
        $this->model = Inventory::class;
    }

    public function uploadFile(Request $request): \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
    {
        if (!$request->hasFile('csv')) return response()->json(['error' => 'No file uploaded.'], 400);


        $file = $request->file('csv')->getRealPath();
        $handle = fopen($file, 'r');
        $headers = fgetcsv($handle);

        return response()->json([
            'headers' => $headers,
        ], 200);
    }

    public function import(Request $request)
    {
        $request->validate([
            'csv' => 'required|file',
            'headers' => 'required'
        ]);

        $request->file('csv');

        $records = $this->getCsvRecordsProperty($request->file('csv')->getRealPath());
        $import = $this->createImport(
            $request->file('csv')->getRealPath(),
            '',
            $this->getTotalRecords($request->file('csv')->getRealPath())
        );

        $batches = collect(
            (new ChunkIterator($records, 10))
                ->get()
        )
            ->map(function ($chunk) use ($import, $request) {
                return new ImportCsv(
                    $import, $this->model,
                    $chunk,
                    array_values(explode(',', $request->input('headers')))
                );
            })
            ->toArray();

        Bus::batch($batches)
            ->finally(function () use ($import) {
                $import->touch('completed_at');
            })
            ->dispatch();

        return response()->json([
            'message' => 'Import started successfully.',
            'total_rows' => $import->total_rows,
            'importer' => $import,
        ], 200);
    }

    public function createImport(string $file_path, string $file_name, int $rows = 0)
    {
        return auth()->user()->imports()->create([
            'model' => Inventory::class,
            'file_path' => $file_path,
            'file_name' => $file_name,
            'total_rows' => $rows
        ]);
    }

    public function getTotalRecords($csvPath): int
    {
        $file = fopen($csvPath, 'r');
        $totalRows = 0;
        while (($line = fgetcsv($file)) !== FALSE) {
            $totalRows++;
        }
        fclose($file);
        return $totalRows - 1;
    }

    public function getCsvRecordsProperty($csvPath)
    {
        $file = fopen($csvPath, 'r');
        $this->columnsToMap = fgetcsv($file);
        while (($line = fgetcsv($file)) !== FALSE) {
            yield $line;
        }
        fclose($file);
    }
}
