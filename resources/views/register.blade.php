<x-layout>
    <div class="auth-page">
        <form action="{{ route('register.store') }}" method="POST" class="auth-form">
            @csrf
            <input type="text" name="name" placeholder="Name">
            <input type="email" name="email" placeholder="Email">
            <input type="password" name="password" placeholder="Password">
            <input type="password" name="password_confirmation" placeholder="Confirm Password">
            <button type="submit">Create Account</button>
        </form>
    </div>
</x-layout>
