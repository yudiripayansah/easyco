<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends EASY_Controller {

    function __construct(){
        parent::__construct();
        $this->auth->restrict();
        $this->load->model('model_setting');
        @date_default_timezone_set('Asia/Jakarta');
    }

    function index(){
        $this->group();
    }

    function group(){
        $data = array();

        // USER PRIVILLEGES
        $uri1 = $this->uri->segment(1);
        $uri2 = $this->uri->segment(2);

        if($uri2){
            $uri = $uri1.'/'.$uri2;
        } else {
            $uri = $uri1;
        }

        $privilleges = $this->privilleges($uri);

        if($privilleges == 0){
            redirect(base_url('notfound'));
        }

        // MAIN PAGE
        $data['body'] = 'setting/vgroup';
        $data['title'] = 'Grup | EasyCo - Berkoperasi Itu Mudah';
        $data['f_title'] = 'Pengaturan';
        $data['s_title'] = 'Grup';

        // LIBRARY
        $data['csspage'] = 'setting/_css/csspage_group';
        $data['jslib'] = 'setting/_js/jslib_group';
        $data['jsscript'] = 'setting/_js/js_group';

        // LOAD DATA
        $data['uri'] = $uri;
        $data['suburi'] = $this->getSubUri($uri);
        $data['menu'] = $this->show_menu(1);

        $this->load->vars($data);
        $this->load->view('view_dashboard');
    }

    function pagroup(){
        if(!$this->input->is_ajax_request()){
            redirect(base_url('setting/group'));
        }

        $group = $this->input->post('group');

        $group = strtoupper($group);

        $created_by = $this->session->userdata('id');
        $created_date = date('Y-m-d H:i:s');

        $confirm = TRUE;

        $DBCore = $this->coreDB();

        $this->form_validation->set_rules('group','Grup','required|trim');

        if($this->form_validation->run() == FALSE){
            // INVALID
            $confirm = FALSE;
            $result = array(
                'result' => FALSE,
                'message' => strip_tags(validation_errors())
            );
        }

        if($confirm == TRUE){
            $get_group = $this->model_setting->get_group_by_group($group);

            $jumlah = $get_group['jumlah'];

            if($jumlah > 0){
                $confirm = FALSE;

                $result = array(
                    'status' => 'failed',
                    'message' => 'Grup sudah terdaftar.'
                );
            }
        }

        if($confirm == TRUE){
            $table = 'kop_group';
            $data = array(
                'nama_grup' => $group,
                'created_by' => $created_by,
                'created_date' => $created_date
            );

            // DATABASE TRANSACTION
            $DBCore->trans_begin();
            $this->insert($table,$data,$DBCore);

            if($DBCore->trans_status() === TRUE){
                $DBCore->trans_commit();

                $result = array(
                    'status' => 'success',
                    'message' => 'Grup berhasil ditambahkan.'
                );
            } else {
                $DBCore->trans_rollback();

                $result = array(
                    'status' => 'failed',
                    'message' => 'Jaringan Anda tidak stabil.'
                );
            }
        }

        echo json_encode($result);
    }

    function read_group(){
        if(!$this->input->is_ajax_request()){
            redirect(base_url('setting/group'));
        }

        $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '';
        $limit_rows = isset($_REQUEST['rows']) ? $_REQUEST['rows'] : '';
        $sidx = isset($_REQUEST['sidx']) ? $_REQUEST['sidx'] : '';
        $sord = isset($_REQUEST['sord']) ? $_REQUEST['sord'] : '';
        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : FALSE;

        if($totalrows){
            $limit_rows = $totalrows;
        }

        $sum = $this->model_setting->read_group('','','','');

        $count = count($sum);

        if($count > 0){
            $total_pages = ceil($count / $limit_rows);
        } else {
            $total_pages = 0;
        }

        if($page > $total_pages){
            $page = $total_pages;
        }

        $start = ($limit_rows * $page) - $limit_rows;

        if($start < 0){
            $start = 0;
        }

        $result = $this->model_setting->read_group($sidx,$sord,$limit_rows,$start);

        $response = array();

        $response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $count;

        foreach($result as $row){
            $id = $row['id_group'];
            $group = $row['nama_grup'];
            $isactive = $row['status_grup'];

            if($isactive == '0'){
                $status = '<span class="btn btn-link-danger font-weight-bold">Tidak Aktif</span>';
            } else {
                $status = '<span class="btn btn-link-success font-weight-bold">Aktif</span>';
            }

            $action = '<a href="javascript:;" id="edit_group" class="label label-lg label-light-info label-inline" title="Ubah" g_id="'.$id.'"><i class="icon-xs fas fa-pencil-alt"></i> Ubah</a>';

            $response['rows'][] = array(
                'id' => $id,
                'group' => $group,
                'status' => $status,
                'action' => $action
            );
        }

        echo json_encode($response);
    }

    function get_group_by_id(){
        if(!$this->input->is_ajax_request()){
            redirect(base_url('setting/group'));
        }

        $id = $this->input->post('g_id');

        $show = $this->model_setting->get_group_by_id($id);

        $id = $show['id_group'];
        $group = $show['nama_grup'];

        $result = array(
            'id' => $id,
            'group' => $group
        );

        echo json_encode($result);
    }

    function pegroup(){
        if(!$this->input->is_ajax_request()){
            redirect(base_url('setting/group'));
        }

        $iduser = $this->session->userdata('id');

        $id = $this->input->post('id');
        $group = $this->input->post('group');

        $group = strtoupper($group);

        $created_by = $this->session->userdata('id');
        $created_date = date('Y-m-d H:i:s');

        $confirm = TRUE;

        $DBCore = $this->coreDB();

        $this->form_validation->set_rules('id','ID','required|trim');
        $this->form_validation->set_rules('group','Grup','required|trim');

        if($this->form_validation->run() == FALSE){
            // INVALID
            $confirm = FALSE;
            $result = array(
                'result' => FALSE,
                'message' => validation_errors()
            );
        }

        if($confirm == TRUE){
            $table = 'kop_group';
            $data = array(
                'nama_grup' => $group,
                'modified_by' => $created_by,
                'modified_date' => $created_date
            );
    
            $param = array('id_group' => $id);

            // DATABASE TRANSACTION
            $DBCore->trans_begin();

            $this->update2($table,$data,$param,$DBCore);

            if($DBCore->trans_status() === TRUE){
                $DBCore->trans_commit();

                $result = array(
                    'status' => 'success',
                    'message' => 'Grup berhasil diubah.'
                );
            } else {
                $DBCore->trans_rollback();

                $result = array(
                    'status' => 'failed',
                    'message' => 'Koneksi internet Anda terputus.'
                );
            }
        }

        echo json_encode($result);
    }

    function psgroup(){
        if(!$this->input->is_ajax_request()){
            redirect(base_url('setting/group'));
        }

        $table = 'kop_group';

        $input_by = $this->session->userdata('id');

        $show = $this->input->post('object');
        $count = count($show);

        $param = 'id';

        $DBCore = $this->coreDB();

        // DATABASE TRANSACTION
        $DBCore->trans_begin();

        for($i = 0; $i < $count; $i++){
            $data = array('status_grup' => '1');
            $param = array('id_group' => $show[$i]);

            $this->update2($table,$data,$param,$DBCore);
        }

        if($DBCore->trans_status() === TRUE){
            $DBCore->trans_commit();

            $result = array(
                'result' => TRUE,
                'message' => 'Grup berhasil diaktifkan.'
            );
        } else {
            $DBCore->trans_rollback();

            $result = array(
                'result' => FALSE,
                'message' => 'Koneksi internet Anda terputus.'
            );
        }

        echo json_encode($result);
    }

    function phgroup(){
        if(!$this->input->is_ajax_request()){
            redirect(base_url('setting/group'));
        }

        $table = 'kop_group';

        $input_by = $this->session->userdata('id');

        $hide = $this->input->post('object');
        $count = count($hide);

        $DBCore = $this->coreDB();

        // DATABASE TRANSACTION
        $DBCore->trans_begin();

        for($i = 0; $i < $count; $i++){
            $data = array('status_grup' => '0');
            $param = array('id_group' => $hide[$i]);

            $this->update2($table,$data,$param,$DBCore);
        }

        if($DBCore->trans_status() === TRUE){
            $DBCore->trans_commit();

            $result = array(
                'result' => TRUE,
                'message' => 'Grup berhasil di-non-aktifkan.'
            );
        } else {
            $DBCore->trans_rollback();

            $result = array(
                'result' => FALSE,
                'message' => 'Koneksi internet Anda terputus.'
            );
        }

        echo json_encode($result);
    }

    function pdgroup(){
        if(!$this->input->is_ajax_request()){
            redirect(base_url('setting/group'));
        }

        $table = 'kop_group';

        $input_by = $this->session->userdata('id');

        $del = $this->input->post('object');
        $count = count($del);

        $param = 'id_group';

        $DBCore = $this->coreDB();

        // DATABASE TRANSACTION
        $DBCore->trans_begin();

        for($i = 0; $i < $count; $i++){
            $this->delete($table,$param,$del[$i],$DBCore);
        }

        if($DBCore->trans_status() === TRUE){
            $DBCore->trans_commit();

            $result = array(
                'result' => TRUE,
                'message' => 'Grup berhasil dihapus.'
            );
        } else {
            $DBCore->trans_rollback();

            $result = array(
                'result' => FALSE,
                'message' => 'Koneksi internet Anda terputus.'
            );
        }

        echo json_encode($result);
    }

    function user(){
        $data = array();

        // USER PRIVILLEGES
        $uri1 = $this->uri->segment(1);
        $uri2 = $this->uri->segment(2);

        if($uri2){
            $uri = $uri1.'/'.$uri2;
        } else {
            $uri = $uri1;
        }

        $privilleges = $this->privilleges($uri);

        if($privilleges == 0){
            redirect(base_url('notfound'));
        }

        // MAIN PAGE
        $data['body'] = 'setting/vuser';
        $data['title'] = 'Pengaturan User | PT. Anugerah Sabda Alam';
        $data['f_title'] = 'Pengaturan';
        $data['s_title'] = 'User';

        // LIBRARY
        $data['csspage'] = 'setting/_css/csspage_user';
        $data['jslib'] = 'setting/_js/jslib_user';
        $data['jsscript'] = 'setting/_js/js_user';

        // LOAD DATA
        $data['menu'] = $this->show_menu(1);
        $data['now'] = $this->current_now();
        $data['group'] = $this->show_group(1);
        $data['e_group'] = $this->show_group(1);
        $data['uri'] = $uri;
        $data['suburi'] = $this->getSubUri($uri);
        $data['category'] = $this->model_setting->get_category();

        $this->load->vars($data);
        $this->load->view('view_dashboard');
    }

    function apiuser(){
        if(!$this->input->is_ajax_request()){
            redirect(base_url('setting/user'));
        }

        $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '';
        $limit_rows = isset($_REQUEST['rows']) ? $_REQUEST['rows'] : '';
        $sidx = isset($_REQUEST['sidx']) ? $_REQUEST['sidx'] : '';
        $sord = isset($_REQUEST['sord']) ? $_REQUEST['sord'] : '';
        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : FALSE;

        if($totalrows){
            $limit_rows = $totalrows;
        }

        $sum = $this->model_setting->apiuser('','','','');

        $count = count($sum);

        if($count > 0){
            $total_pages = ceil($count / $limit_rows);
        } else {
            $total_pages = 0;
        }

        if($page > $total_pages){
            $page = $total_pages;
        }

        $start = ($limit_rows * $page) - $limit_rows;

        if($start < 0){
            $start = 0;
        }

        $result = $this->model_setting->apiuser($sidx,$sord,$limit_rows,$start);

        $response = array();

        $response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $count;

        foreach($result as $row){
            $id = $row['id'];
            $name = $row['name'];
            $email = $row['email'];
            $group = $row['group'];
            $isactive = $row['isactive'];

            if($isactive == '0'){
                $status = '<strong class="kt-font-danger">Tidak Aktif</strong>';
            } else {
                $status = '<strong class="kt-font-success">Aktif</strong>';
            }

            $action = '<a href="javascript:;" id="edit_user" class="kt-badge kt-badge--inline kt-badge--info" title="Ubah" u_id="'.$id.'"><i class="fa fa-edit"></i> Ubah</a>';

            $response['rows'][] = array(
                'id' => $id,
                'name' => $name,
                'email' => $email,
                'group' => $group,
                'status' => $status,
                'action' => $action
            );
        }

        echo json_encode($response);
    }

    function pauser(){
        if(!$this->input->is_ajax_request()){
            redirect(base_url('setting/user'));
        }

        $iduser = $this->session->userdata('id');

        $idgroup = $this->input->post('idgroup');
        $username = $this->input->post('email');
        $password = $this->input->post('password');
        $repassword = $this->input->post('repassword');
        $name = $this->input->post('name');
        $email = $this->input->post('email');

        $name = strtoupper($name);

        $input_by = $this->session->userdata('id');
        $input_date = date('Y-m-d H:i:s');

        $id = md5(sha1($input_by.' '.$input_date.' '.rand().' '.$idgroup));

        $confirm = TRUE;

        $DBCore = $this->coreDB();

        $this->form_validation->set_rules('idgroup','Grup','required|trim');
        $this->form_validation->set_rules('password','Password','required|trim');
        $this->form_validation->set_rules('repassword','Ulang Password','matches[password]|trim');
        $this->form_validation->set_rules('name','Nama','required|trim');
        $this->form_validation->set_rules('email','Email','valid_email|trim');

        if($this->form_validation->run() == FALSE){
            // INVALID
            $confirm = FALSE;
            $result = array(
                'result' => FALSE,
                'message' => strip_tags(validation_errors())
            );
        }

        if($confirm == TRUE){
            $get_username = $this->model_setting->get_user_by_username($username);

            $jumlah = $get_username['jumlah'];

            if($jumlah > 0){
                $confirm = FALSE;

                $result = array(
                    'result' => FALSE,
                    'message' => 'Username sudah terdaftar.'
                );
            }
        }

        if($confirm == TRUE){
            $path = $this->config->item('pphoto');
            $location = $this->config->item('plocation');
            $config['upload_path'] = $path;
            $config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';
            $config['encrypt_name'] = TRUE;

            $this->upload->initialize($config);

            if($this->upload->do_upload()){
                // UPLOAD SUCCESS
                $detail = $this->upload->data();
                $orig = $detail['orig_name'];
                $file = $detail['file_name'];
            } else {
                // UPLOAD FAILED
                $msg_err = $this->upload->display_errors();

                if($msg_err == '<p>You did not select a file to upload.</p>'){
                    // IT DOESN'T MATTER
                    $orig = '';
                    $file = '';
                } else {
                    //  FAILED
                    $confirm = FALSE;
                    $result = array(
                        'result' => FALSE,
                        'message' => $msg_err
                    );
                }
            }
        }

        if($confirm == TRUE){
            $password = sha1(md5(sha1('2016'.$password.'master')));
    
            $table = 'mst_user';
            $data = array(
                'id' => $id,
                'idgroup' => $idgroup,
                'username' => $username,
                'password' => $password,
                'name' => $name,
                'email' => $email,
                'photo' => $orig,
                'attach' => $file,
                'input_by' => $input_by,
                'input_date' => $input_date
            );
    
            $flag = $iduser;
            $keterangan = 'TAMBAH USER PADA TABEL '.$table;
            $tipe = 3;
        }

        if($confirm == TRUE){
            // DATABASE TRANSACTION
            $DBCore->trans_begin();

            $this->insert($table,$data,$DBCore);
            $this->log_activity($flag,$keterangan,$tipe,$iduser,$DBCore);

            if($DBCore->trans_status() === TRUE){
                $DBCore->trans_commit();

                $result = array(
                    'result' => TRUE,
                    'message' => 'User berhasil ditambahkan.'
                );
            } else {
                $DBCore->trans_rollback();

                @unlink($location.$file_name);

                $result = array(
                    'result' => FALSE,
                    'message' => 'Koneksi internet Anda terputus.'
                );
            }
        }

        echo json_encode($result);
   }

    function get_user_by_id(){
        if(!$this->input->is_ajax_request()){
            redirect(base_url('setting/user'));
        }

        $id = $this->input->post('u_id');

        $show = $this->model_setting->get_user_by_id($id);

        $id = $show['id'];
        $idgroup = $show['idgroup'];
        $username = $show['username'];
        $password = $show['password'];
        $name = $show['name'];
        $email = $show['email'];
        $photo = $show['photo'];
        $attach = $show['attach'];

        $result = array(
            'id' => $id,
            'idgroup' => $idgroup,
            'username' => $username,
            'password' => $password,
            'name' => $name,
            'email' => $email,
            'photo' => $photo,
            'attach' => $attach
        );

        echo json_encode($result);
    }

    function peuser(){
        if(!$this->input->is_ajax_request()){
            redirect(base_url('setting/user'));
        }

        $iduser = $this->session->userdata('id');

        $id = $this->input->post('id');
        $idgroup = $this->input->post('idgroup');
        $username = $this->input->post('email');
        $password = $this->input->post('password');
        $oldpass = $this->input->post('oldpass');
        $repassword = $this->input->post('repassword');
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $oldp = $this->input->post('oldp');
        $olda = $this->input->post('olda');

        $name = strtoupper($name);

        $update_by = $this->session->userdata('id');
        $update_date = date('Y-m-d H:i:s');

        $confirm = TRUE;

        $DBCore = $this->coreDB();

        $this->form_validation->set_rules('idgroup','Grup','required|trim');
        $this->form_validation->set_rules('password','Password','trim');
        $this->form_validation->set_rules('repassword','Ulang Password','matches[password]|trim');
        $this->form_validation->set_rules('name','Nama','required|trim');
        $this->form_validation->set_rules('email','Email','valid_email|trim');

        if($this->form_validation->run() == FALSE){
            // INVALID
            $confirm = FALSE;
            $result = array(
                'result' => FALSE,
                'message' => strip_tags(validation_errors())
            );
        }

        if($confirm == TRUE){
            $path = $this->config->item('pphoto');
            $location = $this->config->item('plocation');
            $config['upload_path'] = $path;
            $config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';
            $config['encrypt_name'] = TRUE;

            $this->upload->initialize($config);

            if($this->upload->do_upload()){
                // UPLOAD SUCCESS
                $detail = $this->upload->data();
                @unlink($location.$olda);
                $orig = $detail['orig_name'];
                $file = $detail['file_name'];
            } else {
                // UPLOAD FAILED
                $msg_err = $this->upload->display_errors();

                if($msg_err == '<p>You did not select a file to upload.</p>'){
                    // IT DOESN'T MATTER
                    $orig = $oldp;
                    $file = $olda;
                } else {
                    //  FAILED
                    $confirm = FALSE;
                    $result = array(
                        'result' => FALSE,
                        'message' => $msg_err
                    );
                }
            }
        }

        if($confirm == TRUE){
            if(!empty($password)){
                $password = sha1(md5(sha1('2016'.$password.'master')));
            } else {
                $password = $oldpass;
            }
    
            $table = 'mst_user';
            $data = array(
                'idgroup' => $idgroup,
                'username' => $username,
                'password' => $password,
                'name' => $name,
                'email' => $email,
                'photo' => $orig,
                'attach' => $file,
                'update_by' => $update_by,
                'update_date' => $update_date
            );
    
            $flag = $iduser;
            $keterangan = 'UBAH USER PADA TABEL '.$table;
            $tipe = 4;
    
            $param = 'id';

            // DATABASE TRANSACTION
            $DBCore->trans_begin();

            $this->update($table,$data,$param,$id,$DBCore);
            $this->log_activity($flag,$keterangan,$tipe,$iduser,$DBCore);

            if($DBCore->trans_status() === TRUE){
                $DBCore->trans_commit();

                $result = array(
                    'result' => TRUE,
                    'message' => 'User berhasil diubah.'
                );
            } else {
                $DBCore->trans_rollback();

                @unlink($location.$file_name);

                $result = array(
                    'result' => FALSE,
                    'message' => 'Koneksi internet Anda terputus.'
                );
            }
        }

        echo json_encode($result);
    }

    function psuser(){
        if(!$this->input->is_ajax_request()){
            redirect(base_url('setting/user'));
        }

        $table = 'mst_user';

        $input_by = $this->session->userdata('id');

        $show = $this->input->post('object');
        $count = count($show);

        $param = 'id';

        // CREATE LOG ACTIVITY
        $keterangan = 'TAMPILKAN USER PADA TABEL '.$table;
        $tipe = 6;

        $DBCore = $this->coreDB();

        // DATABASE TRANSACTION
        $DBCore->trans_begin();

        for($i = 0; $i < $count; $i++){
            $data = array('isactive' => '1');

            $this->update($table,$data,$param,$show[$i],$DBCore,$DBCore);
            $this->log_activity($show[$i],$keterangan,$tipe,$input_by,$DBCore,$DBCore);
        }

        if($DBCore->trans_status() === TRUE){
            $DBCore->trans_commit();

            $result = array(
                'result' => TRUE,
                'message' => 'User berhasil ditampilkan.'
            );
        } else {
            $DBCore->trans_rollback();

            $result = array(
                'result' => FALSE,
                'message' => 'Koneksi internet Anda terputus.'
            );
        }

        echo json_encode($result);
    }

    function phuser(){
        if(!$this->input->is_ajax_request()){
            redirect(base_url('setting/user'));
        }

        $table = 'mst_user';

        $input_by = $this->session->userdata('id');

        $hide = $this->input->post('object');
        $count = count($hide);

        $param = 'id';

        // CREATE LOG ACTIVITY
        $keterangan = 'SEMBUNYIKAN USER PADA TABEL '.$table;
        $tipe = 7;

        $DBCore = $this->coreDB();

        // DATABASE TRANSACTION
        $DBCore->trans_begin();

        for($i = 0; $i < $count; $i++){
            $data = array('isactive' => '0');

            $this->update($table,$data,$param,$hide[$i],$DBCore);
            $this->log_activity($hide[$i],$keterangan,$tipe,$input_by,$DBCore);
        }

        if($DBCore->trans_status() === TRUE){
            $DBCore->trans_commit();

            $result = array(
                'result' => TRUE,
                'message' => 'User berhasil disembunyikan.'
            );
        } else {
            $DBCore->trans_rollback();

            $result = array(
                'result' => FALSE,
                'message' => 'Koneksi internet Anda terputus.'
            );
        }

        echo json_encode($result);
    }

    function pduser(){
        if(!$this->input->is_ajax_request()){
            redirect(base_url('setting/user'));
        }

        $table = 'mst_user';

        $input_by = $this->session->userdata('id');

        $location = $this->config->item('plocation');

        $del = $this->input->post('object');
        $count = count($del);

        $param = 'id';

        // CREATE LOG ACTIVITY
        $keterangan = 'HAPUS USER PADA TABEL '.$table;
        $tipe = 5;

        $DBCore = $this->coreDB();

        // DATABASE TRANSACTION
        $DBCore->trans_begin();

        for($i = 0; $i < $count; $i++){
            // DELETE USER
            $show = $this->model_setting->get_user_by_id($del[$i]);
            $attach = $show['attach'];
            @unlink($location.$attach);

            $this->delete($table,$param,$del[$i],$DBCore);
            $this->log_activity($del[$i],$keterangan,$tipe,$input_by,$DBCore);
        }

        if($DBCore->trans_status() === TRUE){
            $DBCore->trans_commit();

            $result = array(
                'result' => TRUE,
                'message' => 'User berhasil dihapus.'
            );
        } else {
            $DBCore->trans_rollback();

            $result = array(
                'result' => FALSE,
                'message' => 'Koneksi internet Anda terputus.'
            );
        }

        echo json_encode($result);
    }

    function menu(){
        $data = array();

        // USER PRIVILLEGES
        $uri = $this->getUri();

        $privilleges = $this->privilleges($uri);

        if($privilleges == 0){
            redirect(base_url('notfound'));
        }

        // MAIN PAGE
        $data['body'] = 'setting/vmenu';
        $data['title'] = 'Pengaturan Menu | Sistem Informasi Karyawan';
        $data['f_title'] = 'Pengaturan';
        $data['s_title'] = 'Menu';
		$data['joinDate'] = $this->getJoinDate();

        // LIBRARY
        $data['csspage'] = 'setting/_css/csspage_menu';
        $data['jslib'] = 'setting/_js/jslib_menu';
        $data['jsscript'] = 'setting/_js/js_menu';

        // LOAD DATA
        $data['menu'] = $this->show_menu(1);
        $data['now'] = $this->current_now();
        $data['uri'] = $uri;
        $data['suburi'] = $this->getSubUri($uri);
        $data['category'] = $this->model_setting->get_category();

        $this->load->vars($data);
        $this->load->view('view_dashboard');
    }

    function pamenu(){
        if(!$this->input->is_ajax_request()){
            redirect(base_url('setting/menu'));
        }

        $iduser = $this->session->userdata('id');

        $parent = $this->input->post('parent');
        $subparent = $this->input->post('subparent');
        $menu = $this->input->post('menu');
        $flag2 = $this->input->post('flag2');
        $control = $this->input->post('control');

        $create_by = $this->session->userdata('id');
        $create_date = date('Y-m-d H:i:s');

        $DBCore = $this->coreDB();

        $id = md5(sha1($create_by.' '.$create_date.' '.rand().' '.$parent));

        $confirm = TRUE;

        $this->form_validation->set_rules('parent','Parent','required|numeric|trim');
        $this->form_validation->set_rules('subparent','Sub Parent','required|numeric|trim');
        $this->form_validation->set_rules('menu','Menu','required|trim');
        $this->form_validation->set_rules('flag2','Flag','required|numeric|trim');
        $this->form_validation->set_rules('control','Control','required|trim');

        if($this->form_validation->run() == FALSE){
            // INVALID
            $confirm = FALSE;
            $result = array(
                'result' => FALSE,
                'message' => validation_errors()
            );
        }

        if($confirm == TRUE){
            $get_menu = $this->model_setting->get_menu_by_menu($menu);

            $jumlah = $get_menu['jumlah'];

            if($jumlah > 0){
                $confirm = FALSE;

                $result = array(
                    'result' => FALSE,
                    'message' => 'Menu sudah terdaftar.'
                );
            }
        }

        if($confirm == TRUE){
            // GET POSITION
            $get_max = $this->model_setting->get_max_position($parent);

            $position = $get_max['max'];

            if($position == 0){
                $position = 1;
            } else {
                $position += 1;
            }

            $table = 'mst_menu';
            $data = array(
                'id' => $id,
                'menu' => $menu,
                'control' => $control,
                'subparent' => $parent,
                'position' => $position,
                'flag' => $flag2,
                'input_by' => $create_by,
                'input_date' => $create_date
            );

            if($subparent == 0){
                $count = $this->model_setting->get_count_category($parent);

                $total = $count['total'];
            }

            $data2 = array(
                'control' => 'javascript:;'
            );

            $param = 'parent';

            $flag = $iduser;
            $keterangan = 'TAMBAH MENU PADA TABEL '.$table;
            $tipe = 3;
            $keterangan2 = 'UBAH CONTROL MENU PADA TABEL '.$table;
            $tipe2 = 4;
        }

        if($confirm == TRUE){
            // DATABASE TRANSACTION
            $this->insert($table,$data,$DBCore);
            $this->log_activity($flag,$keterangan,$tipe,$iduser,$DBCore);

            if($subparent == 0){
                if($total == 0){
                    $this->update($table,$data2,$param,$parent,$DBCore);
                    $this->log_activity($flag,$keterangan2,$tipe2,$iduser,$DBCore);
                }
            }

            if($DBCore->trans_status() === TRUE){
                $DBCore->trans_commit();

                $result = array(
                    'result' => TRUE,
                    'message' => 'Menu berhasil ditambahkan.'
                );
            } else {
                $DBCore->trans_rollback();

                $result = array(
                    'result' => FALSE,
                    'message' => 'Koneksi internet Anda terputus.'
                );
            }
        }

        echo json_encode($result);
    }

    function apimenu(){
        if(!$this->input->is_ajax_request()){
            redirect(base_url('setting/menu'));
        }

        $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '';
        $limit_rows = isset($_REQUEST['rows']) ? $_REQUEST['rows'] : '';
        $sidx = isset($_REQUEST['sidx']) ? $_REQUEST['sidx'] : '';
        $sord = isset($_REQUEST['sord']) ? $_REQUEST['sord'] : '';
        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : FALSE;

        if($totalrows){
            $limit_rows = $totalrows;
        }

        $sum = $this->model_setting->apimenu('','','','');

        $count = count($sum);

        if($count > 0){
            $total_pages = ceil($count / $limit_rows);
        } else {
            $total_pages = 0;
        }

        if($page > $total_pages){
            $page = $total_pages;
        }

        $start = ($limit_rows * $page) - $limit_rows;

        if($start < 0){
            $start = 0;
        }

        $result = $this->model_setting->apimenu($sidx,$sord,$limit_rows,$start);

        $response = array();

        $response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $count;

        foreach($result as $row){
            $id = $row['id'];
            $menu = $row['menu'];
            $control = $row['control'];
            $subparent = $row['subparent'];
            $isactive = $row['isactive'];

            if($isactive == '0'){
                $status = '<strong class="kt-font-danger">Tidak Aktif</strong>';
            } else {
                $status = '<strong class="kt-font-success">Aktif</strong>';
            }

            $action = '<a href="javascript:;" id="edit_menu" class="kt-badge kt-badge--inline kt-badge--info" title="Ubah" m_id="'.$id.'"><i class="fa fa-edit"></i> Ubah</a>';

            $response['rows'][] = array(
                'id' => $id,
                'title' => $menu,
                'link' => $control,
                'parent' => $subparent,
                'status' => $status,
                'action' => $action
            );
        }

        echo json_encode($response);
    }

    function get_menu_by_id(){
        if(!$this->input->is_ajax_request()){
            redirect(base_url('setting/menu'));
        }

        $id = $this->input->post('m_id');

        $show = $this->model_setting->get_menu_by_id($id);

        $id = $show['id'];
        $parent = $show['parent'];
        $menu = $show['menu'];
        $control = $show['control'];
        $subparent = $show['subparent'];
        $flag = $show['flag'];

        $result = array(
            'id' => $id,
            'parent' => $parent,
            'menu' => $menu,
            'control' => $control,
            'subparent' => $subparent,
            'flag' => $flag
        );

        echo json_encode($result);
    }

    function pemenu(){
        if(!$this->input->is_ajax_request()){
            redirect(base_url('setting/menu'));
        }

        $iduser = $this->session->userdata('id');

        $id = $this->input->post('id');
        $parent = $this->input->post('parent');
        $subparent = $this->input->post('subparent');
        $menu = $this->input->post('menu');
        $flag2 = $this->input->post('flag2');
        $control = $this->input->post('control');

        $update_by = $this->session->userdata('id');
        $update_date = date('Y-m-d H:i:s');

        $DBCore = $this->coreDB();

        $confirm = TRUE;

        $this->form_validation->set_rules('parent','Parent','required|numeric|trim');
        $this->form_validation->set_rules('subparent','Sub Parent','required|numeric|trim');
        $this->form_validation->set_rules('menu','Menu','required|trim');
        $this->form_validation->set_rules('flag2','Flag','required|numeric|trim');
        $this->form_validation->set_rules('control','Control','required|trim');

        if($this->form_validation->run() == FALSE){
            // INVALID
            $confirm = FALSE;
            $result = array(
                'result' => FALSE,
                'message' => validation_errors()
            );
        }

        if($confirm == TRUE){
            $table = 'mst_menu';
            $data = array(
                'menu' => $menu,
                'control' => $control,
                'subparent' => $parent,
                'flag' => $flag2,
                'update_by' => $update_by,
                'update_date' => $update_date
            );

            $param = 'id';

            if($subparent == 0){
                $count = $this->model_setting->get_count_category($parent);

                $total = $count['total'];
            }

            $data2 = array(
                'control' => 'javascript:;'
            );

            $param2 = 'parent';

            $flag = $iduser;
            $keterangan = 'UBAH MENU PADA TABEL '.$table;
            $tipe = 4;
            $keterangan2 = 'UBAH CONTROL MENU PADA TABEL '.$table;
            $tipe2 = 4;

            // DATABASE TRANSACTION
            $DBCore->trans_begin();

            $this->update($table,$data,$param,$id,$DBCore);
            $this->log_activity($flag,$keterangan,$tipe,$iduser,$DBCore);

            if($subparent == 0){
                if($total == 0){
                    $this->update($table,$data2,$param2,$parent,$DBCore);
                    $this->log_activity($flag,$keterangan2,$tipe2,$iduser,$DBCore);
                }
            }

            if($DBCore->trans_status() === TRUE){
                $DBCore->trans_commit();

                $result = array(
                    'result' => TRUE,
                    'message' => 'Menu berhasil diubah.'
                );
            } else {
                $DBCore->trans_rollback();

                $result = array(
                    'result' => FALSE,
                    'message' => 'Koneksi internet Anda terputus.'
                );
            }
        }

        echo json_encode($result);
    }

    function psmenu(){
        if(!$this->input->is_ajax_request()){
            redirect(base_url('setting/menu'));
        }

        $table = 'mst_menu';

        $input_by = $this->session->userdata('id');

        $show = $this->input->post('object');
        $count = count($show);

        $param = 'id';

        // CREATE LOG ACTIVITY
        $keterangan = 'TAMPILKAN MENU PADA TABEL '.$table;
        $tipe = 6;

        $DBCore = $this->coreDB();

		// DATABASE TRANSACTION
		$DBCore->trans_begin();

        for($i = 0; $i < $count; $i++){
            $data = array('isactive' => '1');

            $this->update($table,$data,$param,$show[$i],$DBCore);
            $this->log_activity($show[$i],$keterangan,$tipe,$input_by,$DBCore);
        }

		if($DBCore->trans_status() === TRUE){
			$DBCore->trans_commit();

			$result = array(
				'result' => TRUE,
				'message' => 'Menu berhasil ditampilkan.'
			);
		} else {
			$DBCore->trans_rollback();

			$result = array(
				'result' => FALSE,
				'message' => 'Koneksi internet Anda terputus.'
			);
		}

        echo json_encode($result);
    }

    function phmenu(){
        if(!$this->input->is_ajax_request()){
            redirect(base_url('setting/menu'));
        }

        $table = 'mst_menu';

        $input_by = $this->session->userdata('id');

        $hide = $this->input->post('object');
        $count = count($hide);

        $param = 'id';

        // CREATE LOG ACTIVITY
        $keterangan = 'SEMBUNYIKAN MENU PADA TABEL '.$table;
        $tipe = 7;

        $DBCore = $this->coreDB();

		// DATABASE TRANSACTION
		$DBCore->trans_begin();

        for($i = 0; $i < $count; $i++){
            $data = array('isactive' => '0');

            $this->update($table,$data,$param,$hide[$i],$DBCore);
            $this->log_activity($hide[$i],$keterangan,$tipe,$input_by,$DBCore);
        }

		if($DBCore->trans_status() === TRUE){
			$DBCore->trans_commit();

			$result = array(
				'result' => TRUE,
				'message' => 'Menu berhasil disembunyikan.'
			);
		} else {
			$DBCore->trans_rollback();

			$result = array(
				'result' => FALSE,
				'message' => 'Koneksi internet Anda terputus.'
			);
		}

        echo json_encode($result);
    }

    function pdmenu(){
        if(!$this->input->is_ajax_request()){
            redirect(base_url('setting/menu'));
        }

        $table = 'mst_menu';

        $input_by = $this->session->userdata('id');

        $del = $this->input->post('object');
        $count = count($del);

        $param = 'id';

        // CREATE LOG ACTIVITY
        $keterangan = 'HAPUS MENU PADA TABEL '.$table;
        $tipe = 5;

        $DBCore = $this->coreDB();

		// DATABASE TRANSACTION
		$DBCore->trans_begin();

        for($i = 0; $i < $count; $i++){
            $this->delete($table,$param,$del[$i],$DBCore);
            $this->log_activity($del[$i],$keterangan,$tipe,$input_by,$DBCore);
        }

		if($DBCore->trans_status() === TRUE){
			$DBCore->trans_commit();

			$result = array(
				'result' => TRUE,
				'message' => 'Menu berhasil dihapus.'
			);
		} else {
			$DBCore->trans_rollback();

			$result = array(
				'result' => FALSE,
				'message' => 'Koneksi internet Anda terputus.'
			);
		}

        echo json_encode($result);
    }

    function apirole(){
        if(!$this->input->is_ajax_request()){
            redirect(base_url('setting/menu'));
        }

        $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '';
        $limit_rows = isset($_REQUEST['rows']) ? $_REQUEST['rows'] : '';
        $sidx = isset($_REQUEST['sidx']) ? $_REQUEST['sidx'] : '';
        $sord = isset($_REQUEST['sord']) ? $_REQUEST['sord'] : '';
        $totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : FALSE;

        if($totalrows){
            $limit_rows = $totalrows;
        }

        $sum = $this->model_setting->apigroup('','','','');

        $count = count($sum);

        if($count > 0){
            $total_pages = ceil($count / $limit_rows);
        } else {
            $total_pages = 0;
        }

        if($page > $total_pages){
            $page = $total_pages;
        }

        $start = ($limit_rows * $page) - $limit_rows;

        if($start < 0){
            $start = 0;
        }

        $result = $this->model_setting->apigroup($sidx,$sord,$limit_rows,$start);

        $response = array();

        $response['page'] = $page;
        $response['total'] = $total_pages;
        $response['records'] = $count;

        foreach($result as $row){
            $id = $row['id'];
            $group = $row['group'];

            $action = '<a href="javascript:;" id="edit_role" class="kt-badge kt-badge--inline kt-badge--info" title="Ubah" r_id="'.$id.'"><i class="fa fa-edit"></i> Ubah</a>';

            $response['rows'][] = array(
                'id' => $id,
                'group' => $group,
                'action' => $action
            );
        }

        echo json_encode($response);
    }

    function get_role_by_foreign(){
        if(!$this->input->is_ajax_request()){
            redirect(base_url('setting/menu'));
        }

        $id = $this->input->post('r_id');

        $show = $this->model_setting->get_role_by_foreign($id);
        $grup = $this->model_setting->get_group_by_id($id);

        $count = count($show);

        $html = '<input name="idgroup" type="hidden" id="idgroup" value="'.$id.'">';

        $html .= '<h4 class="block"><strong>Akses '.$grup['group'].'</strong></h4>';
        $html .= '<ol>';

        for($i = 0; $i < $count; $i++){
            $idmenu = $show[$i]['idmenu'];
            $idm = $show[$i]['id'];
            $menu = $show[$i]['menu'];
            $flag = $show[$i]['flag'];
            $parent = $show[$i]['parent'];
            $control = $show[$i]['control'];

            if($flag == 0 and $control != 'javascript:;'){
                $html .= '<li style="list-style:none;">';
                $html .= '<label>';

                if($idmenu == $idm){
                    $checked = ' checked="checked"';
                } else {
                    $checked = '';
                }

                $html .= '<input name="idmenu[]" type="checkbox" id="'.$idm.'" value="'.$idm.'"'.$checked.'>';

                $html .= ' '.$menu.'</label>';
                $html .= '</li>';
            } else if($flag == 0 and $control == 'javascript:;'){
                $html .= '<li style="list-style:none;">';
                $html .= '<label>';

                if($idmenu == $idm){
                    $checked = ' checked="checked"';
                } else {
                    $checked = '';
                }

                $html .= '<input name="idmenu[]" type="checkbox" id="'.$idm.'" value="'.$idm.'"'.$checked.'>';

                $html .= ' '.$menu.'</label>';

                for($ii = 0; $ii < $count; $ii++){
                    $idmenu2 = $show[$ii]['idmenu'];
                    $idm2 = $show[$ii]['id'];
                    $menu2 = $show[$ii]['menu'];
                    $flag2 = $show[$ii]['flag'];
                    $parent2 = $show[$ii]['parent'];
                    $subparent = $show[$ii]['subparent'];
                    $control2 = $show[$ii]['control'];

                    $html .= '<ol>';

                    if($flag2 == 1 and $subparent == $parent and $control2 != 'javascript:;'){
                        $html .= '<li style="list-style:none;">';
                        $html .= '<label>';

                        if($idmenu2 == $idm2){
                            $checked2 = ' checked="checked"';
                        } else {
                            $checked2 = '';
                        }

                        $html .= '<input name="idmenu[]" type="checkbox" class="'.$idm.'" id="idmenu" value="'.$idm2.'"'.$checked2.'>';

                        $html .= ' '.$menu2.'</label>';
                        $html .= '</li>';
                    } else if($flag2 == 1 and $subparent == $parent and $control2 == 'javascript:;') {
                        $html .= '<li style="list-style:none;">';
                        $html .= '<label>';

                        if($idmenu2 == $idm2){
                            $checked2 = ' checked="checked"';
                        } else {
                            $checked2 = '';
                        }

                        $html .= '<input name="idmenu[]" type="checkbox" class="'.$idm.'" id="'.$idm2.'" value="'.$idm2.'"'.$checked2.'>';

                        $html .= ' '.$menu2.'</label>';

                        for($iii = 0; $iii < $count; $iii++){
                            $idmenu3 = $show[$iii]['idmenu'];
                            $idm3 = $show[$iii]['id'];
                            $menu3 = $show[$iii]['menu'];
                            $flag3 = $show[$iii]['flag'];
                            $parent3 = $show[$iii]['parent'];
                            $subparent2 = $show[$iii]['subparent'];
                            $control3 = $show[$iii]['control'];

                            $html .= '<ol>';

                            if($flag3 == 2 and $subparent == $parent and $subparent2 == $parent2){
                                $html .= '<li style="list-style:none;">';
                                $html .= '<label>';

                                if($idmenu3 == $idm3){
                                    $checked3 = ' checked="checked"';
                                } else {
                                    $checked3 = '';
                                }

                                $html .= '<input name="idmenu[]" type="checkbox" class="'.$idm.' '.$idm2.'" id="idmenu" value="'.$idm3.'"'.$checked3.'>';

                                $html .= ' '.$menu3.'</label>';
                                $html .= '</li>';
                            }

                            $html .= '</ol>';
                        }

                        $html .= '</li>';
                    }

                    $html .= '</ol>';
                }

                $html .= '</li>';
            }

        }

        $html .= '</ol>';

        echo $html;
    }

    function perole(){
        if(!$this->input->is_ajax_request()){
            redirect(base_url('setting/menu'));
        }

        $iduser = $this->session->userdata('id');

        $idgroup = $this->input->post('idgroup');
        $idmenu = $this->input->post('idmenu');

        $count = count($idmenu);

        $confirm = TRUE;

        $DBCore = $this->coreDB();

        $this->form_validation->set_rules('idgroup','ID Group','required|trim');

        if($this->form_validation->run() == FALSE){
            // INVALID
            $confirm = FALSE;
            $result = array(
                'result' => FALSE,
                'message' => validation_errors()
            );
        }

        if($confirm == TRUE){
			$table = 'mst_role';
	
			$param = 'idgroup';
	
			$data = array();
	
			for($i = 0; $i < $count; $i++){
				$data[] = array(
					'idgroup' => $idgroup,
					'idmenu' => $idmenu[$i]
				);
			}
	
			$flag = $iduser;
			$keterangan = 'TAMBAH ROLE PADA TABEL '.$table;
			$type = 3;

			// DATABASE TRANSACTION
			$DBCore->trans_begin();

            $this->delete($table,$param,$idgroup,$DBCore);
			$this->insert_batch($table,$data,$DBCore);
            $this->log_activity($flag,$keterangan,$type,$iduser,$DBCore);

			if($DBCore->trans_status() === TRUE){
				$DBCore->trans_commit();
	
				$result = array(
					'result' => TRUE,
					'message' => 'Role berhasil ditambahkan.'
				);
			} else {
				$DBCore->trans_rollback();
	
				$result = array(
					'result' => FALSE,
					'message' => 'Koneksi internet Anda terputus.'
				);
			}
        }

        echo json_encode($result);
    }

    function peposition(){
        if(!$this->input->is_ajax_request()){
            redirect(base_url('setting/menu'));
        }

        $html = '<div class="dd" id="menu_nestable">';
        $html .= '<ol class="dd-list">';

        $menu = $this->model_setting->get_category();

        $count = count($menu);

        for($i = 0; $i < $count; $i++){
            $id = $menu[$i]['id'];
            $menus = $menu[$i]['menu'];
            $flag = $menu[$i]['flag'];
            $parent = $menu[$i]['parent'];
            $control = $menu[$i]['control'];

            if($flag == 0 and $control != 'javascript:;'){
                $html .= '<li class="dd-item dd3-item" data-id="'.$parent.'">';
                $html .= '<div class="dd-handle dd3-handle"></div>';
                $html .= '<div class="dd3-content">'.$menus.'</div>';
                $html .= '</li>';
            } else if($flag == 0 and $control == 'javascript:;') {
                $html .= '<li class="dd-item dd3-item" data-id="'.$parent.'">';
                $html .= '<div class="dd-handle dd3-handle"></div>';
                $html .= '<div class="dd3-content">'.$menus.'</div>';
                $html .= '<ol class="dd-list">';

                for($ii = 0; $ii < $count; $ii++){
                    $id2 = $menu[$ii]['id'];
                    $menus2 = $menu[$ii]['menu'];
                    $flag2 = $menu[$ii]['flag'];
                    $parent2 = $menu[$ii]['parent'];
                    $subparent = $menu[$ii]['subparent'];
                    $control2 = $menu[$ii]['control'];

                    if($flag2 == 1 and $subparent == $parent and $control2 != 'javascript:;'){
                        $html .= '<li class="dd-item dd3-item" data-id="'.$parent2.'">';
                        $html .= '<div class="dd-handle dd3-handle"></div>';
                        $html .= '<div class="dd3-content">'.$menus2.'</div>';
                        $html .= '</li>';
                    } else if($flag2 == 1 and $subparent == $parent and $control2 == 'javascript:;'){
                        $html .= '<li class="dd-item dd3-item" data-id="'.$parent2.'">';
                        $html .= '<div class="dd-handle dd3-handle"></div>';
                        $html .= '<div class="dd3-content">'.$menus2.'</div>';
                        $html .= '<ol class="dd-list">';

                        for($iii = 0; $iii < $count; $iii++){
                            $id3 = $menu[$iii]['id'];
                            $menus3 = $menu[$iii]['menu'];
                            $flag3 = $menu[$iii]['flag'];
                            $parent3 = $menu[$iii]['parent'];
                            $subparent2 = $menu[$iii]['subparent'];

                            if($flag3 == 2 and $subparent == $parent and $subparent2 == $parent2){
                                $html .= '<li class="dd-item dd3-item" data-id="'.$parent3.'">';
                                $html .= '<div class="dd-handle dd3-handle"></div>';
                                $html .= '<div class="dd3-content">'.$menus3.'</div>';
                                $html .= '</li>';
                            }
                        }

                        $html .= '</ol>';
                        $html .= '</li>';
                    }
                }

                $html .= '</ol>';
                $html .= '</li>';
            }
        }

        $html .= '</ol>';
        $html .= '</div>';

        echo $html;
    }

    function pcposition(){
        if(!$this->input->is_ajax_request()){
            redirect(base_url('setting/menu'));
        }

        $data = $this->input->post('data');

        $first_nestable = 1;

        $table = 'mst_menu';

        foreach($data as $key => $value){
            $id = $value['id'];

            $parent = array(
                'position' => $first_nestable,
                'subparent' => '0'
            );

            $param = 'parent';

            $this->update($table,$parent,$param,$id);

			$second_nestable = 1;

			if(isset($value['children'])){
				$children = $value['children'];

				foreach($children as $a_child => $b_child){
					$id2 = $b_child['id'];

					$parent2 = array(
						'position' => $second_nestable,
						'subparent' => $id
					);

					$param2 = 'parent';

					$this->update($table,$parent2,$param2,$id2);

					$third_nestable = 1;

					if(isset($b_child['children'])){
						$children2 = $b_child['children'];

						foreach($children2 as $c_child => $d_child){
							$id3 = $d_child['id'];

							$parent3 = array(
								'position' => $third_nestable,
								'subparent' => $id2
							);

							$param3 = 'parent';

							$this->update($table,$parent3,$param3,$id3);

							$third_nestable++;
						}
					}

					$second_nestable++;
				}
			}

            $first_nestable++;
        }
    }
}