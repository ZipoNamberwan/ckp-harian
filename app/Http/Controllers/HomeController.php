<?php

namespace App\Http\Controllers;

use App\Models\Activities;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user  = User::find(Auth::user()->id);
        $today = date('Y-m-d');
        // $today = '2023-12-15';
        $users = [];
        $staffactivities = null;
        $myactivities = null;
        $total_user_has_entried = 0;
        $users_has_not_entried = [];

        if ($user->hasRole('Admin|Chief')) {
            $staffactivities = Activities::where('user_id', '!=', $user->id)->where('date', $today)->get();
            $users = User::where('id', '!=', $user->id)->where('id', '!=', 1)->get();
        } else if ($user->hasRole('Coordinator')) {
            $staffactivities = Activities::whereIn('user_id', $user->staffs->pluck('id'))->where('date', $today)->get();
            $users = $user->staffs;
        }

        $myactivities = Activities::where('user_id', $user->id)->where('date', $today)->get();


        foreach ($users as $user) {
            if (count($user->activities->where('date', $today)) > 0) {
                $total_user_has_entried++;
            } else {
                $users_has_not_entried[] = $user;
            }
        }

        $total_user = count($users);

        return view('home', [
            'staffactivities' => $staffactivities,
            'myactivities' => $myactivities,
            'total_user_has_entried' => $total_user_has_entried,
            'total_user' => $total_user,
            'users_has_not_entried' => $users_has_not_entried,
            'today' => $today
        ]);
    }
}
