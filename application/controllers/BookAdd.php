<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BookAdd extends CI_Controller
{
    public function displayAddBook()
    {
        $this->load->helper('url');
        $this->load->library('form_validation');

        if (null == $this->session->userdata('member-id'))
            redirect();
        else
            $session = true;

        $this->load->library('layout');

        //$this->session->set_userdata('isbn', '225313483X');
        if ($isbn = $this->session->userdata('isbn'))
        {
            $this->load->model('book_model', 'bookManager');

            $dataBook = get_object_vars($this->bookManager->getBook($isbn));

            $dataBook['isDescription'] = $this->bookManager->isDescription($dataBook['id_book']);

            $dataBook['hasEbook'] = false;
            $dataBook['page']     = 'mon_enregistrement_de_livre';
            $dataBook['banner']   = array(
                'session'         => $session,
                'url_deconnexion' => site_url(array('homePage', 'deconnexion')),
                'firstname'       => $this->session->userdata('firstname'),
                'lastname'        => $this->session->userdata('firstname'),
                'url_add_book'    => site_url(array('bookAdd', 'displayAddBook')),
                'url_list'        => site_url(array('bookList', 'list')),
            );
            $dataBook['menu'] = array(
                'url_add_book' => site_url(array('bookAdd', 'displayAddBook')),
                'url_list' => site_url(array('bookList', 'list')),
            );
            
            $data = array('url_add_book' => site_url(array('bookAdd', 'addBook')));

            $this->layout->setTitle('Enregistrer un livre');
            $this->layout->views('add_book', $data)->view('book_page', $dataBook, array('banner', 'menu'));
            $this->session->unset_userdata('isbn');
        }
        else
        {
            $data = array(
                'url_add_book' => site_url(array('bookAdd', 'addBook')),
                'banner' => array(
                    'session'         => $session,
                    'url_deconnexion' => site_url(array('homePage', 'deconnexion')),
                    'firstname'       => $this->session->userdata('firstname'),
                    'lastname'        => $this->session->userdata('firstname'),
                    'url_add_book'    => site_url(array('bookAdd', 'displayAddBook')),
                    'url_list'        => site_url(array('bookList', 'list')),
                ),
                'menu'   => array(
                    'url_add_book' => site_url(array('bookAdd', 'displayAddBook')),
                    'url_list' => site_url(array('bookList', 'list')),
                ),
            );

            $this->layout->view('add_book', $data, array('banner', 'menu'));
        }
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

            $this->bookManager->setBookInfo($this->input->post('isbn'), $_FILES);

            $this->session->set_userdata('isbn', $this->input->post('isbn'));
            redirect('bookAdd/displayAddBook');
        }
    }
}