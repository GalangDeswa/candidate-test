<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - CLT Toolbox</title>
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
        }
        .left-panel {
            background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), 
                        url('https://app.clttoolbox.com.au/images/login-bg.jpg');
            background-size: cover;
            background-position: center;
        }
        .btn-brand {
            background-color: #FF2D20;
            color: white;
            border: none;
            padding: 12px;
            font-weight: 600;
        }
        .btn-brand:hover {
            background-color: #e0281a;
            color: white;
        }
    </style>
</head>
<body>

    <div class="container-fluid p-0">
      
        <div class="row g-0 vh-100">
            
           
            <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center left-panel">
                <div class="text-center">
                    <img src="https://app.clttoolbox.com.au/images/logos/logo_color_white.png" alt="Logo" style="max-width: 350px;">
                </div>
            </div>

           
            <div class="col-12 col-lg-6 d-flex flex-column bg-white">
                
                
                <nav class="p-4 text-end">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-decoration-none text-muted small fw-bold">DASHBOARD</a>
                    @endauth
                </nav>

               
                <div class="flex-grow-1 d-flex align-items-center justify-content-center">
                    <div class="w-100 px-5" style="max-width: 450px;">
                        
                        
                        <div class="d-lg-none text-center mb-5">
                             <img src="https://app.clttoolbox.com.au/images/logos/logo_color_white.png" alt="Logo" class="bg-dark p-3 rounded" style="max-width: 200px;">
                        </div>

                        <h2 class="fw-bold mb-2">Welcome</h2>
                        <p class="text-muted mb-5">Select an option to access your toolbox.</p>

                        <div class="d-grid gap-3">
                            @guest
                                <a href="{{ route('login') }}" class="btn btn-brand rounded-3 shadow-sm " style="background-color: green">
                                    Log in
                                </a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="btn btn-outline-dark rounded-3">
                                        Register
                                    </a>
                                @endif
                            @endguest
                        </div>
                    </div>
                </div>

                
                <footer class="p-4 text-center text-muted small">
                    &copy; {{ date('Y') }} CLT Toolbox
                </footer>
            </div>

        </div>
    </div>

</body>
</html>