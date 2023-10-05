<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LocationsController extends Controller
{
    public function view(): View
    {
        return view('views.worker.locations.view', ['locations' => Location::orderBy('address->city', 'ASC')->get()]);
    }

    public function manage(Location $location): View
    {
        return view('views.worker.locations.manage', ['location' => $location, 'employees' => User::orderBy('name', 'ASC')->pluck('id', 'name')]);
    }

    public function update(Location $location, Request $request): RedirectResponse
    {
        $valid = $request->validate([
            'address' => 'required|array|size:2',
            'address.*' => 'required|string',
            'employees' => 'required|array',
            'employees.*' => 'required|integer|exists:users,id'
        ]);

        if ($valid) {
            $location->update(['address' => json_encode($valid['address'])]);
            $location->employees()->update(['location_id' => null]);
            User::whereIn('id', $valid['employees'])->update(['location_id' => $location->id]);
        }

        return redirect()->route('staff.locations.manage', ['location' => $location->id]);
    }

    public function delete(Location $location): RedirectResponse
    {
        $location->employees()->update(['location_id' => null]);
        $location->delete();

        return redirect()->route('staff.locations.view');
    }

    public function createView(): View
    {
        return view('views.worker.locations.create');
    }

    public function createHandle(Request $request): RedirectResponse
    {
        $valid = $request->validate([
            'address' => 'required|array|size:2',
            'address.*' => 'required|string'
        ]);

        if ($valid) {
            $location = Location::create(['address' => json_encode($valid['address'])]);

            return redirect()->route('staff.locations.manage', ['location' => $location->id]);
        }

        return redirect()->route('staff.locations.view');
    }
}
