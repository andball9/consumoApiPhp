<?php
$random = rand(1, 998);
$url = "https://api.jikan.moe/v4/anime?page={$random}&limit=24";

function getAnimes($url)
{
    $json = file_get_contents($url);
    $response = json_decode($json, true);
    return $response['data'];
}

$animes = getAnimes($url);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <title>ApiAnime</title>
</head>

<body>
    <div class="container">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <div class="mx-auto order-0">
                <a class="navbar-brand mx-auto" href="#">PRUEBA TECNICA</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">VER ANIMES</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="guardados.php">ANIMES ALMACENADOS</a>
                    </li>
                </ul>
            </div>
        </nav>
        <main>
            <div class="row">
                <?php foreach ($animes as $anime) : ?>
                    <div class="col-12 col-md-4">
                        <div class="card">
                            <img src="<?= $anime['images']['jpg']['image_url']; ?>" class="card-img-top" alt="<?= $anime['title']; ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= $anime['title']; ?></h5>
                                <p class="card-text text-truncate-custom text-justify"><?= $anime['synopsis']; ?></p>
                                <div class="btn-group-vertical col-12">
                                    <a href="<?= $anime['url']; ?>" class="btn btn-primary btn-block my-2">Saber Más...</a>
                                    <a href="<?= $anime['trailer']['url']; ?>" class="btn bg-info btn-block my-2">Ver Trailer</a>
                                    <button onclick="
                                    addAnime(
                                        '<?php echo strval($anime['images']['jpg']['image_url']); ?>',
                                        '<?php echo strval($anime['title']); ?>',
                                        '<?php echo strval($anime['trailer']['url']); ?>',
                                    )" class="btn bg-warning btn-block my-2">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        function addAnime($Img_url, $Title, $Trailer_url) {
            $.post('insert.php', {
                $Img_url, $Title, $Trailer_url
            }, (data) => {
                if (data !== null) {
                    alert("Agregado Correctamente")
                }
            })
        }

    </script>
</body>

</html>