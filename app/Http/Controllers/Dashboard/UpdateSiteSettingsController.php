<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\SiteSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UpdateSiteSettingsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $settings = SiteSettings::first();

        $settings->update([
            'name' => $request->name ?? $settings->name,
            'email' => $request->email ?? $settings->email,
            'phone' => $request->phone ?? $settings->phone,
            'address' => $request->address ?? $settings->address,
            'description' => $request->description ?? $settings->description,
        ]);

        logger($request->file('logo_path'));

        if ($request->hasFile('logo_path')) {
            $logo = $this->updateSiteLogo($request->logo_path);

            $settings->update([
                'logo_path' => $logo,
            ]);
        }

        return redirect()->back();
    }

    public function updateSiteLogo($logo_path) {
        return Storage::disk('public')->put('logos', $logo_path);
    }
}
