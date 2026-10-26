<?php

namespace App\Http\Controllers\Admin;

use App\DTOs\Users\CreateTentorDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\StoreTentorRequest;
use App\Services\User\UserInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;

class TentorController extends Controller
{
    public function __construct(
        protected UserInterface $userService,
    ) {}

    public function create(): View
    {
        return view('admin.tentor.create', [
            'title' => 'Buat Akun Tentor Baru - Akademi Pelatihan',
            'currentRole' => 'admin',
        ]);
    }

    public function store(StoreTentorRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        if ($request->hasFile('avatar')) {
            $validatedData['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $dto = CreateTentorDTO::fromArray($validatedData);
        $tentor = $this->userService->createTentor($dto);

        Alert::success('Berhasil', "Akun tentor {$tentor->name} berhasil dibuat. Tentor kini dapat login ke sistem.");

        return redirect()->route('admin.users.index', ['role' => 'tentor']);
    }
}
