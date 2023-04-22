<?=$cabecera?>
    <a class="btn btn-success my-5" href="<?= base_url('crear') ?>">Crear un libro</a>
    <table class="table table-light">
        <thead class="thead-light">
            <tr>
                <th>#</th>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($libros as $libro){ ?>
                <tr>
                    <td><?= $libro['id'] ?></td>
                    <td>
                        <img class="img-thumbnail" width="200" src="<?= base_url('uploads/') . $libro['imagen'] ?>" alt="image">
                    </td>
                    <td><?= $libro['nombre'] ?></td>
                    <td>
                        <a href="<?= base_url('editar') . '/' . $libro['id'] ?>" class="btn btn-primary">Editar</a>
                        <a href="<?= base_url('borrar') . '/' . $libro['id'] ?>" class="btn btn-danger">Borrar</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?=$piepagina?>