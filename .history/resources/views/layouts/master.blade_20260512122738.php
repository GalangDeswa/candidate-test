<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>CLT TOOLBOX INDONESIA</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc."/>
        <meta name="author" content="Zoyothemes"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App favicon -->
        <link rel="shortcut icon" href={{ asset("assets/images/favicon.ico") }} >
        
        <!-- App css -->
        <link href={{ asset("assets/css/app.min.css") }}  rel="stylesheet" type="text/css" id="app-style" />

        <!-- Icons -->
        <link href={{ asset("assets/css/icons.min.css") }}  rel="stylesheet" type="text/css" />

        <!-- Head CSS -->
        <script src={{ asset("assets/js/head.js") }} ></script>
    </head>

    <!-- body start -->
    <body data-menu-color="dark" data-sidebar="default">

        <!-- Start Begin Page -->
        <div id="app-layout">
            
        @include('layouts.header')

       @include('layouts.sidebar')

          
            <div class="content-page">
                 @yield('content')

               @include('layouts.footer')

            </div>
          

        </div>
        <!-- End Begin Page -->

        <!-- Vendor -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script src={{ asset("assets/libs/jquery/jquery.min.js") }} ></script>
        <script src={{ asset("assets/libs/bootstrap/js/bootstrap.bundle.min.js") }} ></script>
        <script src= {{ asset("assets/libs/iconify-icon/iconify-icon.min.js") }}></script>
        <script src= {{ asset("assets/libs/simplebar/simplebar.min.js") }}></script>
        <script src= {{ asset("assets/libs/node-waves/waves.min.js") }}></script>
        <script src= {{ asset("assets/libs/waypoints/lib/jquery.waypoints.min.js") }}></script>
        <script src= {{ asset("assets/libs/jquery.counterup/jquery.counterup.min.js") }}></script>
        <script src= {{ asset("assets/libs/feather-icons/feather.min.js") }}></script>

        <!-- Echarts JS -->
        <script src={{ asset("assets/libs/echarts/echarts.min.js") }} ></script>

        <!-- Widgets Init Js -->
        <script src={{ asset("assets/js/pages/crm-dashboard.init.js") }} ></script>

        <!-- App js-->
        <script src={{ asset("assets/js/app.js") }} ></script>

    </body>

</html>