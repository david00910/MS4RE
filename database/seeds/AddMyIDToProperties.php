<?php

use Illuminate\Database\Seeder;

class AddMyIDToProperties extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('properties')->update([
            'created_by' => 1
        ]);
    }
}
