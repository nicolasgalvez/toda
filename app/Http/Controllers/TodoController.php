<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    use AuthorizesRequests;

    public function index(): Response
    {
        $user = Auth::user();
        if (!$user) {
            abort(401, 'Unauthorized');
        }

        return Inertia::render('Todos/Index', [
            'todos' => $user->todos()->orderBy('created_at', 'desc')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        Auth::user()->todos()->create([
            'title' => $request->title,
            'description' => $request->description ?? null,
            'user_id' => Auth::id(), // ✅ Ensure user_id is set explicitly
        ]);

        return redirect()->route('todos.index');
    }

    public function update(Request $request, Todo $todo)
    {
        $this->authorize('update', $todo);

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'completed' => 'sometimes|boolean', // ✅ Ensure completed is properly handled
        ]);

        $todo->update($validated);

        return redirect()->route('todos.index');
    }

    public function destroy(Todo $todo)
    {
        $this->authorize('delete', $todo);

        if (!$todo) {
            abort(404, 'Todo not found');
        }

        $todo->delete();

        return redirect()->route('todos.index');
    }
}
