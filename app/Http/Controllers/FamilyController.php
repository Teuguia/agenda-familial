<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FamilyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:parent')->only(['destroy']);
    }

    public function index()
    {
        $member = Auth::user()->member;
        $family = $member?->family()->with(['members.user', 'events', 'tasks'])->first();
        return view('family.index', compact('family'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->member && Auth::user()->member->role !== 'parent') {
            abort(403, 'Accès refusé. Seul un parent peut créer une famille.');
        }

        $request->validate(['name' => 'required|string|max:255']);

        if (Auth::user()->member) {
            return redirect()->route('family.index')
                             ->with('warning', 'Vous faites déjà partie d’une famille.');
        }

        $family = Family::create([
            'name'       => $request->name,
            'created_by' => Auth::id(),
        ]);

        Member::create([
            'user_id'   => Auth::id(),
            'family_id' => $family->id,
            'role'      => 'parent',
        ]);

        session()->forget('account_type');

        return redirect()->route('family.index')
                         ->with('success', 'Famille créée avec succès !');
    }

    public function join(Request $request)
    {
        if (Auth::user()->member) {
            return redirect()->route('family.index')
                             ->with('warning', 'Vous êtes déjà membre d’une famille.');
        }

        $request->validate(['code' => 'required|string']);

        $family = Family::where('code', $request->code)->firstOrFail();

        Member::firstOrCreate([
            'user_id'   => Auth::id(),
            'family_id' => $family->id,
        ], ['role' => 'child']);

        session()->forget('account_type');

        return redirect()->route('family.index')
                         ->with('success', 'Vous avez rejoint la famille !');
    }

    public function destroy(Family $family)
    {
        $this->authorize('delete', $family);
        $family->delete();
        return redirect()->route('dashboard')
                         ->with('success', 'Famille supprimée.');
    }
}
