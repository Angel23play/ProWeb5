<?php
/*
5️⃣ Información de un Pokémon ⚡
🔗 API: https://pokeapi.co/api/v2/pokemon/
📌 Muestra la imagen, experiencia base, habilidades y sonido de un Pokémon buscado.
*/

$data = null;
$pokemon = $_POST['pokemon'] ?? ''; // Nombre del Pokémon ingresado
$url = "https://pokeapi.co/api/v2/pokemon/";

// Si se envió el formulario
if ($_POST) {
    // Llamada a la API de Pokémon
    $api = curl_init();
    curl_setopt($api, CURLOPT_URL, $url . urlencode($pokemon));
    curl_setopt($api, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($api);
    curl_close($api);
    $data = json_decode($response, true);

    // Normalizar nombre y generar la URL del audio
    $nombre_normalizado = strtolower(trim($data['name']));
    $audio_url = "https://play.pokemonshowdown.com/audio/cries/{$nombre_normalizado}.mp3";
}
?>

<!-- Formulario de búsqueda -->
<section class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-warning text-dark text-center">
            <h3>🔍 Busca tu Pokémon favorito en la Pokedex</h3>
        </div>
        <div class="card-body">
            <form method="post">
                <input type="text" name="pokemon" class="form-control form-control-lg mb-3 text-center" placeholder="Ej. Pikachu, Charmander..." required>
                <button class="btn btn-danger w-100 fw-bold">Buscar Pokémon</button>
            </form>
        </div>
    </div>

    <!-- Si ocurre un error -->
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger mt-4 text-center">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <!-- Si hay datos válidos del Pokémon -->
    <?php if ($data): ?>
        <div class="card text-center shadow mt-4 border-3 border-danger" style="max-width: 500px; margin: auto;">
            <div class="card-header bg-danger text-white">
                <h4><?= ucfirst($data['name']) ?> #<?= $data['id'] ?></h4>
            </div>

            <!-- Imagen oficial -->
            <img src="<?= $data['sprites']['other']['official-artwork']['front_default'] ?>" class="card-img-top p-3" alt="Imagen de <?= $data['name'] ?>">

            <div class="card-body">
                <!-- Muestra experiencia base -->
                <p><strong>⚡ Experiencia Base:</strong> <?= $data['base_experience'] ?></p>

                <!-- Lista de habilidades -->
                <p><strong>🧠 Habilidades:</strong>
                    <?= implode(', ', array_map(fn($a) => $a['ability']['name'], $data['abilities'])) ?>
                </p>

                <!-- Audio del Pokémon -->
                <hr>
                <p><strong>🎵 Sonido del Pokémon:</strong></p>
                <audio id="pokemonAudio" controls>
                    <source src="<?= $audio_url ?>" type="audio/mpeg">
                    Tu navegador no soporta audio.
                </audio>
                <div id="audioError" class="text-danger mt-2" style="display: none;">
                    ❌ El sonido de este Pokémon no está disponible.
                </div>
            </div>
        </div>

    <!-- Si no se encontraron datos -->
    <?php elseif (is_null($data)): ?>
        <div class="alert alert-danger" role="alert">
            <strong>Este Pokémon no se encuentra en la Pokédex. Favor inserte otro nombre.</strong>
        </div>
    <?php endif; ?>
</section>

<!-- Script para mostrar mensaje si el audio falla -->
<script>
    const audio = document.getElementById('pokemonAudio');
    audio.addEventListener('error', () => {
        document.getElementById('pokemonAudio').style.display = 'none';
        document.getElementById('audioError').style.display = 'block';
    });
</script>
