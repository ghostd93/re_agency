@component('mail::message')
<div>
    <p>Aby aktywować konto kliknij w poniższy link.</p>

    @component('mail::button', [
        'url' => env('APP_URL') . '/api/auth/activate?token=' . $token,
        'color' => 'blue'
    ])
        Aktywuj konto
    @endcomponent
</div>
@endcomponent