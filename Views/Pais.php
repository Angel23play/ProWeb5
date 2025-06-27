<?php
/*
9️⃣ Datos de un país 🌍
🔗 API: https://restcountries.com/v3.1/name/
📌 Muestra información de un país: bandera, capital, población y moneda.
*/

$data = null;
$country = $_POST['country'] ?? ''; // Captura el país ingresado
$url = "https://restcountries.com/v3.1/name/" . urlencode($country);

// Si se envió el formulario
if ($_POST) {
    // Llamada a la API de países
    $api = curl_init();
    curl_setopt($api, CURLOPT_URL, $url);
    curl_setopt($api, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($api);
    curl_close($api);
    $data = json_decode($response, true);

    // Se extraen los datos básicos del país
    $capital = $data[0]['capital'][0] ?? '';
    $poblacion = $data[0]['population'] ?? 0;

    // Obtener el nombre de la primera moneda disponible
    $currencies = $data[0]['currencies'] ?? [];
    $monedaNombre = '';
    if (!empty($currencies)) {
        $primeraMoneda = array_key_first($currencies);
        $monedaNombre = $currencies[$primeraMoneda]['name'] ?? '';
    }

    // Bandera y nombre oficial del país
    $bandera = $data[0]['flags']['png'] ?? '';
    $pais = $data[0]['name']['official'] ?? '';
}
?>

<!-- Formulario para buscar país -->
<section class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white text-center rounded-top-4">
            <h3 class="mb-0">🏳️Datos de un pais</h3>
        </div>
        <div class="card-body">
            <form method="post">
                <div class="mb-3">
                    <label for="country" class="form-label fw-bold">Pais:</label>
                    <input type="text" id="country" name="country" value="<?= htmlspecialchars($country) ?>" class="form-control form-control-lg rounded-3 shadow-sm" placeholder="Ej. Dominican Republic" required>
                    <p class="text-dark">OJO: Escribe el país en inglés</p>
                </div>
                <button type="submit" class="btn btn-success w-100 fw-bold">Buscar</button>
            </form>
        </div>
    </div>

    <!-- Mostrar datos si la API respondió -->
    <?php if ($data): ?>
        <div class="card text-center shadow mt-4 mx-auto" style="max-width: 400px;">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><?= $pais ?></h5>
            </div>
            <div class="card-body">
                <p class="mb-1">🏳️ <strong>Bandera:</strong> <img src="<?= $bandera ?>" alt="bandera"></p>
                <p class="mb-1"><strong>Capital:</strong> <?= $capital ?></p>
                <p class="mb-1">🌎 <strong>Población:</strong> <?= number_format($poblacion, 0, ',', '.') ?> personas</p>
                <p class="mb-1">🪙 <strong>Moneda:</strong> <?= $monedaNombre ?></p>
            </div>
        </div>
    <?php endif; ?>
</section>
