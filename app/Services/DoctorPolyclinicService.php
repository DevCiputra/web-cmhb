<?php

namespace App\Services;

use App\Models\DoctorPolyclinic;
use App\Services\Contracts\DoctorPolyclinicInterface;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DoctorPolyclinicService implements DoctorPolyclinicInterface
{

    public function create(String $name, UploadedFile $icon): ServiceResponse
    {
       // Validasi File: hanya SVG atau PNG
        $allowedExtensions = ['svg', 'png'];
        $allowedMimeTypes = ['image/svg+xml', 'image/png'];

        $extension = strtolower($icon->getClientOriginalExtension());
        $mimeType = $icon->getMimeType();

        if (!$icon->isValid() || !in_array($extension, $allowedExtensions)) {
            return ServiceResponse::error('File harus berupa SVG atau PNG');
        }

        if (!in_array($mimeType, $allowedMimeTypes)) {
            return ServiceResponse::error('File bukan gambar SVG atau PNG yang valid');
        }

        $filename = Str::uuid() . '.' . $extension;
        $icon->storeAs('public/doctor_polyclinics', $filename);

        $result = DoctorPolyclinic::create([
            'name' => $name,
            'icon' => $filename,
        ]);

        return ServiceResponse::success("Poliklinik Dokter Berhasil Dibuat", null);
    }

    public function getById(Int $id): ServiceResponse
    {
        $result = DoctorPolyclinic::find($id);
        if (!$result) {
            return ServiceResponse::error('Data Polyclinic Tidak Ditemukan');
        }
        return ServiceResponse::success('Data Polyclinic Ditemukan', $result);
    }

    public function get(bool $page = true): ServiceResponse
    {

        $result = $page ? DoctorPolyclinic::query()->paginate(10) : DoctorPolyclinic::all();
        return ServiceResponse::success(
            'List Semua Polyclinic',
            $result
        );
    }


    public function delete(Int $id): ServiceResponse
    {
        $doctorPolyclinic = DoctorPolyclinic::find($id);
        if (!$doctorPolyclinic) {
            return ServiceResponse::error('Polyclinic Tidak Ditemukan');
        }
        $doctorPolyclinic->delete();
        return ServiceResponse::success("Polyclinic Dihapus", null);
    }

    public function update(Int $id, String $name, UploadedFile $icon = null): ServiceResponse
    {
         $docterPolyclinic = DoctorPolyclinic::find($id);
        if (!$docterPolyclinic) {
            return ServiceResponse::error('Polyclinic Tidak Ditemukan');
        }

        if ($icon) {
            // Validasi File: hanya SVG atau PNG
            $allowedExtensions = ['svg', 'png'];
            $allowedMimeTypes = ['image/svg+xml', 'image/png'];

            $extension = strtolower($icon->getClientOriginalExtension());
            $mimeType = $icon->getMimeType();

            if (!$icon->isValid() || !in_array($extension, $allowedExtensions)) {
                return ServiceResponse::error('File harus berupa SVG atau PNG');
            }

            if (!in_array($mimeType, $allowedMimeTypes)) {
                return ServiceResponse::error('File bukan gambar SVG atau PNG yang valid');
            }

            // Hapus file lama jika ada
            $oldFile = 'doctor_polyclinics/' . $docterPolyclinic->icon;
            if ($docterPolyclinic->icon && Storage::disk('public')->exists($oldFile)) {
                Storage::disk('public')->delete($oldFile);
            }

            $filename = Str::uuid() . '.' . $extension;
            $icon->storeAs('public/doctor_polyclinics', $filename);
            $docterPolyclinic->icon = $filename;
        }

        $docterPolyclinic->name = $name;
        $docterPolyclinic->save();

        return ServiceResponse::success("Poliklinik Dokter Berhasil Diubah", null);
    }
}
