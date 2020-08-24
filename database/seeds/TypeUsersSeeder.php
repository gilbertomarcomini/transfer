<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\TypeUser;

class TypeUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            ["name" => "Cliente", "created_at" => now(), "updated_at" => now()],
            ["name" => "Lojista", "created_at" => now(), "updated_at" => now()],
        ];
        
        TypeUser::insert($datas);
    }
}
