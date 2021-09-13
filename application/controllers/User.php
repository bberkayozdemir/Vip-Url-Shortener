<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('string');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model("functions_model");
        $this->load->model("shortener_model");
        $this->load->model("chart_model");
        
        if ($this->functions_model->check_login() == false) {
            if (isset($_GET["pure"]))
                redirect(base_url()."login?pure");
            else
                redirect(base_url()."login");
            return;
        }
    }
	
    public function index()
    {
        $page_data["page_name"] = "home";
        $page_data["page_title"] = "Dashboard";
        $page_data["top_clicked_urls"] = $this->chart_model->top_clicked_urls();
        if (isset($_GET["pure"])){
            $this->load->view("back/user/".$page_data["page_name"], $page_data);
            $this->functions_model->set_title_pure($page_data["page_title"]);
        }
        else
            $this->load->view("back/user/index", $page_data);
    }
    
    public function get_chart_data($time = null, $id = null)
    {
        if (empty($time)){
            echo "no_data";
            return;
        }
        if ($id !== null)
            $this->db->where("id", $id);
        $this->db->where("user", $this->session->userdata('user_id'));
        $urlquery = $this->db->get("shorten_urls");

        if ($urlquery !== false && $urlquery->num_rows() > 0)
        {
            $return_data = array();

            $cchart_time = $time;
            if ($time == "all")
                $cchart_time = "yearly";

            $return_data["click_chart"] = $this->chart_model->click_chart($cchart_time, $id);
            $return_data["clicks"] = $this->chart_model->clicks($time, $id);
            $return_data["os"] = $this->chart_model->pie("os", $time, $id);
            $return_data["browser"] = $this->chart_model->pie("browser", $time, $id);
            $return_data["device"] = $this->chart_model->pie("device", $time, $id);
            $return_data["location"] = $this->chart_model->location($time, $id);

            echo json_encode($return_data);
        }
        else
            echo "no_data";
    }

    public function url_list($page = 1, $q = "")
    {
        //$query = $this->db->order_by("id", "DESC")->get_where("shorten_urls", array("user" => $this->session->userdata('user_id')));

        if ($q !== ""){
            $q = filter_var($q, FILTER_SANITIZE_STRING);
            $this->db->where("CONCAT(url, ' ', description) like '%".$q."%'");
        }

        $totalrows = $this->db->where("user", $this->session->userdata('user_id'))->count_all_results("shorten_urls");

        if ($totalrows > 0)
        {
            $rowsperpage = 10;
            $totalpages = ceil($totalrows / $rowsperpage);

            if ($page > $totalpages)
               $page = $totalpages;

            if ($page < 1) 
               $page = 1;

            $offset = ($page - 1) * $rowsperpage;

            if ($q !== "")
                $this->db->where("CONCAT(url, ' ', description) like '%".$q."%'");

            $query = $this->db->order_by("id", "DESC")->where("user", $this->session->userdata('user_id'))->get("shorten_urls", $rowsperpage, $offset);

            $page_data["url_list"] = $query->result_array();

            $pgrange = 3;
            $pg = "";
            if ($page > 1) {
               $pg .= '<li class="page-item"><a'; 
               if ($q !== ""){ $pg .= ' search="'.$q.'"' ;}
               $pg .=' page="1" class="page-link" href="#"><i class="fas fa-angle-double-left"></i></a></li> ';
               $prevpage = $page - 1;
               $pg .= '<li class="page-item"><a';
               if ($q !== ""){ $pg .= ' search="'.$q.'"' ;}
               $pg .=' page="'.$prevpage.'" class="page-link" href="#"><i class="fas fa-angle-left"></i></a></li> ';
            }
            else{
                $pg .= '<li class="page-item disabled"><a';
                if ($q !== ""){ $pg .= ' search="'.$q.'"' ;}
                $pg.=' page="active" class="page-link" href="#"><i class="fas fa-angle-double-left"></i></a></li> ';
                $pg .= '<li class="page-item disabled"><a ';
                if ($q !== ""){ $pg .= ' search="'.$q.'"' ;}
                $pg .=' page="active" class="page-link" href="#"><i class="fas fa-angle-left"></i></a></li> ';
            }

            for ($x = ($page - $pgrange); $x < (($page + $pgrange) + 1); $x++) {
               if (($x > 0) && ($x <= $totalpages)) {
                  if ($x == $page){
                     $pg .= ' <li class="page-item active"><a ';
                     if ($q !== ""){ $pg .= ' search="'.$q.'"' ;}
                     $pg.=' page="active" class="page-link" href="#">'.$x.'</a></li> ';
                  }else{
                     $pg .= ' <li class="page-item"><a';
                     if ($q !== ""){ $pg .= ' search="'.$q.'"' ;}
                     $pg .=' page="'.$x.'" class="page-link" href="#">'.$x.'</a></li> ';
                }
               }
            }

            if ($page != $totalpages) {
               $nextpage = $page + 1;
               $pg .= '<li class="page-item"><a';
               if ($q !== ""){ $pg .= ' search="'.$q.'"' ;}
               $pg.=' page="'.$nextpage.'" class="page-link" href="#"><i class="fas fa-angle-right"></i></a></li> ';
               $pg .= '<li class="page-item"><a';
               if ($q !== ""){ $pg .= ' search="'.$q.'"' ;}
               $pg .=' page="'.$totalpages.'" class="page-link" href="#"><i class="fas fa-angle-double-right"></i></a></li> ';
            } 
            else{
                $pg .= '<li class="page-item disabled"><a';
                if ($q !== ""){ $pg .= ' search="'.$q.'"' ;}
                $pg .=' page="active" class="page-link" href="#"><i class="fas fa-angle-right"></i></a></li> ';
               $pg .= '<li class="page-item disabled"><a';
               if ($q !== ""){ $pg .= ' search="'.$q.'"' ;}
               $pg.= ' page="active" class="page-link" href="#"><i class="fas fa-angle-double-right"></i></a></li> ';
            }

            $page_data["pagination"] = $pg;
        }
        else
            $page_data["url_list"] = array();

        $this->load->view("back/user/url_list", $page_data);
    }

    public function urls($url_id = null, $action = null)
    {
        if ($url_id == null)
        {
            $page_data["page_name"] = "urls";
            $page_data["page_title"] = "Urls";

            if (isset($_GET["pure"])){
                $this->load->view("back/user/".$page_data["page_name"], $page_data);
                $this->functions_model->set_title_pure($page_data["page_title"]);
            }
            else
                $this->load->view("back/user/index", $page_data);
        }
        else
        {
            if (!is_numeric($url_id)){
                show_404();
                return;
            }
            
            $query = $this->db->get_where("shorten_urls", array("user" => $this->session->userdata('user_id'), "id" => $url_id));
            if ($query !== false && $query->num_rows() > 0)
            {
                if ($action == null)//view
                {
                    $page_data["url_data"] = $query->row();

                    $page_data["page_name"] = "url_view";
                    if ($query->row()->description !== null)
                        $page_data["page_title"] = "Url View:" . $query->row()->description;
                    else
                        $page_data["page_title"] = "Url View";

                    if (isset($_GET["pure"])){
                        $this->load->view("back/user/".$page_data["page_name"], $page_data);
                        $this->functions_model->set_title_pure($page_data["page_title"]);
                    }
                    else
                        $this->load->view("back/user/index", $page_data);
                }
                elseif ($action == "edit")
                {
                    $page_data["page_name"] = "url_edit";
                    $page_data["url_data"] = $query->row();
                    $this->load->view("back/user/".$page_data["page_name"], $page_data);
                }
                elseif ($action == "update")
                {
                    echo $this->shortener_model->update_url($query->row());
                }
                elseif ($action == "update-status")
                {
                    $this->db->where("id", $query->row()->id);
                    $this->db->where("user", $query->row()->user);
                    if ($query->row()->status == 0)
                        $data["status"] = 1;
                    else
                        $data["status"] = 0;
                    $query = $this->db->update("shorten_urls", $data);
                    if ($query !== false)
                        echo "success";
                    else
                        echo "error";
                }
                elseif ($action == "delete")
                {
                    $this->db->where("user", $query->row()->user);
                    $this->db->where("url", $query->row()->id)->delete("log");
                    $this->db->where("id", $query->row()->id);
                    $this->db->where("user", $query->row()->user);
                    $query = $this->db->delete("shorten_urls");
                    if ($query !== false)
                        echo "success";
                    else
                        echo "error";
                }
            }
            else
            {
                show_404();
                return;
            }
        }
    }
    
    public function shorten_url()
    {
        if (!isset($_POST["url"]))
        {
            echo "no_data";
            return;
        }
        
        if (empty(trim($_POST["url"])))
        {
            echo "no_url";
            return;
        }
        
        $advanced = array(
            "name" => "",
            "description" => "",
            "expire_date" => "",
            "password" => ""
        );
        
        if (isset($_POST["alias"])){
            $alias = trim($this->input->post("alias"));
            if (!empty($alias))
            if (preg_match("/[^A-Za-z0-9]/", $alias)){
                echo 'bad_alias';
                return;
            }
            
            $advanced["name"] = $alias;
        }
        if (isset($_POST["description"])) $advanced["description"] = htmlspecialchars($this->input->post("description"));
        if (isset($_POST["expire_date"])) $advanced["expire_date"] = $this->input->post("expire_date");
        if (isset($_POST["password"])) $advanced["password"] = $this->input->post("password");

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

        echo $this->shortener_model->shorten_url($this->input->post("url"), $this->session->userdata('user_id'), $advanced, $loctargeting, $devicetargeting);
    }

    public function settings()
    {
        $query = $this->db->get_where("users", array("id" => $this->session->userdata('user_id')));

        if (isset($_POST["email"]))
        {
            if (empty($_POST["email"]) || empty($_POST["username"]))
            {
                echo "empty";
                return;
            }

            if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
                echo "bad_email";
                return;
            }

            if (preg_match("/[^A-Za-z0-9]/", $_POST["username"])){
                echo 'bad_username';
                return;
            }

            if ($query->row()->email !== $this->input->post("email")){
                $cq = $this->db->get_where("users", array("email" => $this->input->post("email")));
                if ($cq !== false && $cq->num_rows() > 0)
                {
                    echo "email_taken";
                    return;
                }
            }

            $data = array(
                "email" => $this->input->post("email"),
                "name" => $this->input->post("username")
            );
            $this->db->where("id", $this->session->userdata('user_id'));
            $query = $this->db->update("users", $data);
            if($query !== false){
                echo "success";
            } else {
                echo "error";
            }

            return;
        }

        if (isset($_POST["cur_pw"]))
        {
            if (empty($_POST["cur_pw"]) || empty($_POST["new_pw"] || empty($_POST["con_pw"])))
            {
                echo "empty";
                return;
            }

            if ($query->row()->password !== sha1($this->input->post("cur_pw")))
            {
                echo "bad_cur_pw";
                return;
            }

            if ($this->input->post("new_pw") !== $this->input->post("con_pw"))
            {
                echo "bad_confirm";
                return;
            }

            if (strlen($this->input->post("new_pw")) < 5)
            {
                echo "short";
                return;
            }

            $data["password"] = sha1($this->input->post("new_pw"));

            $this->db->where("id", $this->session->userdata('user_id'));
            $query = $this->db->update("users", $data);
            if($query !== false){
                echo "success";
            } else {
                echo "error";
            }

            return;
        }

        $page_data["user"] = $query->row();
        $page_data["page_name"] = "settings";
        $page_data["page_title"] = "Settings";
        if (isset($_GET["pure"])){
            $this->load->view("back/user/".$page_data["page_name"], $page_data);
            $this->functions_model->set_title_pure($page_data["page_title"]);
        }
        else
            $this->load->view("back/user/index", $page_data);
    }

    public function login()
    {
        if ($this->functions_model->check_login()) {
            redirect(base_url()."user");
            return;
        }
    }
    
    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url(), 'refresh');
    }
    
}
