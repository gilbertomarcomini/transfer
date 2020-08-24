<?php

use App\Models\TypeTransaction;
use Illuminate\Database\Seeder;

class TypeTransactionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            ["name" => "Transferência", "created_at" => now(), "updated_at" => now()],
        ];

        TypeTransaction::insert($datas);
    }
}
