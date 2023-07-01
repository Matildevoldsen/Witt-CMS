<?php

namespace App\Http\Controllers\Shop;

use App\Helpers\ChunkIterator;
use App\Http\Controllers\Controller;
use App\Http\Resources\ImportResource;
use App\Http\Resources\InventoryResource;
use App\Jobs\ImportCsv;
use App\Models\Import;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Iterator;
use League\Csv\Reader;
use League\Csv\Statement;
use League\Csv\TabularDataReader;

class InventoryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return inertia()->render('Dashboard/Shop/Inventory', [
            'inventory' => InventoryResource::collection(Inventory::query()->with('user')->latest()->paginate(50)),
            'inventoryItems' => number_format(Inventory::count()),
            'query' => $request->query() ?? '',
        ]);
    }

    public function getImporter(Request $request, $id)
    {
        return inertia()->render('Dashboard/Shop/Inventory', [
            'inventory' => InventoryResource::collection(Inventory::query()->with('user')->latest()->paginate(50)),
            'inventoryItems' => number_format(Inventory::count()),
            'query' => $request->query() ?? '',
            'importer' => ImportResource::make(
                Import::find($id)
            ),
        ]);
    }
}
