<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Foundation\Validation\ValidatesRequests; 

class UserController extends Controller
{
    use ValidatesRequests;  // 트레이트 추가

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|max:200|unique:users',
            'snumber' => 'required|unique:users|regex:/^S\d{4}$/',
            'password' => 'required|min:8|confirmed'
        ]);
        // todo add password confirm 
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->snumber = $request->snumber;
        $user->type = 'student';
        $user->password = $request->password;
        $user->save();
        
        $id = $user->id;
        return redirect("user/$id");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        $courses = $user->courses;

        return view('users.show')->with('courses', $courses)->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
