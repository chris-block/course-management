<?php

use Illuminate\Database\Seeder;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            
            ['id' => 1, 'name' => 'Admin', 'email' => 'admin@admin.com', 'password' => '$2y$10$5QD9IE1g/Fvi5cOhqS2R8OR1YDOlfhqbv1WondrOllz4R/.x/4476', 'role_id' => 1, 'remember_token' => '',],
            ['id' => 2, 'name' => 'Jeff Samuels', 'email' => 'jen@queenofmanifestation.com', 'password' => '$2y$10$6fIoaQSDwQxyOKk0hP/3pu8LEXMnzWZWTQmn.uJJeUMEUxPE0uOvu', 'role_id' => 2, 'remember_token' => null,],

        ];

        foreach ($items as $item) {
            \App\User::create($item);
        }
    }
}
