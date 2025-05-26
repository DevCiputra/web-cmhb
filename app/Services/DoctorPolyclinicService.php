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
        // ✅ Validasi Multiple Image Types
        if (!$icon->isValid()) {
            return ServiceResponse::error('File tidak valid');
        }

        // ✅ Check allowed extensions
        $allowedExtensions = ['svg', 'png', 'jpg', 'jpeg'];
        $extension = strtolower($icon->getClientOriginalExtension());

        if (!in_array($extension, $allowedExtensions)) {
            return ServiceResponse::error('File harus berupa SVG, PNG, JPG, atau JPEG');
        }

        // ✅ Check MIME types
        $allowedMimeTypes = [
            'image/svg+xml',        // SVG
            'image/png',            // PNG
            'image/jpeg',           // JPG/JPEG
            'image/jpg',            // JPG alternative
        ];

        if (!in_array($icon->getMimeType(), $allowedMimeTypes)) {
            return ServiceResponse::error('Tipe file tidak diizinkan');
        }

        // ✅ Generate filename with correct extension
        $filename = Str::uuid() . '.' . $extension;

        // ✅ Store file
        $path = $icon->storeAs('public/doctor_polyclinics', $filename);

        // ✅ Save to database
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
        // Find existing record
        $doctorPolyclinic = DoctorPolyclinic::find($id);
        if (!$doctorPolyclinic) {
            return ServiceResponse::error('Polyclinic Tidak Ditemukan');
        }

        // ✅ Process icon if provided
        if ($icon) {
            // Validate file
            if (!$icon->isValid()) {
                return ServiceResponse::error('File tidak valid');
            }

            // ✅ Check allowed extensions
            $allowedExtensions = ['svg', 'png', 'jpg', 'jpeg'];
            $extension = strtolower($icon->getClientOriginalExtension());

            if (!in_array($extension, $allowedExtensions)) {
                return ServiceResponse::error('File harus berupa SVG, PNG, JPG, atau JPEG');
            }

            // ✅ Check MIME types
            $allowedMimeTypes = [
                'image/svg+xml',        // SVG
                'image/png',            // PNG
                'image/jpeg',           // JPG/JPEG
                'image/jpg',            // JPG alternative
            ];

            if (!in_array($icon->getMimeType(), $allowedMimeTypes)) {
                return ServiceResponse::error('Tipe file tidak diizinkan');
            }

            // ✅ Delete old file if exists
            $oldFile = 'doctor_polyclinics/' . $doctorPolyclinic->icon;
            if ($doctorPolyclinic->icon && Storage::disk('public')->exists($oldFile)) {
                Storage::disk('public')->delete($oldFile);
            }

            // ✅ Generate new filename with correct extension
            $filename = Str::uuid() . '.' . $extension;

            // ✅ Store new file
            $icon->storeAs('public/doctor_polyclinics', $filename);
            $doctorPolyclinic->icon = $filename;
        }

        // Update name
        $doctorPolyclinic->name = $name;
        $doctorPolyclinic->save();

        return ServiceResponse::success("Poliklinik Dokter Berhasil Diubah", null);
    }
}
