<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Services\Certificate\CertificateInterface;
use Illuminate\View\View;

class PesertaCertificateController extends Controller
{
    public function __construct(
        protected readonly CertificateInterface $certificateService,
    ) {}

    /**
     * Tampilkan dan cetak sertifikat kelulusan peserta.
     */
    public function show(int $trainingId): View
    {
        $userId = (int) auth()->id();

        if (! $this->certificateService->canUserAccessCertificate($trainingId, $userId)) {
            abort(403, 'Sertifikat pelatihan ini belum diterbitkan atau Anda belum terdaftar sebagai peserta aktif program ini.');
        }

        $certData = $this->certificateService->getCertificateData($trainingId, userId: $userId);

        return view('certificates.template', array_merge($certData, [
            'isPreview' => false,
            'backUrl' => route('peserta.trainings.show', $trainingId),
        ]));
    }
}

