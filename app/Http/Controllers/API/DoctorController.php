<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormater;
use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Services\Contracts\DoctorServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller
{

    protected $doctorService;

    public function __construct(DoctorServiceInterface $doctorService)
    {
        $this->doctorService = $doctorService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            // ⚙️ Service
            $page = $request->has('page');
            $name = $request->get('name');
            $doctorPolyclinicId = $request->get('doctor_polyclinic_id');

            $response = $this->doctorService->get($name, $doctorPolyclinicId);

            if (!$response->status) {
                return ResponseFormater::error(null, $response->message, 400);
            }
            return ResponseFormater::success(
                $response->data,
                $response->message
            );
            // 💬 Response
        } catch (\Throwable $th) {
            return ResponseFormater::error($th->getMessage(), "Data Gagal Diambil", 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 🔐 validation

        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|string|max:255',
                    'user_id' => 'required',
                    'specialization_name' => 'required|string|max:255',
                    'doctor_polyclinic_id' => 'required',
                    'address' => 'nullable|string|max:500',
                    'consultation_fee' => 'required|numeric|min:0',
                    'email' => 'required|email|max:255|unique:doctors,email',
                    'is_published' => 'required|boolean',
                    'is_open_consultation' => 'required|boolean',
                    'is_open_reservation' => 'required|boolean',
                ],
                [
                    'name.required' => 'Nama dokter wajib diisi.',
                    'name.max' => 'Nama dokter tidak boleh lebih dari 255 karakter.',

                    'user_id.required' => 'User wajib dipilih.',
                    'user_id.exists' => 'User tidak ditemukan.',
                    'user_id.unique' => 'User ini sudah memiliki data dokter.',

                    'specialization_name.required' => 'Spesialisasi wajib diisi.',
                    'specialization_name.max' => 'Spesialisasi tidak boleh lebih dari 255 karakter.',

                    'doctor_polyclinic_id.required' => 'Poliklinik wajib dipilih.',
                    'doctor_polyclinic_id.exists' => 'Poliklinik tidak ditemukan.',

                    'address.max' => 'Alamat tidak boleh lebih dari 500 karakter.',

                    'consultation_fee.required' => 'Biaya konsultasi wajib diisi.',
                    'consultation_fee.numeric' => 'Biaya konsultasi harus berupa angka.',
                    'consultation_fee.min' => 'Biaya konsultasi minimal 0.',

                    'email.required' => 'Email wajib diisi.',
                    'email.email' => 'Format email tidak valid.',
                    'email.max' => 'Email tidak boleh lebih dari 255 karakter.',
                    'email.unique' => 'Email ini sudah digunakan.',

                    'is_published.required' => 'Status publikasi wajib dipilih.',
                    'is_published.boolean' => 'Status publikasi harus berupa true atau false.',

                    'is_open_consultation.required' => 'Status konsultasi wajib dipilih.',
                    'is_open_consultation.boolean' => 'Status konsultasi harus berupa true atau false.',

                    'is_open_reservation.required' => 'Status reservasi wajib dipilih.',
                    'is_open_reservation.boolean' => 'Status reservasi harus berupa true atau false.',
                ]
            );

            if ($validator->fails()) {
                return ResponseFormater::error($validator->errors(), "Input Tidak Sesuai: " . $validator->errors()->first(), 422);
            }

            // ⚙️ Service


            $response = $this->doctorService->create($request);

            // 💬 Response
            if (!$response->status) {
                return ResponseFormater::error(null, $response->message, 400);
            }
            return ResponseFormater::success(null, $response->message);
        } catch (\Throwable $th) {
            return ResponseFormater::error($th->getMessage(), "Data Gagal Disimpan", 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            // ⚙️ Service
            $response = $this->doctorService->getById($id);

            if (!$response->status) {
                return ResponseFormater::error(null, $response->message, 400);
            }
            return ResponseFormater::success(
                $response->data,
                $response->message
            );
            // 💬 Response
        } catch (\Throwable $th) {
            return ResponseFormater::error($th->getMessage(), "Data Gagal Diambil", 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            // 🔐 Validation
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|string|max:255',
                    'specialization_name' => 'required|string|max:255',
                    'doctor_polyclinic_id' => 'required',
                    'address' => 'nullable|string|max:500',
                    'consultation_fee' => 'required|numeric|min:0',
                    'email' => 'required|email|max:255|unique:doctors,email',
                    'is_published' => 'required|boolean',
                    'is_open_consultation' => 'required|boolean',
                    'is_open_reservation' => 'required|boolean',
                ],
                [
                    'name.required' => 'Nama dokter wajib diisi.',
                    'name.max' => 'Nama dokter tidak boleh lebih dari 255 karakter.',


                    'specialization_name.required' => 'Spesialisasi wajib diisi.',
                    'specialization_name.max' => 'Spesialisasi tidak boleh lebih dari 255 karakter.',

                    'doctor_polyclinic_id.required' => 'Poliklinik wajib dipilih.',
                    'doctor_polyclinic_id.exists' => 'Poliklinik tidak ditemukan.',

                    'address.max' => 'Alamat tidak boleh lebih dari 500 karakter.',

                    'consultation_fee.required' => 'Biaya konsultasi wajib diisi.',
                    'consultation_fee.numeric' => 'Biaya konsultasi harus berupa angka.',
                    'consultation_fee.min' => 'Biaya konsultasi minimal 0.',

                    'email.required' => 'Email wajib diisi.',
                    'email.email' => 'Format email tidak valid.',
                    'email.max' => 'Email tidak boleh lebih dari 255 karakter.',
                    'email.unique' => 'Email ini sudah digunakan.',

                    'is_published.required' => 'Status publikasi wajib dipilih.',
                    'is_published.boolean' => 'Status publikasi harus berupa true atau false.',

                    'is_open_consultation.required' => 'Status konsultasi wajib dipilih.',
                    'is_open_consultation.boolean' => 'Status konsultasi harus berupa true atau false.',

                    'is_open_reservation.required' => 'Status reservasi wajib dipilih.',
                    'is_open_reservation.boolean' => 'Status reservasi harus berupa true atau false.',
                ]
            );

            if ($validator->fails()) {
                return ResponseFormater::error($validator->errors(), "Input Tidak Sesuai: " . $validator->errors()->first(), 422);
            }

            // ⚙️ Service


            $response = $this->doctorService->update($id, $request);

            // 💬 Response
            if (!$response->status) {
                return ResponseFormater::error(null, $response->message, 400);
            }
            return ResponseFormater::success(null, $response->message);
        } catch (\Throwable $th) {
            return ResponseFormater::error($th->getMessage(), "Data Gagal Disimpan", 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // ⚙️ Service
            $response = $this->doctorService->delete($id);

            // 💬 Response
            if (!$response->status) {
                return ResponseFormater::error(null, $response->message, 400);
            }
            return ResponseFormater::success(null, $response->message);
        } catch (\Throwable $th) {
            return ResponseFormater::error($th->getMessage(), "Data Doktor Gagal Dihapus", 500);
        }
    }
}
