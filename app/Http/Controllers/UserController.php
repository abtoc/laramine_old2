<?php

namespace App\Http\Controllers;

use App\Enums\UserStatus;
use App\Models\User;
use App\Rules\IdentRule;
use App\UseCases\User\ShowAction;
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
        $query = User::query()
            ->when(!$request->has('status'), function($q){
                return $q->whereStatus(UserStatus::ACTIVE);
            })
            ->when($request->query('status') != UserStatus::ANONYMOUS->value, function($q) use($request){
                return $q->whereStatus($request->query('status', 1));
            })
            ->when(!empty($request->query('name', '')), function($q) use($request) {
                return $q->where('name', 'like', '%'.$request->query('name').'%');
            });
        $users = $query->sortable(['created_at' => 'asc'])->paginate(config('laramine.per_page'));
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
        $request->merge([
            'admin' => $request->has('admin') ? 1 : 0,
            'admin_users' => $request->has('admin_users') ? 1 : 0,
            'admin_projects' => $request->has('admin_projects') ? 1 : 0,
            'must_change_password' => $request->has('must_change_password') ? 1 : 0,
        ]);
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'login' => ['required', 'string', 'max:255', 'unique:users', new IdentRule()],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed', Password::default()],
        ]);

        $user = new User();
        $user->fill($request->all());
        $user->password = Hash::make($request->input('password'));
        $user->save();
        
        return to_route_query('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, ShowAction $action)
    {
        list($projects) = $action($user);
        return view('users.show', compact('user', 'projects'));
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
        $request->merge([
            'admin' => $request->has('admin') ? 1 : 0,
            'admin_users' => $request->has('admin_users') ? 1 : 0,
            'admin_projects' => $request->has('admin_projects') ? 1 : 0,
            'must_change_password' => $request->has('must_change_password') ? 1 : 0,
        ]);
       $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'login' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id), new IdentRule()],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ]);

        $user->fill($request->all());
        $user->save();

        return to_route_query('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    { 
        $user->delete();
        return to_route_query('users.index');
    }

    /** Update the specified resource in storage.
    *
    * @param  \App\Models\User  $user
    * @return \Illuminate\Http\Response
    */
   public function lock(User $user)
   {
        $this->authorize('lock', $user);

        $user->status = UserStatus::LOCKED;
        $user->save();

       return to_route_query('users.index');
   }

   /** Update the specified resource in storage.
    *
    * @param  \App\Models\User  $user
    * @return \Illuminate\Http\Response
    */
    public function unlock(User $user)
    {
        $this->authorize('unlock', $user);

        $user->status = UserStatus::ACTIVE;
        $user->save();
 
        return to_route_query('users.index');
    }
 
 }
