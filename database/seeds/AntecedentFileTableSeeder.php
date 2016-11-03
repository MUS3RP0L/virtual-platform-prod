<?php

use Illuminate\Database\Seeder;

class AntecedentFileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    public function run()
    {
        Eloquent::unguard();

        $this->createAntecedentFiles();

        Eloquent::reguard();
    }

    private function createAntecedentFiles()
    {
        $statuses = [

            ['name' => 'ANTICIPO FONDO DE RETIRO POLICIAL(LETRA"A"/LETRA"C")','shortened' =>'FRP-ANT'],
            ['name' => 'FONDO DE RETIRO POR JUBILACIÓN','shortened' => 'FRP-JUB'],
            ['name' => 'FONDO DE RETIRO POLICIAL Y CUOTA MORTUORIA','shortened' => 'FRP-CM'],
            ['name' => 'FONDO DE RETIRO VOLUNTARIO(A)', 'shortened' => 'FRP-RV'],
            ['name' => 'FONDO DE RETIRO FORZOSO', 'shortened' => 'FRP-RF'],
            ['name' => 'CUOTA MORTUORIA CONYUGUE FALLECIDA(O)', 'shortened' => 'CM-CF'],
            ['name' => 'CUOTA MORTUORIA TITULAR FALLECIDO(A)', 'shortened' => 'CM-TF'],
            ['name' => 'AUXILIO MORTUORIO TITULAR FALLECIDO(A)', 'shortened' => 'AM-TF'],
            ['name' => 'AUXILIO MORTUORIO CONYUGUE FALLECIDA', 'shortened' => 'AM-CF'],            
            ['name' => 'AUXILIO MORTUORIO VIUDA FALLECIDA', 'shortened' => 'AM-VF'],
            ['name' => 'APORTE VOLUNTARIO', 'shortened' => 'A.V.'],
            ['name' => 'EXPEDIENTE TRANSITORIO', 'shortened' => 'ET'],

         ];

        foreach ($statuses as $status) {
         
            Muserpol\AntecedentFile::create($status);
            
        }
    }
}
