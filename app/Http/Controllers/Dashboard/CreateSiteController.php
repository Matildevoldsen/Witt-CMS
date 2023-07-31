<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSiteRequest;
use App\Models\SiteSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CreateSiteController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CreateSiteRequest $request)
    {
        $logo = $this->updateSiteLogo($request->logo_path);

        SiteSettings::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'description' => $request->description,
            'logo_path' => $logo,
        ]);

        return redirect()->back();
    }

    public function updateSiteLogo($logo_path)
    {
        return Storage::disk('public')->put('logos', $logo_path);
    }
}
