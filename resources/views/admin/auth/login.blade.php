<form method="POST" action="{{ url('admin/login') }}">
    @csrf

    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>

    <button type="submit">Login Admin</button>

    @if(session('error'))
        <p style="color:red">{{ session('error') }}</p>
    @endif
</form>
