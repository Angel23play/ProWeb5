<?php
/*
7️⃣ Conversión de Monedas 💰
🔗 API: https://api.exchangerate-api.com/v4/latest/USD
📌 Convierte una cantidad en USD a otra moneda (DOP, EUR, GBP, JPY).
*/

$data = null;
$monedaDestino = $_POST['moneda'] ?? 'DOP'; // Moneda seleccionada
$cantidad = $_POST['cantidad'] ?? 0;        // Monto ingresado
$montoConvertido = 0;                       // Resultado final
$tasaSeleccionada = 0;                      // Tasa de cambio usada
$error = '';                                // Mensaje en caso de error

// Si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar que la cantidad sea válida
    if (!is_numeric($cantidad) || $cantidad <= 0) {
        $error = "Por favor ingresa una cantidad válida mayor que 0.";
    } else {
        // Llamada a la API de tasas de cambio
        $api = curl_init();
        curl_setopt($api, CURLOPT_URL, "https://api.exchangerate-api.com/v4/latest/USD");
        curl_setopt($api, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($api);
        curl_close($api);
        $data = json_decode($response, true);

        // Selección de la tasa según moneda
        switch ($monedaDestino) {
            case 'DOP':
                $tasaSeleccionada = $data['rates']['DOP'] ?? 0;
                break;
            case 'EUR':
                $tasaSeleccionada = $data['rates']['EUR'] ?? 0;
                break;
            case 'GBP':
                $tasaSeleccionada = $data['rates']['GBP'] ?? 0;
                break;
            case 'JPY':
                $tasaSeleccionada = $data['rates']['JPY'] ?? 0;
                break;
        }

        // Si hay tasa válida, se realiza la conversión
        if ($tasaSeleccionada > 0) {
            $montoConvertido = $cantidad * $tasaSeleccionada;
        } else {
            $error = "Moneda no válida o tasa no encontrada.";
        }
    }
}
?>

<!-- Interfaz del formulario -->
<section class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white text-center">
            <h3>Convierte tus Dólares en otras monedas</h3>
        </div>
        <div class="card-body">
            <form action="" method="post">
                <!-- Entrada de cantidad -->
                <label for="cantidad">Cantidad en USD:</label>
                <input type="number" class="form-control" name="cantidad" id="cantidad" value="<?= htmlspecialchars($cantidad) ?>" required>

                <!-- Selección de moneda -->
                <label for="moneda" class="mt-3">Convertir a:</label>
                <select name="moneda" id="moneda" class="form-select" required>
                    <option value="DOP" <?= $monedaDestino === 'DOP' ? 'selected' : '' ?>>Pesos Dominicanos (DOP)</option>
                    <option value="EUR" <?= $monedaDestino === 'EUR' ? 'selected' : '' ?>>Euros (EUR)</option>
                    <option value="GBP" <?= $monedaDestino === 'GBP' ? 'selected' : '' ?>>Libras Esterlinas (GBP)</option>
                    <option value="JPY" <?= $monedaDestino === 'JPY' ? 'selected' : '' ?>>Yenes Japoneses (JPY)</option>
                </select>

                <button type="submit" class="btn btn-success mt-3">Convertir</button>
            </form>
        </div>
    </div>

    <!-- Mostrar resultado o error -->
    <?php if ($montoConvertido > 0): ?>
        <div class="alert alert-primary">
            <p class="text-center mt-3 fs-5">
                <?= number_format($cantidad, 2) ?> USD equivalen a <?= number_format($montoConvertido, 2) ?> <?= htmlspecialchars($monedaDestino) ?>
            </p>
        </div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger">
            <p class="text-danger text-center mt-3"><?= htmlspecialchars($error) ?></p>
        </div>
    <?php endif; ?>
</section>
