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
        return Inertia::render('Todos/Index', [
            'todos' => Auth::user()->todos()->orderBy('created_at', 'desc')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        Auth::user()->todos()->create($request->only('title', 'description'));

        return redirect()->route('todos.index');
    }

    public function update(Request $request, Todo $todo)
    {
        $this->authorize('update', $todo);

        $todo->update($request->only('title', 'description', 'completed'));

        return redirect()->route('todos.index');
    }

    public function destroy(Todo $todo)
    {
        $this->authorize('delete', $todo);
        $todo->delete();

        return redirect()->route('todos.index');
    }

}
