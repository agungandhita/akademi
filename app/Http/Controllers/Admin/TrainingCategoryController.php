<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TrainingCategory\StoreTrainingCategoryRequest;
use App\Http\Requests\Admin\TrainingCategory\UpdateTrainingCategoryRequest;
use App\Services\TrainingCategory\TrainingCategoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;

class TrainingCategoryController extends Controller
{
    public function __construct(
        protected TrainingCategoryInterface $categoryService,
    ) {}

    public function index(Request $request): View
    {
        $categories = $this->categoryService->getAllPaginated($request->query('search'));

        return view('admin.categories.index', [
            'categories' => $categories,
            'title' => 'Kategori Pelatihan - Akademi Pelatihan',
            'currentRole' => 'admin',
        ]);
    }

    public function create(): View
    {
        return view('admin.categories.create', [
            'title' => 'Tambah Kategori Pelatihan - Akademi Pelatihan',
            'currentRole' => 'admin',
        ]);
    }

    public function store(StoreTrainingCategoryRequest $request): RedirectResponse
    {
        $category = $this->categoryService->create($request->validated());

        Alert::success('Berhasil', "Kategori {$category->name} berhasil ditambahkan.");

        return redirect()->route('admin.categories.index');
    }

    public function edit(int $id): View
    {
        $category = $this->categoryService->getById($id);

        return view('admin.categories.edit', [
            'category' => $category,
            'title' => 'Ubah Kategori - Akademi Pelatihan',
            'currentRole' => 'admin',
        ]);
    }

    public function update(UpdateTrainingCategoryRequest $request, int $id): RedirectResponse
    {
        $category = $this->categoryService->update($id, $request->validated());

        Alert::success('Berhasil', "Kategori {$category->name} berhasil diperbarui.");

        return redirect()->route('admin.categories.index');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->categoryService->delete($id);

        Alert::success('Berhasil', 'Kategori pelatihan berhasil dihapus.');

        return redirect()->route('admin.categories.index');
    }
}
