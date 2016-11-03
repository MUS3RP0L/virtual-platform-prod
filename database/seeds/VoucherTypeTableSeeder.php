<?php

use Illuminate\Database\Seeder;

class VoucherTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        $this->createVoucherType();

        Eloquent::reguard();
    }

    private function createVoucherType()
    {
        $statuses = [

            ['name' => 'Pago de Aporte Directo']

        ];

        foreach ($statuses as $status) {

            Muserpol\VoucherType::create($status);
        }
    }
}
