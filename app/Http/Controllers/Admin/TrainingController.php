<?php

namespace App\Http\Controllers\Admin;

use App\DTOs\Trainings\CreateTrainingDTO;
use App\DTOs\Trainings\UpdateTrainingDTO;
use App\Enums\SessionType;
use App\Enums\TrainingAudience;
use App\Enums\TrainingMode;
use App\Enums\TrainingStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Training\StoreTrainingRequest;
use App\Http\Requests\Admin\Training\UpdateTrainingRequest;
use App\Http\Requests\Admin\TrainingSession\StoreTrainingSessionRequest;
use App\Services\Training\TrainingInterface;
use App\Services\TrainingCategory\TrainingCategoryInterface;
use App\Services\User\UserInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;

class TrainingController extends Controller
{
    public function __construct(
        protected TrainingInterface $trainingService,
        protected TrainingCategoryInterface $categoryService,
        protected UserInterface $userService,
    ) {}

    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'category_id', 'mode', 'status', 'audience']);
        $trainings = $this->trainingService->getAllPaginated($filters, 10);
        $categories = $this->categoryService->getAll();

        return view('admin.trainings.index', [
            'trainings' => $trainings,
            'categories' => $categories,
            'audiences' => TrainingAudience::cases(),
            'modes' => TrainingMode::cases(),
            'statuses' => TrainingStatus::cases(),
            'filters' => $filters,
            'title' => 'Manajemen Pelatihan - Akademi Pelatihan',
            'currentRole' => 'admin',
        ]);
    }

    public function create(): View
    {
        $categories = $this->categoryService->getAll();
        $tentors = $this->userService->getAllTentors();

        return view('admin.trainings.create', [
            'categories' => $categories,
            'tentors' => $tentors,
            'audiences' => TrainingAudience::cases(),
            'modes' => TrainingMode::cases(),
            'statuses' => TrainingStatus::cases(),
            'title' => 'Tambah Pelatihan Baru - Akademi Pelatihan',
            'currentRole' => 'admin',
        ]);
    }

    public function store(StoreTrainingRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('trainings/thumbnails', 'public');
        }

        $dto = CreateTrainingDTO::fromArray($data, Auth::id());
        $training = $this->trainingService->create($dto);

        if ($request->filled('instructors')) {
            $this->trainingService->syncInstructors($training->id, $request->input('instructors', []));
        }

        Alert::success('Berhasil', "Program pelatihan {$training->title} berhasil dibuat.");

        return redirect()->route('admin.trainings.show', $training->id);
    }

    public function show(int $id): View
    {
        $training = $this->trainingService->getById($id);
        $tentors = $this->userService->getAllTentors();

        return view('admin.trainings.show', [
            'training' => $training,
            'tentors' => $tentors,
            'sessionTypes' => SessionType::cases(),
            'title' => "Detail Pelatihan: {$training->title} - Akademi Pelatihan",
            'currentRole' => 'admin',
        ]);
    }

    public function edit(int $id): View
    {
        $training = $this->trainingService->getById($id);
        $categories = $this->categoryService->getAll();
        $tentors = $this->userService->getAllTentors();

        return view('admin.trainings.edit', [
            'training' => $training,
            'categories' => $categories,
            'tentors' => $tentors,
            'audiences' => TrainingAudience::cases(),
            'modes' => TrainingMode::cases(),
            'statuses' => TrainingStatus::cases(),
            'title' => "Ubah Pelatihan: {$training->title} - Akademi Pelatihan",
            'currentRole' => 'admin',
        ]);
    }

    public function update(UpdateTrainingRequest $request, int $id): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('trainings/thumbnails', 'public');
        }

        $dto = UpdateTrainingDTO::fromArray($data);
        $training = $this->trainingService->update($id, $dto);

        if ($request->has('instructors')) {
            $this->trainingService->syncInstructors($id, $request->input('instructors', []));
        }

        Alert::success('Berhasil', "Pelatihan {$training->title} berhasil diperbarui.");

        return redirect()->route('admin.trainings.show', $id);
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->trainingService->delete($id);

        Alert::success('Berhasil', 'Program pelatihan berhasil dihapus.');

        return redirect()->route('admin.trainings.index');
    }

    public function storeSession(StoreTrainingSessionRequest $request, int $id): RedirectResponse
    {
        $this->trainingService->addSession($id, $request->validated());

        Alert::success('Sesi Ditambahkan', 'Sesi pelatihan berhasil dijadwalkan.');

        return back();
    }

    public function destroySession(int $trainingId, int $sessionId): RedirectResponse
    {
        $this->trainingService->deleteSession($sessionId);

        Alert::success('Sesi Dihapus', 'Sesi pelatihan berhasil dihapus.');

        return back();
    }

    public function syncInstructors(Request $request, int $id): RedirectResponse
    {
        $instructorIds = $request->input('instructors', []);
        $this->trainingService->syncInstructors($id, $instructorIds);

        Alert::success('Instruktur Diperbarui', 'Penugasan tentor/instruktur berhasil disimpan.');

        return back();
    }
}
