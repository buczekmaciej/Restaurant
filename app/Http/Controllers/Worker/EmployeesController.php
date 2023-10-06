<?php

namespace App\Http\Controllers\Worker;

use App\Enums\WorkerPosition;
use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\User;
use App\Services\AppServices;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeesController extends Controller
{
    public function view(): View
    {
        return view('views.worker.employees.view', ['employees' => User::orderBy('name', 'ASC')->paginate(50)]);
    }

    public function manage(User $user): View
    {
        return view('views.worker.employees.manage', ['employee' => $user, 'positions' => WorkerPosition::getValues(), 'locations' => Location::orderBy('address->city', 'ASC')->select('id', 'address')->get()]);
    }

    public function update(User $user, Request $request): RedirectResponse
    {
        $valid = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
            'position' => 'required|string',
            'phone' => 'required|string',
            'address' => 'required|array|size:2',
            'address.*' => 'required|string',
            'workplace' => 'required|integer|exists:locations,id'
        ]);

        if ($valid) {
            User::where('code', $user->code)->update($request->merge(['address' => json_encode($valid['address']), 'location_id' => $valid['workplace']])->except('workplace', '_token'));
        }

        return redirect()->route('staff.employees.manage', ['user' => $user->code]);
    }

    public function delete(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('staff.employees.view');
    }

    public function createView(): View
    {
        return view('views.worker.employees.create', ['positions' => WorkerPosition::getValues(), 'locations' => Location::orderBy('address->city', 'ASC')->select('id', 'address')->get()]);
    }

    public function createHandle(Request $request): RedirectResponse
    {
        $valid = $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
            'email' => 'required|string',
            'position' => 'required|string',
            'phone' => 'required|string',
            'address' => 'required|array|size:2',
            'address.*' => 'required|string',
            'workplace' => 'required|integer|exists:locations,id'
        ]);

        if ($valid) {
            $user = User::create($request->merge(['code' => AppServices::generateCode(), 'password' => Hash::make($valid['password']), 'address' => json_encode($valid['address'])])->except('workplace', '_token'));
            $user->workplace()->associate($valid['workplace']);
            $user->save();

            return redirect()->route('staff.employees.manage', ['user' => $user->code]);
        }

        return redirect()->route('staff.employees.view');
    }
}
