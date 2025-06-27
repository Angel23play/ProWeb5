<?php

/* 4️⃣ Clima en República Dominicana 🌦️
🔗 API: [Usar una API como OpenWeather]
📌 Descripción:

Mostrar el clima actual en República Dominicana con iconos y temperatura.
Adaptar el diseño a las condiciones climáticas (sol ☀️, lluvia 🌧️, nublado ☁️).
Formulario: Entrada para buscar clima en una ciudad específica.
*/



$data = null;
$city = $_POST['city'] ?? '';
$url = "https://wttr.in/" . urlencode($city) . "?format=j1";




if ($_POST) {
    $api = curl_init();
    curl_setopt($api, CURLOPT_URL, $url);
    curl_setopt($api, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($api);
    curl_close($api);
    $data = json_decode($response, true);

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