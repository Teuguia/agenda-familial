<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Family;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:parent')->only(['destroy']);
    }

    public function index()
    {
        $member = Auth::user()->member;
        $family = $member->family;
        $members = $family->members()->with('user')->get();
        return view('members.index', compact('family', 'members'));
    }

    public function destroy(Member $member)
    {
        $userMember = Auth::user()->member;
        if ($userMember->family_id !== $member->family_id) {
            abort(403, 'Accès refusé.');
        }

        $member->delete();
        return back()->with('success', 'Membre supprimé.');
    }

    public function updateRole(Request $request, Member $member)
    {
        $request->validate(['role' => 'required|in:parent,child']);

        $userMember = Auth::user()->member;
        if (!$userMember->isParent() || $userMember->family_id !== $member->family_id) {
            abort(403, 'Accès refusé.');
        }

        $member->update(['role' => $request->role]);
        return back()->with('success', 'Rôle mis à jour.');
    }
}
