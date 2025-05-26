<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;
use App\Services\ServiceResponse;
use Illuminate\Http\UploadedFile;

interface DoctorServiceInterface
{
    public function create(Request $data): ServiceResponse;
    public function get(
        string $name = null,
        int $doctorPolyclinicId = null,
    ): ServiceResponse;
    public function getById(Int $id): ServiceResponse;
    public function delete(Int $id): ServiceResponse;
    public function update(Int $id, Request $data): ServiceResponse;
}
