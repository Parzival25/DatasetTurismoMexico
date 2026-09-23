<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title>Entrar · Administración del dataset</title>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dataset.css') }}">
</head>
<body>
<div class="entrar">
    <form class="tarjeta" method="post" action="{{ route('login') }}">
        @csrf
        <div style="display:flex;align-items:center;gap:.6rem;margin-bottom:1.2rem">
            @include('parciales.logo', ['tamano' => 36])
            <div><strong>Dataset Turístico de Chiapas</strong><br><span style="color:var(--gris);font-size:.9rem">Administración</span></div>
        </div>

        <div class="campo">
            <label for="email">Correo</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
            @error('email') <span class="error">{{ $message }}</span> @enderror
        </div>
        <div class="campo">
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" required autocomplete="current-password">
            @error('password') <span class="error">{{ $message }}</span> @enderror
        </div>
        <label style="display:flex;gap:.45rem;align-items:center;margin-bottom:1rem"><input type="checkbox" name="recordar" value="1"> Mantener la sesión</label>
        <button class="boton" type="submit" style="width:100%;justify-content:center">Entrar</button>
        <p style="margin:1rem 0 0;text-align:center"><a href="{{ route('portal.inicio') }}">← Volver al portal</a></p>
    </form>
</div>
</body>
</html>
