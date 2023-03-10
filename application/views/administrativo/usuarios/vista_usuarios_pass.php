<section id="main-content">
    <section class="wrapper site-min-height content-panel">
        <h3><i class="fa fa-angle-right"></i> Cambiar contraseña</h3>
        <div class="row mt">
          	<div class="col-lg-12">
                <form>
                    <div class="form-group">
                        <label>Contraseña</label>
                        <input type="password" class="form-control" name="password" placeholder="Contraseña...">
                        <input type="hidden" class="form-control" name="id" value="<?= $this->session->userdata('id_usuario')?>">
                    </div>

                    <div class="form-group">
                        <label>Repetir Contraseña</label>
                        <input type="password" class="form-control" name="passwordR" placeholder="Repetir Contraseña...">
                    </div>

                    <button type="button" class="btn btn-warning fa fa-hdd-o" id="btnGuardarPass"> Guardar</button>
                </form>
          	</div>
        </div>
    </section>
      <!-- /wrapper -->
</section>	
<script>
    var urlUsuarioGuardarPass = "<?php echo site_url('administrativo/ControladorUsuarios/passguardar')?>";
</script>

<script src="<?php echo base_url('asset/administrativo/ajax/usuarios/pass.js')?>" type="text/javascript"></script>