<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AgendaKegiatan;
use Carbon\Carbon;

class AgendaKegiatanAdminController extends Controller
{
    public function index()
    {
        $agenda = AgendaKegiatan::orderBy('tanggal', 'desc')->get();
        $page_title = 'Agenda Kegiatan';
        $page_description = 'Daftar seluruh agenda kegiatan Dinas PUPR Kota Samarinda.';
        return view('admin.pages.agenda-kegiatan.index', compact('agenda', 'page_title', 'page_description'));
    }

    public function create()
    {
        $page_title = 'Tambah Agenda Kegiatan';
        $page_description = 'Form untuk menambah agenda kegiatan baru.';
        return view('admin.pages.agenda-kegiatan.create', compact('page_title', 'page_description'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'waktu_mulai' => 'required|date_format:H:i',
            'tempat' => 'required|string|max:255',
            'pelaksana' => 'required|string|max:255',
            'dihadiri_oleh' => 'nullable|string|max:255',
            'tanggal' => 'required|date',
        ]);
        AgendaKegiatan::create($validated);
        return redirect()->route('admin.agenda-kegiatan.index')->with('success', 'Agenda berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $agenda = AgendaKegiatan::findOrFail($id);
        $page_title = 'Edit Agenda Kegiatan';
        $page_description = 'Form untuk mengedit agenda kegiatan.';
        return view('admin.pages.agenda-kegiatan.edit', compact('agenda', 'page_title', 'page_description'));
    }

    public function update(Request $request, $id)
    {
        $agenda = AgendaKegiatan::findOrFail($id);
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'waktu_mulai' => 'required|date_format:H:i',
            'tempat' => 'required|string|max:255',
            'pelaksana' => 'required|string|max:255',
            'dihadiri_oleh' => 'nullable|string|max:255',
            'tanggal' => 'required|date',
        ]);
        $agenda->update($validated);
        return redirect()->route('admin.agenda-kegiatan.index')->with('success', 'Agenda berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $agenda = AgendaKegiatan::findOrFail($id);
        $agenda->delete();
        return redirect()->route('admin.agenda-kegiatan.index')->with('success', 'Agenda berhasil dihapus.');
    }

    public function datatable(Request $request)
    {
        $columns = [
            0 => 'id',
            1 => 'nama',
            2 => 'tanggal',
            3 => 'waktu_mulai',
            4 => 'tempat',
            5 => 'pelaksana',
            6 => 'dihadiri_oleh',
        ];

        $totalData = AgendaKegiatan::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $orderColIdx = $request->input('order.0.column');
        $orderCol = $columns[$orderColIdx] ?? 'tanggal';
        $orderDir = $request->input('order.0.dir', 'desc');
        $search = $request->input('search.value');

        $query = AgendaKegiatan::query();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('tempat', 'like', "%{$search}%")
                  ->orWhere('pelaksana', 'like', "%{$search}%")
                  ->orWhere('dihadiri_oleh', 'like', "%{$search}%");
            });
            $totalFiltered = $query->count();
        }

        $data = $query->orderBy($orderCol, $orderDir)
            ->offset($start)
            ->limit($limit)
            ->get();

        $result = [];
        $no = $start + 1;
        foreach ($data as $item) {
            $result[] = [
                $no++,
                $item->nama,
                Carbon::parse($item->tanggal)->format('d-m-Y'),
                Carbon::parse($item->waktu_mulai)->format('H:i'),
                $item->tempat,
                $item->pelaksana,
                $item->dihadiri_oleh,
                view('admin.pages.agenda-kegiatan._actions', compact('item'))->render(),
            ];
        }

        return response()->json([
            "draw" => intval($request->input('draw')),
            "recordsTotal" => $totalData,
            "recordsFiltered" => $totalFiltered,
            "data" => $result,
        ]);
    }
}
