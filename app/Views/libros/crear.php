<?=$cabecera?>

    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Crear Libro</h5>
        <p class="card-text">
            <form action="<?= /* site_url('/guardar') */ base_url('/guardar')?>" method="POST" enctype="multipart/form-data">

                <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" class="form-control" name="nombre" value="<?= old('nombre'); ?>">
                </div>

                <div class="form-group">
                <label for="imagen">Imagen</label>
                <input type="file" id="imagen" class="form-control-file" name="imagen">
                </div>

                <button type="submit" class="btn btn-success">Guardar</button>
                <a class="btn btn-primary" href="<?= base_url('listar') ?>">Cancelar</a>

            </form>
        </p>
      </div>
    </div>
<?=$piepagina?>