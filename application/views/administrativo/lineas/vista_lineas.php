<section id="main-content">
    <section class="wrapper site-min-height content-panel">
        <h3><i class="fa fa-angle-right"></i> Subcategoria</h3>
        <div class="row mt">
          	<div class="col-lg-12">
              <button type="button" class="btn btn-warning fa fa-list" id="btnCreaLineas"> Crear Subcategoria</button>
                <div class="table-responsive">
                    <table class="table table-hover" id="tablaLineas">
                        <thead>
                            <tr style="background: #ff6565; color: white;">
                                <th>Codigo</th>
                                <th>Categoria</th>
                                <th>Subcategoria</th>
                            </tr>
                        </thead>
                        <tfoot>
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
            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-list"></i> Categorias</h4>
        </div>
        <div class="modal-body scroll_text">
        <form>
            <div class="form-group">
                <label>Seleccione categoria</label>
                <select class="form-control categoria" name="categoria" ></select>
    
                <input type="hidden" class="form-control" name="id" >
            </div>
            <div class="form-group">
                <label>Codigo SubCategoria</label>
                <input type="text" class="form-control" name="codsubcate" placeholder="Codigo SubCategoria...">
            </div>
            <div class="form-group">
                <label>Nombre SubCategoria</label>
                <input type="text" class="form-control" name="nomsubcate" placeholder="Nombre SubCategoria...">
            </div>
            <hr>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger fa fa-trash-o" id="btnEliminarLineas"> Eliminar</button>
        <button type="button" class="btn btn-warning fa fa-ban" data-dismiss="modal"> Cerrar</button>
        <button type="button" class="btn btn-success fa fa-hdd-o" id="btnGuardarLineas"> Guardar</button>
      </div>
    </div>
  </div>
</div>
<!------------------------------------------------MODALS------------------------------------------------------->


<script>
    var siteUrl = "<?php echo site_url('')?>";
    var baseUrl = "<?php echo base_url('')?>";
    console.log("URL LINEAS: ","<?php echo site_url('')?>" +'/administrativo/ControladorLineas/todo')
</script>

<script src="<?php echo base_url('asset/administrativo/ajax/lineas/todo.js')?>" type="text/javascript"></script>