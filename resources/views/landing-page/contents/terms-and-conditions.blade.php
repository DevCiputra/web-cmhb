@extends('landing-page.layouts.app')

@section('content')
<div class="container" style="margin-top: 150px; margin-bottom: 80px;">
    <div class="header-section text-center">
        <h1 class="h3 fw-bold" style="color: #023770;">Terms and Conditions</h1>
        <p class="text-muted mt-3">Harap membaca dengan seksama sebelum menggunakan layanan Telemedicine kami.</p>
    </div>

    <div class="card mt-4" style="border-radius: 12px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
        <div class="card-body">
            <ul class="list-unstyled">
                <li class="mb-4">
                    <p class="fw-bold mb-2">1. Keadaan Gawat Darurat</p>
                    <p>Jika Anda mengalami keadaan gawat dan / atau darurat medis, Anda harus menghubungi Unit Gawat Darurat terdekat. Layanan Telemedicine tidak ditujukan untuk keadaan gawat dan/atau darurat.</p>
                </li>
                <li class="mb-4">
                    <p class="fw-bold mb-2">2. Konsultasi Telemedicine</p>
                    <p>Konsultasi telemedicine tidak dapat dibandingkan dengan konsultasi secara tatap muka, di mana dokter dapat memeriksa pasien secara langsung. Anda tetap disarankan untuk mengunjungi dokter Anda untuk konsultasi secara langsung sejauh memungkinkan.</p>
                </li>
                <li class="mb-4">
                    <p class="fw-bold mb-2">3. Konfirmasi Diagnosis</p>
                    <p>Anda disarankan untuk menjalani konfirmasi diagnosis dan pengobatan saat Anda dapat datang ke Dokter untuk konsultasi secara langsung.</p>
                </li>
                <li class="mb-4">
                    <p class="fw-bold mb-2">4. Informasi yang Diberikan</p>
                    <p>Anda memahami bahwa Anda harus memberikan informasi yang lengkap dan akurat sesuai dengan pengetahuan dan kemampuan Anda. Ini termasuk informasi tentang riwayat medis Anda, kondisi, dan perawatan medis saat ini atau sebelumnya.</p>
                </li>
                <li class="mb-4">
                    <p class="fw-bold mb-2">5. Risiko dan Konsekuensi Telemedicine</p>
                    <p>Anda memahami bahwa ada risiko dan konsekuensi dari telemedicine, termasuk tetapi tidak terbatas pada: transmisi informasi medis saya dapat terganggu atau terdistorsi oleh kegagalan teknis; transmisi informasi medis saya dapat diganggu oleh pihak yang tidak berwenang; dan/atau penyimpanan elektronik informasi medis saya dapat diakses oleh pihak yang tidak berwenang.</p>
                </li>
                <li class="mb-4">
                    <p class="fw-bold mb-2">6. Keakuratan Konsultasi</p>
                    <p>Dokter tidak bertanggung jawab atas keakuratan konsultasi telemedicine, yang cakupannya memiliki keterbatasan karena tidak melakukan pemeriksaan fisik pada pasien. Meskipun segala upaya telah dilakukan situasi yang tidak terduga dapat muncul. Persetujuan Anda terhadap konsultasi telemedicine akan dianggap sebagai persetujuan Anda untuk konsultasi telemedicine dengan batasan-batasannya yang ada.</p>
                </li>
                <li class="mb-4">
                    <p class="fw-bold mb-2">7. Tidak Ada Jaminan</p>
                    <p>Demi keselamatan pasien, tidak ada jaminan dan kewajiban bahwa Dokter akan memberikan resep setelah dilakukan konsultasi telemedicine.</p>
                </li>
                <li class="mb-4">
                    <p class="fw-bold mb-2">8. Pembatasan Resep</p>
                    <p>Dokter tidak dapat meresepkan obat yang dikendalikan oleh BPOM dan obat-obatan tertentu lainnya yang mungkin berbahaya karena potensi penyalahgunaannya.</p>
                </li>
                <li class="mb-4">
                    <p class="fw-bold mb-2">9. Penolakan Layanan</p>
                    <p>Rumah Sakit / Dokter berhak menolak konsultasi telemedicine bila patut diduga adanya potensi penyalahgunaan layanan ini.</p>
                </li>
                <li class="mb-4">
                    <p class="fw-bold mb-2">10. Pembayaran</p>
                    <p>Pembayaran secara online hanya dapat dilakukan setelah adanya konfirmasi perjanjian konsultasi telemedicine.</p>
                </li>
                <li class="mb-4">
                    <p class="fw-bold mb-2">11. Pembatalan dan Pengembalian Dana</p>
                    <p>Pembatalan/pengembalian dana tidak dapat dilakukan.</p>
                </li>
                <li class="mb-4">
                    <p class="fw-bold mb-2">12. Persetujuan Reservasi</p>
                    <p>Dengan mengklik tombol reservasi berarti Anda menyetujui.</p>
                </li>
            </ul>
        </div>
    </div>

    <!-- Tombol Kembali -->
    <div class="text-center mt-4">
        <a href="javascript:history.back()" class="btn btn-secondary" style="border-radius: 8px;">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>
@endsection