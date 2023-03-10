
<section id="main-content">
    <section class="wrapper site-min-height content-panel">
        <h3><i class="fa fa-angle-right"></i> Usuarios</h3>
        <div class="row mt">
          	<div class="col-lg-12">
              <button type="button" class="btn btn-warning fa fa-user-circle-o" id="btnCreaUsuario"> Crear Usuario</button>
                <div class="table-responsive">
                    <table class="table table-hover" id="tablaUsuarios">
                        <thead>
                            <tr style="background: #ff6565; color: white;">
                                <th>Documento</th>
                                <th>Nombre</th>
                                <th>Usuario</th>
                                <th>Tipo</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tfoot>
                        <tbody>
                        </tbody>
                    </table>
                </div>

          	</div>
        </div>
    </section>
      <!-- /wrapper -->
</section>	
    <!------------------------------------------------MODALS------------------------------------------------------->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header" style = "background-color: #e23232 !important">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-user-circle-o"></i> Usuarios</h4>
        </div>
        <div class="modal-body scroll_text">
        <form>
            <div class="form-group">
                <label>Nombres</label>
                <input type="text" class="form-control" name="username" placeholder="Nombres...">
                <input type="hidden" class="form-control" name="usuarioId" >
            </div>
            <div class="form-group">
                <label>Numero de identificacion</label>
                <input type="text" class="form-control" name="nitter" placeholder="Numero de identificacion...">
            </div>
            <div class="form-group">
                <label>Correo electronico</label>
                <input type="email" class="form-control" name="email" placeholder="Correo electronico...">
            </div>
            <div class="form-group">
                <label>Usuario</label>
                <input type="text" class="form-control" name="usuarioUser" placeholder="Usuario...">
            </div>

            <div class="form-group">
                <label>Tipo de usuario</label>
                <select class="form-control usuarioTipo" name="usuarioTipo" ></select>
            </div>

            <div class="form-group">
                <label>Contraseña</label>
                <input type="password" class="form-control" name="password" placeholder="Contraseña...">
            </div>

            <div class="form-group">
                <label>Repetir Contraseña</label>
                <input type="password" class="form-control" name="passwordR" placeholder="Repetir Contraseña...">
            </div>

            <div class="form-group">
                <label>Telefono</label>
                <input type="text" class="form-control" name="telefono" placeholder="Telefono...">
            </div>

            <div class="form-group">
                <label>Direccion</label>
                <input type="text" class="form-control" name="direccion" placeholder="Direccion...">
            </div>

            <hr>
            <button type="button" class="btn btn-danger fa fa-trash-o" id="btnEliminarUsuario"> Eliminar</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning fa fa-ban" data-dismiss="modal"> Cerrar</button>
        <button type="button" class="btn btn-success fa fa-hdd-o" id="btnGuardarUsuario"> Guardar</button>
      </div>
    </div>
  </div>
</div>
<!------------------------------------------------MODALS------------------------------------------------------->


<script>
    var urlUsuarioTabla = "<?php echo site_url('administrativo/ControladorUsuarios/todo')?>";
    var urlUsuarioTipo = "<?php echo site_url('administrativo/ControladorUsuarios/tipo')?>";
    var urlUsuarioGuardar = "<?php echo site_url('administrativo/ControladorUsuarios/guardar')?>";
    var urlUsuarioEliminar = "<?php echo site_url('administrativo/ControladorUsuarios/eliminar')?>";
</script>

<script src="<?php echo base_url('asset/administrativo/ajax/usuarios/todo.js')?>" type="text/javascript"></script>