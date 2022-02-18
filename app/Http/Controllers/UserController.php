<?php

namespace LaraBooking\Http\Controllers;

use LaraBooking\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use LaraBooking\Http\Requests\StoreUser;
use LaraBooking\Http\Requests\UpdateUser;
use LaraBooking\Repositories\UserRepository;

class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    public function __construct(UserRepository $repository){
        $this->userRepository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('manage', User::class);

        $search = $request->get('search', '');
        $users = $this->userRepository->searchAllUsers($search);

        return view('home.users.index')
            ->with('users', $users)
            ->with('search', $search);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('manage', User::class);
        return view('home.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUser $request)
    {
        $this->authorize('manage', User::class);

        return DB::transaction(function() use ($request) {

            $data = $request->all();
            $user = $this->userRepository->saveUser($data);

            return redirect()->route('home.users.edit', $user->id)
                ->withSuccess('Saved successfuly!');

        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \LaraBooking\Models\User  user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $this->authorize('manage', User::class);
        return view('home.users.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \LaraBooking\Models\User  user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize('manage', User::class);
        return view('home.users.edit')->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \LaraBooking\Models\User  user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUser $request, User $user)
    {
        $this->authorize('manage', User::class);

        return DB::transaction(function() use ($request, $user) {
        
            $data = $request->all();
            $user = $this->userRepository->updateUser($user, $data);

            return redirect()->route('home.users.edit', $user->id)
                ->withSuccess('Saved successfuly!');

        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \LaraBooking\Models\User  user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('manage', User::class);

        return DB::transaction(function() use ($user) {
            
            $this->userRepository->delete($user);
            return redirect()->route('home.users.index');

        });
    }
}
