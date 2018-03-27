<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BookList extends CI_Controller
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
        $genres = array();
        foreach ($dataBooks as $book) {
            $genres[$book['genre']] = $book['genre'];
        }

        $data = array(
            'books'  => $dataBooks,
            'banner' => array(
				'session'   => $session,
                'firstname' => $this->session->userdata('firstname'),
                'lastname'  => $this->session->userdata('firstname'),
                'genres'    => $genres,
            ),
            'menu'   => array(
                'genres' => $genres,
            ),
        );

        $this->layout->setTitle('Mes livres');
        $this->layout->view('list', $data, array('banner', 'menu'));
    }

    /**
     * Appel AJAX pour l'affichage de la liste par genre
     * 
     * @returns $list Html de la list
     */
    public function ajaxList()
    {
        $this->load->library('layout');
        $this->load->model('book_model', 'bookManager');

        $genre      = $this->input->post('genre');
        $idCustomer = $this->session->userdata('member-id');

        if ($genre == '0')
            $dataBooks = $this->bookManager->getBooks($idCustomer);
        else
            $dataBooks = $this->bookManager->getBooksByGenre($idCustomer, $genre);
        
        $this->layout->views('listBooks', array('books' => $dataBooks));
        $list = $this->layout->getOutput();
        
        echo $list;
        die;
    }
}