<?php

namespace Database\Seeders;

use App\Models\Experiment;
use Illuminate\Database\Seeder;

class ExperimentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Experiment::create([
            'title' => 'Gunung Berapi Pelangi',
            'description' => 'Simulasi reaksi asam-basa yang menghasilkan letusan berwarna-warni. Cocok untuk mengenalkan konsep reaksi kimia kepada anak-anak dalam suasana aman dan visual.',
            'category' => 'Kimia',
            'difficulty' => 'Mudah',
            'duration_minutes' => 20,
            'points_reward' => 15,
            'simulation_data' => [
                'tools' => ['Gelaskaca kecil', 'Baking soda', 'Cuka', 'Pewarna makanan', 'Sendok'],
                'steps' => [
                    'Masukkan baking soda ke dalam gelas.',
                    'Tambahkan beberapa tetes pewarna makanan.',
                    'Tuangkan cuka perlahan dan amati reaksi.',
                    'Catat perubahan warna dan gelembung yang terbentuk.',
                ],
                'expected_result' => 'Terjadi letusan warna-warni yang aman disebabkan gas karbon dioksida.',
            ],
        ]);

        Experiment::create([
            'title' => 'Listrik Statis Balon',
            'description' => 'Eksperimen fisika sederhana untuk memahami muatan listrik statis. Balon yang digosok akan menarik potongan kertas dan menunjukkan gaya elektrostatis secara visual.',
            'category' => 'Fisika',
            'difficulty' => 'Sedang',
            'duration_minutes' => 25,
            'points_reward' => 18,
            'simulation_data' => [
                'tools' => ['Balon', 'Kertas kecil', 'Kain wol', 'Permukaan halus'],
                'steps' => [
                    'Gosok balon pada kain wol selama 20 detik.',
                    'Dekatkan balon ke potongan kertas dan amati daya tarik.',
                    'Perhatikan bagaimana kertas menempel pada balon.',
                    'Ulangi dengan permukaan yang berbeda untuk membandingkan hasil.',
                ],
                'expected_result' => 'Potongan kertas menempel pada balon karena muatan listrik statis.',
            ],
        ]);

        Experiment::create([
            'title' => 'Ekosistem Mini dalam Toples',
            'description' => 'Membangun ekosistem mini di dalam toples untuk belajar siklus air dan tumbuhan. Anak-anak dapat melihat bagaimana tanaman dan kelembapan bekerja bersama dalam lingkungan tertutup.',
            'category' => 'Biologi',
            'difficulty' => 'Sulit',
            'duration_minutes' => 35,
            'points_reward' => 20,
            'simulation_data' => [
                'tools' => ['Toples kaca transparan', 'Tanah humus', 'Biji tanaman', 'Air', 'Kerikil kecil'],
                'steps' => [
                    'Masukkan kerikil kecil ke dasar toples untuk drainase.',
                    'Tambahkan lapisan tanah humus dan tanam biji.',
                    'Siram sedikit air dan tutup dengan rapat.',
                    'Letakkan toples di tempat yang terang dan amati kondensasi.',
                ],
                'expected_result' => 'Toples membentuk lingkungan tertutup dengan siklus air sederhana dan pertumbuhan tanaman.',
            ],
        ]);
    }
}
