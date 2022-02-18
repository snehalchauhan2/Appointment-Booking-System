<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Providers
        factory(LaraBooking\Models\User::class, 1)->create([
            'name' => 'Dr John (Provider)',
            'email' => 'john@john.com',
            'type' => 'provider',
            'password' => bcrypt('john')
        ])->each(function($user) {
            $user->services()->save(factory(LaraBooking\Models\Service::class)->make());
        });

        factory(LaraBooking\Models\User::class, 1)->create([
            'name' => 'Dr Joane (Provider)',
            'email' => 'joane@joane.com',
            'type' => 'provider',
            'password' => bcrypt('joane')
        ])->each(function($user) {
            $user->services()->save(factory(LaraBooking\Models\Service::class)->make());
        });

        // Clients
        
        // Basic Client
        factory(LaraBooking\Models\User::class, 1)->create([
            'email' => 'client@client.com',
            'type' => 'client',
            'password' => bcrypt('client')
        ]);

        // Random Clients
        factory(LaraBooking\Models\User::class, 5)->create([
            'type' => 'client'
        ]);

        // Secretaries
        factory(LaraBooking\Models\User::class, 1)->create([
            'name' => 'Mary (Secretary)',
            'email' => 'mary@mary.com',
            'type' => 'secretary',
            'password' => bcrypt('mary')
        ]);

        factory(LaraBooking\Models\User::class, 1)->create([
            'name' => 'Joseph (Secretary)',
            'email' => 'joseph@joseph.com',
            'type' => 'secretary',
            'password' => bcrypt('joseph')
        ]);
    }
}
