<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Shortener_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    function url_check($url)
    {
        if(!preg_match('^(?:http(s)?:\/\/)?[\w.-]+(?:\.[\w\.-]+)+[\w\-\._~:/?#[\]@!\$&\'\(\)\*\+,;=.]+$^', $url))
            return "bad_url";
        
        if (!preg_match("~^(?:f|ht)tps?://~i", $url))
            $url = "http://".$url;
        
        return $url;
    }
            
    function shorten_url($url, $user = "", $advanced = "", $loctargeting = array(), $devicetargeting = array())
    {
        $check = $this->url_check($url);
        if ($check == "bad_url")
            return "bad_url";

        $url = $check;

        for ($i = 0; $i < count($loctargeting); $i++)
        {
            $loctargeting[$i]["url"] = $this->url_check($loctargeting[$i]["url"]);
            if ($loctargeting[$i]["url"] == "bad_url")
                return "bad_url_loc";
        }

        for ($i = 0; $i < count($devicetargeting); $i++)
        {
            $devicetargeting[$i]["url"] = $this->url_check($devicetargeting[$i]["url"]);
            if ($devicetargeting[$i]["url"] == "bad_url")
                return "bad_url_device";
        }
        
        if (empty($user))
        {
            $allow_duplicate = $this->functions_model->get_setting("allow_duplicate_url_new_name");
            if ($allow_duplicate == false)
                return "error";

            if ($allow_duplicate == "false")
            {
                $duplicate_name = $this->check_duplicate_url($url);
                if ($duplicate_name == false)
                    return $this->make_short($url, $user, $advanced);
                else
                    return "success".base_url() . $duplicate_name;
            }
        }

        return $this->make_short($url, $user, $advanced, $loctargeting, $devicetargeting);
    }

    function make_short($url, $user = "", $advanced = "", $loctargeting = array(), $devicetargeting = array())
    {
        $data = array();
        if ($advanced == "")
            $data["name"] = $this->generate_short_url_name();
        else
        {
            if (isset($advanced["name"])){
                if (empty(trim($advanced["name"])))
                    $data["name"] = $this->generate_short_url_name();
                else{
                    $data["name"] = trim($advanced["name"]);
                    $query = $this->db->get_where("shorten_urls", array("name" => $data["name"]));
                    if($query !== false && $query->num_rows() > 0)
                        return "name_exists";
                }
            }else
                $data["name"] = $this->generate_short_url_name();
            
            if (isset($advanced["description"])){
                if (!empty(trim($advanced["description"])))
                    $data["description"] = trim($advanced["description"]);
            }
            
            if (isset($advanced["expire_date"])){
                if (!empty(trim($advanced["expire_date"]))){
                    $date = DateTime::createFromFormat('m/d/Y', trim($advanced["expire_date"]));
                    $data["expire_date"] = $date->format("Y-m-d");
                }
            }
            
            if (isset($advanced["password"])){
                if (!empty(trim($advanced["password"])))
                    $data["password"] = trim($advanced["password"]);
            }
            
            
        }

        $data["url"] = $url;
        $data["user"] = $user;

        if ($user == "")
            $data["user"] = null;

        if (count($loctargeting) > 0)
            $data["locations"] = json_encode($loctargeting);

        if (count($devicetargeting) > 0)
            $data["devices"] = json_encode($devicetargeting);
        
        $this->db->insert("shorten_urls", $data);
        if ($this->db->affected_rows() > 0)
            return "success".base_url() . $data["name"];
        else
            return "error";
    }

    function check_duplicate_url($url)
    {
        $query = $this->db->get_where("shorten_urls", array("url" => $url));
        if($query !== false && $query->num_rows() > 0)
        {
            if (empty($query->row()->user))
                return $query->row()->name;
            else
                return false;
        }
        else
            return false;
    }
	
    function generate_short_url_name()
    {
            $random_type = $this->functions_model->get_setting("short_url_name_type");
            if ($random_type == false) $random_type = "alnum";

            $length = 7;
            $rlength = $this->functions_model->get_setting("random_name_length");
            if ($rlength !== false) {
                try {$length = intval($rlength);}catch (Exception $e){}
             }

            $name = random_string($random_type, 7);

            $banned_names = array("admin", "login", "user_panel");

            $query = $this->db->get_where("shorten_urls", array("name" => $name));
    if($query !== false && $query->num_rows() > 0)
        return $this->generate_short_url_name();
    else
        return $name;
    }

    function update_url($url_data, $admin = false)
    {
        if (!isset($_POST["url"]))
        {
            return "no_data";
        }
        
        if (empty(trim($_POST["url"])))
        {
            return "no_url";
        }
        
        $advanced = array(
            "name" => $url_data->name,
            "description" => $url_data->description,
            "expire_date" => $url_data->expire_date,
            "password" => $url_data->password
        );
        
        $is_name_changed = true;
        if ($url_data->name == trim($this->input->post("alias")))
            $is_name_changed = false;
        
        if ($is_name_changed == true){
            if (isset($_POST["alias"])){
                $alias = trim($this->input->post("alias"));
                if (!empty($alias))
                if (preg_match("/[^A-Za-z0-9]/", $alias)){
                    return 'bad_alias';
                }
            }
            
            $advanced["name"] = trim($this->input->post("alias"));
        }
        
        if (isset($_POST["description"])) $advanced["description"] = htmlspecialchars($this->input->post("description"));
        if (isset($_POST["expire_date"])){
            $advanced["expire_date"] = $this->input->post("expire_date");
            if (!empty(trim($advanced["expire_date"]))) {
                $date = DateTime::createFromFormat('m/d/Y', trim($advanced["expire_date"]));
                $advanced["expire_date"] = $date->format("Y-m-d");
            }else
                $advanced["expire_date"] = null;
        }
        if (isset($_POST["password"]))
            $advanced["password"] = $this->input->post("password");
        if (empty($advanced["password"]) && $advanced["password"] !== 0)
            $advanced["password"] = null;

        $check = $this->url_check($this->input->post("url"));
        if ($check == "bad_url")
            return "bad_url";

        $url = $check;

        $data = array(
            "url" => $url,
            "name" => $advanced["name"],
            "description" => $advanced["description"],
            "expire_date" => $advanced["expire_date"],
            "password" => $advanced["password"],
        );

        $loctargeting = array();

        if (isset($_POST["location"]) && isset($_POST["location_url"]))
        {
            for ($i = 0; $i < count($_POST["location"]); $i++)
            {
                $locurl = $_POST["location_url"][$i];
                $loc = $_POST["location"][$i];

                if ($loc == "0" || empty(trim($locurl)))
                    continue;

                array_push($loctargeting, array("location" => $loc, "url" => $locurl));
            }

        }

        $devicetargeting = array();

        if (isset($_POST["device"]) && isset($_POST["device_url"]))
        {
            for ($i = 0; $i < count($_POST["device"]); $i++)
            {
                $deviceurl = $_POST["device_url"][$i];
                $device = $_POST["device"][$i];

                if ($device == "0" || empty(trim($deviceurl)))
                    continue;

                array_push($devicetargeting, array("device" => $device, "url" => $deviceurl));
            }
        }
        
        if ($is_name_changed == true){
            $data["name"] = trim($advanced["name"]);
            $query = $this->db->get_where("shorten_urls", array("name" => $data["name"]));
            if($query !== false && $query->num_rows() > 0)
                return "name_exists";
        }

        for ($i = 0; $i < count($loctargeting); $i++)
        {
            $loctargeting[$i]["url"] = $this->url_check($loctargeting[$i]["url"]);
            if ($loctargeting[$i]["url"] == "bad_url")
                return "bad_url_loc";
        }

        for ($i = 0; $i < count($devicetargeting); $i++)
        {
            $devicetargeting[$i]["url"] = $this->url_check($devicetargeting[$i]["url"]);
            if ($devicetargeting[$i]["url"] == "bad_url")
                return "bad_url_device";
        }

        if (count($loctargeting) > 0)
            $data["locations"] = json_encode($loctargeting);

        if (count($devicetargeting) > 0)
            $data["devices"] = json_encode($devicetargeting);

        if (count($loctargeting) == 0)
            $data["locations"] = null;

        if (count($devicetargeting) == 0)
            $data["devices"] = null;

        $this->db->where("id", $url_data->id);
        if ($admin == false)
            $this->db->where("user", $this->session->userdata('user_id'));
        $query = $this->db->update("shorten_urls", $data);
        if($query !== false){
            return "success";
        } else {
            return "error";
        }
    }

    function search($name)
    {
        $query = $this->db->get_where("shorten_urls", array("name" => $name, "status" => "1"));
        if($query !== false && $query->num_rows() > 0)
        {

            if (!empty($query->row()->expire_date))
            {
                $expire = strtotime($query->row()->expire_date);
                $today = strtotime(date("Y-m-d"));

                if ($today >= $expire)
                {
                    show_404();
                    return;
                }
            }

            if ($query->row()->user !== null){
                $userquery = $this->db->get_where("users", array("id" => $query->row()->user, "status" => 0));
                if($userquery !== false && $userquery->num_rows() > 0)
                {
                    show_404();
                    return;
                }
            }

            $url = $query->row()->url;

            $ip = $this->functions_model->getIp();
            $ipdat = @json_decode(file_get_contents( "http://www.geoplugin.net/json.gp?ip=" . $ip)); 
            $country = $ipdat->geoplugin_countryCode;

            if ($this->mobiledetect->isMobile())
                $device = "Mobile";
            elseif ($this->mobiledetect->isTablet())
                $device = "Tablet";
            else
                $device = "Desktop";

            if ($query->row()->locations !== null)
            {
                $locs = json_decode($query->row()->locations, true);
                foreach ($locs as $row)
                {
                    if ($row["location"] == $country)
                    {
                        $url = $row["url"];
                        break;
                    }
                }
            }

            if ($query->row()->devices !== null && $url == $query->row()->url)
            {
                $devices = json_decode($query->row()->devices, true);

                foreach ($devices as $row)
                {
                    if ($row["device"] == "mobile" && $device == "Mobile")
                        $url = $row["url"];
                    elseif ($row["device"] == "tablet" && $device == "Tablet")
                        $url = $row["url"];
                    elseif ($row["device"] == "desktop" && $device == "Desktop")
                        $url = $row["url"];
                }
            }

            if (!empty($query->row()->password))
            {
                if (!isset($_POST["password"]))
                {
                    $this->load->view("front/unlock_link");
                    return;
                }

                if ($this->input->post("password") !== $query->row()->password)
                {
                    $this->load->view("front/unlock_link", array("error" => ""));
                    return;
                }
            }

            //log the click
            $checklog = $this->db->get_where("log", array("url" => $query->row()->id, "ip_address" => $ip));
            if($checklog->num_rows() == 0)
            {
                $logdata = array(
                    "date" => date('Y-m-d H:i:s'),
                    "url" => $query->row()->id,
                    "user" => $query->row()->user,
                    "browser" => $this->browser->getBrowser(),
                    "device" => $device,
                    "os" => $this->functions_model->getOs(),
                    "location" => $country,
                    "ip_address" => $ip
                );

                $this->db->insert("log", $logdata);
                $this->db->where("id", $query->row()->id)->update("shorten_urls", array("views" => $query->row()->views + 1));
            }

            redirect($url);
        }else
            return "non";
    }
	
}