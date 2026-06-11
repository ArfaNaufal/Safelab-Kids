<?php

namespace App\Http\Controllers\Admin;

use App\Application\Services\ExperimentService;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExperimentRequest;
use App\Models\Experiment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExperimentController extends Controller
{
    public function __construct(private ExperimentService $experimentService)
    {
    }

    private function ensureAdmin(Request $request): void
    {
        if (! $request->user() || $request->user()->role !== 'admin') {
            abort(403);
        }
    }

    public function index(Request $request): View
    {
        $this->ensureAdmin($request);

        $experiments = $this->experimentService->listExperiments();

        return view('admin.experiments.index', compact('experiments'));
    }

    public function create(Request $request): View
    {
        $this->ensureAdmin($request);

        return view('admin.experiments.create');
    }

    public function store(ExperimentRequest $request): RedirectResponse
    {
        $this->ensureAdmin($request);

        $data = $request->validated();

        $tools = array_filter(array_map('trim', explode(',', $data['tools'] ?? '')),
            fn ($tool) => $tool !== ''
        );

        $simulationData = [
            'steps' => array_values($data['steps']),
            'tools' => array_values($tools),
            'expected_result' => trim($data['expected_result'] ?? ''),
        ];

        $this->experimentService->createExperiment([
            'title' => $data['title'],
            'description' => $data['description'],
            'category' => $data['category'],
            'difficulty' => $data['difficulty'],
            'duration_minutes' => $data['duration_minutes'],
            'points_reward' => $data['points_reward'],
            'simulation_data' => $simulationData,
        ]);

        return redirect()->route('admin.experiments.index')->with('success', 'Eksperimen berhasil ditambahkan.');
    }

    public function edit(Request $request, Experiment $experiment): View
    {
        $this->ensureAdmin($request);

        return view('admin.experiments.edit', compact('experiment'));
    }

    public function update(ExperimentRequest $request, Experiment $experiment): RedirectResponse
    {
        $this->ensureAdmin($request);

        $data = $request->validated();

        $tools = array_filter(array_map('trim', explode(',', $data['tools'] ?? '')),
            fn ($tool) => $tool !== ''
        );

        $simulationData = [
            'steps' => array_values($data['steps']),
            'tools' => array_values($tools),
            'expected_result' => trim($data['expected_result'] ?? ''),
        ];

        $this->experimentService->updateExperiment($experiment, [
            'title' => $data['title'],
            'description' => $data['description'],
            'category' => $data['category'],
            'difficulty' => $data['difficulty'],
            'duration_minutes' => $data['duration_minutes'],
            'points_reward' => $data['points_reward'],
            'simulation_data' => $simulationData,
        ]);

        return redirect()->route('admin.experiments.index')->with('success', 'Eksperimen berhasil diperbarui.');
    }

    public function destroy(Request $request, Experiment $experiment): RedirectResponse
    {
        $this->ensureAdmin($request);

        $this->experimentService->deleteExperiment($experiment);

        return redirect()->route('admin.experiments.index')->with('success', 'Eksperimen berhasil dihapus.');
    }
}
