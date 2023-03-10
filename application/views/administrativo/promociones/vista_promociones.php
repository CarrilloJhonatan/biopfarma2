
<section id="main-content">
    <section class="wrapper site-min-height content-panel">
        <h3><i class="fa fa-angle-right"></i> Promociones</h3>
        <div class="row mt">
          	<div class="col-lg-12">
              <button type="button" class="btn btn-warning fa fa-list" id="btnCreaPromociones"> Crear Promocion</button>
                <div class="table-responsive">
                    <table class="table table-sm  table-bordered" id="tablaPromociones">
                        <thead>
                            <tr style="background: #ff6565; color: white;">
                                <th>Imagen</th>
                                <th>Tabla</th>
                                <th>Descripcion</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tfoot>
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
            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-list"></i> Promociones</h4>
        </div>
        <div class="modal-body scroll_text">
        <form>
            <br>
            <div class="form-group last">
                <label class="control-label col-md-3">Importar imagen</label>
                <div class="col-md-9">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                            <img src="<?php echo base_url('asset/administrativo/img/imgblanco.png')?>" alt="" />
                        </div>
                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                        <div>
                            <span class="btn btn-theme02 btn-file">
                                <span class="fileupload-new"><i class="fa fa-paperclip"></i> Selecciona imagen</span>
                                <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                <input type="file" class="default" id="image" name="image"/>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Seleccione la tabla</label>
                <select class="form-control tbl" name="tbl" id="tbl" ></select>
               
            </div>
            <div class="form-group">
                <label>Seleccione la descripcion</label>
                <select class="form-control elegido" name="elegido" id="provincia">
                <option value="Default">Default</option>
                </select>
                
                <input type="hidden" class="form-control" name="id" >
                <input type="hidden" class="form-control" name="urlimg" >
            </div>
            <!-- <div class="form-group">
                <label>Digite el porcentaje de descuento</label>
                <input type="number" class="form-control" name="porcentaje" placeholder="Digite el porcentaje de descuento...">
            </div> -->
            <hr>
            <button type="button" class="btn btn-danger fa fa-trash-o" id="btnEliminarPromociones"> Eliminar</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning fa fa-ban" data-dismiss="modal"> Cerrar</button>
        <button type="button" class="btn btn-success fa fa-hdd-o" id="btnGuardarPromociones"> Guardar</button>
      </div>
    </div>
  </div>
</div>
<!------------------------------------------------MODALS------------------------------------------------------->


<script>
    var urlPromocionesTabla     = "<?php echo site_url('administrativo/ControladorPromociones/todo')?>";
    var urlPromocionesTbl       = "<?php echo site_url('administrativo/ControladorPromociones/tbl')?>";
    var urlPromocionesElegido   = "<?php echo site_url('administrativo/ControladorPromociones/elegido')?>";
    var urlPromocionesGuardar   = "<?php echo site_url('administrativo/ControladorPromociones/guardar')?>";
    var urlPromocionesEliminar   = "<?php echo site_url('administrativo/ControladorPromociones/eliminar')?>";
    var urlPromocionesblanco    = "<?php echo base_url()?>";
   
</script>


<script src="<?php echo base_url('asset/administrativo/ajax/promociones/todo.js')?>" type="text/javascript"></script>