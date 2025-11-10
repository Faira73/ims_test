<x-layout>
    <div class="auth-page">
        <form action="{{ route('login.attempt') }}" method="POST" class="auth-form">
            @csrf

            {{-- Error messages --}}
            @if ($errors->any())
                <div class="form-errors">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}">
            <input type="password" name="password" placeholder="Password">
            <button type="submit">Login</button>
        </form>
         <div class="register-link">
            <p>Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
        </div>
    </div>
</x-layout>
