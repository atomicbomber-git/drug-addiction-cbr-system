<?php

use Illuminate\Database\Seeder;
use App\Feature;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $features = [
            ['description' => "Mengalami gangguan tidur", 'weight' => 1],
            ['description' => "Mengalami gangguan penglihatan seperti mata merah, gatal, pupil mengecil/membesar", 'weight' => 1],
            ['description' => "Mengalami kesulitan bernafas", 'weight' => 1],
            ['description' => "Mengalami mual dan muntah", 'weight' => 1],
            ['description' => "Merasa pusing dan sakit kepala", 'weight' => 1],
            ['description' => "Mengalami penurunan berat badan", 'weight' => 1],
            ['description' => "Mengalami kesulitan mengingat atau fokus pada sesuatu", 'weight' => 1],
            ['description' => "Mengalami perubahan suasana hati yang signifikan seperti gembira yang berlebihan, kesedihan, putus asa dan kehilangan minat", 'weight' => 1],
            ['description' => "Mengalami kesukaran mengontrol perilaku kasar, termasuk kemarahan atau kekerasan", 'weight' => 1],
            ['description' => "Timbul masalah kulit di sekitar mulut, hidung, dan perubahan warna muka seperti gatal-gatal, bibir pecah-pecah, dan terkelupas", 'weight' => 1],
            ['description' => "Mengalami gejala radang paru-paru, seperti sesak nafas, saat batuk nyeri di paru-paru", 'weight' => 1],
            ['description' => "Mengalami gejala kerusakan hati, lambung, dan ginjal seperti nyeri dibagian hati, lambung, dan ginjal, nyeri saat buang air kecil", 'weight' => 1],
            ['description' => "Pingsan sering terjadi disaat pengguna berkeinginan untuk mengkonsumsi narkoba", 'weight' => 1],
            ['description' => "Mengalami rasa cemas serius atau ketegangan seperti gelisah dan khawatir berlebihan", 'weight' => 1],
            ['description' => "Mengalami halusinasi seperti melihat dan mendengar sesuatu yang tidak ada objeknya", 'weight' => 1],
            ['description' => "Berusaha untuk bunuh diri", 'weight' => 1],
            ['description' => "Tekanan darah menurun, sering mengalami lemas, mata cekung", 'weight' => 1],
            ['description' => "Otot-otot menjadi lemas dan mulai mengalami kelumpuhan berjalan, berdiri, dan tidak mampu berkomunikasi", 'weight' => 1],
        ];

        foreach ($features as $feature) {
            Feature::create($feature);
        }
    }
}



