<?php

use Illuminate\Database\Seeder;
use App\CaseRecord;
use App\CaseFeature;
use App\Feature;
use App\Solution;

class CaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $solutions = [];
        $solutions[0] = Solution::create(['content' => "Rehabilitasi rawat jalan, seperti: terapi obat-obatan (farmakoterapi), terapi singkat, konseling adiksi, psikoedukasi keluarga dan kelompok bantu diri antara sesama pengguna"]);
        $solutions[1] = Solution::create(['content' => "Rehabilitasi rawat inap, seperti: detoksifikasi dan pengobatan, pendekatan psikososial dan spiritual, jangka pendek dan jangka panjang"]);

        $cases = [
            ['features' => [1, 0, 1, 1, 0, 1, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0], 'stage' => 'Ringan', 'solution_id' => $solutions[0]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0], 'stage' => 'Ringan', 'solution_id' => $solutions[0]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 0, 1, 0, 0, 1, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0], 'stage' => 'Ringan', 'solution_id' => $solutions[0]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 1, 1, 0, 1, 0, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0], 'stage' => 'Ringan', 'solution_id' => $solutions[0]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [0, 1, 1, 1, 1, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0], 'stage' => 'Ringan', 'solution_id' => $solutions[0]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 1, 0, 1, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0], 'stage' => 'Ringan', 'solution_id' => $solutions[0]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 1, 0, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0], 'stage' => 'Ringan', 'solution_id' => $solutions[0]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 0, 1, 1, 0, 0, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0], 'stage' => 'Ringan', 'solution_id' => $solutions[0]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 1, 0, 0, 1, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0], 'stage' => 'Ringan', 'solution_id' => $solutions[0]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 0, 1, 1, 0, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0], 'stage' => 'Ringan', 'solution_id' => $solutions[0]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 0, 1, 1, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0], 'stage' => 'Ringan', 'solution_id' => $solutions[0]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 1, 0, 1, 0, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0], 'stage' => 'Ringan', 'solution_id' => $solutions[0]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 1, 1, 0, 0, 1, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0], 'stage' => 'Ringan', 'solution_id' => $solutions[0]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [0, 0, 1, 1, 0, 0, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0], 'stage' => 'Ringan', 'solution_id' => $solutions[0]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [0, 1, 0, 1, 0, 1, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0], 'stage' => 'Ringan', 'solution_id' => $solutions[0]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 1, 0, 1, 0, 1, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0], 'stage' => 'Ringan', 'solution_id' => $solutions[0]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 1, 1, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0], 'stage' => 'Ringan', 'solution_id' => $solutions[0]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 1, 1, 1, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0], 'stage' => 'Ringan', 'solution_id' => $solutions[0]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 1, 0, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0], 'stage' => 'Ringan', 'solution_id' => $solutions[0]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 0, 1, 1, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0], 'stage' => 'Ringan', 'solution_id' => $solutions[0]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 1, 0, 1, 1, 1, 1, 0, 1, 0, 0, 1, 1, 1, 0, 0, 0, 0], 'stage' => 'Sedang', 'solution_id' => $solutions[0]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 0, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 0, 1, 0, 0, 0, 0], 'stage' => 'Sedang', 'solution_id' => $solutions[0]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 0, 1, 1, 0, 1, 1, 1, 1, 0, 1, 0, 0, 1, 0, 0, 0, 0], 'stage' => 'Sedang', 'solution_id' => $solutions[0]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 1, 0, 1, 0, 0, 1, 1, 1, 1, 1, 0, 1, 1, 0, 0, 0, 0], 'stage' => 'Sedang', 'solution_id' => $solutions[0]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 0, 1, 1, 0, 0, 0, 0], 'stage' => 'Sedang', 'solution_id' => $solutions[0]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 1, 1, 0, 1, 0, 1, 1, 1, 0, 1, 1, 1, 1, 0, 0, 0, 0], 'stage' => 'Sedang', 'solution_id' => $solutions[0]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 0, 1, 0, 0, 0, 0], 'stage' => 'Sedang', 'solution_id' => $solutions[0]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 0, 0, 1, 1, 1, 1, 1, 1, 0, 0, 1, 1, 1, 0, 0, 0, 0], 'stage' => 'Sedang', 'solution_id' => $solutions[0]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 1, 1, 1, 1, 1, 0, 1, 1, 0, 1, 0, 1, 0, 0, 0, 0, 0], 'stage' => 'Sedang', 'solution_id' => $solutions[0]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0], 'stage' => 'Sedang', 'solution_id' => $solutions[0]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 0, 0, 1, 0, 0, 0, 0], 'stage' => 'Sedang', 'solution_id' => $solutions[0]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 0, 1, 0, 1, 0, 0, 0, 0], 'stage' => 'Sedang', 'solution_id' => $solutions[0]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 1, 1, 1, 0, 1, 0, 1, 1, 0, 1, 1, 1, 1, 0, 0, 0, 0], 'stage' => 'Sedang', 'solution_id' => $solutions[0]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 0, 1, 1, 1, 1, 0, 1, 1, 0, 1, 0, 0, 1, 0, 0, 0, 0], 'stage' => 'Sedang', 'solution_id' => $solutions[0]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [0, 1, 1, 1, 1, 1, 0, 1, 1, 1, 0, 1, 0, 1, 0, 0, 0, 0], 'stage' => 'Sedang', 'solution_id' => $solutions[0]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 0, 1, 1, 0, 1, 1, 0, 1, 1, 1, 1, 0, 1, 0, 0, 0, 0], 'stage' => 'Sedang', 'solution_id' => $solutions[0]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 0, 1, 1, 0, 0, 0, 0], 'stage' => 'Sedang', 'solution_id' => $solutions[0]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 0, 1, 0, 0, 0, 0], 'stage' => 'Sedang', 'solution_id' => $solutions[0]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 0, 0, 0], 'stage' => 'Sedang', 'solution_id' => $solutions[0]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 0, 1, 1, 0, 0, 0, 0], 'stage' => 'Sedang', 'solution_id' => $solutions[0]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 1, 1, 1, 1, 1, 1, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0], 'stage' => 'Berat', 'solution_id' => $solutions[1]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1], 'stage' => 'Berat', 'solution_id' => $solutions[1]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 0, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1], 'stage' => 'Berat', 'solution_id' => $solutions[1]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 1, 1, 1, 1, 0, 1, 1, 1, 0, 1, 1, 0, 1, 1, 1, 1, 1], 'stage' => 'Berat', 'solution_id' => $solutions[1]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 0, 1, 1], 'stage' => 'Berat', 'solution_id' => $solutions[1]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 0, 1, 1, 1, 0, 1, 1], 'stage' => 'Berat', 'solution_id' => $solutions[1]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0], 'stage' => 'Berat', 'solution_id' => $solutions[1]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 1, 1, 1, 1, 1, 0, 1, 1, 0, 1, 1, 1, 1, 1, 0, 1, 1], 'stage' => 'Berat', 'solution_id' => $solutions[1]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 0, 1, 1, 0, 1, 1], 'stage' => 'Berat', 'solution_id' => $solutions[1]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 1, 0, 1, 1, 1], 'stage' => 'Berat', 'solution_id' => $solutions[1]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1, 0, 0, 1, 1], 'stage' => 'Berat', 'solution_id' => $solutions[1]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 1, 1], 'stage' => 'Berat', 'solution_id' => $solutions[1]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0], 'stage' => 'Berat', 'solution_id' => $solutions[1]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1], 'stage' => 'Berat', 'solution_id' => $solutions[1]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1], 'stage' => 'Berat', 'solution_id' => $solutions[1]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 0, 1, 1, 0, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 0], 'stage' => 'Berat', 'solution_id' => $solutions[1]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 1, 0, 1, 1, 0, 1, 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1], 'stage' => 'Berat', 'solution_id' => $solutions[1]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1], 'stage' => 'Berat', 'solution_id' => $solutions[1]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 1, 1, 0, 1, 1], 'stage' => 'Berat', 'solution_id' => $solutions[1]->id, 'recommendation' => '', 'verified' => 1],
            ['features' => [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 1, 1], 'stage' => 'Berat', 'solution_id' => $solutions[1]->id, 'recommendation' => '', 'verified' => 1],
        ];

        // Seed verified cases
        DB::transaction(function() use($cases) {
            foreach ($cases as $case) {
                $case = collect($case);
                $new_case = CaseRecord::create($case->only(['stage', 'solution_id', 'recommendation', 'verified'])->toArray());
                
                foreach ($case['features'] as $key => $value) {
                    CaseFeature::create([
                        'case_id' => $new_case->id,
                        'feature_id' => $key + 1,
                        'value' => $value
                    ]);
                }
            }
        });

        // Seed unverified cases
        DB::transaction(function() use($solutions) {
            $feature_ids = Feature::select('id')->pluck('id');

            factory(CaseRecord::class, 10)
                ->make(['verified' => 0])
                ->each(function($case) use($feature_ids, $solutions) {
                    $case->solution_id = $solutions[rand(0, 1)]->id;
                    $case->save();

                    foreach ($feature_ids as $feature_id) {
                        CaseFeature::create([
                            'case_id' => $case->id,
                            'feature_id' => $feature_id,
                            'value' => rand(0, 1)
                        ]);
                    }
                });
        });
    }
}
