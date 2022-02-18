<?php

namespace LaraBooking\Repositories;

use LaraBooking\Models\User;
use LaraBooking\Models\UserPhone;
use LaraBooking\Repositories\Base\CrudRepository;

class UserRepository extends CrudRepository {

    /**
     * Specify Model class name
     *
     */
    protected $modelClass = User::class;

    public function searchAllUsers($search) {
        $query = $this->newQuery()->search($search);
        return $this->doQuery($query);
    }

    public function searchAdministrators($search) {
        $query = $this->newQuery()->where('type', 'admin')->search($search);
        return $this->doQuery($query);
    }

    public function searchSecretaries($search) {
        $query = $this->newQuery()->where('type', 'secretary')->search($search);
        return $this->doQuery($query);
    }

    public function searchProviders($search) {
        $query = $this->newQuery()->where('type', 'provider')->search($search);
        return $this->doQuery($query);
    }

    public function searchClients($search) {
        $query = $this->newQuery()->where('type', 'client')->search($search);
        return $this->doQuery($query);
    }

    public function getAdministrators() {
        return $this->newQuery()->where('type', 'admin')->orderBy('name')->get();
    }

    public function getSecretaries() {
        return $this->newQuery()->where('type', 'secretary')->orderBy('name')->get();
    }

    public function getProviders() {
        return $this->newQuery()->where('type', 'provider')->orderBy('name')->get();
    }

    public function getClients() {
        return $this->newQuery()->where('type', 'client')->orderBy('name')->get();
    }

    public function saveClient($data) {
        $data['type'] = 'client';
        return $this->saveUser($data);
    }

    public function updateClient($client, $data) {
        return $this->updateUser($client, $data);
    }

    public function saveProvider($data) {
        $data['type'] = 'provider';
        return $this->saveUser($data);
    }

    public function updateProvider($provider, $data) {
        return $this->updateUser($provider, $data);
    }

    public function saveUser($data) {
        $data = $this->treatUserData($data);

        $user = $this->create($data);
        $this->saveUserPhones($user, $data);

        return $user;
    }

    public function updateUser($user, $data) {
        $data = $this->treatUserData($data);

        if($this->update($user, $data)) {
            $this->saveUserPhones($user, $data);
        }

        return $user;
    }

    private function treatUserData($data) {
        if(isset($data['password']))
            $data['password'] = bcrypt($data['password']);

        return $data;
    }

    private function saveUserPhones($user, $data) {
        $user->phones()->delete();

        if(isset($data['phones'])) {
            $phones = collect($data['phones'])->transform(function($phone) {
                return new UserPhone($phone);
            });

            $user->phones()->saveMany($phones);
        }
    }

    /**
     * This funcion returns all providers, but adds a special attribute
     * that informs the providers that provides the service
     */
    public function getProvidersWithServiceRelation($service) {
        $providers = $this->getProviders();

        foreach ($providers as $provider) {
            $provider->providesThisService = ($service->providers()->wherePivot('provider_id', $provider->id)->count() > 0);
        }

        return $providers;
    }
}