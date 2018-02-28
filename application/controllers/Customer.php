<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller
{
    
    public function list()
	{
        $this->load->helper('url');

        if (null == $this->session->userdata('member-id'))
            redirect();
        else
            $session = true;

        $this->load->library('layout');

        $data = array(
            'banner' => array(
				'session'         => $session,
                'url_deconnexion' => site_url(array('homePage', 'deconnexion')),
                'firstname'       => $this->session->userdata('firstname'),
                'lastname'        => $this->session->userdata('firstname'),
            ),
            'menu'   => array(
                'url_add_book' => site_url(array('customer', 'displayAddBook')),
                'url_list' => site_url(array('customer', 'list')),
            ),
        );

        $this->layout->view('list', $data, array('banner', 'menu'));
    }

    public function displayAddBook()
    {
        $this->load->helper('url');
        $this->load->library('form_validation');

        if (null == $this->session->userdata('member-id'))
            redirect();
        else
            $session = true;

        $this->load->library('layout');

        $data = array(
            'url_add_book' => site_url(array('customer', 'addBook')),
            'banner' => array(
				'session'         => $session,
                'url_deconnexion' => site_url(array('homePage', 'deconnexion')),
                'firstname'       => $this->session->userdata('firstname'),
                'lastname'        => $this->session->userdata('firstname'),
            ),
            'menu'   => array(
                'url_add_book' => site_url(array('customer', 'displayAddBook')),
                'url_list' => site_url(array('customer', 'list')),
            ),
        );

        $this->layout->view('add_book', $data, array('banner', 'menu'));
    }

    public function addBook()
    {
        $this->load->helper('url');

        if (null == $this->session->userdata('member-id'))
            redirect();
        else
            $session = true;

        $this->load->library('layout');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('isbn', '"ISBN"', 'required|min_length[10]|max_length[10]');

        if ($this->form_validation->run())
		{
            $this->load->model('book_model', 'bookManager');

            $this->bookManager->setBookInfo($this->input->post('isbn'));

            redirect('customer/displayAddBook');
        }
    }
}