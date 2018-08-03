<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_sms extends CI_Model {
    function __construct() {
        parent::__construct();
    }

    public function getsms($orderby,$group=null,$where=null,$number=null,$offset=null) {
        if($group){
            $this->db->group_by('Number');
        }
        $this->db->order_by($orderby, 'DESC');
        return $this->db->get_where('vsms', $where, $number, $offset)->result();
    }
//    public function getsms($where) {
//        return $this->db->get_where('vsms', $where)->result_array();
//    }
    public function sendsms($notelp,$pesan) {
        return $this->db->insert('sms_full_outbox', array("DestinationNumber"=>$notelp, "TextDecoded"=>$pesan, "CreatorID"=>"Admin"));
    }
    public function sendkonfirm($idres, $edit=null) {
        $res= $this->db->get_where('vreservasi', 'id_rsv='.$idres)->row();
        $format= $this->db->get_where('sms_konfirm', 'id=1')->row();
        if (isset($res) && isset($format)){
            $sms= str_replace(array('[norm]', '[nama]', '[resno]', '[reswaktu]', '[respoli]', '[resdokter]', '[reslayan]', '[resjamin]'), 
                    array($res->norm, $res->nama, $res->nores, $res->waktu_rsv, $res->nama_klinik, $res->nama_dokter, $res->jns_layan, $res->nama_jaminan), $format->format);
            $this->db->insert('sms_full_outbox', array("DestinationNumber"=>$res->notelp, "TextDecoded"=>$edit.$sms, "CreatorID"=>"Admin"));
            return true;
        } else {
            return false;
        }
    }
    public function cekpulsa($ussd) {
        return $this->db->insert('sms_full_outbox', array("DestinationNumber"=>$ussd, "Coding"=>"8bit", "Class"=>"127" ,"CreatorID"=>"Admin"));
    }
}