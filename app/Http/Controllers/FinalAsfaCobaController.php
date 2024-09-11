<?php

namespace App\Http\Controllers;

use App\Models\FinalAsfaCoba;
use Illuminate\Http\Request;

class FinalAsfaCobaController extends Controller
{
    public function index()
    {
        // Mengambil semua data dari tabel untuk /dataset
        $data = FinalAsfaCoba::all();
        return response()->json($data);
    }

    public function dashboard(Request $request)
    {
        $query = FinalAsfaCoba::query();

        // Apply filters jika ada
        if ($request->input('kendaraan')) {
            $query->where('Kendaraan', $request->input('kendaraan'));
        }
        if ($request->input('wilayah')) {
            $query->where('Wilayah', $request->input('wilayah'));
        }
        if ($request->input('status')) {
            $query->where('Status', $request->input('status'));
        }
        if ($request->input('provinsi')) {
            $query->where('Provinsi', $request->input('provinsi'));
        }
        if ($request->input('tahun')) {
            $query->where('Tahun', $request->input('tahun'));
        }

        // Paginate the data
        $data = $query->paginate(20);

        // Ambil data untuk dropdown filter, tahun diurutkan secara ascending
        $filters = [
            'kendaraan' => FinalAsfaCoba::select('Kendaraan')->distinct()->pluck('Kendaraan'),
            'wilayah' => FinalAsfaCoba::select('Wilayah')->distinct()->pluck('Wilayah'),
            'status' => FinalAsfaCoba::select('Status')->distinct()->pluck('Status'),
            'provinsi' => FinalAsfaCoba::select('Provinsi')->distinct()->pluck('Provinsi'),
            'tahun' => FinalAsfaCoba::select('Tahun')->distinct()->orderBy('Tahun', 'asc')->pluck('Tahun'), // Urutkan tahun
        ];

        return view('dashboard', compact('data', 'filters'));
    }

    public function getChartData(Request $request)
    {
        $query = FinalAsfaCoba::query();

        if ($request->input('kendaraan')) {
            $query->where('Kendaraan', $request->input('kendaraan'));
        }
        if ($request->input('wilayah')) {
            $query->where('Wilayah', $request->input('wilayah'));
        }
        if ($request->input('tahun')) {
            $query->where('Tahun', $request->input('tahun'));
        }

        $data = $query->selectRaw('Provinsi, Status, SUM(Nilai) as total')
            ->whereIn('Provinsi', [
                'ACEH', 'SUMATERA UTARA', 'SUMATERA BARAT', 'RIAU', 
                'JAMBI', 'SUMATERA SELATAN', 'BENGKULU', 'LAMPUNG', 
                'KEP. BANGKA BELITUNG', 'KEP. RIAU', 'DKI JAKARTA', 
                'JAWA BARAT', 'JAWA TENGAH', 'DI YOGYAKARTA', 
                'JAWA TIMUR', 'BANTEN', 'BALI', 'NUSA TENGGARA BARAT',
                'NUSA TENGGARA TIMUR', 'KALIMANTAN BARAT', 'KALIMANTAN TENGAH', 
                'KALIMANTAN SELATAN', 'KALIMANTAN TIMUR', 'KALIMANTAN UTARA', 
                'SULAWESI UTARA', 'SULAWESI TENGAH', 'SULAWESI SELATAN', 
                'SULAWESI TENGGARA', 'GORONTALO', 'SULAWESI BARAT', 
                'MALUKU', 'MALUKU UTARA', 'PAPUA BARAT', 'PAPUA BARAT DAYA', 
                'PAPUA', 'PAPUA SELATAN', 'PAPUA TENGAH', 'PAPUA PEGUNUNGAN'
            ])
            ->groupBy('Provinsi', 'Status')
            ->get();

        $provinces = $data->pluck('Provinsi')->unique()->values();
        $datang = $data->where('Status', 'Datang')->pluck('total')->values();
        $berangkat = $data->where('Status', 'Berangkat')->pluck('total')->values();

        return response()->json([
            'provinces' => $provinces,
            'datang' => $datang,
            'berangkat' => $berangkat
        ]);
    }

    public function groupedBarChart(Request $request)
    {
        $query = FinalAsfaCoba::query();

        if ($request->input('kendaraan')) {
            $query->where('Kendaraan', $request->input('kendaraan'));
        }
        if ($request->input('wilayah')) {
            $query->where('Wilayah', $request->input('wilayah'));
        }
        if ($request->input('status')) {
            $query->where('Status', $request->input('status'));
        }
        if ($request->input('provinsi')) {
            $query->where('Provinsi', $request->input('provinsi'));
        }
        if ($request->input('tahun')) {
            $query->where('Tahun', $request->input('tahun'));
        }

        $data = $query->paginate(20);

        $filters = [
            'kendaraan' => FinalAsfaCoba::select('Kendaraan')->distinct()->pluck('Kendaraan'),
            'wilayah' => FinalAsfaCoba::select('Wilayah')->distinct()->pluck('Wilayah'),
            'status' => FinalAsfaCoba::select('Status')->distinct()->pluck('Status'),
            'provinsi' => FinalAsfaCoba::select('Provinsi')->distinct()->pluck('Provinsi'),
            'tahun' => FinalAsfaCoba::select('Tahun')->distinct()->orderBy('Tahun', 'desc')->pluck('Tahun'),
        ];

        return view('chart', compact('data', 'filters'));
    }

    public function linechartView(Request $request)
{
    // Ambil parameter dari request
    $kendaraan = $request->input('kendaraan');
    $wilayah = $request->input('wilayah');
    $provinsi = $request->input('provinsi');

    // Ambil data untuk dropdown filter
    $filters = [
        'kendaraan' => FinalAsfaCoba::select('Kendaraan')->distinct()->pluck('Kendaraan'),
        'wilayah' => FinalAsfaCoba::select('Wilayah')->distinct()->pluck('Wilayah'),
        'provinsi' => FinalAsfaCoba::select('Provinsi')->distinct()->pluck('Provinsi'),
    ];

    // Return view with data for chart and filters
    return view('linechart', ['filters' => $filters]);
}

public function lineChart(Request $request)
{
    // Ambil parameter dari request
    $kendaraan = $request->input('kendaraan');
    $wilayah = $request->input('wilayah');
    $provinsi = $request->input('provinsi');

    // Query untuk mendapatkan data chart
    $query = FinalAsfaCoba::query();

    if ($kendaraan) {
        $query->where('Kendaraan', $kendaraan);
    }

    if ($wilayah) {
        $query->where('Wilayah', $wilayah);
    }

    if ($provinsi) {
        $query->where('Provinsi', $provinsi);
    }

    // Ambil data untuk chart
    $data = $query->selectRaw('Tahun, Status, SUM(Nilai) as total')
        ->groupBy('Tahun', 'Status')
        ->orderBy('Tahun', 'asc')
        ->get();

    // Format data untuk dikirim ke frontend
    $years = $data->pluck('Tahun')->unique()->values();
    $datang = $data->where('Status', 'Datang')->pluck('total')->values();
    $berangkat = $data->where('Status', 'Berangkat')->pluck('total')->values();

    return response()->json([
        'years' => $years,
        'datang' => $datang,
        'berangkat' => $berangkat
    ]);
}

}
