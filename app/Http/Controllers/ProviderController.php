<?php

namespace LaraBooking\Http\Controllers;

use LaraBooking\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use LaraBooking\Repositories\UserRepository;
use LaraBooking\Http\Requests\StoreProvider;
use LaraBooking\Http\Requests\UpdateProvider;

class ProviderController extends Controller
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
        $this->authorize('view-provider', User::class);

        if($request->wantsJson()) {
            $providers = $this->userRepository->getProviders();
            return response()->json(compact('providers')); 
        }else{
            $search = $request->get('search', '');
            $providers = $this->userRepository->searchProviders($search);

            return view('home.providers.index')
                ->with('providers', $providers)
                ->with('search', $search);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-provider', User::class);
        return view('home.providers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProvider $request)
    {
        $this->authorize('create-provider', User::class);

        return DB::transaction(function() use ($request) {

            $data = $request->all();
            $provider = $this->userRepository->saveProvider($data);

            return redirect()->route('home.providers.edit', $provider->id)
                ->withSuccess('Saved successfuly!');

        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \LaraBooking\Models\User  provider
     * @return \Illuminate\Http\Response
     */
    public function show(User $provider)
    {
        $this->authorize('view-provider', User::class);
        return view('home.providers.show')->with('provider', $provider);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \LaraBooking\Models\User  provider
     * @return \Illuminate\Http\Response
     */
    public function edit(User $provider)
    {
        $this->authorize('update-provider', User::class);
        return view('home.providers.edit')->with('provider', $provider);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \LaraBooking\Models\User  provider
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProvider $request, User $provider)
    {
        $this->authorize('update-provider', User::class);

        return DB::transaction(function() use ($request, $provider) {

            $data = $request->all();
            $provider = $this->userRepository->updateProvider($provider, $data);

            return redirect()->route('home.providers.edit', $provider->id)
                ->withSuccess('Saved successfuly!');

        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \LaraBooking\Models\User  provider
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $provider)
    {
        $this->authorize('delete-provider', User::class);

        return DB::transaction(function() use ($provider) {

            if(!$provider->providerAppointments->isEmpty()) {
                return back()->withErrors('This provider can\'t be removed because has dependent appointments!');
            }

            if(!$provider->services->isEmpty()) {
                return back()->withErrors('This provider can\'t be removed because has dependent services!');
            }

            $this->userRepository->delete($provider);
            return redirect()->route('home.providers.index');
            
        });
    }
}
