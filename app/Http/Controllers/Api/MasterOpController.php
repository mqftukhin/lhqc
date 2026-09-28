<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MasterOp;
use Illuminate\Http\JsonResponse;

class MasterOpController extends Controller
{
    public function show(string $id_op): JsonResponse
    {
        // Cari operator berdasarkan id_op dari barcode/kartu
        $operator = MasterOp::where('id_op', $id_op)->first();

        // Jika ID operator tidak terdaftar di database
        if (!$operator) {
            return response()->json([
                'success' => false,
                'message' => 'ID Operator tidak terdaftar di sistem.'
            ], 404);
        }

        // Jika ditemukan, kembalikan data berformat JSON
        return response()->json([
            'success' => true,
            'data' => $operator
        ], 200);
    }
}
