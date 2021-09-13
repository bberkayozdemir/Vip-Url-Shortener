<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Page_control extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('string');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library("mobiledetect");
        $this->load->library("browser");
        $this->load->model("functions_model");
        $this->load->model("shortener_model");
    }
	
    public function index()
    {
        show_404();
    }

    public function page_control()
    {
        switch ($this->uri->segment(1))
        {
            case "login":
                if (!isset($_GET["pure"]))
                    $this->login();
                else
                    echo 'Your session ended please login again <a href="'.base_url().'login">'.base_url().'login</a>';
                return;
                break;
            case "register":
                $this->register();
                return;
                break;
            default :
                break;
        }
        
        $redirect = $this->shortener_model->search($this->uri->segment(1));
        if ($redirect == "non")
            show_404();
    }
    
    public function login()
    {
        if ($this->functions_model->check_login()) {
            redirect(base_url()."user");
            return;
        }
        
        if (isset($_POST["login"]))
        {
            if (!isset($_POST["email"]) || !isset($_POST["password"]) || empty($_POST["email"]) || empty($_POST["password"]))
            {
                $this->load->view("front/login", array("error" => ""));
                return;
            }
            
            $data["email"] = $this->input->post("email");
            $data["password"] = sha1($this->input->post("password"));
            
            $query = $this->db->get_where("users", array(
                "email" => $data["email"],
                "password" => $data["password"]
            ));
            
            if ($query !== false && $query->num_rows() > 0)
            {
                if ($query->row()->status == "0" && $query->row()->user_type !== "admin"){
                    $this->load->view("front/login", array("error1" => ""));
                    return;
                }

                $this->session->set_userdata('login', 'yes');
                $this->session->set_userdata('user_id', $query->row()->id);
                $this->session->set_userdata('user_email', $query->row()->email);
                $this->session->set_userdata('user_name', $query->row()->name);
                if ($query->row()->user_type == "admin")
                {
                    $this->session->set_userdata('admin_login', 'yes');
                }
                redirect(base_url()."user");
                return;
            }
            else{
                $this->load->view("front/login", array("error" => ""));
                return;
            }
        }
        else
        {
            $this->load->view("front/login");
        }
    }

    public function register()
    {
        if ($this->functions_model->check_login()) {
            redirect(base_url()."user");
            return;
        }

        if (isset($_POST["register"]))
        {
            $data = array(
                "email" => $this->input->post("email"),
                "name" => $this->input->post("username")
            );

            if (empty($_POST["email"]) || empty($_POST["username"]) || empty($_POST["password"]) || empty($_POST["repeat_password"]))
            {
                $data["error"] = "";
                $this->load->view("front/register", $data);
                return;
            }

            if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
                $data["error2"] = "";
                $this->load->view("front/register", $data);
                return;
            }

            if (preg_match("/[^A-Za-z0-9]/", $_POST["username"])){
                $data["error4"] = "";
                $this->load->view("front/register", $data);
                return;
            }

            if ($this->input->post("password") !== $this->input->post("repeat_password"))
            {
                $data["error3"] = "";
                $this->load->view("front/register", $data);
                return;
            }

            if (strlen($this->input->post("password")) < 5)
            {
                $data["error5"] = "";
                $this->load->view("front/register", $data);
                return;
            }

            $cq = $this->db->get_where("users", array("email" => $this->input->post("email")));
            if ($cq !== false && $cq->num_rows() > 0)
            {
                $data["error1"] = "";
                $this->load->view("front/register", $data);
                return;
            }

            $data["password"] = sha1($this->input->post("new_pw"));

            $this->db->insert("users", $data);

            if ($this->db->affected_rows() > 0)
            {
                $query = $this->db->get_where("users", array("email" => $this->input->post("email")));

                if ($query !== false && $query->num_rows() > 0){

                    $this->session->set_userdata('login', 'yes');
                    $this->session->set_userdata('user_id', $query->row()->id);
                    $this->session->set_userdata('user_email', $query->row()->email);
                    $this->session->set_userdata('user_name', $query->row()->name);

                    redirect(base_url()."user");
                }else
                    redirect(base_url()."login");
                return;
            }
            else{
                $data["error0"] = "";
                $this->load->view("front/register", $data);
                return;
            }
        }
        else
        {
            $this->load->view("front/register");
        }
    }
}
