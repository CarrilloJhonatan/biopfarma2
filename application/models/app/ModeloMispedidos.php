<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModeloMispedidos extends CI_Model
{

    function gettodo(){

        $nit        =  $this->session->userdata('nit_tusuario');

        $select     = 'select * ';
        $from       = 'from factura ';
        $where      = 'WHERE nitcli = '.$nit.' and pedidoestado between 0 and 2 ORDER BY fecfac DESC';

        $rest       = $this->db->query($select.$from.$where);
        $result     = $rest->result();

        return $result;
    }

    function getarticulos(){
        $nit        =  $this->session->userdata('nit_tusuario');
        $fecfac  =   $this->input->post('fecfac');
        $numfac     =   $this->input->post('numfac');

        $select = 'select ta.nomart, df.qtyart ';
        $from   = 'FROM tbl_articulos ta, detallefactura df, factura f ';
        $where  = 'where ta.codart = df.codart AND df.numfactura = f.numfac AND df.fecha = f.fecfac AND f.nitcli = '.$nit.' and f.numfac ='.$numfac.' and df.fecha = "'.$fecfac.'"';

        $rest       = $this->db->query($select.$from.$where);
        $result     = $rest->result();

        return $result;

    }


}


?>