<?php

namespace App\Http\Controllers\Admin;

use App\DTOs\Certificate\UpdateCertificateDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateCertificateRequest;
use App\Services\Certificate\CertificateInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;

class CertificateController extends Controller
{
    public function __construct(
        protected readonly CertificateInterface $certificateService,
    ) {}

    /**
     * Tampilkan formulir konfigurasi sertifikat pelatihan (Admin).
     */
    public function edit(int $trainingId): View
    {
        $training = $this->certificateService->getTraining($trainingId);

        return view('admin.trainings.certificate', [
            'training' => $training,
            'title' => "Pengaturan Sertifikat: {$training->title} - Akademi Pelatihan",
            'currentRole' => 'admin',
        ]);
    }

    /**
     * Simpan pembaruan pengaturan sertifikat pelatihan.
     */
    public function update(UpdateCertificateRequest $request, int $trainingId): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('certificate_signer_left_signature')) {
            $data['certificate_signer_left_signature'] = $request->file('certificate_signer_left_signature')
                ->store('certificates/signatures', 'public');
        }

        if ($request->hasFile('certificate_signer_right_signature')) {
            $data['certificate_signer_right_signature'] = $request->file('certificate_signer_right_signature')
                ->store('certificates/signatures', 'public');
        }

        // Checkbox boolean handling
        $data['is_certificate_enabled'] = $request->boolean('is_certificate_enabled');

        $dto = UpdateCertificateDTO::fromArray($data);
        $training = $this->certificateService->updateCertificateSettings($trainingId, $dto);

        Alert::success('Berhasil', "Pengaturan sertifikat untuk pelatihan \"{$training->title}\" berhasil disimpan.");

        return redirect()->route('admin.trainings.certificate.edit', $trainingId);
    }

    /**
     * Pratinjau sertifikat dengan data contoh untuk Admin.
     */
    public function preview(int $trainingId): View
    {
        $certData = $this->certificateService->getCertificateData($trainingId);

        return view('certificates.template', array_merge($certData, [
            'isPreview' => true,
            'backUrl' => route('admin.trainings.certificate.edit', $trainingId),
        ]));
    }

    /**
     * Tampilkan / cetak sertifikat peserta tertentu dari daftar peserta admin.
     */
    public function showParticipant(int $trainingId, int $enrollmentId): View
    {
        $certData = $this->certificateService->getCertificateData($trainingId, enrollmentId: $enrollmentId);

        return view('certificates.template', array_merge($certData, [
            'isPreview' => false,
            'backUrl' => route('admin.trainings.participants', $trainingId),
        ]));
    }
}

