<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>DASHMIN - Bootstrap Admin Template</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">
    
        <!-- Favicon -->
        <link href="img/favicon.ico" rel="icon">

        <!--bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >
    
        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
        
        <!-- Icon Font Stylesheet -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    
        <!-- Libraries Stylesheet -->
        <link href="{{ url('assets/admin/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
        <link href="{{ url('assets/admin/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />
    
        <!-- Customized Bootstrap Stylesheet -->
        <link href="{{ url('assets/admin/css/bootstrap.min.css') }}" rel="stylesheet">
    
        <!-- Template Stylesheet -->
        <link href="{{ url('assets/admin/css/style.css') }}" rel="stylesheet">
    </head>
<body>
    <div id="app">
        <main class="py-4">
            @yield('content')
        </main>
    </div>

      <!-- JavaScript Libraries -->
      <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
      <script src="{{ url('assets/admin/lib/chart/chart.min.js') }}"></script>
      <script src="{{ url('assets/admin/lib/easing/easing.min.js') }}"></script>
      <script src="{{ url('assets/admin/lib/waypoints/waypoints.min.js') }}"></script>
      <script src="{{ url('assets/admin/lib/owlcarousel/owl.carousel.min.js') }}"></script>
      <script src="{{ url('assets/admin/lib/tempusdominus/js/moment.min.js') }}"></script>
      <script src="{{ url('assets/admin/lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
      <script src="{{ url('assets/admin/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>
  
      <!-- Template Javascript -->
      <script src="{{ url('assets/admin/js/main.js') }}"></script>
      <script src="{{ url('assets/admin/js/custom.js') }}"></script>
       <!-- sweet alert 2 -->
      <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
