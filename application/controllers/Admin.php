<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

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

        if ($this->functions_model->check_admin_login() == false){
            show_404();
            return;
        }
    }
	
    public function index()
    {
        $page_data["clicks_all"] = $this->chart_model->clicks("all", null, null, true);
        $page_data["clicks_today"] = $this->chart_model->clicks("today", null, null, true);
        $page_data["registers_all"] = $this->chart_model->registered_users("all", null, null, true);
        $page_data["registers_today"] = $this->chart_model->registered_users("today", null, null, true);
        $page_data["created_urls_all"] = $this->chart_model->created_urls("all", null, null, true);
        $page_data["created_urls_today"] = $this->chart_model->created_urls("today", null, null, true);

        $page_data["page_name"] = "home";
        $page_data["page_title"] = "Dashboard";

        if (isset($_GET["pure"])){
            $this->load->view("back/admin/".$page_data["page_name"], $page_data);
            $this->functions_model->set_title_pure($page_data["page_title"], true);
        }
        else
            $this->load->view("back/admin/index", $page_data);
    }

    public function url_list($page = 1, $q = "")
    {
        if ($q !== ""){
            $q = filter_var($q, FILTER_SANITIZE_STRING);
            $this->db->where("CONCAT(url, ' ', description) like '%".$q."%'");
        }

        if (isset($_GET["user"]))
            $this->db->where("user", $_GET["user"]);

        $totalrows = $this->db->count_all_results("shorten_urls");

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

            if (isset($_GET["user"]))
                $this->db->where("user", $_GET["user"]);

            $query = $this->db->order_by("id", "DESC")->get("shorten_urls", $rowsperpage, $offset);

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

        $this->load->view("back/admin/url_list", $page_data);
    }

    public function urls($url_id = null, $action = null)
    {
        if ($url_id == "user")
            goto list_urls;
        if ($url_id == null)
        {
            list_urls:
            $page_data["page_name"] = "urls";
            $page_data["page_title"] = "Urls";

            if ($url_id == "user")
            {
                $uquery = $this->db->where("id",  $action)->get("users");
                if ($uquery !== false && $uquery->num_rows() > 0) {
                    $page_data["only_user"] = $uquery->row()->id;
                    $page_data["user_data"] = $uquery->row();
                }
            }

            if (isset($_GET["pure"])){
                $this->load->view("back/admin/".$page_data["page_name"], $page_data);
                $this->functions_model->set_title_pure($page_data["page_title"], true);
            }
            else
                $this->load->view("back/admin/index", $page_data);
        }
        else
        {
            if (!is_numeric($url_id)){
                show_404();
                return;
            }

            $query = $this->db->get_where("shorten_urls", array("id" => $url_id));
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
                        $this->load->view("back/admin/".$page_data["page_name"], $page_data);
                        $this->functions_model->set_title_pure($page_data["page_title"], true);
                    }
                    else
                        $this->load->view("back/admin/index", $page_data);
                }
                elseif ($action == "edit")
                {
                    $page_data["page_name"] = "url_edit";
                    $page_data["url_data"] = $query->row();
                    $this->load->view("back/admin/".$page_data["page_name"], $page_data);
                }
                elseif ($action == "update")
                {
                    echo $this->shortener_model->update_url($query->row(), true);
                }
                elseif ($action == "update-status")
                {
                    $this->db->where("id", $query->row()->id);
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
                    $this->db->where("url", $query->row()->id)->delete("log");
                    $this->db->where("id", $query->row()->id);
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

    public function get_chart_data($time = null, $id = null, $user = null)
    {
        if (empty($time)){
            echo "no_data";
            return;
        }
        if ($id !== null && $user == null)
			
            $return_data = array();

            $cchart_time = $time;
            if ($time == "all")
                $cchart_time = "yearly";

            $return_data["click_chart"] = $this->chart_model->click_chart($cchart_time, $id, $user, true);
            $return_data["location"] = $this->chart_model->location($time, $id, $user, true);
            $return_data["clicks"] = $this->chart_model->clicks($time, $id, $user, true);
            $return_data["os"] = $this->chart_model->pie("os", $time, $id, $user, true);
            $return_data["browser"] = $this->chart_model->pie("browser", $time, $id, $user, true);
            $return_data["device"] = $this->chart_model->pie("device", $time, $id, $user, true);

            if (isset($_GET["hp"]))
            {
                $return_data["registers_chart"] = $this->chart_model->registered_users_chart($cchart_time);
                $return_data["created_urls_chart"] = $this->chart_model->created_urls_chart($cchart_time);
            }

            echo json_encode($return_data);

    }

    public function user_list($page = 1, $q = "")
    {
        if ($q !== ""){
            $q = filter_var($q, FILTER_SANITIZE_STRING);
            $this->db->where("CONCAT(name, ' ', email) like '%".$q."%'");
        }

        $totalrows = $this->db->count_all_results("users");

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
                $this->db->where("CONCAT(name, ' ', email) like '%".$q."%'");

            $query = $this->db->order_by("id", "DESC")->get("users", $rowsperpage, $offset);

            $page_data["user_list"] = $query->result_array();

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
            $page_data["user_list"] = array();

        for ($i = 0; $i < count($page_data["user_list"]); $i++)
        {
            $page_data["user_list"][$i]["views"] = $this->db->where("user", $page_data["user_list"][$i]["id"])->count_all_results("log");
            $page_data["user_list"][$i]["total_urls"] = $this->db->where("user", $page_data["user_list"][$i]["id"])->count_all_results("shorten_urls");
        }

        $this->load->view("back/admin/user_list", $page_data);
    }

    public function users($user_id = null, $action = null)
    {
        if ($user_id == null)
        {
            $page_data["page_name"] = "users";
            $page_data["page_title"] = "Users";

            if (isset($_GET["pure"])){
                $this->load->view("back/admin/".$page_data["page_name"], $page_data);
                $this->functions_model->set_title_pure($page_data["page_title"], true);
            }
            else
                $this->load->view("back/admin/index", $page_data);
        }
        else
        {
            if (!is_numeric($user_id)){
                show_404();
                return;
            }

            $query = $this->db->get_where("users", array("id" => $user_id));
            if ($query !== false && $query->num_rows() > 0)
            {
                if ($action == null)//user stats
                {
                    $page_data["user_data"] = $query->row();
                    $page_data["page_name"] = "user_stats";
                    $page_data["page_title"] = "User Url Statistics:";

                    if (isset($_GET["pure"])){
                        $this->load->view("back/admin/".$page_data["page_name"], $page_data);
                        $this->functions_model->set_title_pure($page_data["page_title"], true);
                    }
                    else
                        $this->load->view("back/admin/index", $page_data);
                }
                elseif ($action == "view")
                {
                    $page_data["user_data"] = $query->row();
                    $page_data["page_name"] = "user_view";
                    $this->load->view("back/admin/".$page_data["page_name"], $page_data);
                }
                elseif ($action == "edit")
                {
                    $page_data["page_name"] = "user_edit";
                    $page_data["user_data"] = $query->row();
                    $this->load->view("back/admin/".$page_data["page_name"], $page_data);
                }
                elseif ($action == "update")
                {
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

                        $data = array(
                            "email" => $this->input->post("email"),
                            "name" => $this->input->post("username")
                        );

                        if (!empty(trim($_POST["password"])))
                            $data["password"] = sha1($this->input->post("password"));

                        $this->db->where("id", $user_id);
                        $query = $this->db->update("users", $data);
                        if($query !== false){
                            echo "success";
                        } else {
                            echo "error";
                        }

                        return;
                    }
                }
                elseif ($action == "update-status")
                {
                    $this->db->where("id", $query->row()->id);
                    if ($query->row()->status == 0)
                        $data["status"] = 1;
                    else
                        $data["status"] = 0;
                    $query = $this->db->update("users", $data);
                    if ($query !== false)
                        echo "success";
                    else
                        echo "error";
                }
                elseif ($action == "delete")
                {
                    if ($query->row()->user_type == "admin")
                        return "error";

                    $this->db->where("user", $user_id)->delete("shorten_urls");
                    $this->db->where("user", $user_id)->delete("log");

                    $this->db->where("id", $query->row()->id);
                    $query = $this->db->delete("users");
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

        if (isset($_POST["duplicate_alias"])) {
            $da = $_POST["duplicate_alias"];
            $rnl = $_POST["random_name_length"];
            if (($da == true || $da == "true" || $da == false || $da == "false") == false) {
                echo "da_empty";
                return;
            }

            if (empty($rnl)) {
                echo "rnl_empty";
                return;
            }

            if (!is_numeric($rnl)){
                echo "rnl_not_numeric";
                return;
            }

            $a = $this->functions_model->set_setting("allow_duplicate_url_new_name", $da);
            $b = $this->functions_model->set_setting("random_name_length", $rnl);

            if ($a && $b)
                echo "success";
            else
                echo "error";

            return;
        }

        $page_data["user"] = $query->row();
        $page_data["page_name"] = "settings";
        $page_data["page_title"] = "Settings";
        if (isset($_GET["pure"])){
            $this->load->view("back/admin/".$page_data["page_name"], $page_data);
            $this->functions_model->set_title_pure($page_data["page_title"]);
        }
        else
            $this->load->view("back/admin/index", $page_data);
    }
    
    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url(), 'refresh');
    }
}
