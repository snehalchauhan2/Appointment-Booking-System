<?php

namespace LaraBooking\Repositories;

use LaraBooking\Models\Service;
use LaraBooking\Models\ProviderService;
use LaraBooking\Repositories\Base\CrudRepository;

class ServiceRepository extends CrudRepository {

    /**
     * Specify Model class name
     *
     */
    protected $modelClass = Service::class;

    public function getServices() {
        $query = $this->newQuery();
        $query->filterByUserType();
        
        $query->with('providers');
        $query->orderBy('name');

        return $this->doQueryWithoutPagination($query);
    }

    public function searchAllServices($search) {
        $query = $this->newQuery()->search($search);
        return $this->doQuery($query);
    }

    public function saveService($data) {
        $service = $this->create($data);
        $this->saveServiceProviders($service, $data);

        return $service;
    }

    public function updateService($service, $data) {
        $this->update($service, $data);
        $this->saveServiceProviders($service, $data);

        return $service;
    }

    private function saveServiceProviders($service, $data) {
        $service->providers()->sync($data['providers']);
    }
}

