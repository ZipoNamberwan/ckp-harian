<?php

namespace App\Http\Controllers;

use App\Models\Activities;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('activity/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('activity/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'date' => 'required',
            'time_start' => 'required:lte:time_end',
            'time_end' => 'required|gte:time_start',
            'activity_plan' => 'required',
            'activity_name' => 'required',
            'achievement' => 'required',
            'proggress' => 'required|numeric|min:0|max:100',
        ]);

        Activities::create([
            'date' => $request->date,
            'time_start' => sprintf('%02d', $request->time_start) . ':00:00',
            'time_end' => sprintf('%02d', $request->time_end) . ':00:00',
            'activity_plan' => $request->activity_plan,
            'activity_name' => $request->activity_name,
            'achievement' => $request->achievement,
            'proggress' => $request->proggress,
            'file' => $request->file,
            'is_skp' => true,
            'user_id' => Auth::user()->id
        ]);

        return redirect('/activities')->with('success-create', 'Kegiatan telah ditambah!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $activity = Activities::find($id);
        return view('activity/view', ['activity' => $activity]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $activity = Activities::find($id);
        if ($activity->user->id != Auth::user()->id) {
            abort(403);
        }

        return view('activity/edit', ['activity' => $activity]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'date' => 'required',
            'time_start' => 'required:lte:time_end',
            'time_end' => 'required|gte:time_start',
            'activity_plan' => 'required',
            'activity_name' => 'required',
            'achievement' => 'required',
            'proggress' => 'required|numeric|min:0|max:100',
        ]);

        $activity = Activities::find($id);
        $activity->update([
            'date' => $request->date,
            'time_start' => sprintf('%02d', $request->time_start) . ':00:00',
            'time_end' => sprintf('%02d', $request->time_end) . ':00:00',
            'activity_plan' => $request->activity_plan,
            'activity_name' => $request->activity_name,
            'achievement' => $request->achievement,
            'proggress' => $request->proggress,
            'file' => $request->file,
            'is_skp' => true,
            'user_id' => Auth::user()->id
        ]);

        return redirect('/activities')->with('success-create', 'Kegiatan telah diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Activities::find($id)->delete();
        return redirect('/activities')->with('success-delete', 'Kegiatan telah dihapus!');
    }

    public function getData(Request $request, $monitoring, $user, $start, $end)
    {
        $currentuser = User::find(Auth::user()->id);
        $recordsTotal = Activities::where('user_id', $currentuser->id);
        if ($monitoring == true) {
            if ($currentuser->hasRole('Admin|Chief')) {
                $recordsTotal = Activities::where('user_id', '!=', $currentuser->id);
            } else if ($currentuser->hasRole('Coordinator')) {
                $recordsTotal = Activities::whereIn('user_id', $currentuser->staffs->pluck('id'));
            } else {
                $recordsTotal = Activities::where('user_id', $currentuser->id);
            }
        }
        if ($user != 'all') {
            if ($currentuser->hasRole('Admin|Chief|Coordinator')) {
                $recordsTotal = Activities::where('user_id', $user);
            } else {
                $recordsTotal = Activities::where('user_id', $currentuser->id);
            }
        }
        if ($start != 'all') {
            $recordsTotal = $recordsTotal->where('date', '>=', $start);
        }
        if ($end != 'all') {
            $recordsTotal = $recordsTotal->where('date', '<=', $end);
        }
        $recordsTotal = $recordsTotal->get()->count();

        $orderColumn = 'date';
        $orderDir = 'desc';
        if ($request->order != null) {
            if ($request->order[0]['dir'] == 'asc') {
                $orderDir = 'asc';
            } else {
                $orderDir = 'desc';
            }
            if ($monitoring == true) {
                if ($currentuser->hasRole('Admin|Chief|Coordinator')) {
                    if ($request->order[0]['column'] == '3') {
                        $orderColumn = 'activity_plan';
                    } else if ($request->order[0]['column'] == '4') {
                        $orderColumn = 'activity_name';
                    } else if ($request->order[0]['column'] == '5') {
                        $orderColumn = 'achievement';
                    } else if ($request->order[0]['column'] == '1') {
                        $orderColumn = 'date';
                    } else if ($request->order[0]['column'] == '6') {
                        $orderColumn = 'proggress';
                    } else if ($request->order[0]['column'] == '0') {
                        $orderColumn = 'user_id';
                    }
                }
            } else {
                if ($request->order[0]['column'] == '2') {
                    $orderColumn = 'activity_plan';
                } else if ($request->order[0]['column'] == '3') {
                    $orderColumn = 'activity_name';
                } else if ($request->order[0]['column'] == '4') {
                    $orderColumn = 'achievement';
                } else if ($request->order[0]['column'] == '0') {
                    $orderColumn = 'date';
                } else if ($request->order[0]['column'] == '5') {
                    $orderColumn = 'proggress';
                }
            }
        }

        $searchkeyword = $request->search['value'];
        $activities = Activities::where('user_id', $currentuser->id);
        if ($monitoring == true) {
            if ($currentuser->hasRole('Admin|Chief')) {
                $activities = Activities::where('user_id', '!=', $currentuser->id);
            } else if ($currentuser->hasRole('Coordinator')) {
                $activities = Activities::whereIn('user_id', $currentuser->staffs->pluck('id'));
            } else {
                $activities = Activities::where('user_id', $currentuser->id);
            }
        }
        if ($user != 'all') {
            if ($currentuser->hasRole('Admin|Chief|Coordinator')) {
                $activities = Activities::where('user_id', $user);
            } else {
                $activities = Activities::where('user_id', $currentuser->id);
            }
        }
        if ($start != 'all') {
            $activities = $activities->where('date', '>=', $start);
        }
        if ($end != 'all') {
            $activities = $activities->where('date', '<=', $end);
        }
        $activities = $activities->get();

        if ($searchkeyword != null) {
            $activities = $activities->filter(function ($q) use (
                $searchkeyword
            ) {
                return Str::contains(strtolower($q->activity_plan), strtolower($searchkeyword)) ||
                    Str::contains(strtolower($q->activity_name), strtolower($searchkeyword)) ||
                    Str::contains(strtolower($q->achievement), strtolower($searchkeyword));
                Str::contains(strtolower($q->user->name), strtolower($searchkeyword));
            });
        }
        $recordsFiltered = $activities->count();

        if ($orderDir == 'asc') {
            $activities = $activities->sortBy($orderColumn);
        } else {
            $activities = $activities->sortByDesc($orderColumn);
        }

        if ($request->length != -1) {
            $activities = $activities->skip($request->start)
                ->take($request->length);
        }

        $activitiesArray = array();
        $i = $request->start + 1;
        foreach ($activities as $activity) {
            $activityData = array();
            $activityData["index"] = $i;
            $activityData["id"] = $activity->id;
            $activityData["activity_plan"] = $activity->activity_plan;
            $activityData["activity_name"] = $activity->activity_name;
            $activityData["achievement"] = $activity->achievement;
            $activityData["proggress"] = $activity->proggress;
            $activityData["file"] = $activity->file;
            $activityData["date"] = $activity->date;
            $activityData["time_start"] = $activity->time_start;
            $activityData["time_end"] = $activity->time_end;
            $activityData["is_skp"] = $activity->is_skp;
            $activityData["user_id"] = $activity->user->id;
            $activityData["user_name"] = $activity->user->name;
            $activitiesArray[] = $activityData;
            $i++;
        }
        return json_encode([
            "draw" => $request->draw,
            "recordsTotal" => $recordsTotal,
            "recordsFiltered" => $recordsFiltered,
            "data" => $activitiesArray
        ]);
    }

    public function download(Request $request)
    {
        // dd($request);
        $currentuser = User::find(Auth::user()->id);

        $activities = Activities::where('user_id', $currentuser->id);
        if ($request->monitoringhidden == true) {
            if ($currentuser->hasRole('Admin|Chief')) {
                $activities = Activities::where('user_id', '!=', $currentuser->id);
            } else if ($currentuser->hasRole('Coordinator')) {
                $activities = Activities::whereIn('user_id', $currentuser->staffs->pluck('id'));
            } else {
                $activities = Activities::where('user_id', $currentuser->id);
            }
        }
        if ($request->userhidden != 'all') {
            if ($currentuser->hasRole('Admin|Chief|Coordinator')) {
                $activities = Activities::where('user_id', $request->userhidden);
            } else {
                $activities = Activities::where('user_id', $currentuser->id);
            }
        }
        if ($request->starthidden != 'all') {
            $activities = $activities->where('date', '>=', $request->starthidden);
        }
        if ($request->endhidden != 'all') {
            $activities = $activities->where('date', '<=', $request->endhidden);
        }
        $activities = $activities->get();
        $activities = $activities->sortByDesc('date');

        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();

        $startrow = 1;
        $activeWorksheet->setCellValue('A' . $startrow, 'Nama Pegawai');
        $activeWorksheet->setCellValue('B' . $startrow, 'Tanggal');
        $activeWorksheet->setCellValue('C' . $startrow, 'Jam Mulai');
        $activeWorksheet->setCellValue('D' . $startrow, 'Jam Selesai');
        $activeWorksheet->setCellValue('E' . $startrow, 'Rencana Kinerja');
        $activeWorksheet->setCellValue('F' . $startrow, 'Kegiatan');
        $activeWorksheet->setCellValue('G' . $startrow, 'Capaian');
        $activeWorksheet->setCellValue('H' . $startrow, 'Progres (Persen)');
        $activeWorksheet->setCellValue('I' . $startrow, 'Link Bukti Dukung');
        $startrow++;

        foreach ($activities as $activity) {
            $activeWorksheet->setCellValue('A' . $startrow, $activity->user->name);
            $activeWorksheet->setCellValue('B' . $startrow, $activity->date);
            $activeWorksheet->setCellValue('C' . $startrow, substr($activity->time_start, 0, 5));
            $activeWorksheet->setCellValue('D' . $startrow, substr($activity->time_end, 0, 5));
            $activeWorksheet->setCellValue('E' . $startrow, $activity->activity_plan);
            $activeWorksheet->setCellValue('F' . $startrow, $activity->activity_name);
            $activeWorksheet->setCellValue('G' . $startrow, $activity->achievement);
            $activeWorksheet->setCellValue('H' . $startrow, $activity->proggress);
            $activeWorksheet->setCellValue('I' . $startrow, $activity->file);
            $startrow++;
        }

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Daftar Kegiatan.xlsx"');
        $writer->save('php://output');
    }
}
