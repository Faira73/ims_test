<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NCH-WI</title>

    @vite(['resources/css/app.css', 'resources/js/app.js', 'public/images'])
</head>
<body>
        <header class="flex justify-between items-center p-4 bg-gray-100">
            <div class="flex items-center space-x-4">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10">
            </div>

            @auth
                <div class="flex items-center space-x-4">
                    <span class="font-medium text-white">
                        {{ auth()->user()->name }}
                    </span>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="sign_out bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                            Sign out
                        </button>
                    </form>
                </div>
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
    </body>
</html>