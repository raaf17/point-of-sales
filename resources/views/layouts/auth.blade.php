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
</body>

</html>
