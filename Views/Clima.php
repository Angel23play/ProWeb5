<?php
/*
4️⃣ Clima en República Dominicana 🌦️
🔗 API: Usando wttr.in
📌 Muestra el clima actual de una ciudad (por defecto, RD).
Incluye formulario para buscar por ciudad.
*/

// Inicializa variables
$data = null;
$city = $_POST['city'] ?? ''; // Ciudad enviada por el formulario
$url = "https://wttr.in/" . urlencode($city) . "?format=j1"; // URL de la API con formato JSON

// Si se envió el formulario
if ($_POST) {
    // Llamada a la API usando cURL
    $api = curl_init();
    curl_setopt($api, CURLOPT_URL, $url);
    curl_setopt($api, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($api);
    curl_close($api);

    // Decodifica la respuesta
    $data = json_decode($response, true);

    // Extrae información del clima
    $clima = $data['current_condition'][0];
    $area = $data['nearest_area'][0];

    $temp = $clima['temp_C'];
    $desc = $clima['weatherDesc'][0]['value'];
    $humedad = $clima['humidity'];
    $viento = $clima['windspeedKmph'];
    $direccion = $clima['winddir16Point'];
    $ciudad = $area['areaName'][0]['value'];
    $pais = $area['country'][0]['value'];
}
?>

<!-- Formulario para buscar el clima por ciudad -->
<section class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white text-center rounded-top-4">
            <h3 class="mb-0">🤔Como va el clima❔</h3>
        </div>
        <div class="card-body">
            <form method="post">
                <div class="mb-3">
                    <label for="city" class="form-label fw-bold">Pais:</label>
                    <input type="text" id="city" name="city" value="<?= htmlspecialchars($city) ?>" class="form-control form-control-lg rounded-3 shadow-sm" placeholder="Ej. Santo Domingo" required>
                    <p class="text-dark">OJO: La ciudad o municipio debe escribirse en idioma Ingles</p>
                </div>
                <button type="submit" class="btn btn-success w-100 fw-bold">Buscar</button>
            </form>
        </div>
    </div>

    <!-- Si hay datos, se muestra el clima actual -->
    <?php if ($data): ?>
        <div class="card text-center shadow mt-4 mx-auto" style="max-width: 400px;">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Clima en <?= $ciudad ?>, <?= $pais ?></h5>
            </div>
            <div class="card-body">
                <h1 class="display-4"><?= $temp ?>°C</h1>
                <p class="lead"><?= $desc ?></p>
                <hr>
                <p class="mb-1">💧 <strong>Humedad:</strong> <?= $humedad ?>%</p>
                <p class="mb-1">💨 <strong>Viento:</strong> <?= $viento ?> km/h (<?= $direccion ?>)</p>
            </div>
        </div>
    <?php endif; ?>
</section>
