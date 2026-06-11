<?php
namespace App\Http\Controllers\Api;

use App\Application\Services\ExperimentService;
use App\Application\Services\ProgressService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExperimentApiController extends Controller
{
    public function __construct(
        private ExperimentService $experimentService,
        private ProgressService $progressService
    ) {
    }

    public function index()
    {
        $experiments = $this->experimentService->listExperiments();

        return response()->json(['status' => 'success', 'data' => $experiments->makeHidden(['description', 'simulation_data'])], 200);
    }

    public function show($id)
    {
        $experiment = $this->experimentService->findOrFail($id);

        return response()->json(['status' => 'success', 'data' => $experiment], 200);
    }

    public function submitProgress(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:started,completed',
            'score' => 'nullable|integer',
        ]);

        $userId = Auth::id();
        $experiment = $this->experimentService->findOrFail($id);

        $progress = $this->progressService->saveProgress(
            $userId,
            $id,
            0,
            $validated['status'],
            $validated['score'] ?? null
        );

        if ($validated['status'] === 'completed') {
            Auth::user()->increment('total_points', $experiment->points_reward);
        }

        return response()->json(['status' => 'success', 'message' => 'Progress saved.', 'data' => $progress], 200);
    }
}
