<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{

    public function index()
    {
        $user = auth()->user();
        $todos = $user->todos()->latest()->get();

        $total_todos = $todos->count();
        $completed_todos = $todos->where('is_completed', true)->count();
        $remaining_todos = $total_todos - $completed_todos;

        // Kirim semua data ke view
        return view('todos.index', [
            'todos' => $todos,
            'total_todos' => $total_todos,
            'completed_todos' => $completed_todos,
            'remaining_todos' => $remaining_todos,
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        auth()->user()->todos()->create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Tugas berhasil ditambahkan!');
    }

    public function update(Todo $todo)
    {
        if (auth()->user()->id !== $todo->user_id) {
            abort(403);
        }

        $todo->update(['is_completed' => !$todo->is_completed]);

        return back()->with('success', 'Status tugas berhasil diperbarui!');
    }

    public function destroy(Todo $todo)
    {
        if (auth()->user()->id !== $todo->user_id) {
            abort(403);
        }

        $todo->delete();

        return back()->with('success', 'Tugas berhasil dihapus!');
    }

    public function edit(Todo $todo)
    {
        // Pastikan user hanya bisa mengedit todo miliknya sendiri
        if (auth()->user()->id !== $todo->user_id) {
            abort(403);
        }

        return view('todos.edit', ['todo' => $todo]);
    }

    /**
     * Mengupdate data tugas di database.
     */
    public function updateData(Request $request, Todo $todo)
    {
        if (auth()->user()->id !== $todo->user_id) {
            abort(403);
        }

        // Validasi input
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Update data
        $todo->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('todos.index')->with('success', 'Tugas berhasil diperbarui!');
    }
}
