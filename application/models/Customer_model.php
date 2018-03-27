<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer_model extends CI_Model
{
    protected $table = 'customer';

    public function __construct()
    {
        $this->load->database();

        parent::__construct();
    }
    
    public function isCustomerExist($data)
    {
        $result = $this->db->select('*')
            ->from($this->table)
            ->where('mail', $data['mail'])
            ->where('password', md5($data['password']))
            ->get()
            ->result();

        return (count($result) > 0) ? $result[0] : false;
    }

    public function isEmailExist($email)
    {
        return $this->db->select('mail')
            ->from($this->table)
            ->where('mail', $email)
            ->get()
            ->result();
    }

    public function addCustomer($data)
    {
        return $this->db->insert($this->table, $data);
    }
}