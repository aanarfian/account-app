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
        $input = $request->all();
        $db = DB::getInstance('127.0.0.1:3306', 'root', '', 'accountapp');
        // $input['password'] = bcrypt($input['password']);
        $rawquery = $db->query("select * from users where email = '{$input['email']}'");
        $query = [];
        foreach ($rawquery as $user){
            array_push($query, $user);
        }
        array_push($query, [$request->fullUrl()]);

    return redirect(route('unsecured.loginView'))->with([
        'query' => $query,
    ]);

    }

    public function register(Request $request)
    {
        $input = $request->all();
        // dd($input);
        $db = DB::getInstance('127.0.0.1:3306', 'root', '', 'accountapp');
        $input['password'] = bcrypt($input['password']);
        // $validatedData = $request->validate([
        //     'name' => ['required', 'string', 'max:255'],
        //     'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        //     'password' => 'required|confirmed|min:6'
        // ]);

        // $input['password'] = bcrypt($input['password']);

        // $db->query('insert into users (name, email, email_verified_at, password, created_at) values (?, ?, ?, ?, ?)', [$validatedData['name'], $validatedData['email'], Carbon::now(),$validatedData['password'], Carbon::now()]);
        $uri = $request->fullurl();
        // $db->query
        $time = Carbon::now();
        $db->query("insert into users (email, email_verified_at, password, created_at, name) values ('{$input['email']}', '{$time}','{$input['password']}', '{$time}','{$input['name']}');");

        // // dd("insert into users (name, email, email_verified_at, password, created_at) values ('{$validatedData['name']}', '{$validatedData['email']}', '{$time}','{$validatedData['password']}', '{$time}')");
        // $where = [
        //     'name = ' => $input['name'],
        //     // 'page_type ='         => 'article',
        //     // 'page_type NOT LIKE'  => '%öäü123',
        //     // 'page_id >='          => 2,
        // ];
        // $name = $db->query("select name from users where name = '{$input['name']}'");
        // // $name = $db->select('users', $where);
        // // $resultSelect = $db->execSQL("SELECT name FROM users", true, 3600);

        // // dd($name[0]);
        // // $db->insert( "users", $validatedData);
        // $query = [];
        // foreach ($name as $user){
        //     array_push($query, $user);
        // }

    return redirect(route('unsecured.registerView'))->with([
        'status' => $input['name'].' berhasil ditambahkan '/*.$uri*/,
        // 'query' => $query,
    ]);
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
