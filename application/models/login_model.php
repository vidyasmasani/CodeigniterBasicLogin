<?php
/* * Login_model
 *
 * @package	Codeigniter Basic Login
 * @subpackage  Login Management
 * @category	Login Management model
 * @author	Vidya S Masani
 * created on   10-04-2015
 * updated on   10-04-2015
 * 
 */
class Login_model extends CI_Model{
    
    /*login check
     * 
     * @access	public
     * @param	array
     * @return	array
     * @author	vidya
     * created on 10-04-2015
     * 
    */
    public function login_data($data) {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('username', $data['username']);
        $query = $this->db->get();
        $password = md5($data['password']);
        $data['username'] = mysql_real_escape_string($data['username']);
        $password = mysql_real_escape_string($password);
        //return $log_password;
        return $this->db->query("SELECT id,name,username,status	
                                FROM user 
                                WHERE username ='{$data['username']}' 
                                AND password='{$password}'
                                AND status = 1
                                LIMIT 0,1")->result();
    }   
    
     /*check whether username already exist
     * 
     * @access	public
     * @param	array
     * @return	integer
     * @author	Vidya S Masani
     * created on 10-04-2015
     * 
    */
    function get_username_count($data) {
        return $this->db->query(" SELECT COUNT(*) as count FROM user WHERE email = '" . $data['email'] . "' AND status = 1")->row()->count;
    }
    
    
    /*get id using email count
     * 
     * @access	public
     * @param	array
     * @return	integer
     * @author	Vidya S Masani
     * created on 10-04-2015
     * 
    */
    function get_user_id($data) {
        return $this->db->query(" SELECT id as id FROM user WHERE email = '" . $data['email'] . "' AND status = 1")->row()->id;
    }
    
    
    /*get username
     * 
     * @access	public
     * @param	array
     * @return	string
     * @author	Vidya S Masani
     * created on 10-04-2015
     * 
    */
    function get_username($data) {
        return $this->db->query(" SELECT username as username FROM user WHERE id = '" . $data . "' ")->row()->username;
    }
    
    
    /*set forgotpassword value in db
     * 
     * @access	public
     * @param	array
     * @return	array
     * @author	Vidya S Masani
     * created on 10-04-2015
     * 
    */
    function set_password($data) {
        $dataarray = array('forgotpassword' => $data['temp']);
        $this->db->where('email', $data['email']);
        $this->db->where('id', $data['id']);
        $this->db->update('user', $dataarray);
    }
    
    

    /*get value in forgotpassword field
     * 
     * @access	public
     * @param	array
     * @return	integer
     * @author	Vidya S Masani
     * created on 10-04-2015
     * 
    */
    function get_user_pass_count($data) {
        return $this->db->query("SELECT forgotpassword as forgotpassword FROM user WHERE id = '" . $data['us_id'] . "' AND status = 1 ")->row()->forgotpassword;
    }
    
    
    /*get user email id
     * 
     * @access	public
     * @param	array
     * @return	integer
     * @author	Vidya S Masani
     * created on 10-04-2015
     * 
    */
    function get_user_email($data) {
        return $this->db->query(" SELECT email as email FROM user WHERE id = '" . $data['us_id'] . "' AND status = 1 AND forgotpassword = '" . $data['temp_id'] . "' ")->row()->email;
    }
    
    
    /*update the password
     * 
     * @access	public
     * @param	array
     * @return	array
     * @author	Vidya S Masani
     * created on 10-04-2015
     * 
    */
    function set_password_new($data) {
        $password = md5($data['password']);
        $dataarray = array('forgotpassword' => 0,
            'password' => $password
        );
        $this->db->where('id', $data['us_id']);
        $this->db->update('user', $dataarray);
    }
    
}
?>
