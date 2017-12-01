<?php

use Illuminate\Database\Seeder;

class team extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(\App\Team);
        App\Team::create(
            [
                'name' => 'IT Hà Nội'
            ],
            [
                'name' => 'IT Đà Nẵng'
            ]
        );

    }
}
