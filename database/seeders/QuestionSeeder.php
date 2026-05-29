<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\Answer;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Gunung Berapi Pelangi - Chemistry Questions
        $volcanicQuestions = [
            [
                'question' => 'Apa nama gas yang dilepaskan ketika baking soda bereaksi dengan cuka?',
                'answers' => [
                    ['text' => 'Karbon dioksida', 'correct' => true],
                    ['text' => 'Nitrogen', 'correct' => false],
                    ['text' => 'Oksigen', 'correct' => false],
                    ['text' => 'Hidrogen', 'correct' => false],
                ]
            ],
            [
                'question' => 'Cuka mengandung asam apakah?',
                'answers' => [
                    ['text' => 'Asam asetat', 'correct' => true],
                    ['text' => 'Asam klorida', 'correct' => false],
                    ['text' => 'Asam sulfat', 'correct' => false],
                    ['text' => 'Asam sitrat', 'correct' => false],
                ]
            ],
            [
                'question' => 'Baking soda adalah senyawa apakah?',
                'answers' => [
                    ['text' => 'Natrium bikarbonat', 'correct' => true],
                    ['text' => 'Natrium klorida', 'correct' => false],
                    ['text' => 'Kalium karbonat', 'correct' => false],
                    ['text' => 'Natrium sulfat', 'correct' => false],
                ]
            ],
            [
                'question' => 'Reaksi antara asam dan basa menghasilkan apa?',
                'answers' => [
                    ['text' => 'Garam dan air', 'correct' => true],
                    ['text' => 'Hanya air', 'correct' => false],
                    ['text' => 'Hanya garam', 'correct' => false],
                    ['text' => 'Minyak', 'correct' => false],
                ]
            ],
            [
                'question' => 'Gelembung yang terbentuk dalam eksperimen Gunung Berapi disebabkan oleh apa?',
                'answers' => [
                    ['text' => 'Gas karbon dioksida', 'correct' => true],
                    ['text' => 'Uap air', 'correct' => false],
                    ['text' => 'Gas klor', 'correct' => false],
                    ['text' => 'Gas amonia', 'correct' => false],
                ]
            ],
            [
                'question' => 'Pewarna makanan dalam eksperimen berfungsi untuk apa?',
                'answers' => [
                    ['text' => 'Membuat reaksi lebih menarik secara visual', 'correct' => true],
                    ['text' => 'Mempercepat reaksi', 'correct' => false],
                    ['text' => 'Mengubah suhu', 'correct' => false],
                    ['text' => 'Melarutkan asam', 'correct' => false],
                ]
            ],
            [
                'question' => 'Reaksi kimia antara asam dan basa adalah reaksi apa?',
                'answers' => [
                    ['text' => 'Penetralan', 'correct' => true],
                    ['text' => 'Oksidasi', 'correct' => false],
                    ['text' => 'Reduksi', 'correct' => false],
                    ['text' => 'Substitusi', 'correct' => false],
                ]
            ],
            [
                'question' => 'Temperatur reaksi asam dan basa umumnya apakah?',
                'answers' => [
                    ['text' => 'Eksotermik (melepaskan panas)', 'correct' => true],
                    ['text' => 'Endotermik (menyerap panas)', 'correct' => false],
                    ['text' => 'Tetap sama', 'correct' => false],
                    ['text' => 'Negatif', 'correct' => false],
                ]
            ],
            [
                'question' => 'pH baking soda (natrium bikarbonat) adalah apakah?',
                'answers' => [
                    ['text' => 'Basa (pH > 7)', 'correct' => true],
                    ['text' => 'Asam (pH < 7)', 'correct' => false],
                    ['text' => 'Netral (pH = 7)', 'correct' => false],
                    ['text' => 'Negatif', 'correct' => false],
                ]
            ],
            [
                'question' => 'Manfaat mempelajari reaksi asam-basa adalah apa?',
                'answers' => [
                    ['text' => 'Memahami fenomena alam dan aplikasi industri', 'correct' => true],
                    ['text' => 'Hanya untuk hiburan', 'correct' => false],
                    ['text' => 'Tidak ada manfaat', 'correct' => false],
                    ['text' => 'Membuat makanan lebih enak', 'correct' => false],
                ]
            ],
        ];

        // Static Electricity Questions
        $electricityQuestions = [
            [
                'question' => 'Listrik statis terjadi karena apakah?',
                'answers' => [
                    ['text' => 'Pengalihan elektron antar benda', 'correct' => true],
                    ['text' => 'Aliran air', 'correct' => false],
                    ['text' => 'Gerakan cahaya', 'correct' => false],
                    ['text' => 'Perubahan suhu', 'correct' => false],
                ]
            ],
            [
                'question' => 'Ketika balon digosok dengan kain wol, balon menjadi apa?',
                'answers' => [
                    ['text' => 'Bermuatan listrik statis', 'correct' => true],
                    ['text' => 'Menjadi panas', 'correct' => false],
                    ['text' => 'Mengembang lebih besar', 'correct' => false],
                    ['text' => 'Berubah warna', 'correct' => false],
                ]
            ],
            [
                'question' => 'Gaya yang bekerja antara balon bermuatan dan kertas adalah apakah?',
                'answers' => [
                    ['text' => 'Gaya elektrostatik', 'correct' => true],
                    ['text' => 'Gaya gravitasi', 'correct' => false],
                    ['text' => 'Gaya magnet', 'correct' => false],
                    ['text' => 'Gaya gesekan', 'correct' => false],
                ]
            ],
            [
                'question' => 'Muatan listrik pada balon setelah digosok adalah muatan apa?',
                'answers' => [
                    ['text' => 'Negatif', 'correct' => true],
                    ['text' => 'Positif', 'correct' => false],
                    ['text' => 'Netral', 'correct' => false],
                    ['text' => 'Bergantian', 'correct' => false],
                ]
            ],
            [
                'question' => 'Mengapa potongan kertas tertarik ke balon bermuatan?',
                'answers' => [
                    ['text' => 'Karena gaya elektrostatis menarik muatan berlawanan', 'correct' => true],
                    ['text' => 'Karena kertas memiliki magnet', 'correct' => false],
                    ['text' => 'Karena balon memiliki lem', 'correct' => false],
                    ['text' => 'Karena daya tarik gravitasi', 'correct' => false],
                ]
            ],
            [
                'question' => 'Permukaan apa yang paling mudah untuk pengalihan muatan elektron?',
                'answers' => [
                    ['text' => 'Permukaan halus', 'correct' => true],
                    ['text' => 'Permukaan kasar', 'correct' => false],
                    ['text' => 'Permukaan basah', 'correct' => false],
                    ['text' => 'Permukaan gelap', 'correct' => false],
                ]
            ],
            [
                'question' => 'Kain wol dipilih untuk eksperimen listrik statis karena apa?',
                'answers' => [
                    ['text' => 'Mudah melepaskan elektron ketika digosok', 'correct' => true],
                    ['text' => 'Tahan lama', 'correct' => false],
                    ['text' => 'Murah', 'correct' => false],
                    ['text' => 'Berwarna gelap', 'correct' => false],
                ]
            ],
            [
                'question' => 'Aplikasi teknologi yang menggunakan prinsip elektrostatis adalah apa?',
                'answers' => [
                    ['text' => 'Printer laser dan fotokopi', 'correct' => true],
                    ['text' => 'Microwave', 'correct' => false],
                    ['text' => 'Lemari es', 'correct' => false],
                    ['text' => 'Kompor listrik', 'correct' => false],
                ]
            ],
            [
                'question' => 'Listrik statis akan hilang ketika apa terjadi?',
                'answers' => [
                    ['text' => 'Benda disentuh dengan tangan atau bumi', 'correct' => true],
                    ['text' => 'Cuaca berubah', 'correct' => false],
                    ['text' => 'Cahaya matahari hilang', 'correct' => false],
                    ['text' => 'Balon ditiup angin', 'correct' => false],
                ]
            ],
            [
                'question' => 'Daya tarik dan tolakan dalam listrik statis tergantung pada apa?',
                'answers' => [
                    ['text' => 'Jenis muatan (sejenis tolak, berlawanan tarik)', 'correct' => true],
                    ['text' => 'Warna benda', 'correct' => false],
                    ['text' => 'Ukuran benda saja', 'correct' => false],
                    ['text' => 'Cuaca', 'correct' => false],
                ]
            ],
        ];

        // Ecosystem Questions
        $ecosystemQuestions = [
            [
                'question' => 'Siklus air dalam ekosistem mini terjadi karena apa?',
                'answers' => [
                    ['text' => 'Penguapan air dari tanah dan kondensasi di dinding toples', 'correct' => true],
                    ['text' => 'Penambahan air baru setiap hari', 'correct' => false],
                    ['text' => 'Fotosintesis tanaman', 'correct' => false],
                    ['text' => 'Perubahan suhu', 'correct' => false],
                ]
            ],
            [
                'question' => 'Fungsi kerikil kecil di dasar toples adalah apakah?',
                'answers' => [
                    ['text' => 'Drainase dan pencegahan genangan air', 'correct' => true],
                    ['text' => 'Mempercepat pertumbuhan tanaman', 'correct' => false],
                    ['text' => 'Mengubah warna toples', 'correct' => false],
                    ['text' => 'Memberikan nutrisi', 'correct' => false],
                ]
            ],
            [
                'question' => 'Tanah humus dalam ekosistem mini berfungsi untuk apa?',
                'answers' => [
                    ['text' => 'Menyediakan nutrisi dan media pertumbuhan tanaman', 'correct' => true],
                    ['text' => 'Mendinginkan toples', 'correct' => false],
                    ['text' => 'Menghalangi cahaya', 'correct' => false],
                    ['text' => 'Menciptakan bau', 'correct' => false],
                ]
            ],
            [
                'question' => 'Mengapa ekosistem mini dalam toples harus ditutup rapat?',
                'answers' => [
                    ['text' => 'Untuk menjaga kelembapan dan menciptakan siklus tertutup', 'correct' => true],
                    ['text' => 'Untuk mencegah cahaya masuk', 'correct' => false],
                    ['text' => 'Untuk mempercepat pertumbuhan', 'correct' => false],
                    ['text' => 'Untuk menghemat ruang', 'correct' => false],
                ]
            ],
            [
                'question' => 'Kondensasi pada dinding toples menunjukkan apa?',
                'answers' => [
                    ['text' => 'Siklus air sedang terjadi dalam ekosistem tertutup', 'correct' => true],
                    ['text' => 'Toples kotor', 'correct' => false],
                    ['text' => 'Tanaman sedang mati', 'correct' => false],
                    ['text' => 'Air terlalu banyak', 'correct' => false],
                ]
            ],
            [
                'question' => 'Manakah yang bukan bagian dari ekosistem mini?',
                'answers' => [
                    ['text' => 'Lampu listrik eksternal', 'correct' => true],
                    ['text' => 'Tanah', 'correct' => false],
                    ['text' => 'Tanaman', 'correct' => false],
                    ['text' => 'Air', 'correct' => false],
                ]
            ],
            [
                'question' => 'Cahaya apa yang diperlukan ekosistem mini?',
                'answers' => [
                    ['text' => 'Cahaya matahari atau cahaya buatan', 'correct' => true],
                    ['text' => 'Hanya cahaya buatan', 'correct' => false],
                    ['text' => 'Hanya cahaya matahari langsung', 'correct' => false],
                    ['text' => 'Tidak memerlukan cahaya', 'correct' => false],
                ]
            ],
            [
                'question' => 'Proses fotosintesis dalam ekosistem mini menghasilkan apa?',
                'answers' => [
                    ['text' => 'Oksigen dan glukosa', 'correct' => true],
                    ['text' => 'Karbon dioksida', 'correct' => false],
                    ['text' => 'Nitrogen', 'correct' => false],
                    ['text' => 'Air', 'correct' => false],
                ]
            ],
            [
                'question' => 'Dalam ekosistem mini, tanaman bertindak sebagai apa?',
                'answers' => [
                    ['text' => 'Produsen yang menghasilkan makanan dari fotosintesis', 'correct' => true],
                    ['text' => 'Konsumen', 'correct' => false],
                    ['text' => 'Pengurai', 'correct' => false],
                    ['text' => 'Simbiosis', 'correct' => false],
                ]
            ],
            [
                'question' => 'Berapa lama ekosistem mini dapat bertahan dalam kondisi ideal?',
                'answers' => [
                    ['text' => 'Berminggu-minggu hingga berbulan-bulan', 'correct' => true],
                    ['text' => 'Hanya beberapa hari', 'correct' => false],
                    ['text' => 'Hanya beberapa jam', 'correct' => false],
                    ['text' => 'Selamanya tanpa perawatan', 'correct' => false],
                ]
            ],
        ];

        // Get experiment IDs
        $volcanicExp = \App\Models\Experiment::where('title', 'Gunung Berapi Pelangi')->first();
        $electricityExp = \App\Models\Experiment::where('title', 'Listrik Statis Balon')->first();
        $ecosystemExp = \App\Models\Experiment::where('title', 'Ekosistem Mini dalam Toples')->first();

        // Seed Volcanic Experiment Questions
        if ($volcanicExp) {
            foreach ($volcanicQuestions as $qData) {
                $question = Question::create([
                    'experiment_id' => $volcanicExp->id,
                    'question_text' => $qData['question'],
                ]);
                foreach ($qData['answers'] as $ansData) {
                    Answer::create([
                        'question_id' => $question->id,
                        'answer_text' => $ansData['text'],
                        'is_correct' => $ansData['correct'],
                    ]);
                }
            }
        }

        // Seed Electricity Experiment Questions
        if ($electricityExp) {
            foreach ($electricityQuestions as $qData) {
                $question = Question::create([
                    'experiment_id' => $electricityExp->id,
                    'question_text' => $qData['question'],
                ]);
                foreach ($qData['answers'] as $ansData) {
                    Answer::create([
                        'question_id' => $question->id,
                        'answer_text' => $ansData['text'],
                        'is_correct' => $ansData['correct'],
                    ]);
                }
            }
        }

        // Seed Ecosystem Experiment Questions
        if ($ecosystemExp) {
            foreach ($ecosystemQuestions as $qData) {
                $question = Question::create([
                    'experiment_id' => $ecosystemExp->id,
                    'question_text' => $qData['question'],
                ]);
                foreach ($qData['answers'] as $ansData) {
                    Answer::create([
                        'question_id' => $question->id,
                        'answer_text' => $ansData['text'],
                        'is_correct' => $ansData['correct'],
                    ]);
                }
            }
        }
    }
}
