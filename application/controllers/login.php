<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

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
            if($this->session->userdata('id')) {
                redirect('dashboard');
            }
            
            $this->load->view('index');
        }

        /**
         * CodeIgniter
         * @package         Basic login
         * @author          vidya
         * @since           Version 1.0
         * Description      login
         */

        //check login
        public function login_user() {
            $data['username'] = $this->input->post('username');
            $data['password'] = $this->input->post('password');

            //remember me code
            // If checkbox is checked it return true either false
            $checked = (isset($_POST['remember']))?true:false; 
            if($checked== true){
                setcookie('username', $data['username'], time() + 3600 * 24 * 30, '/'); // Expires in a month.
                setcookie('password_hash', $data['password'], time() + 3600 * 24 * 30, '/');
            }

            //remember me code
            $d['ud'] = $this->login_model->login_data($data);

            $c = count($d['ud']);
            if ($c > 0) {
                foreach ($d['ud'] as $ud) {
                    $id = $ud->id;
                    $name = $ud->name;
                    $username = $ud->username;
                    $status = $ud->status;
                }

                if ($status == 1) {
                    $data['id'] = $id;
                    
                    //Setting session
                    $user_session_data = array(
                        'id' => $id,
                        'name' => $name,
                        'username' => $username,
                        'password' => $data['password'],
                        'is_active' => $status
                    );
                }
                $this->session->set_userdata($user_session_data);
                
                $this->session->set_flashdata('Success', 'Successfully logged in');
                redirect('dashboard');
            } else {
                $this->session->set_flashdata('error', 'Sorry, Invalid login');
                redirect('login');
            }
        }

        //logout
        public function logout() {
            $this->session->sess_destroy();
            redirect('login');
        }

        //load forgot password page
        function forgotpassword() {
            $this->load->view('forgot');
        }

        //sent mail when clicking forgot password
        function forgot() {
            $this->load->library('email');
            $email = $this->input->post('email');
            $data['email'] = $email;

            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

            if ($this->form_validation->run() == FALSE){
                $this->load->view('forgot');
            } else {            

                $data['count'] = $this->login_model->get_username_count($data);
                if ($data['count'] > 0) {
                    $data['id'] = $this->login_model->get_user_id($data);
                    $data['username'] = $this->login_model->get_username($data['id']);
                    $data['temp'] = rand(1, 1000);


                    $message = 'Welcome to Codeigniter Basic Login!       
                                <p> Forgot Your Password ?</p>
                                <p> We received a request to reset the password for your account <b>' . $data['username'] . '</b></p>
                                <p>To reset your password <a href="'.site_url().'login/get_password/' . $data['id'] . '/' . $data['temp'] . '">click here</a></p>
                                <p>Thanks,</p>
                                <p>Admin</p>';

                    $data['message']= '';    
                    $config['protocol'] = 'mail'; // mail, sendmail, or smtp    The mail sending protocol.
                    $config['smtp_host'] = 'xxx.xxx.xx.xx'; // SMTP Server Address.
                    $config['smtp_user'] = 'null';
                    $config['smtp_pass'] = 'null';//'hll@hll'; // SMTP Password.
                    $config['smtp_port'] = '25'; // SMTP Port.
                    $config['smtp_timeout'] = '5'; // SMTP Timeout (in seconds).
                    $config['wordwrap'] = TRUE; // TRUE or FALSE (boolean)    Enable word-wrap.
                    $config['wrapchars'] = 76; // Character count to wrap at.
                    $config['mailtype'] = 'html'; // text or html Type of mail. If you send HTML email you must send it as a complete web page. Make sure you don't have any relative links or relative image paths otherwise they will not work.
                    $config['charset'] = 'utf-8'; // Character set (utf-8, iso-8859-1, etc.).
                    $config['validate'] = FALSE; // TRUE or FALSE (boolean)    Whether to validate the email address.
                    $config['priority'] = 3; // 1, 2, 3, 4, 5    Email Priority. 1 = highest. 5 = lowest. 3 = normal.
                    $config['crlf'] = "\r\n"; // "\r\n" or "\n" or "\r" Newline character. (Use "\r\n" to comply with RFC 822).
                    $config['newline'] = "\r\n"; // "\r\n" or "\n" or "\r"    Newline character. (Use "\r\n" to comply with RFC 822).
                    $config['bcc_batch_mode'] = FALSE; // TRUE or FALSE (boolean)    Enable BCC Batch Mode.
                    $config['bcc_batch_size'] = 200; // Number of emails in each BCC batch.


                    $this->email->initialize($config);
                    $this->email->clear();

                    $this->email->from('test@gmail.com', 'Admin');
                    $this->email->reply_to('test@gmail.com', 'Admin');
                    $this->email->to($email);
                    $this->email->subject('Forgot Your Password');
                    $this->email->message($message);
                    if ( ! $this->email->send()){
                            $data['message'].= 'An error have been occured';
                    } else{   
                            $this->login_model->set_password($data);
                            $data['message'].= 'Password Sent To Your Mail';
                    } 
                    $this->load->view('forgot',$data);
                } else {
                    $this->session->set_flashdata('error', 'Email doesnot exist');
                    redirect('login/forgotpassword', 'refresh');
                }
            }
        }

    //mail password to user's email when clicking the linking
    function get_password() {
        $this->load->library('email');
        $data['us_id'] = $this->uri->segment(3);
        $data['temp_id'] = $this->uri->segment(4);

        $forgot = $this->login_model->get_user_pass_count($data);
        if ($forgot != 0) {
            $data['email'] = $this->login_model->get_user_email($data);
            $email = $data['email'];
            $data['password'] = $this->generatePassword();

            $message = 'Welcome to Codeigniter Basic Login!       
                        <p>Your password has been changed !!</p>
                        <p>Your new password: <b>' . $data['password'] . '</b></p>
                        <p>Please reset your password after login using this password.</p>
                        <p>Thanks,</p>
                        <p>Admin</p>';
            
            $data['message']= '';    
            $config['protocol'] = 'mail'; // mail, sendmail, or smtp    The mail sending protocol.
            $config['smtp_host'] = 'xxxx.xxx.xx.xx'; // SMTP Server Address.
            $config['smtp_user'] = 'null';//'hll@e-smartlab.com'; // SMTP Username.
            $config['smtp_pass'] = 'null';//'hll@hll'; // SMTP Password.
            $config['smtp_port'] = '465'; // SMTP Port.
            $config['smtp_timeout'] = '30'; // SMTP Timeout (in seconds).
            $config['wordwrap'] = TRUE; // TRUE or FALSE (boolean)    Enable word-wrap.
            $config['wrapchars'] = 76; // Character count to wrap at.
            $config['mailtype'] = 'html'; // text or html Type of mail. If you send HTML email you must send it as a complete web page. Make sure you don't have any relative links or relative image paths otherwise they will not work.
            $config['charset'] = 'utf-8'; // Character set (utf-8, iso-8859-1, etc.).
            $config['validate'] = TRUE; // TRUE or FALSE (boolean)    Whether to validate the email address.
            $config['priority'] = 3; // 1, 2, 3, 4, 5    Email Priority. 1 = highest. 5 = lowest. 3 = normal.
            $config['crlf'] = "\r\n"; // "\r\n" or "\n" or "\r" Newline character. (Use "\r\n" to comply with RFC 822).
            $config['newline'] = "\r\n"; // "\r\n" or "\n" or "\r"    Newline character. (Use "\r\n" to comply with RFC 822).
            $config['bcc_batch_mode'] = FALSE; // TRUE or FALSE (boolean)    Enable BCC Batch Mode.
            $config['bcc_batch_size'] = 200; // Number of emails in each BCC batch.

            $this->email->initialize($config);
            $this->email->clear();

            $this->email->from('test@gmail.com', 'Admin');
            $this->email->reply_to('test@gmail.com', 'Admin');
            $this->email->to($email);
            $this->email->subject('Forgot Your Password');
            $this->email->message($message);
            if ( ! $this->email->send()){
                    $data['message'].= 'An error have been occured';
            } else{                       
                    $this->login_model->set_password_new($data);
                    $this->session->set_flashdata('Success', 'Password Reseted. You can login now');
                    redirect('login', 'refresh');
            }             
        } else {
            $this->session->set_flashdata('error', 'Reset code not found');
            redirect('login/forgotpassword', 'refresh');
        }
    }

    //generate password
    function generatePassword($length = 9, $strength = 0) {
        $vowels = 'aeuy';
        $consonants = 'bdghjmnpqrstvz';
        if ($strength & 1) {
            $consonants .= 'BDGHJLMNPQRSTVWXZ';
        }
        if ($strength & 2) {
            $vowels .= "AEUY";
        }
        if ($strength & 4) {
            $consonants .= '23456789';
        }
        if ($strength & 8) {
            $consonants .= '@#$%';
        }

        $password = '';
        $alt = time() % 2;
        for ($i = 0; $i < $length; $i++) {
            if ($alt == 1) {
                $password .= $consonants[(rand() % strlen($consonants))];
                $alt = 0;
            } else {
                $password .= $vowels[(rand() % strlen($vowels))];
                $alt = 1;
            }
        }
        return $password;
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
