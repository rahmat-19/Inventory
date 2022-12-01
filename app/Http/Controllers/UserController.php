<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index', [
            'title' => 'User | Data'
        ]);
    }

    public function create()
    {
        return view('user.create', [
            'title' => 'User | Create',
            'categorys' => Category::all()
        ]);
    }

    public function store(Request $request)
    {
        $akses = $request->akses;

        $validatedData = $request->validate([
            'username' => ['required', 'unique:users', 'max:25'],
            'password' => ['required', 'min:6', 'max:25'],

        ]);

        $validatedData['password'] = bcrypt($validatedData['password']);

        $valid = Auth::user()->create($validatedData)->categories()->attach($akses);

        return redirect(Route('user.index'))->with('success', 'Registered successful!');
    }


    public function destroy(User $user)
    {
        $valid = User::destroy($user->id);
        if ($valid) {
            return redirect(Route('user.index'));
        }
    }
}
