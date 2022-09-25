<?php

namespace App\Http\Controllers;

use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Models\User;
use App\Rules\IdentRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;


class UserController extends Controller
{
    /**
     * Creation of controller instance
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = User::whereType(UserType::USER);

        if($request->has('status')){
            if($request->query('status') != UserStatus::ANONYMOUS->value){
                $query = $query->whereStatus($request->query('status', 1));
            }
        } else {
            $query = $query->whereStatus(UserStatus::ACTIVE);
        }
        if(!empty($request->query('name', ''))){
            $query = $query->where('name', 'like', '%'.$request->query('name').'%');
        }
        $users = $query->sortable(['created_at' => 'asc'])->paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'login' => ['required', 'string', 'max:255', 'unique:users', new IdentRule()],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed', Password::default()],
        ]);

        $user = new User();
        $user->fill($request->all());
        $user->type = UserType::USER;
        $user->password = Hash::make($request->input('password'));
        $user->save();
        
        return to_route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'login' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id), new IdentRule()],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ]);

        $user->fill($request->all());
        $user->save();

        return to_route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    { 
        $user->delete();
        return to_route('users.index', $request->query());
    }

    /** Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Models\User  $user
    * @return \Illuminate\Http\Response
    */
   public function lock(Request $request, User $user)
   {
        $this->authorize('lock', $user);

        $user->status = UserStatus::LOCKED;
        $user->save();

       return to_route('users.index', $request->query());
   }

   /** Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Models\User  $user
    * @return \Illuminate\Http\Response
    */
    public function unlock(Request $request, User $user)
    {
        $this->authorize('unlock', $user);

        $user->status = UserStatus::ACTIVE;
        $user->save();
 
        return to_route('users.index', $request->query());
    }
 
 }
