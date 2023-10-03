<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class IngredientsController extends Controller
{
    public function view(): View
    {
        return view('views.worker.ingredients.view', ['ingredients' => Ingredient::orderBy('name', 'ASC')->paginate(20)]);
    }

    public function manage(Ingredient $ingredient): View
    {
        return view('views.worker.ingredients.manage', ['ingredient' => $ingredient]);
    }

    public function update(Ingredient $ingredient, Request $request): RedirectResponse
    {
        $valid = $request->validate([
            'name' => 'string|required'
        ]);

        if ($valid) $ingredient->update($request->all());

        return redirect()->route('staff.ingredients.manage', ['ingredient' => strtolower($request['name'])]);
    }

    public function delete(Ingredient $ingredient): RedirectResponse
    {
        $ingredient->meals()->detach();
        $ingredient->delete();

        return redirect()->route('staff.ingredients.view');
    }
}
