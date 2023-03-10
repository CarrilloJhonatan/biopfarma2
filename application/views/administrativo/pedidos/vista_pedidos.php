<section id="main-content">
    <section class="wrapper site-min-height content-panel">
        <h3><i class="fa fa-angle-right"></i> Pedidos</h3>
        <div class="row mt">
          	<div class="col-lg-12">
                <div class="table-responsive">
                    <table class="table table-hover" id="tablaPedidos">
                        <thead>
                            <tr style="background: #ff6565; color: white;">
                                <th>id</th>
                                <th>centro de costo</th>
                                <th>tipo factura</th>
                                <th>factura</th>
                                <th>cliente</th>
                                <th>fecha</th>
                                <th>valor</th>
                                <th>descuento</th>
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
            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-list"></i> Detalles del pedido</h4>
        </div>
        <div class="modal-body scroll_text">
        <form>
            <br>
            
            <div class="scroll_text" id="tblDetalle">
								
                                </div>

            
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning fa fa-ban" data-dismiss="modal"> Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!------------------------------------------------MODALS Resumido------------------------------------------------------->


<div class="modal fade" id="exampleModalResumen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header" style="background-color: #e23232 !important">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-list"></i> Detalles del pedido </h4>
        </div>
        <div class="modal-body scroll_text">
        <div class="col-m-12">
        
                    <div class="row" style="padding-left:20px; padding-top:10px">
                    <div class="col-md-4">
                        <label><b>Referencia de la transaccion:</b></label>
                    </div>
                    <div class="col-md-3">
                        <label id="reftrans"></label>
                    </div>
                    </div>
                    <div class="row" style="padding-left:20px; padding-top:10px">
                    <div class="col-md-4">
                        <label><b>Medio de pago:</b></label>
                    </div>
                    <div class="col-md-3">
                        <label id="mediopago"></label>
                    </div>
                    </div>
                    <div class="row" style="padding-left:20px; padding-top:10px">
                    <div class="col-md-4">
                        <label><b>Tipo medio de pago:</b></label>
                    </div>
                    <div class="col-md-3">
                        <label id="tipomediopago"></label>
                    </div>
                    </div>
                    <div class="row" style="padding-left:20px; padding-top:10px">
                    <div class="col-md-4">
                        <label><b>Cod. Transferencia:</b></label>
                    </div>
                    <div class="col-md-8">
                        <label id="codtranferencia"></label>
                    </div>
                    </div>
                    <div class="row" style="padding-left:20px; padding-top:10px">
                    <div class="col-md-4">
                        <label><b>Direccion:</b></label>
                    </div>
                    <div class="col-md-3">
                        <label id="direccion"></label>
                    </div>
                    </div>
                    <hr>
                <div class="table-responsive">
                    <table class="table table-hover" id="pedidosResumido">
                        <thead>
                            <tr>
                                <th>item</th>
                                <th>articulo</th>
                                <th>valor</th>
                                <th>cantidad</th>
                                <th>valor total</th>
                                <th>comentario</th>
                                
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
                    <input type="text" id="numfac" hidden>
          	</div>

        <button type="button" class="btn btn-danger" id="cancelarPedido"><i class="fa fa-trash-o" aria-hidden="true"></i> Cancelar pedido</button>
            
            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning fa fa-ban" data-dismiss="modal"> Cerrar</button>
      </div>
    </div>
  </div>
</div>


<!------------------------------------------------------------------------------------------------>

<script>
    var urlCategorias   =   "<?php echo site_url()?>";
</script>

<script src="<?php echo base_url('asset/administrativo/ajax/pedidos/todo.js')?>" type="text/javascript"></script>