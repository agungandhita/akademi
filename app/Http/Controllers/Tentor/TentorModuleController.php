<?php

namespace App\Http\Controllers\Tentor;

use App\Enums\TrainingStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tentor\Module\StoreModuleRequest;
use App\Http\Requests\Tentor\Module\UpdateModuleRequest;
use App\Services\Module\ModuleInterface;
use App\Services\Training\TrainingInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;

class TentorModuleController extends Controller
{
    public function __construct(
        protected readonly ModuleInterface $moduleService,
        protected readonly TrainingInterface $trainingService,
    ) {}

    /**
     * Tampilkan daftar modul materi pembelajaran (TNT-03).
     */
    public function index(Request $request): View
    {
        $tentor = auth()->user();
        $assignedTrainings = $tentor ? $this->trainingService->getByInstructor($tentor->id) : collect();

        $selectedTrainingId = $request->query('training_id');
        if (! $selectedTrainingId && $assignedTrainings->isNotEmpty()) {
            $selectedTrainingId = $assignedTrainings->first()->id;
        }

        $selectedTraining = $assignedTrainings->firstWhere('id', (int) $selectedTrainingId);

        $modules = $selectedTraining
            ? $this->moduleService->getByTraining($selectedTraining->id, publishedOnly: false)
            : collect();

        return view('admin.tentor.modules.index', [
            'currentRole' => 'tentor',
            'title' => 'Kelola Modul Pembelajaran - Portal Instruktur',
            'assignedTrainings' => $assignedTrainings,
            'selectedTraining' => $selectedTraining,
            'modules' => $modules,
        ]);
    }

    /**
     * Formulir pembuatan modul materi baru.
     */
    public function create(Request $request): View
    {
        $tentor = auth()->user();
        $assignedTrainings = $tentor ? $this->trainingService->getByInstructor($tentor->id) : collect();

        // TNT-03: Hanya pelatihan berstatus published yang dapat ditambahkan modul
        $publishedTrainings = $assignedTrainings->where('status', TrainingStatus::Published);

        $selectedTrainingId = $request->query('training_id');

        return view('admin.tentor.modules.create', [
            'currentRole' => 'tentor',
            'title' => 'Tambah Modul Pembelajaran - Akademi Pelatihan',
            'publishedTrainings' => $publishedTrainings,
            'selectedTrainingId' => $selectedTrainingId,
        ]);
    }

    /**
     * Simpan modul materi pembelajaran baru.
     */
    public function store(StoreModuleRequest $request): RedirectResponse
    {
        $tentor = auth()->user();
        $assignedTrainings = $tentor ? $this->trainingService->getByInstructor($tentor->id) : collect();

        // Validasi kepemilikan pelatihan
        if (! $assignedTrainings->contains('id', (int) $request->input('training_id'))) {
            abort(403, 'Anda tidak ditugaskan pada program pelatihan ini.');
        }

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('modules', 'public');
        }

        $dto = $request->toDTO($tentor->id, $filePath);

        try {
            $module = $this->moduleService->create($dto);
        } catch (\InvalidArgumentException $e) {
            Alert::error('Gagal', $e->getMessage());

            return back()->withInput()->withErrors(['training_id' => $e->getMessage()]);
        }

        Alert::success('Modul Dibuat', "Modul '{$module->title}' berhasil disimpan.");

        return redirect()->route('tentor.modules.index', ['training_id' => $module->training_id]);
    }

    /**
     * Formulir ubah modul materi pembelajaran.
     */
    public function edit(int $id): View
    {
        $tentor = auth()->user();
        $module = $this->moduleService->getById($id);

        $assignedTrainings = $tentor ? $this->trainingService->getByInstructor($tentor->id) : collect();
        if (! $assignedTrainings->contains('id', $module->training_id)) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengedit modul pada pelatihan ini.');
        }

        $publishedTrainings = $assignedTrainings->where('status', TrainingStatus::Published);

        return view('admin.tentor.modules.edit', [
            'currentRole' => 'tentor',
            'title' => 'Ubah Modul: ' . $module->title,
            'module' => $module,
            'publishedTrainings' => $publishedTrainings,
        ]);
    }

    /**
     * Simpan pembaruan modul materi.
     */
    public function update(UpdateModuleRequest $request, int $id): RedirectResponse
    {
        $tentor = auth()->user();
        $module = $this->moduleService->getById($id);

        $assignedTrainings = $tentor ? $this->trainingService->getByInstructor($tentor->id) : collect();
        if (! $assignedTrainings->contains('id', $module->training_id)) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah modul ini.');
        }

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('modules', 'public');
        }

        $dto = $request->toDTO($filePath);

        try {
            $updated = $this->moduleService->update($id, $dto);
        } catch (\InvalidArgumentException $e) {
            Alert::error('Gagal', $e->getMessage());

            return back()->withInput()->withErrors(['title' => $e->getMessage()]);
        }

        Alert::success('Modul Diperbarui', "Modul '{$updated->title}' berhasil diperbarui.");

        return redirect()->route('tentor.modules.index', ['training_id' => $updated->training_id]);
    }

    /**
     * Hapus modul materi.
     */
    public function destroy(int $id): RedirectResponse
    {
        $tentor = auth()->user();
        $module = $this->moduleService->getById($id);

        $assignedTrainings = $tentor ? $this->trainingService->getByInstructor($tentor->id) : collect();
        if (! $assignedTrainings->contains('id', $module->training_id)) {
            abort(403, 'Anda tidak memiliki hak akses untuk menghapus modul ini.');
        }

        $trainingId = $module->training_id;
        $this->moduleService->delete($id);

        Alert::success('Modul Dihapus', 'Modul pembelajaran berhasil dihapus.');

        return redirect()->route('tentor.modules.index', ['training_id' => $trainingId]);
    }
}
