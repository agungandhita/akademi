<?php

namespace App\Http\Controllers\Admin;

use App\DTOs\Users\UpdateUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\UpdateUserRequest;
use App\Services\User\UserInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function __construct(
        protected UserInterface $userService,
    ) {}

    public function index(Request $request): View
    {
        $users = $this->userService->getAllPaginated(
            search: $request->query('search'),
            role: $request->query('role'),
            perPage: 15
        );

        $roleCounts = $this->userService->getUserRoleCounts();

        return view('admin.users.index', [
            'users' => $users,
            'roleCounts' => $roleCounts,
            'title' => 'Manajemen Pengguna - Akademi Pelatihan',
            'currentRole' => 'admin',
        ]);
    }

    public function show(int $id): View
    {
        $user = $this->userService->getById($id);

        return view('admin.users.show', [
            'user' => $user,
            'title' => "Detail Pengguna: {$user->name} - Akademi Pelatihan",
            'currentRole' => 'admin',
        ]);
    }

    public function edit(int $id): View
    {
        $user = $this->userService->getById($id);

        return view('admin.users.edit', [
            'user' => $user,
            'title' => 'Ubah Pengguna - Akademi Pelatihan',
            'currentRole' => 'admin',
        ]);
    }

    public function update(UpdateUserRequest $request, int $id): RedirectResponse
    {
        $validatedData = $request->validated();

        if ($request->hasFile('avatar')) {
            $validatedData['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $dto = UpdateUserDTO::fromArray($validatedData);
        $user = $this->userService->update($id, $dto);

        Alert::success('Berhasil', "Data pengguna {$user->name} berhasil diperbarui.");

        return redirect()->route('admin.users.index');
    }

    public function toggleActive(int $id): RedirectResponse
    {
        $user = $this->userService->toggleActive($id);

        $statusText = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        Alert::success('Status Diperbarui', "Akun {$user->name} berhasil {$statusText}.");

        return back();
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->userService->delete($id);

        Alert::success('Berhasil', 'Pengguna berhasil dihapus.');

        return redirect()->route('admin.users.index');
    }
}
