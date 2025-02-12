<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogActivity;
use Carbon\Carbon;

class LogActivityController extends Controller
{
    public function index()
    {
        return view('logs_activity.index', [
            'title' => 'Logs Activity'
        ]);
    }

    public function data()
    {
        $logs_activity = LogActivity::orderBy('id', 'desc')->get();

        return datatables()
            ->of($logs_activity)
            ->addIndexColumn()
            ->addColumn('aksi', function ($logs_activity) {
                return '
                <div class="btn-group">
                    <button onclick="deleteData(`'. route('logs_activity.destroy', $logs_activity->id) .'`)" class="btn btn-xs btn-danger btn-flat btn-sm"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->editColumn('created_at', function ($data) {
                return Carbon::parse($data->created_at)->format('M j, Y');
            })
            ->rawColumns(['aksi', 'created_at'])
            ->make(true);
    }

    public function show($id)
    {
        $logs_activity = LogActivity::find($id);

        return response()->json($logs_activity);
    }

    public function destroy($id)
    {
        $logs_activity = LogActivity::find($id);
        $logs_activity->delete();

        return response(null, 204);
    }
}
