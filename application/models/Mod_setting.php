<?php defined('BASEPATH') OR exit('No direct script access allowed');
 class Mod_setting extends CI_Model {
     function __construct() {
         parent:: __construct();
    }
    
    function getdatalibur($number,$offset) {
        return $this->db->get('tgl_libur',$number,$offset)->result();
    }
    function getnumlibur() {
       return $this->db->get('tgl_libur')->num_rows(); 
    }
 }