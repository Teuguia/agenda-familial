<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Member;
use App\Notifications\TaskAssigned;
use App\Notifications\TaskStatusChanged;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
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
        
        $tasks  = Task::where('family_id', $member->family_id)
                      ->with('assignee.user')
                      ->orderBy('due_date')
                      ->get();
        $members = Member::where('family_id', $member->family_id)
                         ->with('user')->get();
        return view('tasks.index', compact('tasks', 'members'));
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
        return view('tasks.create', compact('members'));
    }

    public function store(Request $request)
    {
        $member = Auth::user()->member;
        
        if (!$member) {
            return redirect()->route('family.index')
                           ->with('warning', 'Vous devez rejoindre une famille d\'abord.');
        }
        
        $request->validate([
            'title'       => 'required|string|max:255',
            'assigned_to' => 'required|exists:members,id',
            'due_date'    => 'nullable|date',
        ]);

        $task = Task::create([
            'title'       => $request->title,
            'description' => $request->description,
            'status'      => 'todo',
            'due_date'    => $request->due_date,
            'assigned_to' => $request->assigned_to,
            'family_id'   => $member->family_id,
        ]);

        // Notification à la personne assignée
        $assignee = Member::find($request->assigned_to);
        $assignee->user->notify(new TaskAssigned($task));

        return redirect()->route('tasks.index')->with('success', 'Tâche créée !');
    }

    public function edit(Task $task)
    {
        $member  = Auth::user()->member;
        $members = Member::where('family_id', $member->family_id)
                         ->with('user')->get();
        return view('tasks.edit', compact('task', 'members'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'assigned_to' => 'required|exists:members,id',
            'due_date'    => 'nullable|date',
        ]);

        $task->update($request->only(['title', 'description', 'assigned_to', 'due_date']));
        return redirect()->route('tasks.index')->with('success', 'Tâche mise à jour.');
    }

    public function updateStatus(Request $request, Task $task)
    {
        $request->validate(['status' => 'required|in:todo,in_progress,done']);
        $oldStatus = $task->status;
        $task->update(['status' => $request->status]);
        
        // Notifier les parents quand un enfant change le statut
        $member = Auth::user()->member;
        if ($member && $member->isChild()) {
            $family = $member->family;
            $parents = Member::where('family_id', $family->id)
                             ->where('role', 'parent')
                             ->with('user')
                             ->get();
            
            foreach ($parents as $parent) {
                $parent->user->notify(new TaskStatusChanged($task, Auth::user()->name));
            }
        }
        
        return back()->with('success', 'Statut mis à jour.');
    }

    public function destroy(Task $task)
    {
        $member = Auth::user()->member;
        // Only parent can delete, or the assigned person
        if ($member->isParent() || $task->assigned_to === $member->id) {
            $task->delete();
            return back()->with('success', 'Tâche supprimée.');
        }
        abort(403, 'Accès refusé.');
    }
}
