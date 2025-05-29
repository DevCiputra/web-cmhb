<?php

namespace App\Services;

use App\Models\Doctor;
use App\Models\User;
use App\Services\Contracts\DoctorServiceInterface;
use Illuminate\Http\Request;

class DoctorService implements DoctorServiceInterface
{
    public function create(Request $data): ServiceResponse
    {

        $user = Doctor::query()->where('user_id', "=", $data->user_id)->exists();
        if ($user) {
            return ServiceResponse::error("Dokter sudah memiliki akun user", null);
        }


        $result = Doctor::create([
            'user_id' => $data->user_id,
            'name' => $data->name,
            'specialization_name' => $data->specialization_name,
            'doctor_polyclinic_id' => $data->doctor_polyclinic_id,
            'address' => $data->address,
            'consultation_fee' => $data->consultation_fee,
            'email' => $data->email,
            'is_published' => $data->is_published,
            'is_open_reservation' => $data->is_open_reservation,
            'is_open_consultation' => $data->is_open_consultation
        ]);

        return ServiceResponse::success("Data Dokter Berhasil Disimpan", $result);
    }

    public function get(
        string $name = null,
        int $doctorPolyclinicId = null,
        int $is_published = null,
        string $schedule = null
    ): ServiceResponse {
        $query = Doctor::query();

        // Filter berdasarkan teks pencarian di 'name' atau 'specialization_name'
        if ($name) {
            $query->where(function ($q) use ($name) {
                $q->where('name', 'LIKE', "%{$name}%")
                    ->orWhere('specialization_name', 'LIKE', "%{$name}%");
            });
        }

        // Filter berdasarkan doctor_polyclinic_id
        if ($doctorPolyclinicId) {
            $query->where('doctor_polyclinic_id', $doctorPolyclinicId);
        }

        if($is_published) {
            $query->where('is_published', $is_published);
        }

         // ✅ FIXED: Field name corrected from 'schedules' to 'schedule'
        if ($schedule) {
            $query->whereHas('schedules', function ($q) use ($schedule) {
                $q->where('schedule', 'LIKE', "%{$schedule}%"); // ✅ Fixed field name
            });
        }


        // Pagination atau ambil semua
        $result = $query->with('polyclinic', 'photos')->paginate(10);

        return ServiceResponse::success('Data Dokter Berhasil Diambil', $result);
    }

    public function getById(Int $id): ServiceResponse
    {
        $result = Doctor::with(['polyclinic', 'photos','schedules', 'education'])
        ->withCount('reviews') // ✅ Tambahkan count reviews
        ->find($id);


        if (!$result) {
            return ServiceResponse::error("Data Doktor Tidak Ditemukan");
        }

        // Transform data untuk membersihkan semua karakter dan tag yang tidak diinginkan
        $result = $this->cleanDoctorData($result);

        return ServiceResponse::success("Data Doktor Ditemukan", $result);
    }

    private function cleanDoctorData($doctor)
    {
    // Bersihkan dan format education
    if ($doctor->education) {
        $doctor->education->name = $this->formatEducationText($doctor->education->name);
    }

    // Bersihkan dan format schedule
    if ($doctor->schedules) {
        foreach ($doctor->schedules as $schedule) {
            $schedule->schedule = $this->formatScheduleText($schedule->schedule);
        }
    }

    return $doctor;
    }

    private function formatScheduleText($text)
    {
        if (!$text) return $text;

        // 1. Hilangkan HTML tags dan karakter escape
        $text = $this->cleanHtmlAndSpecialChars($text);

        // 2. Daftar hari dalam bahasa Indonesia
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        // 3. Pattern untuk mendeteksi hari dan jamnya
        foreach ($days as $day) {
            // Ganti pattern "Hari:" dengan "\nHari:" kecuali yang pertama
            $text = preg_replace('/(?<!^)\s*' . $day . '\s*:/', "\n" . $day . ':', $text);
        }

        // 4. Trim untuk menghilangkan \n di awal jika ada
        $text = ltrim($text, "\n");

        return $text;
    }

    private function formatEducationText($text)
    {
        if (!$text) return $text;

        // 1. Hilangkan HTML tags dan karakter escape terlebih dahulu
        $text = $this->cleanHtmlAndSpecialChars($text);

        // 2. Array tingkat pendidikan yang akan dijadikan pemisah
        $educationMarkers = ['S1 ', 'S2 ', 'S3 ', 'D1 ', 'D2 ', 'D3 ', 'D4 '];

        // 3. Untuk setiap marker, tambahkan \n di depannya (kecuali yang pertama)
        foreach ($educationMarkers as $marker) {
            // Cari posisi marker, jika tidak di awal string maka tambahkan \n
            $positions = [];
            $offset = 0;
            while (($pos = strpos($text, $marker, $offset)) !== false) {
                if ($pos > 0) { // Bukan di posisi awal
                    $positions[] = $pos;
                }
                $offset = $pos + 1;
            }

            // Replace dari belakang ke depan agar posisi tidak berubah
            foreach (array_reverse($positions) as $pos) {
                $text = substr_replace($text, "\n" . $marker, $pos, strlen($marker));
            }
        }

        return $text;
    }

    private function cleanHtmlAndSpecialChars($text)
    {
        if (!$text) return $text;

        // 1. Hilangkan semua HTML tags (div, ul, li, dll)
        $text = strip_tags($text);

        // 2. Hilangkan karakter escape sequences
        $text = str_replace([
            '\\r\\n', '\\r', '\\n',  // escaped sequences
            '\r\n', '\r', '\n',      // actual line breaks
            "\r\n", "\r", "\n"       // real line breaks
        ], ' ', $text);

        // 3. Hilangkan karakter HTML entities jika ada
        $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');

        // 4. Hilangkan spasi berlebihan (multiple spaces jadi single space)
        $text = preg_replace('/\s+/', ' ', $text);

        // 5. Trim whitespace di awal dan akhir
        $text = trim($text);

        return $text;
    }

    public function delete(Int $id): ServiceResponse
    {
        $doctor = Doctor::find($id);
        if (!$doctor) {
            return ServiceResponse::error("Data Doktor Tidak Ditemukan");
        }
        $doctor->delete();
        return ServiceResponse::success("Data Doktor Berhasil Dihapus");
    }

    public function update(Int $id, Request $data): ServiceResponse
    {

        $doctor = Doctor::find($id);
        if (!$doctor) {
            return ServiceResponse::error("Data Doktor Tidak Ditemukan");
        }

        $doctor->update(
            [
                'name' => $data->name,
                'specialization_name' => $data->specialization_name,
                'doctor_polyclinic_id' => $data->doctor_polyclinic_id,
                'address' => $data->address,
                'consultation_fee' => $data->consultation_fee,
                'email' => $data->email,
                'is_published' => $data->is_published,
                'is_open_reservation' => $data->is_open_reservation,
                'is_open_consultation' => $data->is_open_consultation
            ]
        );
        return ServiceResponse::success("Data Doktor Berhasil Disimpan");
    }
}
