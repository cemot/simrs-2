<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class MasterJenisPenerimaan extends CI_Controller
{   
    function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->model('default_setting');
        $this->load->model('penggunaModel');
        $this->load->model('masterTabelModel');
        $this->session->set_userdata('navbar_status', 'kelola');
        if (!$this->penggunaModel->is_loggedin()){
            redirect('login');
        }
    }
    
    public function index()
    {   
        $this->page(1);
    }

    public function page($page=null)
    {   
        $namatabel = "jenis_penerimaan";
        
        if(!isset($page)){
            $page=1;
        }
        $title['title']="Kelola Jenis Penerimaan";
        $limit = $_COOKIE["pageLimit"];
        $sort = $_COOKIE["pageSort"];
        if(!isset($page)){ $page = 1; }
        if(!isset($limit)){ 
            $limit = $this->default_setting->pagination('LIMIT'); 
        }
        if(!isset($sort)){ 
            $sort = $this->default_setting->pagination('SORT'); 
        }
        
        $data = $this->masterTabelModel->getData($namatabel, $sort, $page, $limit);
        $this->load->view('header',$title);
        $this->load->view('navbar');
        $this->load->view('kelola/masterjenispenerimaan', $data);
        $this->load->view('footer');
    }

    public function detil($id=null)
    {   
        $namatabel = "jenis_penerimaan";
        
        $title['title']="Kelola Jenis Penerimaan";
        
        $data = $this->masterTabelModel->getOne($namatabel, $id);
        $this->load->view('header',$title);
        $this->load->view('navbar');
        $this->load->view('kelola/masterjenispenerimaan', $data);
        $this->load->view('footer');
    }


    public function search($search=null)
    {   
        $namatabel = "jenis_penerimaan";
        $search = $_POST['search'];
        
        $title['title']="Kelola Jenis Penerimaan";
        
        $data = $this->masterTabelModel->searchData($namatabel, $search);
        $this->load->view('header',$title);
        $this->load->view('navbar');
        $this->load->view('kelola/masterjenispenerimaan', $data);
        $this->load->view('footer');
    }
    
    public function insertData() {
        $namatabel = "jenis_penerimaan";
        
        $affectedRow = $this->masterTabelModel->postData($namatabel);
        $this->pesan("Tambah", $affectedRow);
        redirect('kelola/masterjenispenerimaan', 'refresh');
    }

    public function editData($id) {
        $namatabel = "jenis_penerimaan";
        
        $affectedRow = $this->masterTabelModel->editData($namatabel, $id);
        $this->pesan("Edit", $affectedRow);
        redirect('kelola/masterjenispenerimaan', 'refresh');
    }

    public function deleteData($id) {
        $namatabel = "jenis_penerimaan";
        
        $affectedRow = $this->masterTabelModel->deleteData($namatabel, $id);
        $this->pesan("Hapus", $affectedRow);
        redirect('kelola/masterjenispenerimaan', 'refresh');
    }

    public function pesan($metode, $affectedRow) {
        $this->session->set_flashdata('metode', $metode);
        if ($affectedRow == 1) {

            $this->session->set_flashdata('pesan', 'berhasil');
        } elseif ($affectedRow == 0 and $metode == "ubah") {
            $this->session->set_flashdata('pesan', 'berhasil');
        } else {
            $this->session->set_flashdata('pesan', 'gagal');
        }
    }
}
