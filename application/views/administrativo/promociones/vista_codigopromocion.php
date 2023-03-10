
<section id="main-content">
    <section class="wrapper site-min-height content-panel">
        <h3><i class="fa fa-angle-right"></i>Codigos Promocionales</h3>
        <div class="row mt">
          	<div class="col-lg-12">
              <button type="button" class="btn btn-warning fa fa-list" id="btnCreaPromociones"> Crear Codigo</button>
                <div class="table-responsive">
                    <table class="table table-sm  table-bordered" id="tablaPromociones">
                        <thead>
                            <tr style="background: #ff6565; color: white;">
                                <th>id</th>
                                <th>codigo</th>
                                <th>aplica</th>
                                <th>valor</th>
                                <th>fecha inicio</th>
                                <th>fecha final</th>
                                
                            </tr>
                        </thead>
                        <tfoot>
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
            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-list"></i> Promociones</h4>
        </div>
        <div class="modal-body scroll_text">
        <form>
            <br>
            
            <div class="form-group">
                <label>Seleccione la tabla</label>
                <select class="form-control tbl" name="tbl" ></select>
            </div>
            <div class="form-group">
                <label>Seleccione la descripcion</label>
                <select class="form-control elegido" name="elegido" ></select>
                <input type="hidden" class="form-control" name="id" >
                
            </div>
            <div class="form-group">
                <label>Digite el valor de descuento</label>
                <input type="number" class="form-control" name="valor" placeholder="Digite el valor de descuento...">
            </div>
            <div class="form-group">
            <label>Codigo promocional</label>
                <div class="row pl-2 pr-2">
                
                <div class="col-sm-8">
                
                <input type="text" class="form-control" name="codigoprom" id="codigoprom" disabled> 
                </div>
                <div class="col-sm-4">
                
                <button type="button" id="btnGenerar" class="btn btn-warning">
                <i class="fa fa-retweet" aria-hidden="true"></i> Generar
                </button>
                </div>
                </div>
            </div>
            <div class="form-group">
                <label>Fecha inicio</label>
                <div class="row pl-2 pr-2">
                    <div class="col-sm-6" >
                    <input type="date" class="form-control" name="inicio">
              
                    </div>
                    <div class="col-sm-6" >
                    
                    <input type="time" class="form-control" name="horainicio">
                    </div>
                </div>
                <label>Fecha final</label>
                <div class="row pl-2 pr-2">
                    <div class="col-sm-6" >
                    <input type="date" class="form-control" name="final" >
              
                    </div>
                    <div class="col-sm-6" >
                    
                    <input type="time" class="form-control" name="horafinal" >
                    </div>
                </div>
                
                
            </div>
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


<script>
    var urlPromocionesTabla     = "<?php echo site_url('administrativo/ControladorPromociones/todoCodigo')?>";
    var urlPromocionesTbl       = "<?php echo site_url('administrativo/ControladorPromociones/tblCod')?>";
    var urlPromocionesElegido   = "<?php echo site_url('administrativo/ControladorPromociones/elegidoCod')?>";
    var urlPromocionesGuardar   = "<?php echo site_url('administrativo/ControladorPromociones/guardarCod')?>";
    var urlPromocionesEliminar   = "<?php echo site_url('administrativo/ControladorPromociones/eliminarCod')?>";
    var urlPromocionesblanco    = "<?php echo base_url()?>";
   
</script>


<script src="<?php echo base_url('asset/administrativo/ajax/codpromociones/todo.js')?>" type="text/javascript"></script>