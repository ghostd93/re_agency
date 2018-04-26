@component('mail::message')
<div>
    <p>Aby aktywować konto kliknij w poniższy link.</p>

    @component('mail::button', [
        'url' => 'http://localhost:8000/api/auth/activate?token=' . $token,
        'color' => 'blue'
    ])
        Aktywuj konto
    @endcomponent
</div>
@endcomponent