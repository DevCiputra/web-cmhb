<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormater;
use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceCategoryController extends Controller
{
    public function storeServiceCategory(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'created_by' => 'nullable'
        ]);


        if($validator->fails()) {
            return ResponseFormater::error(
                null,
                $validator->errors(),
                500
            );
        }

        $serviceCategory = ServiceCategory::create([
            'name' => $request->name,
            'created_by' => $request->created_by,
        ]);


        try {
            $serviceCategory->save();
            return ResponseFormater::success(
                $serviceCategory,
                'Data Service Category  Berhasil di tambahkan'
            );
        }

        catch(Exception $error) {
            return ResponseFormater::error(
                $error->getMessage(),
                'Data Service Category  tidak ada',
                404
            );
        }
    }

    public function getServiceCategory(Request $request)
    {
        $id = $request->input('id');


        if($id)
        {
            $serviceCategory = ServiceCategory::find($id);

            if($serviceCategory)
            {
                return ResponseFormater::success(
                    $serviceCategory,
                    'Service Category Status berhasil diambil'
                );
            }

            else {
                return ResponseFormater::error(
                    null,
                    'Service Category tidak ditemukan',
                    404,
                );
            }
        }

        $serviceCategory = ServiceCategory::query();

        return ResponseFormater::success(
            $serviceCategory->get(),
            'Service Category Status berhasil diambil'
        );
    }
}
