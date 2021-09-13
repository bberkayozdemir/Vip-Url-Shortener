<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Functions_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
	
    function set_setting($name, $value)
    {
            $this->db->where("name", $name);
            return $this->db->update("settings", array("value" => $value));
    }

    function get_setting($name)
    {
            $setting_query = $this->db->get_where('settings', array('name' => $name));
            if($setting_query !== false && $setting_query->num_rows() > 0)
                    return $setting_query->row()->value;

            return false;
    }
    
    function check_admin_login()
    {
        if ($this->session->userdata('admin_login') == 'yes') {
            return true;
        } else {
            return false;
        }
    }
    
    function check_login()
    {
        if ($this->session->userdata('login') == 'yes') {
            return true;
        } else {
            return false;
        }
    }
    
    function set_title_pure($title, $admin = false)
    {
        if (isset($_GET["title"]))
        {
            if ($admin == false)
                echo '<script>document.title = "User Panel - ' . $title . '"</script>';
            else
                echo '<script>document.title = "Admin Panel - ' . $title . '"</script>';
        }
    }

    function getIp()
    { 
          
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) { 
            return $_SERVER['HTTP_CLIENT_IP']; 
        } 
        else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { 
            return $_SERVER['HTTP_X_FORWARDED_FOR']; 
        } 
        else { 
            return $_SERVER['REMOTE_ADDR']; 
        } 
    } 

    function getOS()
    { 

        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        $os_platform  = "unknown";

        $os_array     = array(
                              '/windows nt 10/i'      =>  'Windows',
                              '/windows nt 6.3/i'     =>  'Windows',
                              '/windows nt 6.2/i'     =>  'Windows',
                              '/windows nt 6.1/i'     =>  'Windows',
                              '/windows nt 6.0/i'     =>  'Windows',
                              '/windows nt 5.2/i'     =>  'Windows',
                              '/windows nt 5.1/i'     =>  'Windows',
                              '/windows xp/i'         =>  'Windows',
                              '/windows nt 5.0/i'     =>  'Windows',
                              '/windows me/i'         =>  'Windows',
                              '/win98/i'              =>  'Windows',
                              '/win95/i'              =>  'Windows',
                              '/win16/i'              =>  'Windows',
                              '/macintosh|mac os x/i' =>  'Mac',
                              '/mac_powerpc/i'        =>  'Mac',
                              '/linux/i'              =>  'Linux',
                              '/ubuntu/i'             =>  'Ubuntu',
                              '/iphone/i'             =>  'iPhone',
                              '/ipod/i'               =>  'iPod',
                              '/ipad/i'               =>  'iPad',
                              '/android/i'            =>  'Android',
                              '/blackberry/i'         =>  'BlackBerry',
                              '/webos/i'              =>  'Mobile'
                        );

        foreach ($os_array as $regex => $value)
            if (preg_match($regex, $user_agent))
                $os_platform = $value;

        return $os_platform;
    }


}