<?php

namespace App\Http\Controllers;

use App\Models\ShoppingList;
use App\Models\ShoppingItem;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShoppingListController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:parent')->only(['create', 'store', 'edit', 'update', 'addItem', 'destroy']);
    }

    public function index()
    {
        $member = Auth::user()->member;
        
        if (!$member) {
            return redirect()->route('family.index')
                           ->with('warning', 'Vous devez rejoindre une famille d\'abord.');
        }
        
        $shoppingLists = ShoppingList::where('family_id', $member->family_id)
                                     ->with('items')
                                     ->get();
        return view('shopping-lists.index', compact('shoppingLists'));
    }

    public function create()
    {
        return view('shopping-lists.create');
    }

    public function store(Request $request)
    {
        $member = Auth::user()->member;
        
        if (!$member) {
            return redirect()->route('family.index')
                           ->with('warning', 'Vous devez rejoindre une famille d\'abord.');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        ShoppingList::create([
            'name'       => $request->name,
            'family_id'  => $member->family_id,
        ]);

        return redirect()->route('shopping-lists.index')
                         ->with('success', 'Liste créée !');
    }

    public function edit(ShoppingList $shoppingList)
    {
        $members = Member::where('family_id', $shoppingList->family_id)
                         ->with('user')->get();
        return view('shopping-lists.edit', compact('shoppingList', 'members'));
    }

    public function update(Request $request, ShoppingList $shoppingList)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $shoppingList->update(['name' => $request->name]);
        return redirect()->route('shopping-lists.index')
                         ->with('success', 'Liste mise à jour.');
    }

    public function destroy(ShoppingList $shoppingList)
    {
        $member = Auth::user()->member;
        if ($member->family_id !== $shoppingList->family_id) {
            abort(403, 'Accès refusé.');
        }

        $shoppingList->delete();
        return redirect()->route('shopping-lists.index')
                         ->with('success', 'Liste supprimée.');
    }

    public function addItem(Request $request, ShoppingList $shoppingList)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'quantity' => 'nullable|integer|min:1',
        ]);

        ShoppingItem::create([
            'name'               => $request->name,
            'quantity'           => $request->quantity ?? 1,
            'shopping_list_id'   => $shoppingList->id,
        ]);

        return back()->with('success', 'Article ajouté !');
    }

    public function toggleItem(Request $request, ShoppingItem $item)
    {
        $item->update(['checked' => !$item->checked]);
        return back()->with('success', 'Article mis à jour.');
    }
}
