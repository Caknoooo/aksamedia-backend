<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class SQLController extends Controller
{
  public function nilaiST()
  {
    $nilai = DB::table('nilais')
      ->select(
        'nama',
        'nisn',
        DB::raw(
          '
                SUM(CASE
                    WHEN pelajaran_id = 44 THEN skor * 41.67
                    WHEN pelajaran_id = 45 THEN skor * 29.67
                    WHEN pelajaran_id = 46 THEN skor * 100
                    WHEN pelajaran_id = 47 THEN skor * 23.81
                    ELSE 0
                END) as total'
        ),
        DB::raw('SUM(CASE WHEN pelajaran_id = 44 THEN skor * 41.67 ELSE 0 END) as figural'),
        DB::raw('SUM(CASE WHEN pelajaran_id = 45 THEN skor * 29.67 ELSE 0 END) as kuantitatif'),
        DB::raw('SUM(CASE WHEN pelajaran_id = 46 THEN skor * 100 ELSE 0 END) as penalaran'),
        DB::raw('SUM(CASE WHEN pelajaran_id = 47 THEN skor * 23.81 ELSE 0 END) as verbal')
      )
      ->where('materi_uji_id', 4)
      ->groupBy('nama', 'nisn')
      ->orderByDesc('total')
      ->get();

    $result = $nilai->map(function ($item) {
      return [
        'listnilai' => [
          'figural' => $item->figural,
          'kuantitatif' => $item->kuantitatif,
          'penalaran' => $item->penalaran,
          'verbal' => $item->verbal,
        ],
        'nama' => $item->nama,
        'nisn' => $item->nisn,
        'total' => $item->total,
      ];
    });

    return response()->json($result);
  }

  public function nilaiRT()
  {
    $nilai = DB::table('nilais')
      ->select(
        'nama',
        'nisn',
        DB::raw('SUM(CASE WHEN pelajaran_id = 39 THEN skor ELSE 0 END) as artistic'),
        DB::raw('SUM(CASE WHEN pelajaran_id = 42 THEN skor ELSE 0 END) as conventional'),
        DB::raw('SUM(CASE WHEN pelajaran_id = 38 THEN skor ELSE 0 END) as investigative'),
        DB::raw('SUM(CASE WHEN pelajaran_id = 41 THEN skor ELSE 0 END) as enterprising'),
        DB::raw('SUM(CASE WHEN pelajaran_id = 35 THEN skor ELSE 0 END) as realistic'),
        DB::raw('SUM(CASE WHEN pelajaran_id = 40 THEN skor ELSE 0 END) as social')
      )
      ->where('materi_uji_id', 7)
      ->groupBy('nama', 'nisn')
      ->orderBy('nama')
      ->get();

    $result = $nilai->map(function ($item) {
      return [
        'nama' => $item->nama,
        'nisn' => $item->nisn,
        'nilaiRt' => [
          'artistic' => (int) $item->artistic,
          'conventional' => (int) $item->conventional,
          'investigative' => (int) $item->investigative,
          'enterprising' => (int) $item->enterprising,
          'realistic' => (int) $item->realistic,
          'social' => (int) $item->social,
        ],
      ];
    });

    return response()->json($result);
  }
}
