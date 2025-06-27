<?php
/*
5️⃣ Información de un Pokémon ⚡
🔗 API: https://pokeapi.co/api/v2/pokemon/pikachu
📌 Descripción:

Ingresar el nombre de un Pokémon y mostrar su foto, experiencia base y habilidades. De alguna manera debe reproducir el sonido del pokemon (esta en la api el archivo de audio)
Usar un diseño acorde al universo Pokémon 🎮.
Formulario: Entrada de texto para el nombre del Pokémon.
*/
$data = null;
$pokemon = $_POST['pokemon'] ?? '';
$url = "https://pokeapi.co/api/v2/pokemon/";
if ($_POST) {
    $api = curl_init();
    curl_setopt($api, CURLOPT_URL, $url . urlencode($pokemon));
    curl_setopt($api, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($api);
    curl_close($api);
    $data = json_decode($response, true);

    $nombre_normalizado = strtolower(trim($data['name'])); // asegura que esté bien
    $audio_url = "https://play.pokemonshowdown.com/audio/cries/{$nombre_normalizado}.mp3";
}


?>

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

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger mt-4 text-center">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <?php if ($data): ?>
        <div class="card text-center shadow mt-4 border-3 border-danger" style="max-width: 500px; margin: auto;">
            <div class="card-header bg-danger text-white">
                <h4><?= ucfirst($data['name']) ?> #<?= $data['id'] ?></h4>
            </div>
            <img src="<?= $data['sprites']['other']['official-artwork']['front_default'] ?>" class="card-img-top p-3" alt="Imagen de <?= $data['name'] ?>">
            <div class="card-body">
                <p><strong>⚡ Experiencia Base:</strong> <?= $data['base_experience'] ?></p>
                <p><strong>🧠 Habilidades:</strong>
                    <?= implode(', ', array_map(fn($a) => $a['ability']['name'], $data['abilities'])) ?>
                </p>
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
    <?php elseif (is_null($data)): ?>
        <div class="alert alert-danger" role="alert">
            <strong>Este Pokemon no se encuentra en la Pokedex, Favor inserte otro nombre de Pokémon</strong>
        </div>
    <?php endif; ?>
</section>

<script>
    const audio = document.getElementById('pokemonAudio');
    audio.addEventListener('error', () => {
        document.getElementById('pokemonAudio').style.display = 'none';
        document.getElementById('audioError').style.display = 'block';
    });
</script>