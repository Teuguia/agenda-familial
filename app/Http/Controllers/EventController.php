<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:parent')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    public function index()
    {
        $member = Auth::user()->member;
        
        if (!$member) {
            return redirect()->route('family.index')
                           ->with('warning', 'Vous devez rejoindre une famille d\'abord.');
        }
        
        $events   = Event::where('family_id', $member->family_id)
                         ->with('member.user')
                         ->orderBy('start_at')
                         ->get();
        $members  = Member::where('family_id', $member->family_id)
                          ->with('user')->get();
        return view('events.index', compact('events', 'members'));
    }

    public function create()
    {
        $member = Auth::user()->member;
        
        if (!$member) {
            return redirect()->route('family.index')
                           ->with('warning', 'Vous devez rejoindre une famille d\'abord.');
        }
        
        $members = Member::where('family_id', $member->family_id)
                         ->with('user')->get();
        return view('events.create', compact('members'));
    }

    public function store(Request $request)
    {
        $member = Auth::user()->member;
        
        if (!$member) {
            return redirect()->route('family.index')
                           ->with('warning', 'Vous devez rejoindre une famille d\'abord.');
        }
        
        $request->validate([
            'title'     => 'required|string|max:255',
            'start_at'  => 'required|date',
            'end_at'    => 'nullable|date|after:start_at',
            'member_id' => 'required|exists:members,id',
        ]);

        Event::create([
            'title'       => $request->title,
            'description' => $request->description,
            'start_at'    => $request->start_at,
            'end_at'      => $request->end_at,
            'member_id'   => $request->member_id,
            'family_id'   => $member->family_id,
        ]);

        return redirect()->route('events.index')
                         ->with('success', 'Événement créé !');
    }

    public function edit(Event $event)
    {
        $member  = Auth::user()->member;
        $members = Member::where('family_id', $member->family_id)
                         ->with('user')->get();
        return view('events.edit', compact('event', 'members'));
    }

    public function update(Request $request, Event $event)
    {
        $this->authorize('update', $event);
        $request->validate([
            'title'    => 'required|string|max:255',
            'start_at' => 'required|date',
        ]);
        $event->update($request->only(['title', 'description', 'start_at', 'end_at', 'member_id']));
        return redirect()->route('events.index')->with('success', 'Événement mis à jour.');
    }

    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);
        $event->delete();
        return redirect()->route('events.index')->with('success', 'Événement supprimé.');
    }
}
