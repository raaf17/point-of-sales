<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $setting->nama_perusahaan ? $setting->nama_perusahaan : config('app.name') }} &mdash; Log in</title>
    <link rel="stylesheet" href="{{ asset('mazer') }}/assets/css/main/app.css">
    <link rel="stylesheet" href="{{ asset('mazer') }}/assets/css/pages/auth.css">
    <link rel="stylesheet" href="{{ asset('mazer') }}/assets/css/pages/fontawesome.css">
    <link rel="icon" href="{{ url($setting->path_logo) }}" type="image/png">
</head>

<body>
    <div id="auth">
        @yield('login')
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/6.0.0/bootbox.min.js"
        integrity="sha512-oVbWSv2O4y1UzvExJMHaHcaib4wsBMS5tEP3/YkMP6GmkwRJAa79Jwsv+Y/w7w2Vb/98/Xhvck10LyJweB8Jsw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>
