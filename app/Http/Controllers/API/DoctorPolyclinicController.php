<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormater;
use App\Http\Controllers\Controller;
use App\Models\DoctorPolyclinic;
use App\Services\Contracts\DoctorPolyclinicInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class DoctorPolyclinicController extends Controller
{

    protected $doctorPolyclinicService;

    public function __construct(DoctorPolyclinicInterface $doctorPolyclinicService)
    {
        $this->doctorPolyclinicService = $doctorPolyclinicService;
    }

    public function index(Request $request)
    {
        try {
            // ⚙️ Service
            $page = $request->has('page');
            $response = $this->doctorPolyclinicService->get($page);

            if (!$response->status) {
                return ResponseFormater::error(null, $response->message, 400);
            }
            return ResponseFormater::success(
                $response->data,
                $response->message
            );
            // 💬 Response
        } catch (\Throwable $th) {
            return ResponseFormater::error($th->getMessage(), "Data Poliklinik Gagal Diambil", 500);
        }
    }

    public function show($id)
    {
        try {

            // ⚙️ Service
            $response = $this->doctorPolyclinicService->get($id);

            if (!$response->status) {
                return ResponseFormater::error(null, $response->message, 400);
            }
            return ResponseFormater::success($response->data, $response->message);
            // 💬 Response
        } catch (\Throwable $th) {
            return ResponseFormater::error($th->getMessage(), "Data Poliklinik Gagal Diambil", 500);
        }
    }

    public function destroy($id)
    {
        try {
            // ⚙️ Service
            $response = $this->doctorPolyclinicService->delete($id);

            if (!$response->status) {
                return ResponseFormater::error(null, $response->message, 400);
            }
            return ResponseFormater::success($response->data, $response->message);
            // 💬 Response
        } catch (\Throwable $th) {
            return ResponseFormater::error($th->getMessage(), "Data Poliklinik Gagal Dihapus", 500);
        }
    }

    public function update(Request $request, $id)
    {
         try {
            // 🔐 validation

            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:100'],
                'icon' => ['file', 'mimes:svg,png', 'max:512'], // max:512 artinya 512 KB
            ], [
                'name.required' => 'Nama ikon wajib diisi.',
                'name.string' => 'Nama ikon harus berupa teks.',
                'name.max' => 'Nama ikon maksimal 100 karakter.',

                'icon.file' => 'File ikon harus berupa file yang valid.',
                'icon.mimes' => 'File ikon harus berupa file SVG.',
                'icon.max' => 'Ukuran file ikon maksimal 512KB.',
            ]);


            if ($validator->fails()) {
                return ResponseFormater::error($validator->errors(), "Input Tidak Sesuai: " . $validator->errors()->first(), 422);
            }


            // ⚙️ Service
            $response = $this->doctorPolyclinicService->update($id, $request->name, $request->file('icon'));

            // 💬 Response
            if (!$response->status) {
                return ResponseFormater::error(null, $response->message, 400);
            }
            return ResponseFormater::success(null, $response->message);
        } catch (\Throwable $th) {
            return ResponseFormater::error($th->getMessage(), "Data Poliklinik Gagal Diubah", 500);
        }
    }

    public function store(Request $request)
    {
        try {
            // 🔐 validation
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:100'],
                'icon' => ['required', 'file', 'mimes:svg,png', 'max:512'], // 512 KB
            ], [
                'name.required' => 'Nama ikon wajib diisi.',
                'name.string' => 'Nama ikon harus berupa teks.',
                'name.max' => 'Nama ikon maksimal 100 karakter.',

                'icon.required' => 'File ikon wajib diunggah.',
                'icon.file' => 'File ikon harus berupa file yang valid.',
                'icon.mimes' => 'File ikon harus berupa file SVG atau PNG.', // ✅ diperbaiki di sini
                'icon.max' => 'Ukuran file ikon maksimal 512KB.',
            ]);


            if ($validator->fails()) {
                return ResponseFormater::error($validator->errors(), "Input Tidak Sesuai: " . $validator->errors()->first(), 422);
            }

            // ⚙️ Service
            $response = $this->doctorPolyclinicService->create($request->name, $request->file('icon'));

            // 💬 Response
            if (!$response->status) {
                return ResponseFormater::error(null, $response->message, 400);
            }
            return ResponseFormater::success(null, $response->message);
        } catch (\Throwable $th) {
            return ResponseFormater::error($th->getMessage(), "Data Poliklinik Gagal Disimpan", 500);
        }
    }

    public function storeNew(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'icon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $cek = DoctorPolyclinic::where('name', $request->name);

        if($cek->first()) {
            return redirect()->back()->with('failed', 'Kategori Poliklinik Ini Sudah pernah anda buat');
        }

        $input = $request->all();



        if($request->file('icon')->isValid()) {
            $photoCategoryPoly = $request->file('icon');
            $extensions = $photoCategoryPoly->getClientOriginalExtension();
            $categoryPolyUpload = "polyclinic/".date('YmdHis').".".$extensions;
            $categoryPolyPath = \env('UPLOAD_PATH'). "/polyclinic";
            $request->file('icon')->move($categoryPolyPath, $categoryPolyUpload);
            $input['icon'] = $categoryPolyUpload;
        }


        $input['name'] = strtoupper($request->name);
        $doctorPolyclinic = DoctorPolyclinic::create($input);

        try {
            $doctorPolyclinic->save();
            return ResponseFormater::success(
                $doctorPolyclinic,
                'Data Doctor Polyclinic  Berhasil di tambahkan'
            );
        }

        catch(Exception $error) {
            return ResponseFormater::error(
                $error->getMessage(),
                'Data Doctor Polyclinic  tidak ada',
                404
            );
        }
    }
}
