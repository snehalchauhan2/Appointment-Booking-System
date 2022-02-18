<?php

namespace LaraBooking\Http\Controllers;

use LaraBooking\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use LaraBooking\Http\Requests\StoreClient;
use LaraBooking\Repositories\UserRepository;

class ClientController extends Controller
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
        $this->authorize('view-client', User::class);

        if($request->wantsJson()) {
            $clients = $this->userRepository->getClients();
            return response()->json(compact('clients')); 
        }else{

            $search = $request->get('search', '');
            $clients = $this->userRepository->searchClients($search);

            return view('home.clients.index')
                ->with('clients', $clients)
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
        $this->authorize('create-client', User::class);
        return view('home.clients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClient $request)
    {
        $this->authorize('create-client', User::class);

        return DB::transaction(function() use ($request) {

            $data = $request->all();
            $client = $this->userRepository->saveClient($data);

            return redirect()->route('home.clients.edit', $client->id)
                ->withSuccess('Saved successfuly!');

        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \LaraBooking\Models\User  client
     * @return \Illuminate\Http\Response
     */
    public function show(User $client)
    {
        $this->authorize('view-client', User::class);
        return view('home.clients.show')->with('client', $client);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \LaraBooking\Models\User  client
     * @return \Illuminate\Http\Response
     */
    public function edit(User $client)
    {
        $this->authorize('update-client', User::class);
        return view('home.clients.edit')->with('client', $client);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \LaraBooking\Models\User  client
     * @return \Illuminate\Http\Response
     */
    public function update(StoreClient $request, User $client)
    {
        $this->authorize('update-client', User::class);

        return DB::transaction(function() use ($request, $client) {

            $data = $request->all();
            $client = $this->userRepository->updateClient($client, $data);

            return redirect()->route('home.clients.edit', $client->id)
                ->withSuccess('Saved successfuly!');

        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \LaraBooking\Models\User  client
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $client)
    {
        $this->authorize('delete-client', User::class);
        
        return DB::transaction(function() use ($client) {

            $this->userRepository->delete($client);
            return redirect()->route('home.clients.index');

        });
    }
}
