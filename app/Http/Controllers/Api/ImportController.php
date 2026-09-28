<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterPart;
use App\Models\MasterOp;
use Illuminate\Http\JsonResponse;

class ImportController extends Controller
{
    public function importMasterPart(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:10240', // Admin cukup save as Excel ke .CSV
        ]);

        $file = $request->file('file');
        $handle = fopen($file->getRealPath(), 'r');
        
        // Ambil baris pertama sebagai nama kolom (heading)
        $headers = fgetcsv($handle, 1000, ',');
        $headers = array_map('trim', $headers);

        $dataImport = [];
        
        while (($row = fgetcsv($handle, 1000, ',')) !== FALSE) {
            if (count($headers) !== count($row)) continue;
            
            $item = array_combine($headers, $row);
            
            $dataImport[] = [
                'kode_part'   => $item['kode_part'],
                'parent_kode' => $item['parent_kode'] ?? null,
                'part_number' => $item['part_number'],
                'part_name'   => $item['part_name'],
                'project'     => $item['project'],
                'customer'    => $item['customer'],
                'proses'      => $item['proses'],
                'created_at'  => now(),
                'updated_at'  => now()
            ];
        }
        fclose($handle);

        if (!empty($dataImport)) {
            // Logika UPSERT Laravel: jika kode_part kembar, otomatis UPDATE kolom sisanya
            MasterPart::upsert($dataImport, ['kode_part'], ['parent_kode', 'part_number', 'part_name', 'project', 'customer', 'proses', 'updated_at']);
        }

        return response()->json(['success' => true, 'message' => 'Bulk Import Master Part Sukses Terproses!']);
    }

    public function importMasterOp(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:10240',
        ]);

        $file = $request->file('file');
        $handle = fopen($file->getRealPath(), 'r');
        
        $headers = fgetcsv($handle, 1000, ',');
        $headers = array_map('trim', $headers);

        $dataImport = [];
        
        while (($row = fgetcsv($handle, 1000, ',')) !== FALSE) {
            if (count($headers) !== count($row)) continue;
            
            $item = array_combine($headers, $row);
            
            $dataImport[] = [
                'id_op'      => $item['id_op'],
                'name_op'    => $item['name_op'],
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
        fclose($handle);

        if (!empty($dataImport)) {
            MasterOp::upsert($dataImport, ['id_op'], ['name_op', 'updated_at']);
        }

        return response()->json(['success' => true, 'message' => 'Bulk Import Master Operator Sukses Terproses!']);
    }
}
