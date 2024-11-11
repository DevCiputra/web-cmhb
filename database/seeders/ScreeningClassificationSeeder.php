<?php

namespace Database\Seeders;

use App\Models\ScreeningClassification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScreeningClassificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Data klasifikasi berdasarkan ketentuan yang diberikan
        $classifications = [
            // Kategori Total Distres
            [
                'category_name' => 'Stress',  // Ubah dari 'Stres' menjadi 'Stress'
                'classification_name' => 'Normal',
                'min_score' => 0,
                'max_score' => 7,
            ],
            [
                'category_name' => 'Stress',  // Ubah dari 'Stres' menjadi 'Stress'
                'classification_name' => 'Ringan',
                'min_score' => 8,
                'max_score' => 9,
            ],
            [
                'category_name' => 'Stress',  // Ubah dari 'Stres' menjadi 'Stress'
                'classification_name' => 'Sedang',
                'min_score' => 10,
                'max_score' => 12,
            ],
            [
                'category_name' => 'Stress',  // Ubah dari 'Stres' menjadi 'Stress'
                'classification_name' => 'Berat',
                'min_score' => 13,
                'max_score' => 16,
            ],
            [
                'category_name' => 'Stress',  // Ubah dari 'Stres' menjadi 'Stress'
                'classification_name' => 'Sangat Berat',
                'min_score' => 17,
                'max_score' => 30, // >= 30, jadi tanpa max
            ],

            // Kategori Depresi
            [
                'category_name' => 'Depression',  // Ubah dari 'Depresi' menjadi 'Depression'
                'classification_name' => 'Normal',
                'min_score' => 0,
                'max_score' => 4,
            ],
            [
                'category_name' => 'Depression',  // Ubah dari 'Depresi' menjadi 'Depression'
                'classification_name' => 'Ringan',
                'min_score' => 5,
                'max_score' => 6,
            ],
            [
                'category_name' => 'Depression',  // Ubah dari 'Depresi' menjadi 'Depression'
                'classification_name' => 'Sedang',
                'min_score' => 7,
                'max_score' => 10,
            ],
            [
                'category_name' => 'Depression',  // Ubah dari 'Depresi' menjadi 'Depression'
                'classification_name' => 'Berat',
                'min_score' => 11,
                'max_score' => 13,
            ],
            [
                'category_name' => 'Depression',  // Ubah dari 'Depresi' menjadi 'Depression'
                'classification_name' => 'Sangat Berat',
                'min_score' => 14,
                'max_score' => 30, // >= 14, jadi tanpa max
            ],

            // Kategori Kecemasan
            [
                'category_name' => 'Anxiety',  // Ubah dari 'Anxitas' menjadi 'Anxiety'
                'classification_name' => 'Normal',
                'min_score' => 0,
                'max_score' => 3,
            ],
            [
                'category_name' => 'Anxiety',  // Ubah dari 'Anxitas' menjadi 'Anxiety'
                'classification_name' => 'Ringan',
                'min_score' => 4,
                'max_score' => 4,
            ],
            [
                'category_name' => 'Anxiety',  // Ubah dari 'Anxitas' menjadi 'Anxiety'
                'classification_name' => 'Sedang',
                'min_score' => 5,
                'max_score' => 7,
            ],
            [
                'category_name' => 'Anxiety',  // Ubah dari 'Anxitas' menjadi 'Anxiety'
                'classification_name' => 'Berat',
                'min_score' => 8,
                'max_score' => 9,
            ],
            [
                'category_name' => 'Anxiety',  // Ubah dari 'Anxitas' menjadi 'Anxiety'
                'classification_name' => 'Sangat Berat',
                'min_score' => 10,
                'max_score' => 30, // >= 10, jadi tanpa max
            ],
        ];

        // Masukkan data ke dalam tabel screening_classifications
        foreach ($classifications as $classification) {
            ScreeningClassification::create($classification);
        }
    }
}
