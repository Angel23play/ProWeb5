<?php
/*
🔗 API: http://universities.hipolabs.com/search?country=
📌 Descripción:
Permite ingresar el nombre de un país en inglés y mostrar una lista de universidades con su nombre, dominio y sitio web.
*/

$data = null;
$country = $_POST['country'] ?? ''; // Se obtiene el país ingresado en el formulario

// Si se envió el formulario
if ($_POST) {
    // Se hace la llamada a la API con cURL
    $api = curl_init();
    curl_setopt($api, CURLOPT_URL, "http://universities.hipolabs.com/search?country=" . urlencode($country));
    curl_setopt($api, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($api);
    curl_close($api);
    $data = json_decode($response, true); // Se convierte la respuesta en array PHP
}
?>

<!-- Formulario para ingresar el país -->
<section class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white text-center rounded-top-4">
            <h3 class="mb-0">🔎 Busquemos las universidades de un país</h3>
        </div>
        <div class="card-body">
            <form method="post">
                <div class="mb-3">
                    <label for="country" class="form-label fw-bold">País:</label>
                    <input type="text" id="country" name="country" value="<?= htmlspecialchars($country) ?>"
                        class="form-control form-control-lg rounded-3 shadow-sm" placeholder="Ej. Dominican Republic" required>
                    <p class="text-dark">OJO: El país debe escribirse en idioma inglés</p>
                </div>
                <button type="submit" class="btn btn-success w-100 fw-bold">Buscar</button>
            </form>
        </div>
    </div>

    <!-- Si la API devolvió universidades -->
    <?php if ($data): ?>
        <div class="mt-5">
            <h3 class="text-center text-primary mb-4">🎓 Lista de universidades en <?= htmlspecialchars($country) ?></h3>
            <div class="">
                <?php foreach ($data as $uni): ?>
                    <div class="col">
                        <div class="card h-100 shadow-sm rounded-4 mb-3">
                            <div class="card-body">
                                <h5 class="card-title text-dark fw-bold"><?= htmlspecialchars($uni['name']) ?></h5>
                                <p class="card-text text-muted mb-1">
                                    🌐 Dominio: <strong><?= htmlspecialchars($uni['domains'][0] ?? 'No disponible') ?></strong>
                                </p>
                                <p class="card-text">
                                    🔗 Sitio web:
                                    <a href="<?= htmlspecialchars($uni['web_pages'][0] ?? '#') ?>" target="_blank" class="text-decoration-none">
                                        <?= htmlspecialchars($uni['web_pages'][0] ?? 'No disponible') ?>
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    <!-- Si no se encontró ninguna universidad -->
    <?php elseif (is_array($data) && empty($data)): ?>
        <div class="mt-5 text-center">
            <div class="card shadow-sm border-danger">
                <div class="card-body">
                    <h3 class="card-title text-danger">❌ No se encontraron universidades</h3>
                    <p class="card-text text-muted">Prueba con otro país escrito en inglés.</p>
                </div>
            </div>
        </div>
    <?php endif; ?>
</section>
