@extends('landing-page.layouts.app')

@section('content')

<div class="container" style="margin-top: 80px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="profile-header text-center">
                <img src="{{ asset('images/user.jpg') }}" alt="User Photo">
                <h5>Nama User</h5>
                <p>user@mail.com</p>
                <img src="icons/pencil-square.png" alt="Edit Profile" class="edit-icon" data-bs-toggle="modal" data-bs-target="#editProfileModal">
            </div>
            <div class="profile-info">
                <h6>Alamat</h6>
                <div class="mb-3">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas efficitur, eros ut porttitor semper, ex tellus cursus ipsum, eu posuere augue turpis ac tortor.</p>
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
    <a href="#!" class="btn btn-danger fab-btn shadow-lg rounded-circle"
        onclick="toggleEmergencyButtons()">
        <i class="fa-solid fa-phone"></i>
    </a>
</div>

<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
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
</script>
@endpush

@push('styles')
<link rel="stylesheet" href="{{ asset('css/user_profile.css') }}">
@endpush
