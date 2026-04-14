<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Experiment;
use App\Models\ExperimentProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExperimentApiController extends Controller
{
    // GET: Fetch all experiments for the interactive catalog
    public function index()
    {
        $experiments = Experiment::select('id', 'title', 'category', 'difficulty', 'duration_minutes')->get();
        return response()->json(['status' => 'success', 'data' => $experiments], 200);
    }

    // GET: Fetch specific simulation data
    public function show($id)
    {
        $experiment = Experiment::findOrFail($id);
        return response()->json(['status' => 'success', 'data' => $experiment], 200);
    }

    // POST: Update student progress from the interactive simulation
    public function submitProgress(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:started,completed',
            'score' => 'nullable|integer'
        ]);

        $progress = ExperimentProgress::updateOrCreate(
            ['user_id' => Auth::id(), 'experiment_id' => $id],
            [
                'status' => $validated['status'],
                'score' => $validated['score'] ?? null,
                'completed_at' => $validated['status'] === 'completed' ? now() : null,
            ]
        );

        if ($validated['status'] === 'completed') {
            $user = Auth::user();
            $user->increment('total_points', Experiment::find($id)->points_reward);
        }

        return response()->json(['status' => 'success', 'message' => 'Progress saved.', 'data' => $progress], 200);
    }
}
