<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $users = User::select('id','name','email','account_type')->get();
        return view('user.index',compact('users'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // dd($request->all());
        $request->validate([
            'name' => 'required|min:3|max:100',
            'email' => 'required|unique:users|email',
            'password' => 'required|string|min:6|same:password_confirmation',
        ]);
       
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->account_type = $request->account_type;
            $user->password = Hash::make($request->password);
            $user->save();
            return redirect()->route('user.index')->with('success','User created successfylly');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        
        return view('user.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
        $request->validate([
            'name' => 'required|min:3|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);
       
        try {
            // DB::beginTransaction();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->account_type = $request->account_type;
            $user->save();
            return redirect()->route('user.index')->with('success','User created successfylly');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
      
       try {
        // DB::beginTransaction();
        $user->delete();
        return redirect()->route('user.index')->with('success','User created successfylly');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }
}
