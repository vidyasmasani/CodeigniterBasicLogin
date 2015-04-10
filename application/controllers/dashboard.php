<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct() {
            parent::__construct();
            $this->load->model('login_model');
            $this->load->helper('url');
            $this->load->library('session');
            $this->load->library('form_validation');
        }

        /**
         * CodeIgniter
         * @package         Basic login
         * @author          vidya
         * @since           Version 1.0
         * Description      Indexpage
         */
        public function index() {   
            if(!$this->session->userdata('id')) {
                redirect('login');
            }
            
            $data['name'] = $this->session->userdata('name');
            
            $this->load->view('dashboard', $data);
        }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */