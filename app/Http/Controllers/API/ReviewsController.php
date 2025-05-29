<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormater;
use App\Http\Controllers\Controller;
use App\Models\Review;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewsController extends Controller
{
    public function storeReviews(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'doctor_id' => 'required|exists:doctors,id',
            'rating' => 'nullable|integer',
            'message' => 'sometimes|nullable',
            'name_pasien' => 'required|string|max:255',
        ]);


        if($validator->fails()) {
            return ResponseFormater::error(
                null,
                $validator->errors(),
                500
            );
        }

        $reviews = Review::create([
            'doctor_id' => $request->doctor_id,
            'rating' => $request->rating,
            'message' => $request->message,
            'name_pasien' => $request->name_pasien,
        ]);


        try {
            $reviews->save();
            return ResponseFormater::success(
                $reviews,
                'Data Reviews  Berhasil di tambahkan'
            );
        }

        catch(Exception $error) {
            return ResponseFormater::error(
                $error->getMessage(),
                'Data Reviews  tidak ada',
                404
            );
        }
    }

    public function fetchReviews(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 10);
        $doctor_id = $request->input('doctor_id');

        if($id)
        {
            $reviews = Review::with(['doctors.user'])->find($id);

            if($reviews)
            {
                return ResponseFormater::success(
                    $reviews,
                    'Reviews berhasil diambil'
                );
            }
            else {
                return ResponseFormater::error(
                    null,
                    'Reviews tidak ditemukan',
                    404,
                );
            }
        }

        $reviews = Review::with(['doctors.user'])
                    ->orderBy('rating', 'desc')          // ✅ Rating tertinggi di atas
                    ->orderBy('created_at', 'desc');    // ✅ Jika rating sama, yang terbaru di atas

        if($doctor_id)
        {
            $reviews->where('doctor_id', $doctor_id);
        }

        return ResponseFormater::success(
            $reviews->paginate($limit),
            'Reviews berhasil diambil'
        );
    }

    public function deleteReviews(Request $request, $id)
    {
        $reviews = Review::findOrFail($id);
        $data = $request->all();

        $reviews->delete();
        return ResponseFormater::success(
            $reviews,
            'Data Reviews Berhasil di delete'
        );
    }
}
