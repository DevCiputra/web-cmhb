<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormater;
use App\Http\Controllers\Controller;
use App\Models\ReservationStatus;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReservationStatusController extends Controller
{
    public function storeReservationStatus(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'class' => 'nullable|string'
        ]);


        if($validator->fails()) {
            return ResponseFormater::error(
                null,
                $validator->errors(),
                500
            );
        }

        $reservationStatus = ReservationStatus::create([
            'name' => $request->name,
            'class' => $request->class,
        ]);


        try {
            $reservationStatus->save();
            return ResponseFormater::success(
                $reservationStatus,
                'Data Reservasi  Berhasil di tambahkan'
            );
        }

        catch(Exception $error) {
            return ResponseFormater::error(
                $error->getMessage(),
                'Data Reservasi  tidak ada',
                404
            );
        }
    }


    public function getReservationStatus(Request $request)
    {
        $id = $request->input('id');


        if($id)
        {
            $reservationStatus = ReservationStatus::find($id);

            if($reservationStatus)
            {
                return ResponseFormater::success(
                    $reservationStatus,
                    'Reservasi Status berhasil diambil'
                );
            }

            else {
                return ResponseFormater::error(
                    null,
                    'Reservasi Status tidak ditemukan',
                    404,
                );
            }
        }

        $reservationStatus = ReservationStatus::query();

        return ResponseFormater::success(
            $reservationStatus->get(),
            'Reservasi Status berhasil diambil'
        );
    }
}
