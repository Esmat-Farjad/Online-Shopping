<?php
class My_model extends CI_Model{
    function userdata(){
        $this->load->database();
        $query=$this->db->query("select * from user_info where email=");
        return $query->result_array();
    }
    function canLogin($email,$password){
        // $this->db->where('email',$username);
        // $this->db->where('password',$password);
        // $query=$this->db->get('user_info');
        $query=$this->db->query("select * from user_info where email='".$email."' and password='".$password."'");
        if($query->num_rows()!=1)
            return false;
        else
            return true;

    }
    function canLoginAdmin($email,$password)
    {
        // $this->db->where('email',$username);
        // $this->db->where('password',$password);
        // $query=$this->db->get('user_info');
        $query=$this->db->query("select * from admin_info where admin_email='".$email."' and admin_password='".$password."'");
        if($query->num_rows()!=1)
            return false;
        else
            return true;
        
    }
    function getDataUser($email,$password)
    {
        $query=$this->db->query("select * from user_info where email='".$email."' and password='".$password."'");
        return $query->result_array();
    }
    function getDataadmin($email,$password)
    {
        $query=$this->db->query("select * from admin_info where admin_email='".$email."' and admin_password='".$password."'");
        return $query->result_array();
    }
    function add($data)
    {
        $this->db->insert('user_info',$data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }
    function searchResult($key)
    {
        // SELECT products.*, cat_title from products,categories WHERE products.product_cat=categories.cat_id
        $query=$this->db->query("select products.*, cat_title  from products,categories where products.product_cat=categories.cat_id and (product_title like '%".$key."%' or product_keywords like '%".$key."%')" );
        // echo $key;
        // echo '<pre>';
        // print_r($query->result_array());
        // echo '</pre>';
        
         return $query->result_array();
    }
    function retrieveProduct($id)
    {
        $query=$this->db->query("select * from products, brands, categories where brands.brand_id=products.product_brand and categories.cat_id=products.product_cat and products.product_id=$id");
        return $query->result_array();
    }
    function getDetails()
    {
        $query=$this->db->query("select products.*, cat_title  from products,categories where products.product_cat=categories.cat_id");
        return $query->result_array();
    }  
}
?>