<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QcRecord;
use App\Models\Shift;
use App\Models\MasterPart;
use App\Models\MasterOp;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class QcRecordController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        // 1. Validasi Input Data dari Operator Vue
        $request->validate([
            'kode_part'   => 'required|exists:master_parts,kode_part',
            'id_op'        => 'required|exists:master_ops,id_op',
            'time_awal'   => 'required|date_format:H:i',
            'time_akhir'  => 'required|date_format:H:i',
            'lot'         => 'required|string',
            'ok'          => 'required|integer|min:0',
            'ngr'         => 'required|integer|min:0',
            'ket_ngr'     => 'nullable|string',
            'ngt'         => 'required|integer|min:0',
            'ket_ngt'     => 'nullable|string',
            'ket_losttime'=> 'nullable|string',
        ]);

        // 2. Ambil ID Internal untuk Foreign Key berdasarkan barcode yang discan
        $part = MasterPart::where('kode_part', $request->kode_part)->first();
        $op   = MasterOp::where('id_op', $request->id_op)->first();

        // 3. LOGIKA OTOMATISASI SHIFT & TANGGAL QC
        $timeAwal = Carbon::createFromFormat('H:i', $request->time_awal);
        $jam      = $timeAwal->format('H:i:s');
        
        // Default tanggal menggunakan hari ini
        $tanggalQc = Carbon::today()->format('Y-m-d'); 
        $shiftId   = 1; // Default Shift 1

        // Cari shift yang cocok berdasarkan range jam di database
        $selectedShift = Shift::whereTime('jam_mulai', '<=', $jam)
                              ->whereTime('jam_selesai', '>=', $jam)
                              ->first();

        if ($selectedShift) {
            $shiftId = $selectedShift->id;
            
            // Aturan Khusus Shift 3: Jika jam 00:00 - 06:59, tanggal QC mundur 1 hari
            if ($selectedShift->nama_shift === 'Shift 3') {
                $tanggalQc = Carbon::yesterday()->format('Y-m-d');
            }
        }

        // 4. Simpan Data ke Tabel qc_records
        $record = QcRecord::create([
            'master_part_id' => $part->id,
            'master_op_id'   => $op->id,
            'shift_id'       => $shiftId,
            'tanggal_qc'     => $tanggalQc,
            'time_awal'      => $request->time_awal,
            'time_akhir'     => $request->time_akhir,
            'lot'            => $request->lot,
            'ok'             => $request->ok,
            'ngr'            => $request->ngr,
            'ket_ngr'        => $request->ket_ngr,
            'ngt'            => $request->ngt,
            'ket_ngt'        => $request->ket_ngt,
            'ket_losttime'   => $request->ket_losttime,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Inspeksi QC Berhasil Disimpan!',
            'data'    => $record->load(['masterPart', 'masterOp', 'shift']) // Load relasi untuk konfirmasi data
        ], 201);
    }
}
