<?php
/*
Generador de chistes aleatorios usando la API:
https://official-joke-api.appspot.com/random_joke

Muestra un chiste cada vez que se carga la página.
No usa formulario.
*/

$data = null;

// URL de la API
$url = "https://official-joke-api.appspot.com/random_joke";

// Inicializa cURL para pedir el chiste
$api = curl_init();
curl_setopt($api, CURLOPT_URL, $url);
curl_setopt($api, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($api);
curl_close($api);

// Convierte JSON a array PHP
$data = json_decode($response, true);
?>

<!-- Mostrar el chiste dentro de una tarjeta -->
<section class="container mt-5">
    <div class="card text-center p-4 border border-primary shadow-lg" style="max-width: 600px; margin: auto; background: linear-gradient(145deg, #ffffff, #f0f8ff); border-radius: 1.5rem;">
        <div class="card-body">
            <!-- Emoji animado -->
            <div class="mb-3" style="font-size: 3rem; animation: float 2s ease-in-out infinite;">🤣</div>
            <h3 class="card-title fw-bold mb-3 text-dark">¡Hora de reír!</h3>
            <!-- Tipo de chiste -->
            <p class="badge bg-warning text-dark mb-2" style="font-size: 0.9rem;">Tipo: <?= htmlspecialchars($data['type']) ?></p>
            <!-- Texto del chiste -->
            <blockquote class="blockquote">
                <p class="mb-3 fw-semibold text-secondary" style="font-size: 1.2rem;"><?= htmlspecialchars($data['setup']) ?></p>
                <footer class="blockquote-footer mt-2 text-primary" style="font-size: 1.1rem;"><?= htmlspecialchars($data['punchline']) ?></footer>
            </blockquote>
        </div>
    </div>
</section>

<!-- Animación sencilla para el emoji -->
<style>
@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-5px); }
}
</style>
