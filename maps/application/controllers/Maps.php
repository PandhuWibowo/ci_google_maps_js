<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Maps extends CI_Controller {
  function __construct(){
  		parent::__construct();
  		$this->load->model('mm_provinsi','m_prov');
      // $this->load->helper('url');
	}
  public function index()
	{
    $data['varListPorpinsi'] = $this->m_prov->mmListProvinsi()->result();
		$this->load->view('g_maps/index',$data);
    // redirect('maps/baru');
	}

  public function m_list_kabupaten(){
    $modul=$this->input->post('modul');
    $id=$this->input->post('id');

    if($modul=="kabupaten"){
      echo $this->m_prov->mmListKabupatenKota($id);
    }
  }
}
