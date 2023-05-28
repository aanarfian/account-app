<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use voku\db\DB;

class UnsecuredAuthController extends Controller
{
    // Create connection
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function register(Request $request)
    {
        $input = $request->all();
        // dd($input);
        $db = DB::getInstance('127.0.0.1:3306', 'root', '', 'accountapp');
        // $validatedData = $request->validate([
        //     'name' => ['required', 'string', 'max:255'],
        //     'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        //     'password' => 'required|confirmed|min:6'
        // ]);

        $input['password'] = bcrypt($input['password']);

        // $db->query('insert into users (name, email, email_verified_at, password, created_at) values (?, ?, ?, ?, ?)', [$validatedData['name'], $validatedData['email'], Carbon::now(),$validatedData['password'], Carbon::now()]);
        // $uri = $request->fullUrl();
        // $db->query
        $time = Carbon::now();
        $db->query("insert into users (name, email, email_verified_at, password, created_at) values ('{$input['name']}', '{$input['email']}', '{$time}','{$input['password']}', '{$time}')");

        // dd("insert into users (name, email, email_verified_at, password, created_at) values ('{$validatedData['name']}', '{$validatedData['email']}', '{$time}','{$validatedData['password']}', '{$time}')");

        // $db->insert( "users", $validatedData);

    return redirect(route('unsecured.registerView'))->with('status', $input['name'].' berhasil ditambahkan'/*.$uri*/);
}


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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
