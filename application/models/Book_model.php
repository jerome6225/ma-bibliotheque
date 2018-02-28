<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Book_model extends CI_Model
{
    protected $table = 'book';

    /**
     * Récupère les infos du livre si non présent en BDD
     * 
     * @params $isbn isbn du livre
     * 
     * @returns Infos du livre
     */
    public function setBookInfo($isbn)
    {
        $this->load->database();

        // si le livre n'est pas dans la BDD
        if (!$this->getBook($isbn))
        {
            // Récupération des informations sur la page Amazon
            $url = 'https://www.amazon.fr/gp/product/'.$isbn.'/';
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_USERAGENT, '');
            
            $resultat = curl_exec ($ch);
            curl_close($ch);

            // Parcours de la page HTML
            $page = new DOMDocument();
            @$page->loadHTML($resultat);

            $title  = '';
            $author = '';
            $imgUrl = '';
            $words  = array('Amazon', 'recherche', 'Auteurs');

            // Element url de l'image
            foreach ($page->getElementsByTagName('img') as $img){
                if ($img->getAttribute('id') == "imgBlkFront"){
                    $element = explode('"', $img->getAttribute('data-a-dynamic-image'));
                    $imgUrl  = $element[1];
                }
            }

            // Element title
            foreach ($page->getElementsByTagName('span') as $span){
                if ($span->getAttribute('id') == "productTitle"){
                    $title = $span->textContent;
                }
            }

            // Element Auteur
            foreach ($page->getElementsByTagName('div') as $div){
                if ($div->getAttribute('id') == "byline"){
                    foreach ($div->getElementsByTagName('a') as $domAuthor){
                        if ($domAuthor->getAttribute('href') != "#" && $domAuthor->getAttribute('href') != "javascript:void(0)"){
                            $notWord = true;

                            // On vérifie les mots interdits
                            foreach ($words as $word)
                            {
                                if (strpos($domAuthor->textContent, $word))
                                {
                                    $notWord = false;
                                }
                            }

                            if ($notWord)
                                $author .= $domAuthor->textContent.',';
                        }
                    }
                }
            }

            // Element genre
            foreach ($page->getElementsByTagName('div') as $div) {
                if ($div->getAttribute('id') == "detail_bullets_id") {
                    foreach ($div->getElementsByTagName('li') as $li){
                        if (stristr($li->nodeValue, 'Collection'))
                        {
                            $expl  = explode(':', $li->nodeValue);
                            $genre = trim($expl[1]);
                        }
                            
                    }
                }
            }
            
            $author = substr($author, 0, -1);
            $this->setBook($isbn, $title, $genre, $author, $imgUrl);
        }

        if (null != $this->session->userdata('member-id'))
        {
            $book = $this->getBook($isbn);

            $this->addBookToCustomer($this->session->userdata('member-id'), $book->id_book);
        }
    }

    /**
     * Associe un livre et un utilisateur
     * 
     * @params $customer Id du customer
     * 
     * @params $idBook Id du livre
     */
    public function addBookToCustomer($customer, $idBook)
    {
        $result = $this->db->select('*')
            ->from('customer_book')
            ->where('id_customer', $customer)
            ->where('id_book',   $idBook)
            ->get()
            ->result();

        if (!$result)
        {
            return $this->db->set('id_customer',  $customer)
                ->set('id_book',   $idBook)
                ->insert('customer_book');
        }
    }
    /**
     * Récupère les infos du livre en BDD
     * 
     * @params $isbn isbn du livre
     * 
     * @returns les infos du livre
     */
    public function getBook($isbn)
    {
        $result = $this->db->select('*')
            ->from($this->table)
            ->where('isbn', $isbn)
            ->get()
            ->result();

        return $result[0];
    }

    /**
     * Enregistre les infos du livre en BDD
     * 
     * @params $isbn   isbn du livre
     * @params $title  titre du livre
     * @params $author auteur du livre
     * @params $imgUrl url de l'image du livre
     * 
     * @returns boolean
     */
    public function setBook($isbn, $title, $genre, $author, $imgUrl)
    {
        return $this->db->set('isbn',  $isbn)
            ->set('title',   $title)
            ->set('genre', $genre)
            ->set('author',  $author)
            ->set('img_url',  $imgUrl)
            ->set('date_add', 'NOW()', false)
            ->set('date_upd', 'NOW()', false)
            ->insert($this->table);
    }
}