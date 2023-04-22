<?=$cabecera?>
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Editar libro</h5>
        <p class="card-text">
            <form action="<?= base_url('/actualizar')?>" method="POST" enctype="multipart/form-data">
                
                <input type="hidden" name="id" value="<?= $libro["id"]; ?>">

                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input 
                        type="text" 
                        id="nombre" 
                        class="form-control" 
                        name="nombre" 
                        value="<?php echo session('mensaje') ? old('nombre') : $libro["nombre"]; ?>"
                    >
                </div>

                <div class="form-group">
                    <label for="imagen">Imagen</label>
                    <input type="file" id="imagen" class="form-control-file" name="imagen">
                    <img class="img-thumbnail" width="200" src="<?= base_url('uploads/') . $libro['imagen'] ?>" alt="image">
                </div>

                <button type="submit" class="btn btn-success">Actualizar</button>
                <a class="btn btn-primary" href="<?= base_url('listar') ?>">Cancelar</a>

            </form>
        </p>
      </div>
    </div>
<?=$piepagina?>



