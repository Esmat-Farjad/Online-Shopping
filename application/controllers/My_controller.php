<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class My_controller extends CI_Controller{
    function index()
    {
        // $this->load->model("my_model");
        // $this->load->helper("html");
        // $result['result']=$this->my_model->userdata();
        $this->load->helper('url');
        $this->load->model("my_model");
        $res['res']=$this->my_model->getDetails();
        $this->load->view("homepage",$res);

    }
    function login()
    {
        
        $this->load->helper('url'); 
        $this->load->view("login");
    }
    function validateLogin()
    {
        $this->load->helper('url'); 
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email1','email','required');
        $this->form_validation->set_rules('password','Password','required');
        if($this->form_validation->run())
        {
            $email=$this->input->post('email1');
            $password=md5($this->input->post('password'))   ;
            $this->load->model('My_model');
            if($this->My_model->canLogin($email,$password))
            {
                $sessionData=array(
                    'email'=>$email,
                    'password'=>$password
                );
                $result=$this->My_model->getDataUser($email,$password);
               
                $this->session->set_userdata($result[0]);
                print_r($_SESSION);
                if ($this->session->has_userdata('error'))
                    unset($_SESSION['error']);
                // echo $this->session->userdata('username');
            //$this->session->unset_userdata('username ');
                // unset(
                //     $_SESSION['result']
                // );
            // echo $this->session->userdata('username');
            // echo $this->session->userdata('password');
             redirect(base_url());    
            }
            else if($this->My_model->canLoginAdmin($email,$password))
            {
                // $sessionData=array(
                //     'email'=>$,
                //     'password'=>$password
                // );
                // $this->session->set_userdata($sessionData);
                $result=$this->My_model->getDataAdmin($email,$password);
                foreach($result[0] as $key=>$val)
                    setcookie($key,$val, time() + (86400 * 30),"/");


                if ($this->session->has_userdata('error'))
                    unset($_SESSION['error']);
                redirect(base_url()."admin/");  
            }
            else
            {
                $this->session->set_userdata("error","incorrect Password or username"); 
                redirect(base_url()."index.php/My_controller/login");
            }
                 
        }
        else
        {
            $this->login();
        }
    }
    function search2($key)
    {
        $this->load->helper('url'); 
        if($key=="t%20shirt")
            $key="t shirt";
        elseif($key=="Samsung%20mobile")
            $key="samsung mobile";
        // $key=$_POST['keyword'];
        $this->load->model('My_model');
        $result['result']=$this->My_model->searchResult($key);
        // $result['result2']=$this->My_model->suggstion($result['result'][0]['cat_title']);
        // echo '<pre>';
        // print_r($result);
        // echo '</pre>';
        $this->load->view('productView',$result);
    }
    function getProduct($id)
    {
        $this->load->helper('url');
        $this->load->model('My_model');
        $result['result']=$this->My_model->retrieveProduct($id);

        $this->load->view('buying',$result);
    }
    function search()
    {
        $this->load->helper('url'); 
        $key=$_POST['keyword'];
        $this->load->model('My_model');
        $result['result']=$this->My_model->searchResult($key);
        // $result['result2']=$this->My_model->suggstion($result['result'][0]['cat_title']);
        // echo '<pre>';
        // print_r($result);
        // echo '</pre>';
        $this->load->view('productView',$result);

    }
    function logout()
    {
        $this->load->helper('url');
        unset(
                $_SESSION['first_name'],
                $_SESSION['password'],
                $_SESSION['last_name'],
                $_SESSION['email'],
                $_SESSION['mobile']
                );
        redirect(base_url()); 
    }
    
    function addUser()
    {
        $this->load->helper('url'); 
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username','Username','required');
        $this->form_validation->set_rules('password','Password','required');
        
        // if($this->form_validation->run())
        // {
            $data=array(
                'first_name'=>$this->input->post('firstname'),
                'last_name'=>$this->input->post('lastname'),
                'password'=>md5($this->input->post('password1')),
                'email'=>$this->input->post('email'),
                'mobile'=>$this->input->post('phone')
            );
            print_r($data);
            $this->load->model('My_model');

            if($this->My_model->add($data))
            {
                $this->session->set_userdata($data);
                // print_r($_SESSION); 
                if ($this->session->has_userdata('error'))
                    unset($_SESSION['error']);
                redirect(base_url());
            }
            else
                echo "unsucessfull";

        // }
    }

    // checking login or not
    function checkLogin()
    {
        $this->addCart();
    }
    function addCart()
    {
        $this->load->view('shoppingCart');
    }



}
?>