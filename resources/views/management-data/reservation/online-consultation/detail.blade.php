@extends('management-data.layouts.app')

@section('title', 'Konsultasi Online')

@section('content')

<div class='dashboard-app'>
    <header class='dashboard-toolbar'>
        <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
    </header>
    <div class='dashboard-content'>
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex flex-column">
                    <h4 class="mb-1 fw-normal" style="color: #1C3A6B;">Detail Pemesanan</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard-page') }}">Beranda</a></li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('reservation.onlineconsultation.index') }}">Reservasi</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('reservation.onlineconsultation.index') }}">Konsultasi Online</a>
                            </li>
                            <li class="breadcrumb-item" style="color: #023770">Detail Pemesanan</li>
                        </ol>
                    </nav>

                </div>
            </div>
        </div>

        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                {{ $error }}
                @endforeach
            </ul>
        </div>
        @endif


        <div class="card p-4" style="box-shadow: 4px 4px 24px rgba(0, 0, 0, 0.04); border: none; border-radius: 12px;">
            <h5 class="fw-bold" style="color: #1C3A6B;">Kode Pemesanan</h5>
            <h4 class="mb-4" style="color: #000;">{{ $reservation->code }}</h4>

            <div class="d-flex mb-4">
                {{-- Jika status reservasi masih null dan status pembayaran juga null --}}
                @if(is_null($reservation->reservation_status_id) && is_null($reservation->status_pembayaran))
                <form id="contactForm" action="{{ route('reservation.contact', $reservation->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="button" class="btn btn-info me-2" onclick="contactPatient('{{ $reservation->patient->user->whatsapp }}')">
                        <i class="fas fa-phone me-1"></i> Hubungi Pasien
                    </button>
                </form>
                <button type="button" class="btn btn-danger me-2" data-bs-toggle="modal" data-bs-target="#cancelOrderModal">
                    <i class="fas fa-times-circle me-1"></i> Cancel Order
                </button>

                @elseif(optional($reservation->status)->name === 'Konfirmasi Jadwal' && is_null($reservation->status_pembayaran)
                {{-- Jika status reservasi = Konfirmasi Jadwal dan status pembayaran = null --}}
                )
                <form action="{{ route('reservation.schedule', $reservation->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-warning me-2" onclick="return confirm('Apakah Anda yakin ingin menyepakati jadwal ini?')">
                        <i class="fas fa-calendar-check me-1"></i> Sepakati Jadwal
                    </button>
                </form>
                <button type="button" class="btn btn-danger me-2" data-bs-toggle="modal" data-bs-target="#cancelOrderModal" onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                    <i class="fas fa-times-circle me-1"></i> Cancel Order
                </button>

                @elseif(optional($reservation->status)->name === 'Jadwal Dikonfirmasi' && is_null($reservation->status_pembayaran)
                {{-- Jika status reservasi = Jadwal Dikonfirmasi dan status pembayaran = null --}}
                )
                <button type="button" class="btn btn-danger me-2" data-bs-toggle="modal" data-bs-target="#cancelOrderModal" onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                    <i class="fas fa-times-circle me-1"></i> Cancel Order
                </button>

                @elseif(optional($reservation->status)->name === 'Jadwal Dikonfirmasi' && $reservation->status_pembayaran === 'Menunggu Konfirmasi')
                {{-- Jika status reservasi = Jadwal Dikonfirmasi dan status pembayaran = Menunggu Konfirmasi --}}
                <form action="{{ route('reservation.confirm-paymet', $reservation->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success me-2" onclick="return confirm('Apakah Anda yakin ingin mengonfirmasi pembayaran ini?')">
                        <i class="fas fa-money-bill-wave me-1"></i> Konfirmasi Pembayaran
                    </button>
                </form>
                <button type="button" class="btn btn-danger me-2" data-bs-toggle="modal" data-bs-target="#cancelOrderModal" onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                    <i class="fas fa-times-circle me-1"></i> Cancel Order
                </button>

                @elseif(optional($reservation->status)->name === 'Jadwal Dikonfirmasi' && $reservation->status_pembayaran === 'Lunas'
                {{-- Jika status reservasi = Jadwal Dikonfirmasi dan status pembayaran = Lunas --}}
                )
                <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#approveModal" onclick="return confirm('Apakah Anda yakin ingin menyetujui pesanan ini?')">
                    <i class="fas fa-check-circle me-1"></i> Approve Order
                </button>
                <button type="button" class="btn btn-danger me-2" data-bs-toggle="modal" data-bs-target="#cancelOrderModal" onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                    <i class="fas fa-times-circle me-1"></i> Cancel Order
                </button>

                @elseif(optional($reservation->status)->name === 'Berhasil' && $reservation->status_pembayaran === 'Lunas'
                {{-- Jika status reservasi = Berhasil dan status pembayaran = Lunas --}}
                )
                <button type="button" class="btn btn-danger me-2" data-bs-toggle="modal" data-bs-target="#cancelOrderModal" onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                    <i class="fas fa-times-circle me-1"></i> Cancel Order
                </button>

                @elseif($reservation->status_pembayaran === 'Menunggu Konfirmasi'
                {{-- Jika status pembayaran = Menunggu Konfirmasi --}}
                )
                <form action="{{ route('reservation.confirm-paymet', $reservation->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success me-2" onclick="return confirm('Apakah Anda yakin ingin mengonfirmasi pembayaran ini?')">
                        <i class="fas fa-money-bill-wave me-1"></i> Konfirmasi Pembayaran
                    </button>
                </form>
                <button type="button" class="btn btn-danger me-2" data-bs-toggle="modal" data-bs-target="#cancelOrderModal" onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                    <i class="fas fa-times-circle me-1"></i> Cancel Order
                </button>
                @endif

                {{-- Tombol Delete hanya untuk admin --}}
                @if(auth()->user()->role === 'Admin')
                <form action="{{ route('reservation.delete', $reservation->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-secondary" onclick="return confirm('Yakin ingin menghapus reservasi ini?')">
                        <i class="fas fa-trash me-1"></i> Delete Order
                    </button>
                </form>
                @endif
            </div>
            <!-- Cancellation Reason Section -->
            @if($cancellationReason)
            <div class="alert alert-warning mt-3" role="alert" style="font-weight: bold;">
                <strong>Catatan:</strong> {{ $cancellationReason }}
            </div>
            @endif


            <div class="row">
                <div class="col-md-6">
                    <p><strong>Nama Pasien:</strong> {{ $reservation->patient->name }}</p>
                    <p>
                        <strong>No HP:</strong>
                        <a href="javascript:void(0)" onclick="contactPatient('{{ $reservation->patient->user->whatsapp }}')">
                            {{ $reservation->patient->user->whatsapp }}
                        </a>
                    </p>
                    <p><strong>Email:</strong> {{ $reservation->patient->user->email }}</p>
                    <p><strong>Nama Dokter:</strong> {{ $reservation->doctorConsultationReservation->doctor->name }}</p>
                    <p><strong>Spesialis:</strong> {{ $reservation->doctorConsultationReservation->doctor->specialization_name }}</p>
                    <p><strong>Poliklinik:</strong> {{ $reservation->doctorConsultationReservation->doctor->polyclinic->name ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Waktu Konsultasi (Permintaan Pasien):</strong>
                        @if ($reservation->doctorConsultationReservation->preferred_consultation_date)
                        {{ \Carbon\Carbon::parse($reservation->doctorConsultationReservation->preferred_consultation_date)
                ->translatedFormat('l, d-m-Y') }}
                        @else
                        <span>(Belum diisi pasien)</span>
                        @endif
                    </p>

                    <p><strong>Waktu Konsultasi (Disepakati):</strong>
                        @if ($reservation->doctorConsultationReservation->agreed_consultation_date)
                        {{ \Carbon\Carbon::parse($reservation->doctorConsultationReservation->agreed_consultation_date)
                ->translatedFormat('l, d-m-Y') }}
                        @if ($reservation->doctorConsultationReservation->agreed_consultation_time)
                        , {{ \Carbon\Carbon::parse($reservation->doctorConsultationReservation->agreed_consultation_time)
                    ->format('H:i') }} WITA
                        @endif
                        @else
                        <span>(Menunggu kesepakatan jadwal dengan Pasien.)</span>
                        @endif
                    </p>

                    <p><strong>Bukti Pembayaran:</strong>
                        @if ($reservation->paymentRecords->isNotEmpty())
                        <a href="{{ asset('storage/' . $reservation->paymentRecords->last()->payment_proof) }}" target="_blank">
                            Lihat Bukti Pembayaran
                        </a>
                        @else
                        N/A
                        @endif
                    </p>

                    <p><strong>Biaya Konsultasi:</strong> Rp {{ number_format($reservation->doctorConsultationReservation->doctor->consultation_fee, 2) }}</p>

                    <p><strong>Tanggal Reservasi:</strong>
                        {{ $reservation->created_at->translatedFormat('l, d-m-Y, H:i') }} WITA
                    </p>

                    <p><strong>Status Pembayaran:</strong>
                        @if ($reservation->paymentRecords->last()?->payment_confirmation_date) Pembayaran Lunas,
                        {{ \Carbon\Carbon::parse($reservation->paymentRecords->last()->payment_confirmation_date)
                ->translatedFormat('l, d-m-Y, H:i') }} WITA
                        @else
                        Belum Dibayar
                        @endif
                    </p>
                </div>

            </div>

            <hr>

            <h5 class="fw-bold mb-3" style="color: #1C3A6B;">Informasi Zoom Meeting</h5>

            <div class="row">
                <div class="col-md-6">
                    <p><strong>Link Zoom (Pasien):</strong><br>
                        @if ($reservation->doctorConsultationReservation->zoom_link)
                        <a href="{{ $reservation->doctorConsultationReservation->zoom_link }}"
                            target="_blank" class="link-primary">
                            Gabung Zoom
                        </a>
                        <button class="btn btn-sm btn-outline-secondary ms-2"
                            onclick="copyToClipboard('{{ $reservation->doctorConsultationReservation->zoom_link }}')">
                            <i class="bi bi-clipboard"></i> Copy
                        </button>
                        @else
                        <span class="text-muted">Belum Tersedia</span>
                        @endif
                    </p>
                    <p><strong>ID Zoom (Pasien):</strong><br>
                        @if ($reservation->doctorConsultationReservation->zoom_meeting_id)
                        {{ $reservation->doctorConsultationReservation->zoom_meeting_id }}
                        @else
                        <span class="text-muted">Belum Tersedia</span>
                        @endif
                    </p>
                    <p><strong>Password Zoom (Pasien):</strong><br>
                        @if ($reservation->doctorConsultationReservation->zoom_password)
                        {{ $reservation->doctorConsultationReservation->zoom_password }}
                        @else
                        <span class="text-muted">Belum Tersedia</span>
                        @endif
                    </p>
                </div>

                <div class="col-md-6">
                    <p><strong>Link Zoom (Dokter):</strong><br>
                        @if ($reservation->doctorConsultationReservation->zoom_host_link)
                        <a href="{{ $reservation->doctorConsultationReservation->zoom_host_link }}"
                            target="_blank" class="link-primary">
                            Masuk sebagai Host
                        </a>
                        <button class="btn btn-sm btn-outline-secondary ms-2"
                            onclick="copyToClipboard('{{ $reservation->doctorConsultationReservation->zoom_host_link }}')">
                            <i class="bi bi-clipboard"></i> Copy
                        </button>
                        @else
                        <span class="text-muted">Belum Tersedia</span>
                        @endif
                    </p>
                    <p><strong>ID Zoom (Dokter):</strong><br>
                        @if ($reservation->doctorConsultationReservation->zoom_host_id)
                        {{ $reservation->doctorConsultationReservation->zoom_host_id }}
                        @else
                        <span class="text-muted">Belum Tersedia</span>
                        @endif
                    </p>
                    <p><strong>Password Zoom (Dokter):</strong><br>
                        @if ($reservation->doctorConsultationReservation->zoom_host_password)
                        {{ $reservation->doctorConsultationReservation->zoom_host_password }}
                        @else
                        <span class="text-muted">Belum Tersedia</span>
                        @endif
                    </p>
                </div>
            </div>


            <div id="copyAlert" class="alert alert-success position-fixed top-0 end-0 m-3 d-none" role="alert">
                Link berhasil disalin!
            </div>

        </div>
    </div>
</div>



<!-- Modal Approve Order -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('reservation.approve', $reservation->id) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="approveModalLabel">Approve Konsultasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="agreedDate" class="form-label">Tanggal Disepakati</label>
                        <input type="date" class="form-control" id="agreedDate" name="agreed_consultation_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="agreedTime" class="form-label">Waktu Disepakati</label>
                        <input type="time" class="form-control" id="agreedTime" name="agreed_consultation_time" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Approve</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Cancel Order Modal -->
<div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('reservation.cancel', $reservation->id) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelOrderModalLabel">Pembatalan Reservasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="cancellationReason" class="form-label">Alasan Pembatalan</label>
                        <textarea class="form-control @error('cancellation_reason') is-invalid @enderror"
                            id="cancellationReason" name="cancellation_reason" rows="3" required>{{ old('cancellation_reason') }}</textarea>
                        @error('cancellation_reason')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="authorizationPassword" class="form-label">Password Otorisasi</label>
                        <input type="password" class="form-control @error('authorization_password') is-invalid @enderror"
                            id="authorizationPassword" name="authorization_password" required>
                        @error('authorization_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Konfirmasi Pembatalan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection


@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    const mobileScreen = window.matchMedia("(max-width: 990px )");
    $(document).ready(function() {
        $(".dashboard-nav-dropdown-toggle").click(function() {
            $(this).closest(".dashboard-nav-dropdown")
                .toggleClass("show")
                .find(".dashboard-nav-dropdown")
                .removeClass("show");
            $(this).parent()
                .siblings()
                .removeClass("show");
        });
        $(".menu-toggle").click(function() {
            if (mobileScreen.matches) {
                $(".dashboard-nav").toggleClass("mobile-show");
            } else {
                $(".dashboard").toggleClass("dashboard-compact");
            }
        });
    });

    function copyToClipboard(text) {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(text).then(() => {
                showCopyAlert(); // Menampilkan notifikasi jika berhasil
            }).catch(err => {
                console.error('Gagal menyalin teks: ', err);
            });
        } else {
            // Fallback untuk browser yang tidak mendukung navigator.clipboard
            const tempInput = document.createElement('input');
            tempInput.value = text;
            document.body.appendChild(tempInput);
            tempInput.select();
            try {
                document.execCommand('copy');
                showCopyAlert();
            } catch (err) {
                console.error('Gagal menyalin teks: ', err);
            }
            document.body.removeChild(tempInput);
        }
    }

    function showCopyAlert() {
        alert('Link berhasil disalin!');
    }
</script>

<script>
    // Inisialisasi flatpickr untuk input waktu dengan format 24 jam
    flatpickr("#agreedTime", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i", // Format 24 jam
        time_24hr: true, // Aktifkan 24 jam
    });

    flatpickr("#agreedDate", {
        dateFormat: "Y-m-d", // Format tanggal (ISO)
    });
</script>

<script>
    function contactPatient(phoneNumber) {
        // Konfirmasi dialog
        if (confirm('Apakah Anda yakin ingin menghubungi pasien ini?')) {
            // Ganti country_code dengan kode negara yang sesuai
            const country_code = '62'; // Contoh: Kode negara untuk Indonesia
            const whatsappUrl = `https://api.whatsapp.com/send?phone=${country_code}${phoneNumber}`;
            // Buka jendela baru untuk menghubungi pasien
            window.open(whatsappUrl, '_blank');

            // Setelah membuka WhatsApp, kirim formulir untuk melanjutkan flow
            document.getElementById('contactForm').submit();
        }
    }
</script>
@endpush