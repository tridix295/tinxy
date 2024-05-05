<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/app.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>TINXY</title>
</head>
<body>
<header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
      <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
        <span class="fs-4">TINXY</span>
      </a>

      <?php
      use Helpers\Helpers;
      Helpers::show_header();
      ?>
      <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search" method="POST" action="/libros/consultar" id='buscador'>
          <input type="search" class="form-control" placeholder="Buscar..." aria-label="Search" name="busqueda">
        </form>
</header>
<div class="container">