<?php

namespace App\Http\Controllers;

use App\Models\Activities;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
            'user_id' => 1
        ]);

        return redirect('/activities')->with('success-create', 'Kegiatan telah ditambah!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $activity = Activities::find($id);
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
            'user_id' => 1
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

    public function getData(Request $request)
    {
        $recordsTotal = Activities::all()->count();
        $orderColumn = 'date';
        $orderDir = 'desc';
        if ($request->order != null) {
            if ($request->order[0]['dir'] == 'asc') {
                $orderDir = 'asc';
            } else {
                $orderDir = 'desc';
            }
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

        $searchkeyword = $request->search['value'];
        $activities = Activities::all();
        if ($searchkeyword != null) {
            $activities = $activities->filter(function ($q) use (
                $searchkeyword
            ) {
                return Str::contains(strtolower($q->activity_plan), strtolower($searchkeyword)) ||
                    Str::contains(strtolower($q->activity_name), strtolower($searchkeyword)) ||
                    Str::contains(strtolower($q->achievement), strtolower($searchkeyword));
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

    public function download() {
        return 'coming soon';
    }
}
