<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Weight_log;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreatelogRequest;
use App\Http\Requests\TargetWeightRequest;
use App\Models\WeightTarget;

class WeightlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userId = Auth::id();

        $latestWeightLog = Weight_log::where('user_id', $userId)->latest('date')->first();

        $targetData = WeightTarget::where('user_id', $userId)->first();
        $targetWeight = $targetData ? $targetData->target_weight : null;

        $logs = Weight_log::where('user_id', $userId)
            ->orderBy('date', 'desc')
            ->paginate(8);

        return view('index', [
            'latestWeightLog' => $latestWeightLog,
            'targetWeight' => $targetWeight,
            'logs' => $logs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $latestWeightLog = Weight_log::latest()->first();
        $targetWeight = auth()->user()->target_weight ?? null;

        $logs = Weight_log::where('user_id', Auth::id())
            ->orderBy('date', 'desc')
            ->get();

        return view('weight_logs.index', [
            'latestWeightLog' => $latestWeightLog,
            'targetWeight' => $targetWeight,
            'modal' => 'new',
            'logs' => $logs,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatelogRequest $request)
    {
        $validatedData = $request->validated();

        Auth::user()->weightLogs()->create($validatedData);

        return redirect()->route('weight-logs.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreatelogRequest $request, $id)
    {
        $log = Weight_log::where('user_id', Auth::id())->findOrFail($id);

        $validatedData = $request->validated();

        $log->update($validatedData);

        return redirect()->route('weight-logs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $log = Weight_log::where('user_id', Auth::id())->findOrFail($id);

        $log->delete();

        return redirect()->route('weight-logs.index', ['t' => time()]);
    }

    public function showGoalSettingForm()
    {
        return view('weight_logs.goal_setting');
    }

    public function setGoal(TargetWeightRequest $request)
    {
        $userId = Auth::id();

        WeightTarget::updateOrCreate(
            ['user_id' => $userId],
            ['target_weight' => $request->input('target_weight')]
        );

        return redirect()->route('weight-logs.index');
    }

    public function search(Request $request)
    {
        $userId = Auth::id();
        $query = Weight_log::where('user_id', $userId);

        if ($request->filled('start_date')) {
            $query->where('date', '>=', $request->input('start_date'));
        }

        if ($request->filled('end_date')) {
            $query->where('date', '<=', $request->input('end_date'));
        }

        $logs = $query->orderBy('date', 'desc')->paginate(8);

        $latestWeightLog = Weight_log::where('user_id', $userId)->latest('date')->first();
        $targetData = \App\Models\WeightTarget::where('user_id', $userId)->first();
        $targetWeight = $targetData ? $targetData->target_weight : null;

        return view('index', [
            'logs' => $logs,
            'latestWeightLog' => $latestWeightLog,
            'targetWeight' => $targetWeight,

            'startDate' => $request->input('start_date'),
            'endDate' => $request->input('end_date'),
        ]);
    }

}
