<?php

class Mm_provinsi extends CI_Model{
	function mmListProvinsi(){
    $this->db->order_by('lokasi_nama','ASC');
// $provinces= $this->db->get('provinces');


// return $provinces->result_array();
		return $this->db->get('master_propinsi');
	}

  function mmListKabupatenKota($varIdPropinsi){
    $kabupaten="<option value='0'>Pilih Kota</pilih>";

    $this->db->order_by('lokasi_nama','ASC');
    $kab= $this->db->get_where('master_kabko',array('lokasi_propinsi'=>$varIdPropinsi));

    foreach ($kab->result_array() as $data ){
    $kabupaten.= "<option value='$data[lokasi_nama]'>$data[lokasi_nama]</option>";
    }

    return $kabupaten;
  }
}
