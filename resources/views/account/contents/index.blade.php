@extends('landing-page.layouts.app')

@section('content')
    <div class="container" style="margin-top: 80px;">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="profile-header text-center">
                    <img src="{{ asset('images/user.jpg') }}" alt="User Photo">
                    <h5>Nama User</h5>
                    <p>08218881010</p>
                    <p>user@mail.com</p>
                    <img src="icons/pencil-square.png" alt="Edit Profile" class="edit-icon" data-bs-toggle="modal"
                        data-bs-target="#editProfileModal">
                </div>
                <div class="tab-bar" style="max-width: auto;">
                    <nav class="nav-profile">
                        <div class="nav nav-tabs mb-1 justify-content-center" id="nav-tab" role="tablist">
                            <button class="nav-link active flex-fill text-center py-2 px-3" id="profile-info-tab"
                                data-bs-toggle="tab" data-bs-target="#profile-info" type="button" role="tab"
                                aria-controls="profile-info" aria-selected="true">Informasi Pribadi</button>
                            <button class="nav-link flex-fill text-center py-2 px-3" id="nav-profile-tab"
                                data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab"
                                aria-controls="nav-profile" aria-selected="false">Pemesanan Konsultasi</button>
                        </div>
                    </nav>

                    <div class="tab-content p-3" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="profile-info" role="tabpanel"
                            aria-labelledby="profile-info-tab">
                            <div class="profile-info">
                                <h6>Alamat</h6>
                                <div class="mb-3">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas efficitur, eros ut
                                        porttitor semper, ex tellus cursus ipsum, eu posuere augue turpis ac tortor.</p>
                                </div>
                                <h6>Usia</h6>
                                <div class="mb-3">
                                    <p>43 Tahun</p>
                                </div>
                                <h6>Alergi</h6>
                                <div class="mb-3">
                                    <p>Alergi ayam ras</p>
                                </div>
                                <h6>Golongan Darah</h6>
                                <div class="mb-3">
                                    <p>B</p>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <!-- Filter Section -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span>Filter by:</span>
                                <div class="btn-group" role="group" aria-label="Filter Options">
                                    <button type="button" class="btn btn-outline-primary"
                                        id="filter-latest">Terbaru</button>
                                    <button type="button" class="btn btn-outline-primary"
                                        id="filter-newest">Paling Lama</button>
                                </div>
                            </div>

                            <!-- Scrollable Consultation List -->
                            <div class="consultation-list" style="max-height: 300px; overflow-y: auto;">
                                <div class="booking-item">
                                    <div class="booking-info">
                                        <span class="booking-code">#12345</span>
                                        <div class="booking-details">
                                            <span class="booking-date">2024-09-17</span>
                                            <span class="booking-time">10:30 AM</span>
                                        </div>
                                    </div>
                                    <span class="status-badge badge-success">Success</span>
                                </div>
                                <div class="booking-item">
                                    <div class="booking-info">
                                        <span class="booking-code">#12346</span>
                                        <div class="booking-details">
                                            <span class="booking-date">2024-09-18</span>
                                            <span class="booking-time">02:45 PM</span>
                                        </div>
                                    </div>
                                    <span class="status-badge badge-warning">On Process</span>
                                </div>
                                <div class="booking-item">
                                    <div class="booking-info">
                                        <span class="booking-code">#12347</span>
                                        <div class="booking-details">
                                            <span class="booking-date">2024-09-19</span>
                                            <span class="booking-time">09:00 AM</span>
                                        </div>
                                    </div>
                                    <span class="status-badge badge-danger">Cancelled</span>
                                </div>
                                <div class="booking-item">
                                    <div class="booking-info">
                                        <span class="booking-code">#12345</span>
                                        <div class="booking-details">
                                            <span class="booking-date">2024-09-17</span>
                                            <span class="booking-time">10:30 AM</span>
                                        </div>
                                    </div>
                                    <span class="status-badge badge-success">Success</span>
                                </div>
                                <div class="booking-item">
                                    <div class="booking-info">
                                        <span class="booking-code">#12346</span>
                                        <div class="booking-details">
                                            <span class="booking-date">2024-09-18</span>
                                            <span class="booking-time">02:45 PM</span>
                                        </div>
                                    </div>
                                    <span class="status-badge badge-warning">On Process</span>
                                </div>
                                <div class="booking-item">
                                    <div class="booking-info">
                                        <span class="booking-code">#12347</span>
                                        <div class="booking-details">
                                            <span class="booking-date">2024-09-19</span>
                                            <span class="booking-time">09:00 AM</span>
                                        </div>
                                    </div>
                                    <span class="status-badge badge-danger">Cancelled</span>
                                </div>
                                <div class="booking-item">
                                    <div class="booking-info">
                                        <span class="booking-code">#12345</span>
                                        <div class="booking-details">
                                            <span class="booking-date">2024-09-17</span>
                                            <span class="booking-time">10:30 AM</span>
                                        </div>
                                    </div>
                                    <span class="status-badge badge-success">Success</span>
                                </div>
                                <div class="booking-item">
                                    <div class="booking-info">
                                        <span class="booking-code">#12346</span>
                                        <div class="booking-details">
                                            <span class="booking-date">2024-09-18</span>
                                            <span class="booking-time">02:45 PM</span>
                                        </div>
                                    </div>
                                    <span class="status-badge badge-warning">On Process</span>
                                </div>
                                <div class="booking-item">
                                    <div class="booking-info">
                                        <span class="booking-code">#12347</span>
                                        <div class="booking-details">
                                            <span class="booking-date">2024-09-19</span>
                                            <span class="booking-time">09:00 AM</span>
                                        </div>
                                    </div>
                                    <span class="status-badge badge-danger">Cancelled</span>
                                </div>
                                <div class="booking-item">
                                    <div class="booking-info">
                                        <span class="booking-code">#12345</span>
                                        <div class="booking-details">
                                            <span class="booking-date">2024-09-17</span>
                                            <span class="booking-time">10:30 AM</span>
                                        </div>
                                    </div>
                                    <span class="status-badge badge-success">Success</span>
                                </div>
                                <div class="booking-item">
                                    <div class="booking-info">
                                        <span class="booking-code">#12346</span>
                                        <div class="booking-details">
                                            <span class="booking-date">2024-09-18</span>
                                            <span class="booking-time">02:45 PM</span>
                                        </div>
                                    </div>
                                    <span class="status-badge badge-warning">On Process</span>
                                </div>
                                <div class="booking-item">
                                    <div class="booking-info">
                                        <span class="booking-code">#12347</span>
                                        <div class="booking-details">
                                            <span class="booking-date">2024-09-19</span>
                                            <span class="booking-time">09:00 AM</span>
                                        </div>
                                    </div>
                                    <span class="status-badge badge-danger">Cancelled</span>
                                </div>
                                <div class="booking-item">
                                    <div class="booking-info">
                                        <span class="booking-code">#12345</span>
                                        <div class="booking-details">
                                            <span class="booking-date">2024-09-17</span>
                                            <span class="booking-time">10:30 AM</span>
                                        </div>
                                    </div>
                                    <span class="status-badge badge-success">Success</span>
                                </div>
                                <div class="booking-item">
                                    <div class="booking-info">
                                        <span class="booking-code">#12346</span>
                                        <div class="booking-details">
                                            <span class="booking-date">2024-09-18</span>
                                            <span class="booking-time">02:45 PM</span>
                                        </div>
                                    </div>
                                    <span class="status-badge badge-warning">On Process</span>
                                </div>
                                <div class="booking-item">
                                    <div class="booking-info">
                                        <span class="booking-code">#12347</span>
                                        <div class="booking-details">
                                            <span class="booking-date">2024-09-19</span>
                                            <span class="booking-time">09:00 AM</span>
                                        </div>
                                    </div>
                                    <span class="status-badge badge-danger">Cancelled</span>
                                </div>
                                <div class="booking-item">
                                    <div class="booking-info">
                                        <span class="booking-code">#12345</span>
                                        <div class="booking-details">
                                            <span class="booking-date">2024-09-17</span>
                                            <span class="booking-time">10:30 AM</span>
                                        </div>
                                    </div>
                                    <span class="status-badge badge-success">Success</span>
                                </div>
                                <div class="booking-item">
                                    <div class="booking-info">
                                        <span class="booking-code">#12346</span>
                                        <div class="booking-details">
                                            <span class="booking-date">2024-09-18</span>
                                            <span class="booking-time">02:45 PM</span>
                                        </div>
                                    </div>
                                    <span class="status-badge badge-warning">On Process</span>
                                </div>
                                <div class="booking-item">
                                    <div class="booking-info">
                                        <span class="booking-code">#12347</span>
                                        <div class="booking-details">
                                            <span class="booking-date">2024-09-19</span>
                                            <span class="booking-time">09:00 AM</span>
                                        </div>
                                    </div>
                                    <span class="status-badge badge-danger">Cancelled</span>
                                </div>
                                
                                <!-- Add more booking items as needed -->
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Emergency Section -->
    <!-- Emergency FAB -->
    <div id="emergency" class="emergency-fab">
        <!-- Sub-menu FAB buttons that will collapse/expand -->
        <div id="emergency-buttons" class="emergency-buttons d-flex flex-column align-items-center">
            <a href="#" class="btn btn-success btn-lg mb-2 rounded-circle">
                <i class="fas fa-ambulance"></i>
            </a>
            <a href="#" class="btn btn-outline-success btn-lg rounded-circle mb-2">
                <i class="fab fa-whatsapp"></i>
            </a>
        </div>
        <a href="#!" class="btn btn-danger fab-btn shadow-lg rounded-circle" onclick="toggleEmergencyButtons()">
            <i class="fa-solid fa-phone"></i>
        </a>
    </div>

    <!-- Modal for Editing Profile -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editProfileForm">
                        <div class="mb-3">
                            <label for="profilePhoto" class="form-label">Profile Photo</label>
                            <input type="file" class="form-control" id="profilePhoto">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" value="Nama User">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" value="user@mail.com">
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" rows="3">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas efficitur, eros ut porttitor semper, ex tellus cursus ipsum, eu posuere augue turpis ac tortor.</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="allergy" class="form-label">Allergy</label>
                            <input type="text" class="form-control" id="allergy" value="Alergi ayam ras">
                        </div>
                        <div class="mb-3">
                            <label for="bloodType" class="form-label">Blood Type</label>
                            <input type="text" class="form-control" id="bloodType" value="B">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('js/navbar.js') }}"></script>

    <script>
        function toggleEmergencyButtons() {
            const buttons = document.getElementById("emergency-buttons");
            buttons.classList.toggle("expand");

            if (buttons.style.maxHeight === "0px" || buttons.style.maxHeight === "") {
                buttons.style.maxHeight = "200px"; // Expand the sub-menu (adjust height as needed)
            } else {
                buttons.style.maxHeight = "0px"; // Collapse the sub-menu
            }
        }

        document.getElementById('filter-latest').addEventListener('click', function() {
            sortConsultations('latest');
        });

        document.getElementById('filter-newest').addEventListener('click', function() {
            sortConsultations('newest');
        });

        function sortConsultations(order) {
            const bookingList = document.querySelector('.consultation-list');
            const bookings = Array.from(bookingList.querySelectorAll('.booking-item'));

            bookings.sort((a, b) => {
                const dateA = new Date(a.querySelector('.booking-date').textContent);
                const dateB = new Date(b.querySelector('.booking-date').textContent);

                return order === 'latest' ? dateB - dateA : dateA - dateB;
            });

            bookings.forEach(booking => bookingList.appendChild(booking));
        }
    </script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/user_profile.css') }}">
@endpush
