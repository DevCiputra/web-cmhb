<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PoliklinikController extends Controller
{
    public function index()
    {
        // Dummy data
        $data = [
            ['id' => 1, 'nama' => 'Poliklinik A', 'no_ruangan' => '101', 'no_lantai' => '1', 'created_by' => 'Admin', 'created_at' => '2024-08-15', 'updated_at' => '2024-08-15'],
            ['id' => 2, 'nama' => 'Poliklinik B', 'no_ruangan' => '102', 'no_lantai' => '1', 'created_by' => 'Admin', 'created_at' => '2024-08-14', 'updated_at' => '2024-08-14'],
            ['id' => 3, 'nama' => 'Poliklinik C', 'no_ruangan' => '201', 'no_lantai' => '2', 'created_by' => 'Admin', 'created_at' => '2024-08-13', 'updated_at' => '2024-08-13'],
            ['id' => 4, 'nama' => 'Poliklinik D', 'no_ruangan' => '202', 'no_lantai' => '2', 'created_by' => 'Admin', 'created_at' => '2024-08-12', 'updated_at' => '2024-08-12'],
        ];

        return response()->json(['data' => $data]);
    }
}
