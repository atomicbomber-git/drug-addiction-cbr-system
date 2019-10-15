<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CaseRecord extends Model
{
    protected $table = 'cases';

    protected $perPage = 10;

    const MAX_NEIGHBOR_COUNT = 7;

    public $fillable = [
        'stage', 'solution_id', 'verified'
    ];

    const STAGES = [
        'Ringan', 'Sedang', 'Berat'
    ];

    public function scopeVerified($query)
    {
        return $query->where('verified', 1);
    }

    public function scopeUnverified($query)
    {
        return $query->where('verified', 0);
    }

    public function case_features()
    {
        return $this->hasMany(CaseFeature::class, 'case_id');
    }

    public function solution()
    {
        return $this->belongsTo(Solution::class)
            ->withDefault(['content' => '']);
    }

    public function getKeyedCaseFeaturesAttribute()
    {
        $this->loadMissing("case_features:case_id,feature_id,value");
        return $this->case_features->mapWithKeys(function($case_feature) {
            return [$case_feature['feature_id'] => $case_feature['value']];
        });
    }

    /*
        Prosedur untuk menentukan daftar basis kasus yang terdekat dengan kasus ini,
        diurutkan berdasarkan jarak euclidean dari seluruh basis kasus
        dengan kasus ini, mulai dari yang nilainya terkecil hingga
        yang terbesar
    */
    public function getClosestBaseCases()
    {
        /* Data CaseRecord (kasus) ditarik dari database */
        $base_cases = CaseRecord::select('id', 'stage', 'solution_id')
            ->with([
                'case_features:case_id,feature_id,value', /* Sekaligus menarik data dari case_features yang berisi data tentang masing-masing fitur (gejala) dari setiap kasus */
                'solution:id,content' /* Menarik data solusi */
            ])
            ->verified() /* Memfilter data kasus supaya hanya data yang terverifikasi / basis kasus yang ditarik */
            ->get();

        foreach ($base_cases as $base_case) { /* Untuk setiap basis kasus yang ada, lakukan kedua hal berikut:  */
            $base_case->similarity = $base_case->calculateSimilarity($this); /* 1: Hitung nilai similaritas kasus ini dengan kasus lainnya */
            $base_case->distance = $base_case->calculateDistance($this); /* 2: Hitung nilai jarak euklidean kasus ini dengan kasus lainnya */
        }

        return $base_cases->sortBy("distance")->values(); /* Urutkan seluruh basis kasus dari nilai jarak euclidean yang terkecil hingga yang terbesar */
    }

    /*
        Prosedur untuk menentukan basis kasus yang terdekat dengan sebuah kasus,
        $max_meighbor_count menentukan jumlah neighbor / kasus terdekat yang dikembalikan oleh prosedur ini
    */
    public function getClosestBaseCase($max_neighbor_count = self::MAX_NEIGHBOR_COUNT)
    {
        $closest_base_cases = $this->getClosestBaseCases() /* Menarik semua basis kasus yang ada dan yang telah diurutkan berdasarkan jarak euclidenanya terhadap kasus ini */
            ->values()
            ->take($max_neighbor_count); /* Hanya mengambil sebagian dari seluruh basis kasus yang ada. Jumlah yang diambil ditentukan oleh $max_neighbor_count */

        /*
            Disini basis kasus pada langkah sebelumnya yang memiliki tahapan yang sama dengan tahapan yang paling sering muncul ($stage)
            diurutkan berdasarkan nilai jarak euclidean dan prioritasnya
        */
        $closest_base_cases = $closest_base_cases
            ->sort(
                function ($a, $b) {
                    if ($a->distance == $b->distance) { /* Jika jarak basis kasus A & basis kasus B terhadap jarak kasus ini sama, maka: ... */
                        return $a->similarity < $b->similarity ? 1 : -1; /* ... urutkan berdasarkan similaritas, dimana similaritas yang lebih tinggi berada pada posisi yg lebih tinggi */
                    }
                    else { /* Jika jarak basis kasus A & basis kasus B terhadap jarak kasus ini TIDAK sama, maka: ... */
                        return $a->distance > $b->distance ? 1 : -1; /* ... urutkan berdasarkan jarak euclidean, dimana jarak euclidean yang lebih rendah berada pada posisi yg lebih tinggi  */
                    }
                }
            );

        return $closest_base_cases->first(); /* Setelah diurutkan, pilih data yang paling teratas lalu kembalikan */
    }

    /* Hitung jarak euclidean dari kasus ini dengan $case_record (kasus lain) */
    public function calculateDistance(CaseRecord $case_record)
    {
        $sum = 0; /* Mulai $sum (total) dengan nilai nol */
        foreach ($this->keyed_case_features as $feature_id => $value) { /* Untuk setiap fitur / gejala dari kasus ini */
            $sum += pow($value - $case_record->keyed_case_features[$feature_id], 2); /* Tambahkan (nilai gejala kasus ini - nilai gejala kasus lain)^2 ke $sum */
        }
        return sqrt($sum); /* Akarkan $sum */
    }

    /* Hitng nilai similaritas dari kasus ini dengan $case_record (kasus lain) */
    public function calculateSimilarity(CaseRecord $case_record)
    {
        $case_features_a = $this->keyed_case_features; /* Daftar fitur kasus ini */
        $case_features_b = $case_record->keyed_case_features; /* Daftar fitur kasus lain */

        $numerator = 0; /* Bagian angka diatas pecahan, mulai dengan nol */
        foreach ($case_features_a as $feature_id => $value) { /* Untuk setiap fitur / gejala di kasus ini: */
            $numerator += (
                $this->determineSimilarity($value, $case_features_b[$feature_id]) *
                $this->determineWeight($value, $case_features_b[$feature_id])
            ); /* Tambah dengan similaritas * bobot */
        }

        $denominator = 0; /* Angka dibawah pecahan */
        foreach ($case_features_a as $feature_id => $value) {
            $denominator += (
                $this->determineWeight($value, $case_features_b[$feature_id])
            ); /* Totalkan bobot ke angka dibawah pecahan */
        }

        return $numerator / $denominator; /* Nilai pecahan */
    }

    private function determineSimilarity($a, $b)
    {
        if ($a === 0 && $b === 0) {
            return 0;
        }
        else if ($a === 0 && $b === 1) {
            return 0;
        }
        else if ($a === 1 && $b === 0) {
            return 0;
        }
        else if ($a === 1 && $b === 1) {
            return 1;
        }
        else {
            throw new \Exception("Value error.");
        }
    }

    private function determineWeight($a, $b)
    {
        if ($a === 0 && $b === 0) {
            return 0;
        }
        else if ($a === 0 && $b === 1) {
            return 1;
        }
        else if ($a === 1 && $b === 0) {
            return 1;
        }
        else if ($a === 1 && $b === 1) {
            return 1;
        }
        else {
            throw new \Exception("Value error.");
        }
    }
}
