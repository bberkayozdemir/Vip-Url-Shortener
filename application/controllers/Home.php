<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('string');
        $this->load->helper('url');
        $this->load->model("functions_model");
        $this->load->model("shortener_model");
        $this->load->model("chart_model");
    }
	
    public function index()
    {
        if (isset($_POST["url"]))
        {
            echo $this->shortener_model->shorten_url($this->input->post("url"));
            return;
        }

        $page_data["clicks_all"] = $this->chart_model->clicks("all", null, null, true);
        $page_data["registers_all"] = $this->chart_model->registered_users("all", null, null, true);
        $page_data["created_urls_all"] = $this->chart_model->created_urls("all", null, null, true);

        $this->load->view("front/index", $page_data);
    }
}
