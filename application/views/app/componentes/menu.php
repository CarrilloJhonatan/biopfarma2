<style>
    .navbar-dark .navbar-nav .nav-link {
    color: #FC970A;
}
    

</style>
<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-light" style="border-bottom: red 2px solid;">
    <a class="navbar-brand" href="<?php echo site_url('page');?>">
        <img src="<?php echo base_url('asset/app/img/delyloco.png')?>" width="80%" height="40%" alt="" loading="lazy">
        
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <i class="fa fa-bars" style="color:black !important;" aria-hidden="true"></i>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <div class="form-inline">
            <input class="form-control mr-sm-2" id="busquedaGeneral" type="text" placeholder="Buscar.....">
            <button class="btn btn-outline-warning my-2 my-sm-0" id="btnBusquedaGeneral" type="button"><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
        </div>
      
        <ul class="navbar-nav ml-auto">
        <li class="nav-item">
                <a style="color: black;" class="nav-link totalPedidosBtn" href="#"> <i style="color: black;" class="fa fa-list-alt" aria-hidden="true"></i> Mis Pedidos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link totalCarritoBtn" href="#" style="color: black;"><span style="color: black;" class="badge badge-dark totalCarrito"></span> <i class="fa fa-list" aria-hidden="true"></i> Pedido</a>
            </li>
            <?php
                $query = $this->db->query('select * from tbl_usuarios where u_estado = 1 and u_tipo = 2');
                $rest = $query->result();
                $rest2 = false;
                foreach($rest as $rows){
                    if($rows->u_id === $this->session->userdata('id_usuario')){
                        $rest2=true;
                    }
                }
            if( !$rest2){?>
          <li class="nav-item">
                <a class="nav-link " style="color: black;"  href="<?php echo site_url('Login/login');?>" tabindex="-1" aria-disabled="true"><i class="fa fa-sign-in" aria-hidden="true"></i> Iniciar sesion</a>
                <input type="hidden" id="sesion" value="1">
            </li>
            <?php } elseif($rest2){?>
            <li class="nav-item">
                <a class="nav-link " style="color: black;"  href="<?php echo site_url('Login/logout');?>" tabindex="-1" aria-disabled="true"><i class="fa fa-power-off" aria-hidden="true"></i> Cerrar sesion</a>
                <input type="hidden" id="sesion" value="0">
            </li>
            <?php }?>
        </ul>
  </div>
</nav>



<!---------------------------------------MODAL LOGIN----------------------------------------------->
