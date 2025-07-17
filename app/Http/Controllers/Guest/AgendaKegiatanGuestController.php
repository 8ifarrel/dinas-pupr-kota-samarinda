<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AgendaKegiatan;
use Carbon\Carbon;

class AgendaKegiatanGuestController extends Controller
{
    public function ajaxAgenda(Request $request)
    {
        $start = $request->query('start');
        $end = $request->query('end');

        $query = AgendaKegiatan::query();

        if ($start && $end) {
            $query->whereBetween('tanggal', [$start, $end]);
        } elseif ($start) {
            $query->where('tanggal', $start);
        }

        $agenda = $query->orderBy('tanggal')->orderBy('waktu_mulai')->get();

        return response()->json($agenda);
    }

    public function ajaxAgendaCount(Request $request)
    {
        $date = $request->query('date');
        $count = 0;
        if ($date) {
            $count = AgendaKegiatan::where('tanggal', $date)->count();
        }
        return response()->json(['count' => $count]);
    }

    public function ajaxAgendaWeekCount(Request $request)
    {
        $start = $request->query('start');
        $end = $request->query('end');
        $result = [];

        if ($start && $end) {
            $period = [];
            $date = Carbon::parse($start);
            $endDate = Carbon::parse($end);
            while ($date->lte($endDate)) {
                $period[] = $date->format('Y-m-d');
                $date->addDay();
            }

            $counts = AgendaKegiatan::selectRaw('tanggal, COUNT(*) as count')
                ->whereBetween('tanggal', [$start, $end])
                ->groupBy('tanggal')
                ->pluck('count', 'tanggal')
                ->toArray();

            foreach ($period as $tgl) {
                $result[$tgl] = isset($counts[$tgl]) ? $counts[$tgl] : 0;
            }
        }

        return response()->json($result);
    }
}
