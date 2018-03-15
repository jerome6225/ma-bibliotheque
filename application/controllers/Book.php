<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Book extends CI_Controller
{
    /**
     * Affiche la liste des ebooks du customer
     */
    public function list()
	{
        $this->load->helper('url');

        if (null == $this->session->userdata('member-id'))
            redirect();
        else
            $session = true;

        $this->load->library('layout');
        $this->load->model('book_model', 'bookManager');

        $dataBooks = $this->bookManager->getBooks($this->session->userdata('member-id'));

        $data = array(
            'books' => $dataBooks,
            'banner' => array(
				'session'         => $session,
                'url_deconnexion' => site_url(array('homePage', 'deconnexion')),
                'firstname'       => $this->session->userdata('firstname'),
                'lastname'        => $this->session->userdata('firstname'),
            ),
            'menu'   => array(
                'url_add_book' => site_url(array('book', 'displayAddBook')),
                'url_list' => site_url(array('book', 'list')),
            ),
        );

        $this->layout->setTitle('Mes livres');
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

        //$this->session->set_userdata('isbn', '225313483X');
        if ($isbn = $this->session->userdata('isbn'))
        {
            $this->load->model('book_model', 'bookManager');

            $dataBook = get_object_vars($this->bookManager->getBook($isbn));
            $dataBook['hasEbook'] = false;
            $dataBook['page']     = 'mon_enregistrement_de_livre';
            $dataBook['banner']   = array(
                'session'         => $session,
                'url_deconnexion' => site_url(array('homePage', 'deconnexion')),
                'firstname'       => $this->session->userdata('firstname'),
                'lastname'        => $this->session->userdata('firstname'),
            );
            $dataBook['menu'] = array(
                'url_add_book' => site_url(array('book', 'displayAddBook')),
                'url_list' => site_url(array('book', 'list')),
            );
            
            $data = array('url_add_book' => site_url(array('book', 'addBook')));

            $this->layout->setTitle('Enregistrer un livre');
            $this->layout->views('add_book', $data)->view('book_page', $dataBook, array('banner', 'menu'));
            $this->session->unset_userdata('isbn');
        }
        else
        {
            $data = array(
                'url_add_book' => site_url(array('book', 'addBook')),
                'banner' => array(
                    'session'         => $session,
                    'url_deconnexion' => site_url(array('homePage', 'deconnexion')),
                    'firstname'       => $this->session->userdata('firstname'),
                    'lastname'        => $this->session->userdata('firstname'),
                ),
                'menu'   => array(
                    'url_add_book' => site_url(array('book', 'displayAddBook')),
                    'url_list' => site_url(array('book', 'list')),
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
            redirect('book/displayAddBook');
        }
    }

    public function displayBook()
	{
        $this->load->helper('url');

        if (null == $this->session->userdata('member-id'))
            redirect();
        else
            $session = true;

        $this->load->library('layout');
        $this->load->model('book_model', 'bookManager');

        $ext                   = '';
        $customerBook          = $this->bookManager->getCustomerBook($this->session->userdata('member-id'), $this->uri->segment(3));
        $dataBook              = get_object_vars($this->bookManager->getBookById($this->uri->segment(3)));
        $name                  = str_replace(' ', '_', $dataBook['title']);
        $dataBook['urlEbook']  = '';
        $dataBook['nameEbook'] = '';

        if ($customerBook->ext != '')
        {
            $ext = $this->bookManager->getFormatEbook($customerBook->ext);

            if (file_exists('./assets/ebooks/'.$name.'.'.$ext))
            {
                $dataBook['urlEbook']  = site_url(array('book', 'downloadEbook', $name, $ext));
                $dataBook['nameEbook'] = $name.'.'.$ext;

            }
        }

        $dataBook['hasEbook'] = $customerBook->ebook;
        $dataBook['page']     = 'mon_livre';
        $dataBook['banner']   = array(
            'session'         => $session,
            'url_deconnexion' => site_url(array('homePage', 'deconnexion')),
            'firstname'       => $this->session->userdata('firstname'),
            'lastname'        => $this->session->userdata('firstname'),
        );

        $dataBook['menu'] = array(
            'url_add_book' => site_url(array('book', 'displayAddBook')),
            'url_list' => site_url(array('book', 'list')),
        );

        $this->layout->setTitle($dataBook['title']);
        $this->layout->view('book_page', $dataBook, array('banner', 'menu'));
    }

    public function downloadEbook()
    {
        $file = $this->uri->segment(3).'.'.$this->uri->segment(4);
        $filesize = filesize(_DIR_EBOOK_.$file);
        
        header('Content-Type: application/octet-stream');
        header('Cache-Control: no-store, no-cache');
        header('Content-Disposition: attachment; filename="'.$file.'"');
        header('Content-Length: '.$filesize);
        readfile(_DIR_EBOOK_.$file);
    }
}