<?php
require 'ConexionDb.php';

function getAnimes()
{
    $db = new ConexionDb();
    $con = $db->conectar();
    $comando = $con->query("SELECT * FROM anime");
    $comando->execute();
    return $comando->fetchAll(PDO::FETCH_ASSOC);
}
$animes = getAnimes();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
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
                        <a class="nav-link" href="index.php">VER ANIMES</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="guardados.php">ANIMES ALMACENADOS</a>
                    </li>
                </ul>
            </div>
        </nav>
        <main>
            <div class="row">

                <?php if (empty($animes)) : ?>
                    <div class="col-12">
                        <h1>No hay Animes</h1>
                    </div>
                <?php endif; ?>

                <?php foreach ($animes as $anime) : ?>
                    <div class="col-12 col-md-4">
                        <div class="card">
                            <img src="<?= $anime['Img_url']; ?>" class="card-img-top" alt="<?= $anime['Title']; ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= $anime['Title']; ?></h5>
                                <div class="btn-group-vertical col-12">
                                    <a href="<?= $anime['Trailer_url']; ?>" class="btn bg-info btn-block my-2" target="_blank">Ver Trailer</a>
                                    <button data-toggle="modal" data-target="#exampleModal" data-animetrailer="<?= $anime['Trailer_url']; ?>" data-imagenanime="<?= $anime['Img_url']; ?>" data-nameanime="<?= $anime['Title']; ?>" data-whatever="<?= $anime['Id']; ?>" class="btn bg-warning btn-block my-2">Editar</button>
                                    <button onclick="
                                    deleteAnime(
                                        '<?php echo strval($anime['Id']); ?>',
                                    )
                                    " class="btn bg-danger btn-block my-2">Eliminar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formEditar" onsubmit="event.preventDefault(); return modalEditarAnime();">
                        <input type="hidden" class="idinput" name="Id">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Imagen:</label>
                            <input type="text" class="form-control imagenAnime" name="Img_url">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">titulo:</label>
                            <input class="form-control animetitle" id="message-text" name="Title"></input>
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Trailer URL:</label>
                            <input class="form-control animetrailer" id="message-text" name="Trailer_url"></input>
                        </div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Actualizar Anime</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

    <script>
        function deleteAnime($Id) {
            $.post('delete.php', {
                $Id
            }, (data) => {
                if (data !== null) {
                    alert("Eliminado Correctamente")
                    window.location.reload()
                }
            })
        }


        $('#exampleModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('whatever')
            var nameAnime = button.data('nameanime')
            var imagenAnime = button.data('imagenanime')
            var animeTrailer = button.data('animetrailer')
            var modal = $(this)
            modal.find('.modal-title').text('Editando ' + nameAnime)
            modal.find('.modal-body .idinput').val(id)
            modal.find('.modal-body .animetitle').val(nameAnime)
            modal.find('.modal-body .imagenAnime').val(imagenAnime)
            modal.find('.modal-body .animetrailer').val(animeTrailer)
        })

        function modalEditarAnime() {
            let form = $("#formEditar").serialize()
            $.ajax({
                url: 'update.php',
                type: 'post',
                data: form
            }).done(function(data) {
                alert('Anime Actualizado con exito')
                window.location.reload()
            }).fail(function(jqXHR) {
                console.log(jqXHR.statusText);
            });
        }
    </script>

</body>

</html>