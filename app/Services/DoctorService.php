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

        // Pagination atau ambil semua
        $result = $query->with('polyclinic', 'photos')->paginate(10);

        return ServiceResponse::success('Data Dokter Berhasil Diambil', $result);
    }

    public function getById(Int $id): ServiceResponse
    {
        $result = Doctor::with(['polyclinic', 'photos','schedules', 'education'])->find($id);
        if (!$result) {
            return ServiceResponse::error("Data Doktor Tidak Ditemukan");
        }
        return ServiceResponse::success("Data Doktor Ditemukan", $result);
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
