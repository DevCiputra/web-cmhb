@extends('landing-page.layouts.app')

@section('content')
<div class="container" style="margin-top: 80px;">
    <!-- Breadcrumb Section -->
    <div class="container" style="margin-top: 110px;">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                <li class="breadcrumb-item"><a href="#">Fitur</a></li>
                <li class="breadcrumb-item active" aria-current="page">BMI Calculator</li>
            </ol>
        </nav>
    </div>

    <div id="list-mcu" class="header-section">
        <div class="container-fluid">
            <h1 class="mb-2">Body Mass Index Calculator</h1>
            <p class="mb-3">Hitung berat badan ideal anda.</p>
        </div>

        <!-- BMI Calculator Section -->
    <div class="bmi-calculator">
        <p class="intro">Indeks Massa Tubuh (BMI) adalah cara untuk mengetahui apakah berat badan Anda dalam kisaran sehat berdasarkan tinggi badan Anda. 
            Kalkulator ini akan membantu Anda mengetahui kategori BMI Anda berdasarkan hasil perhitungan berat badan dan tinggi badan.</p>
        <div class="form-group">
            <label for="weight">Weight (kg):</label>
            <input type="number" id="weight" placeholder="Enter your weight">
        </div>
        <div class="form-group">
            <label for="height">Height (cm):</label>
            <input type="number" id="height" placeholder="Enter your height in cm">
        </div>
        <button class="btn" onclick="calculateBMI()">Calculate BMI</button>
        
        <div class="result" id="result"></div>
    </div>

    <!-- BMI Categories Table -->
    <div class="bmi-table">
        <h3>BMI Categories</h3>
        <table>
            <thead>
                <tr>
                    <th>Category</th>
                    <th>BMI Range (kg/m²)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Underweight</td>
                    <td>&lt; 18.5</td>
                </tr>
                <tr>
                    <td>Normal weight</td>
                    <td>18.5 - 24.9</td>
                </tr>
                <tr>
                    <td>Overweight</td>
                    <td>25 - 29.9</td>
                </tr>
                <tr>
                    <td>Obese</td>
                    <td>&gt; 30</td>
                </tr>
            </tbody>
        </table>
    </div>

</div>


    </div>
    <!-- Emergency Section -->
    <!-- Emergency FAB -->
    <div id="emergency" class="emergency-fab">
        <!-- Sub-menu FAB buttons that will collapse/expand -->
        <div id="emergency-buttons" class="emergency-buttons d-flex flex-column align-items-center">
            <a href="tel:+625116743911" class="btn btn-success btn-lg mb-2 rounded-circle">
                <i class="fas fa-ambulance"></i>
            </a>
            <a href="https://api.whatsapp.com/send?phone=6278033212250&text=Saya%20tertarik%20layanan%20di%20Ciputra%20Hospital%20saya%20ingin%20informasi%20mengenai"
                class="btn btn-outline-success btn-lg rounded-circle mb-2" target="_blank">
                <i class="fab fa-whatsapp"></i>
            </a>
        </div>
        <a href="#!" class="btn btn-danger fab-btn shadow-lg rounded-circle" onclick="toggleEmergencyButtons()">
            <i class="fa-solid fa-phone"></i>
        </a>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/navbar.js') }}"></script>
<script>
    function toggleEmergencyButtons() {
        const buttons = document.getElementById("emergency-buttons");
        buttons.classList.toggle("expand");
        buttons.style.maxHeight = buttons.style.maxHeight === "0px" || buttons.style.maxHeight === "" ? "200px" : "0px";
    }

    function calculateBMI() {
        const weight = parseFloat(document.getElementById('weight').value);
        const heightCm = parseFloat(document.getElementById('height').value);

        if (!weight || !heightCm || heightCm <= 0 || weight <= 0) {
            document.getElementById('result').innerText = 'Please enter valid weight and height values.';
            return;
        }

        // Convert height from cm to m
        const height = heightCm / 100;

        // Calculate BMI
        const bmi = (weight / (height * height)).toFixed(2);

        let category = '';
        if (bmi < 18.5) {
            category = 'Underweight';
        } else if (bmi >= 18.5 && bmi < 24.9) {
            category = 'Normal weight';
        } else if (bmi >= 25 && bmi < 29.9) {
            category = 'Overweight';
        } else {
            category = 'Obese';
        }

        document.getElementById('result').innerText = `Your BMI is ${bmi} (${category}).`;
    }
</script>
@endpush

@push('styles')
<link rel="stylesheet" href="{{ asset('css/bmi.css') }}">
@endpush