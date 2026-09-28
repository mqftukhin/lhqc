<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MasterPart;
use Illuminate\Http\JsonResponse;

class MasterPartController extends Controller
{
    public function show(string $kode_part): JsonResponse
    {
        // Cari data berdasarkan kode_part yang discan operator
        $part = MasterPart::where('kode_part', $kode_part)->first();

        // Jika data part tidak ditemukan di database
        if (!$part) {
            return response()->json([
                'success' => false,
                'message' => 'Kode part tidak terdaftar di sistem.'
            ], 404);
        }

        // Jika ditemukan, kembalikan data berformat JSON
        return response()->json([
            'success' => true,
            'data' => $part
        ], 200);
    }
}
