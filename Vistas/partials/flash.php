<?php
use Helpers\Helpers;

function showFlash($type, $msg) {
    $classes = [
        "success" => "alert-success",
        "warning" => "alert-warning",
        "danger"  => "alert-danger"
    ];

    // Verifica si el tipo de mensaje es válido
    if (isset($classes[$type])) {
        return "<div class='alert {$classes[$type]}' role='alert'>$msg</div>";
    }

    // Si el tipo de mensaje no es válido, devuelve una cadena vacía
    return "";
}

$flash = Helpers::getFlashMessage();

if (!empty($flash)) {
    foreach ($flash as $type => $msg) {
        echo showFlash($type, $msg);
    }
}
