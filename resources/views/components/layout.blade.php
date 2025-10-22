<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NCH-WI</title>

    @vite(['resources/css/app.css', 'resources/js/app.js', 'public/images'])
</head>
<body>
    <header>
        <img src="{{ asset('images/logo.png') }}" alt="Logo">
        @auth
        <form action="{{ route('logout')}}" method="POST">
            @csrf
            <button type="submit" class="sign_out">Sign out</button>
        </form>
        @endauth
    </header>
    <div class="main-container">

        @if(!empty($sidebar))
            <aside class="sidebar">
                {{ $sidebar }}
            </aside>
        @endif

        <main class="container">
            {{ $slot }}
        </main>
    </div>
    {{-- <footer style="
    height: 51px; 
    background: url('{{ asset('images/imagesfooter-strip.png') }}') repeat-x; 
    background-size: auto; 
    position: fixed; 
    bottom: 0; 
    left: 0; 
    width: 100%;">
    </footer> --}}
</body>
</html>