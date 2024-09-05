<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>

<body>
    <div class="container-fluid">
        <div class="row w-100">
            <!-- Left Section (Login Form) -->
            <div class="col-lg-6 d-flex align-items-center justify-content-center auth-form-container">
                <div class="auth-form text-center">
                    <h2>Welcome back</h2>
                    <p>Please enter your details.</p>
                    <form>
                        <div class="mb-3 text-start">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="fa-solid fa-envelope"></i></div>
                                <input type="email" class="form-control" id="email" name="email" required autofocus>
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
                            <a href="/" class="text-primary">Forgot password</a>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Sign in</button>
                    </form>
                    <p class="text-center mt-4">Don’t have an account? <a href="/register" class="text-primary">Sign
                            up</a></p>
                </div>
            </div>
            

            <!-- Right Section (Background with Circular Gradient) -->
            <div class="col-lg-6 full-image-section">
                <div class="position-relative">
                    <img src="images/logo.png" alt="Logo" class="logo">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
