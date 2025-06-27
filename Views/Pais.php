<?php

/* 
9️⃣ Datos de un país 🌍
🔗 API: https://restcountries.com/v3.1/name/dominican
📌 Descripción:

Ingresar el nombre de un país y mostrar su bandera, capital, población y moneda.
Formulario: Entrada de texto para el nombre del país.
*/



$data = null;
$country = $_POST['country'] ?? '';
$url = "https://restcountries.com/v3.1/name/" . urlencode($country);




if ($_POST) {
    $api = curl_init();
    curl_setopt($api, CURLOPT_URL, $url);
    curl_setopt($api, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($api);
    curl_close($api);
    $data = json_decode($response, true);

    $capital = $data[0]['capital'][0] ?? '';
    $poblacion = $data[0]['population'] ?? 0;

    // Obtener la moneda (primer clave del array currencies)
    $currencies = $data[0]['currencies'] ?? [];
    $monedaNombre = '';
    if (!empty($currencies)) {
        // Tomar la primera moneda del array currencies
        $primeraMoneda = array_key_first($currencies);
        $monedaNombre = $currencies[$primeraMoneda]['name'] ?? '';
    }

    $bandera = $data[0]['flags']['png'] ?? '';
    $pais = $data[0]['name']['official'] ?? '';
}


?>

<section class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white text-center rounded-top-4">
            <h3 class="mb-0">🏳️Datos de un pais</h3>
        </div>
        <div class="card-body">
            <form method="post">
                <div class="mb-3">
                    <label for="country" class="form-label fw-bold">Pais:</label>
                    <input type="text" id="country" name="country" value="<?= htmlspecialchars($country) ?>" class="form-control form-control-lg rounded-3 shadow-sm" placeholder="Ej. Santo Domingo" required>
                    <p class="text-dark">OJO: Escribe el Pais o la nacionalidad del pais en el idioma Ingles</p>
                </div>
                <button type="submit" class="btn btn-success w-100 fw-bold">Buscar</button>
            </form>

        </div>
    </div>

    <?php if ($data): ?>
        <div class="card text-center shadow mt-4 mx-auto" style="max-width: 400px;">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><?= $pais ?></h5>
            </div>
            <div class="card-body">
                <p class="mb-1">🏳️ <strong>Bandera:</strong> <img src="<?= $bandera ?>" alt="bandera"> </p>
                <p class="mb-1"><strong>Capital:</strong> <?= $capital ?></p>
                <p class="mb-1">🏳️ <strong>Poblacion:</strong> <?= number_format($poblacion, 0, ',', '.') ?> de personas</p>
                <p class="mb-1">🪙 <strong>Moneda:</strong> <?= $monedaNombre ?></p>
                
            </div>

        </div>
    <?php endif; ?>
</section>