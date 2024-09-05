<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>

<body>
    <div class="container-fluid">
        <div class="row w-100">
            <!-- Right Section (Background with Circular Gradient) -->
            <div class="col-lg-6 full-image-section">
                <div class="position-relative">
                    <img src="images/logo.png" alt="Logo" class="logo">
                    <div class="circle"></div>
                </div>
            </div>
            
            <!-- Left Section (Registration Form) -->
            <div class="col-lg-6 d-flex align-items-center justify-content-center auth-form-container">
                <div class="auth-form text-center">
                    <!-- Add a container for the logo above the form -->
                    <div class="form-logo">
                        <img src="images/logo.png" alt="Logo" class="form-logo-img">
                    </div>
                    <h2>Create an Account</h2>
                    <p>Fill in the details to register.</p>
                    <form>
                        <div class="mb-3 text-start">
                            <label for="name" class="form-label">Name</label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="fa-solid fa-user"></i></div>
                                <input type="text" class="form-control" id="name" name="name" required autofocus>
                            </div>
                        </div>
                        <div class="mb-3 text-start">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="fa-solid fa-envelope"></i></div>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                        <div class="mb-3 text-start">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="fa-solid fa-lock"></i></div>
                                <input type="password" class="form-control" id="password" name="password" required>
                                <div class="input-group-text"><i class="fa-solid fa-eye-slash"></i></div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <a href="/" class="text-primary">Already have an account? Log in</a>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Register</button>
                    </form>
                    <p class="text-center mt-4">Already have an account? <a href="/login" class="text-primary">Log in</a></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
