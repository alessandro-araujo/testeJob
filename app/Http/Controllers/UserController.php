<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function view()
    {
        return view('user.index');
    }

    public function edit()
    {
        $user = Auth::user();
        return view('user.edit', compact('user'));
    }

    public function store(UserRequest $request)
    {
        $request->validated();
        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'password' => $request->password,
                'rm' => $request->rm,
                'directorship' => $request->directorship
            ]);
            return redirect()->route('user.view')->with('success', 'Usuário cadastrado com sucesso!');
        } catch (QueryException $e) {
            return redirect()->back()->with('error', $e);
        }
    }

    public function update(UserRequest $request, User $user)
    {
        $request->validated();

        Student::where('rm_student', $user->rm)->update([
            'rm_student' => $request->rm
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'rm' => $request->rm,
            'directorship' => $request->directorship,
        ]);


        return redirect()->route('user.edit', ['user' => $user->id ])->with('success', 'Usuário editado com sucesso!');
    }
    public function destroy()
    {
        //  coding...
    }
}
