<?php

namespace Database\Seeders;

use App\Models\QuestionCategory;
use App\Models\ScreeningOption;
use App\Models\ScreeningQuestion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScreeningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Buat kategori dan simpan ID-nya
        $categories = [
            'Depression' => null,
            'Anxiety' => null,
            'Stress' => null,
        ];

        foreach ($categories as $name => &$id) {
            $category = QuestionCategory::create(['name' => $name]);
            $id = $category->id; // Simpan ID kategori
        }

        // Soal dengan ID kategori terkait
        $questions = [
            ['Saya merasa sulit untuk relaks / santai', $categories['Stress']],
            ['Saya merasa mulut saya sering kering.', $categories['Anxiety']],
            ['Saya sama sekali tidak dapat merasakan perasaan positif.', $categories['Depression']],
            ['Saya merasa sulit nafas / sesak (padahal tidak melakukan aktivitas fisik sebelumnya).', $categories['Anxiety']],
            ['Saya merasa sulit berinisiatif melakukan sesuatu.', $categories['Depression']],
            ['Saya cenderung bereaksi berlebihan terhadap suatu situasi.', $categories['Stress']],
            ['Saya merasa gemetar (misal: pada tangan).', $categories['Anxiety']],
            ['Saya merasa menghabiskan banyak energi saat merasa cemas.', $categories['Stress']],
            ['Saya khawatir dengan situasi di mana saya mungkin menjadi panik dan mempermalukan diri sendiri.', $categories['Anxiety']],
            ['Saya merasa tidak ada lagi hal yang dapat diharapkan di masa depan.', $categories['Depression']],
            ['Saya merasa gelisah.', $categories['Stress']],
            ['Saya merasa sulit untuk tenang / santai', $categories['Stress']],
            ['Saya merasa sedih dan tertekan', $categories['Depression']],
            ['Saya sulit untuk mentoleransi gangguan yang terjadi saat saya sedang mengerjakan sesuatu.', $categories['Stress']],
            ['Saya merasa hampir panik', $categories['Anxiety']],
            ['Saya merasa tidak antusias dalam hal apapun.', $categories['Depression']],
            ['Saya merasa sebagai orang yang tidak berharga.', $categories['Depression']],
            ['Saya merasa mudah tersinggung.', $categories['Stress']],
            ['Saya merasakan perubahan detak jantung saya, walaupun tidak sehabis melakukan aktivitas fisik', $categories['Anxiety']],
            ['Saya merasa takut tanpa alasan yang jelas.', $categories['Anxiety']],
            ['Saya merasa hidup ini tidak berarti.', $categories['Depression']],
        ];

        // Opsi yang sama untuk setiap soal
        $options = [
            ['option_text' => 'Tidak Pernah', 'weight' => 0],
            ['option_text' => 'Kadang-kadang', 'weight' => 1],
            ['option_text' => 'Sering', 'weight' => 2],
            ['option_text' => 'Selalu', 'weight' => 3],
        ];

        // Memasukkan data soal dan opsi
        foreach ($questions as $questionData) {
            $questionText = $questionData[0];
            $categoryId = $questionData[1];

            // Buat soal dengan category_id terkait
            $question = ScreeningQuestion::create([
                'question_text' => $questionText,
                'category_id' => $categoryId,
            ]);

            // Tambahkan opsi untuk setiap soal
            foreach ($options as $optionData) {
                ScreeningOption::create([
                    'question_id' => $question->id,
                    'option_text' => $optionData['option_text'],
                    'weight' => $optionData['weight'],
                ]);
            }
        }
    }
}
