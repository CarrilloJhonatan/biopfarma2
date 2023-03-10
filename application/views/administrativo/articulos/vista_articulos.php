<style>
    .kv-avatar .krajee-default.file-preview-frame,.kv-avatar .krajee-default.file-preview-frame:hover {
        margin: 0;
        padding: 0;
        border: none;
        box-shadow: none;
        text-align: center;
    }
    .kv-avatar {
        display: inline-block;
    }
    .kv-avatar .file-input {
        display: table-cell;
        width: 213px;
    }
    .kv-reqd {
        color: red;
        font-family: monospace;
        font-weight: normal;
    }
</style>
<section id="main-content">
    <section class="wrapper site-min-height content-panel">
        <h3><i class="fa fa-angle-right"></i> Articulos</h3>
        <div class="row mt">
          	<div class="col-lg-12">
              <button type="button" class="btn btn-warning fa fa-list" id="btnCreaArticulos"> Crear Articulo</button>
                <div class="table-responsive">
                    <table class="table table-hover" id="tablaArticulos">
                        <thead>
                            <tr style="background: #ff6565; color: white;">
                                <th>Imagen</th>
                                <th>Categoria</th>
                                <th>Subcategoria</th>
                                <th>Codigo</th>
                                <th>Nombre</th>
                                <th>Valor</th>
                                <th>Unidad</th>
                                <th>promocion</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
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
        <div class="modal-header" style="background-color: #e23232 !important">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-list"></i> Articulos</h4>
        </div>
        <div class="modal-body scroll_text">
        <form>
            <br>
            <div class="form-group text-center">
                <div class="kv-avatar">
                    <div class="file-loading">
                        <input id="image" class="form-control" name="avatar-2" type="file" required>
                    </div>
                </div>
                <div class="kv-avatar-hint">
                    <small>Select file < 1500 KB</small>
                </div>
            </div>

            <div class="form-group">
                <label>Seleccione categoria</label>
                <select class="form-control categoria" name="categoria" ></select>
            </div>
            <div class="form-group">
                <label>Seleccione subcategoria</label>
                <select class="form-control subcategoria" name="subcategoria" ></select>
            </div>
            <div class="form-group">
                <label>Codigo del articulo</label>
                <input type="text" class="form-control" name="codart" placeholder="Codigo del articulo...">
                <input type="hidden" class="form-control" name="id" >
                <input type="hidden" class="form-control" name="urlimg" >
            </div>
            <div class="form-group">
                <label>Nombre del articulo</label>
                <input type="text" class="form-control" name="nomart" placeholder="Nombre del articulo...">
            </div>
            <div class="form-group">
                <label>Valor del articulo</label>
                <input type="number" class="form-control" name="valart" placeholder="Valor del articulo...">
            </div>
            <div class="form-group">
                <label>Unidad del articulo</label>
                <input type="number" class="form-control" name="qtyart" placeholder="Unidad del articulo...">
            </div>
            <div class="form-group">
                <label>Descripcion del articulo</label>
                <textarea  class="form-control" name="descripcion" rows="7" placeholder="Descripcion del articulo..."></textarea>
            </div>
            <div class="form-group">
                <label>Tipo de promocion</label>
                <select class="form-control form-control-sm" name="tipopromo">
                    <option value="1">Sin promocion</option>
                    <option value="2">Nuevo Producto</option>
                    <option value="3">Los Recomendados</option>
                    <option value="4">Los Mas Vendido</option>
                    <option value="5">Promociones</option>
                </select>
            </div>
            <hr>
            <button type="button" class="btn btn-danger fa fa-trash-o" id="btnEliminarArticulos"> Eliminar</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning fa fa-ban" data-dismiss="modal"> Cerrar</button>
        <button type="button" class="btn btn-success fa fa-hdd-o" id="btnGuardarArticulos"> Guardar</button>
      </div>
    </div>
  </div>
</div>
<!------------------------------------------------MODALS------------------------------------------------------->


<script>
    var urlArticulosTabla       = "<?php echo site_url('administrativo/ControladorArticulos/todo')?>";
    var urlArticulosGuardar     = "<?php echo site_url('administrativo/ControladorArticulos/guardar')?>";
    var urlArticulosEliminar    = "<?php echo site_url('administrativo/ControladorArticulos/eliminar')?>";
    var urlArticulosblanco      = "<?php echo base_url()?>";
    var urlArticuloscategoria   = "<?php echo site_url('administrativo/ControladorArticulos/categoria')?>";
    var siteUrl                 = "<?php echo site_url('')?>";
</script>

<script src="<?php echo base_url('asset/administrativo/ajax/articulos/todo.js')?>" type="text/javascript"></script>