<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BookSearch extends CI_Controller
{
    /**
     * Recherche Ajax pour l'autocompletion
     */
    public function ajaxSearch()
    {
        $this->load->model('book_model', 'bookManager');

        $books      = array();
        $search     = $this->input->get('search');
        $idCustomer = $this->session->userdata('member-id');
        $dataBooks  = $this->bookManager->getBooksSearch($search);
        
        $k = 0;
        foreach ($dataBooks as $data) {
            if (stripos($data->author, trim($search))) {
                $books['list'][$k]['name'] = $data->author;
                $k++;
            }
            if (stripos($data->title, trim($search))) {
                $books['list'][$k]['name'] = $data->title;
                $k++;
            }
            if (stripos($data->genre, trim($search))) {
                $books['list'][$k]['name'] = $data->genre;
                $k++;
            }
            
            if ($k > 7) {
                break;
            }
        }

        echo json_encode($books);
        die;
    }

    /**
     * Page Recherche
     */
    public function search()
    {
        $this->load->library('layout');
        $this->load->model('book_model', 'bookManager');

        if (null == $this->session->userdata('member-id'))
            redirect();
        else
            $session = true;

        $books      = array();
        $search     = $this->input->post('search');
        $idCustomer = $this->session->userdata('member-id');
        $dataBooks  = $this->bookManager->getBooksSearch($search);
        
        if (!$dataBooks) {
            $isIsbn = $this->bookManager->isIsbn($search);

            if ($isIsbn != false) {
                $this->bookManager->getBookFromUrl($search);
                $dataBooks[0] = $this->bookManager->getBook($search);
            }
        }

        /* Si plusieurs livre on affiche la page liste */
        if (count($dataBooks) > 1) {
            $genres = array();
            foreach ($dataBooks as &$book) {
                $book                   = get_object_vars($book);
                $ebook                  = $this->bookManager->getCustomerBook($idCustomer, $book['id_book']);
                $book['ebook']          = $ebook->ebook;
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
        /** sinon on affiche la fiche du livre */
        else {
            $dataBook              = get_object_vars($dataBooks[0]);
            $name                  = str_replace(' ', '_', $dataBook['title']);
            $customerBook          = $this->bookManager->getCustomerBook($idCustomer, $dataBook['id_book']);
            $dataBook['urlEbook']  = '';
            $dataBook['nameEbook'] = '';
            $dataBook['hasEbook']  = false;

            if ($customerBook) {
                if ($customerBook->ext != '') {
                    $ext = $this->bookManager->getFormatEbook($customerBook->ext);

                    if (file_exists('./assets/ebooks/'.$name.'.'.$ext))
                    {
                        $dataBook['urlEbook']  = site_url(array('book', 'downloadEbook', $name, $ext));
                        $dataBook['nameEbook'] = $name.'.'.$ext;
                    }
                }
                $dataBook['hasEbook'] = $customerBook->ebook;
            }
            
            $dataBook['page']   = 'mon_livre';
            $dataBook['banner'] = array(
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
    }
}