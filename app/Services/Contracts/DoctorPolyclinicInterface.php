<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;
use App\Services\ServiceResponse;
use Illuminate\Http\UploadedFile;

interface DoctorPolyclinicInterface
{
    public function create(String $name, UploadedFile $icon): ServiceResponse;
    public function get(?Int $id = null): ServiceResponse;
    public function delete(Int $id): ServiceResponse;
    public function update(Int $id, String $name, ?UploadedFile $icon = null): ServiceResponse;
}
