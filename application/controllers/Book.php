<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Book extends CI_Controller
{
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
            'url_add_book'    => site_url(array('book', 'displayAddBook')),
            'url_list'        => site_url(array('book', 'list')),
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