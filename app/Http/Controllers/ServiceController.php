<?php

namespace LaraBooking\Http\Controllers;

use Illuminate\Http\Request;
use LaraBooking\Models\Service;
use Illuminate\Support\Facades\DB;
use LaraBooking\Http\Requests\StoreService;
use LaraBooking\Repositories\UserRepository;
use LaraBooking\Repositories\ServiceRepository;
use LaraBooking\Services\ServiceAvailableTimes;

class ServiceController extends Controller
{
    /**
     * @var ServiceRepository
     */
    protected $serviceRepository;

    /**
     * @var UserRepository
     */
    protected $userRepository;

    public function __construct(ServiceRepository $repository, UserRepository $userRepository){
        $this->serviceRepository = $repository;
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', Service::class);

        $search = $request->get('search', '');
        $services = $this->serviceRepository->searchAllServices($search);

        return view('home.services.index')
            ->with('services', $services)
            ->with('search', $search);

    }

    /**
     * Resturns a listing of the resource (JSON).
     *
     * @return \Illuminate\Http\Response
     */
    public function indexJson(Request $request)
    {
        $this->authorize('view', Service::class);

        $services = $this->serviceRepository->getServices();
        return response()->json(compact('services'));
    }

    /**
     * Resturns disponible times.
     *
     * @return \Illuminate\Http\Response
     */
    public function availableTimes(Request $request, $service_id)
    {
        $this->authorize('view', Service::class);

        $date = $request->get('date');
        $provider = $this->userRepository->findByID($request->get('provider'));
        $service = $this->serviceRepository->findByID($service_id);

        $times = (new ServiceAvailableTimes($date, $service, $provider))->getAvailableTimes();

        return response()->json(compact('times'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Service::class);

        $providers = $this->userRepository->getProviders();

        return view('home.services.create')
            ->with('providers', $providers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreService $request)
    {
        $this->authorize('create', Service::class);

        return DB::transaction(function() use ($request) {

            $data = $request->all();
            $service = $this->serviceRepository->saveService($data);

            return redirect()->route('home.services.edit', $service->id)
                ->withSuccess('Saved successfuly!');

        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \LaraBooking\Models\Service  service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        $this->authorize('view', Service::class);
        return view('home.services.show')->with('service', $service);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \LaraBooking\Models\Service  service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        $this->authorize('update', Service::class);
        $providers = $this->userRepository->getProvidersWithServiceRelation($service);

        return view('home.services.edit')
            ->with('service', $service)
            ->with('providers', $providers);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \LaraBooking\Models\Service  service
     * @return \Illuminate\Http\Response
     */
    public function update(StoreService $request, Service $service)
    {
        $this->authorize('update', Service::class);

        return DB::transaction(function() use ($request, $service) {
            
            $data = $request->all();
            $this->serviceRepository->updateService($service, $data);

            return redirect()->route('home.services.edit', $service->id)
                ->withSuccess('Saved successfuly!');

        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \LaraBooking\Models\Service  service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        $this->authorize('delete', Service::class);

        return DB::transaction(function() use ($service) {
            
            if(!$service->appointments->isEmpty()) {
                return back()->withErrors('This service can\'t be removed because it has dependent appointments!');
            }

            if(!$service->providers->isEmpty()) {
                return back()->withErrors('This service can\'t be removed because it is related with providers!');
            }

            $this->serviceRepository->delete($service);
            return redirect()->route('home.services.index');
        
        });
    }
}
