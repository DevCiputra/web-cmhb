<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=DM Sans' rel='stylesheet'>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user_profile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
</head>

<body>
    <!-- Navbar Section -->
    @include('layouts.navbar')

    <div class="container" style="margin-top: 80px;">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="profile-header text-center">
                    <img src="{{ asset('images/user.jpg') }}" alt="User Photo">
                    <h5>Nama User</h5>
                    <p>08218881010</p>
                    <p>user@mail.com</p>
                    <img src="icons/pencil-square.png" alt="Edit Profile" class="edit-icon" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                </div>
                <div class="card p-3 shadow tab-bar" style="max-width: auto;">
                    <nav>
                        <div class="nav nav-tabs mb-1 justify-content-center" id="nav-tab" role="tablist">
                            <button class="nav-link active flex-fill text-center py-2 px-3" id="profile-info-tab" data-bs-toggle="tab" data-bs-target="#profile-info" type="button" role="tab" aria-controls="profile-info" aria-selected="true">Informasi Pribadi</button>
                            <button class="nav-link flex-fill text-center py-2 px-3" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Pemesanan Konsultasi</button>
                        </div>
                    </nav>
                    
                    <div class="tab-content p-3 border bg-light" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="profile-info" role="tabpanel" aria-labelledby="profile-info-tab">
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
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <p><strong>This is some placeholder content the Profile tab's associated content.</strong>
                                Clicking another tab will toggle the visibility of this one for the next.
                                The tab JavaScript swaps classes to control the content visibility and styling. You can use it with
                                tabs, pills, and any other <code>.nav</code>-powered navigation.</p>
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
            <a href="#!" class="btn btn-danger fab-btn shadow-lg rounded-circle"
                onclick="toggleEmergencyButtons()">
                <i class="fa-solid fa-phone"></i>
            </a>
        </div>

<!-- Modal for Editing Profile -->
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

    @include('layouts.footer')
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
</body>

</html>
