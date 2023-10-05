<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use App\Models\Meal;
use App\Services\MealServices;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MealsController extends Controller
{
    public function view(): View
    {
        return view('views.worker.meals.view', ['meals' => Meal::orderBy('name', 'ASC')->get()]);
    }

    public function manage(Meal $meal): View
    {
        return view('views.worker.meals.manage', ['meal' => $meal, 'ingredients' => Ingredient::orderBy('name', 'ASC')->pluck('name')]);
    }

    public function update(Meal $meal, Request $request): RedirectResponse
    {
        $valid = $request->validate([
            'name' => 'string|required',
            'price' => 'numeric|required',
            'ingredients' => 'required|array|min:1',
            'ingredients.*' => 'required|string|exists:ingredients,name'
        ]);

        if ($valid) {
            $meal->update($request->all());
            $meal->ingredients()->detach();
            $meal->ingredients()->attach(Ingredient::whereIn('name', $valid['ingredients'])->pluck('id'));
        }

        return redirect()->route('staff.meals.manage', ['meal' => strtolower($request['name'])]);
    }

    public function delete(Meal $meal): RedirectResponse
    {
        $meal->meals()->detach();
        $meal->delete();

        return redirect()->route('staff.meals.view');
    }

    public function createView(): View
    {
        return view('views.worker.meals.create', ['ingredients' => Ingredient::orderBy('name', 'ASC')->pluck('name')]);
    }

    public function createHandle(Request $request): RedirectResponse
    {
        $valid = $request->validate([
            'name' => 'string|required',
            'price' => 'numeric|required',
            'ingredients' => 'required|array|min:1',
            'ingredients.*' => 'required|string|exists:ingredients,name'
        ]);

        if ($valid) {
            MealServices::createMeal(['name' => $valid['name'], 'price' => $valid['price']], $valid['ingredients']);
        }

        return redirect()->route('staff.meals.view');
    }
}
