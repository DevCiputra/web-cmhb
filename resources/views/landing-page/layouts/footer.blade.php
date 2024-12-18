<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5>Tentang Kami</h5>
                <p>{{ $hospitalInformation->mission ?? 'Ciputra Mitra Hospital selalu mengutamakan kepentingan dan kepuasan pasien...' }}</p>
            </div>
            <div class="col-md-4">
                <h5>Hubungi Kami</h5>
                <ul>
                    <li>Phone: {{ $hospitalInformation->phone ?? '(0511) 6743999' }}</li>
                    <!--<li>Email: {{ $hospitalInformation->email ?? 'info@example.com' }}</li>-->
                    <li>Address: {{ $hospitalInformation->address ?? 'Komplek Citra Land Jalan Ahmad Yani KM. 7,8...' }}</li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5>Follow Us</h5>
                <ul class="social-media">
                    <li>
                        <a href="https://www.facebook.com/CiputraMitraHospitalBJM" target="_blank">
                            <img src="{{ asset('icons/facebook.png') }}" alt="Facebook">
                        </a>
                    </li>
                    <li>
                        <a href="https://www.tiktok.com/@ciputramitrahospital" target="_blank">
                            <img src="{{ asset('icons/tiktok.png') }}" alt="Tiktok">
                        </a>
                    </li>
                    <li>
                        <a href="https://www.instagram.com/ciputramitrahospitalbjm/" target="_blank">
                            <img src="{{ asset('icons/instagram.png') }}" alt="Instagram">
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="text-center">
            <p>&copy; {{ date('Y') }} Ciputra Mitra Hospital. All rights reserved.</p>
        </div>
    </div>
</footer>