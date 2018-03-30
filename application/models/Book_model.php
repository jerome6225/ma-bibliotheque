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
    public function setBookInfo($isbn, $files)
    {
        $this->load->database();

        // si le livre n'est pas dans la BDD
        if (!$this->getBook($isbn))
        {
            $this->getBookFromUrl($isbn);
        }

        if (null != $this->session->userdata('member-id'))
        {
            $book  = $this->getBook($isbn);

            if ($book) {
                $ebook = false;
                $idExt = '';
                /**
                 * Enregistrement de l'ebook si il n'existe pas 
                 */
                if ($files['book']['name'] != '')
                {
                    $expl  = explode('.', $files['book']['name']);
                    $ext   = end($expl);
                    $name  = str_replace(' ', '_', $book->title);
                    $idExt = $this->getIdFormatEbook($ext);
                    if (!file_exists('./assets/ebooks/'.$name.'.'.$ext))
                    {
                        if (!move_uploaded_file($files['book']['tmp_name'], './assets/ebooks/'.$name.'.'.$ext))
                        {
                            return false;
                        }
                        
                        $this->addEbook($book->id_book, $idExt);
                    }
                        
                    $ebook = true;
                }
                $this->addBookToCustomer($this->session->userdata('member-id'), $book->id_book, $ebook, $idExt);
            }
        }
    }

    /**
     * indique si un ebook est téléchargé pour ce livre
     * 
     * @params $idBook Id du livre
     * 
     * @params $idExt Id de l'extension du livre
     */
    public function addEbook($idBook, $idExt)
    {
        return $this->db->set('id_book', $idBook)
            ->set('id_ebook_format', $idExt)
            ->insert('book_ebook_format');
    }

    /**
     * Retourne l'id du format de l'ebook
     * 
     * @params $ext extension du livre
     * 
     * @returns l'id de l'extension de l'ebook
     */
    public function getIdFormatEbook($ext)
    {
        $result = $this->db->select('id_ebook_format')
            ->from('ebook_format')
            ->where('format', $ext)
            ->get()
            ->result();
        
        return (count($result) > 0) ? $result[0]->id_ebook_format : false;
    }

    /**
     * Retourne le format de l'ebook
     * 
     * @params $idExt Id de l'extension du livre
     * 
     * @returns l'extension de l'ebook
     */
    public function getFormatEbook($idExt)
    {
        $result = $this->db->select('format')
            ->from('ebook_format')
            ->where('id_ebook_format', $idExt)
            ->get()
            ->result();
        
        return (count($result) > 0) ? $result[0]->format : false;
    }

    /**
     * Associe un livre et un utilisateur
     * 
     * @params $customer Id du customer
     * 
     * @params $idBook Id du livre
     */
    public function addBookToCustomer($customer, $idBook, $ebook, $idExt)
    {
        $result = $this->db->select('*')
            ->from('customer_book')
            ->where('id_customer', $customer)
            ->where('id_book', $idBook)
            ->get()
            ->result();

        if (!$result)
        {
            return $this->db->set('id_customer', $customer)
                ->set('id_book', $idBook)
                ->set('ebook', $ebook)
                ->set('ext', $idExt)
                ->insert('customer_book');
        }
        else
        {
            return $this->db->set('ebook', $ebook)
                ->set('ext', $idExt)
                ->where('id_customer', $customer)
                ->where('id_book', $idBook)
                ->update('customer_book');
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

        return (count($result) > 0) ? $result[0] : false;
    }

    /**
     * Récupère les infos du livre en BDD
     * 
     * @params $idBook Id du livre
     * 
     * @returns les infos du livre
     */
    public function getBookById($idBook)
    {
        $result = $this->db->select('*')
            ->from($this->table)
            ->where('id_book', $idBook)
            ->get()
            ->result();

        return (count($result) > 0) ? $result[0] : false;
    }

    /**
     * Récupère les infos des livres en BDD
     * 
     * @params $idCustomer Id du customer
     * 
     * @returns les infos des livres
     */
    public function getBooks($idCustomer)
    {
        $books = array();
        $result = $this->db->select('*')
            ->from('customer_book')
            ->where('id_customer', $idCustomer)
            ->get()
            ->result();

        if (count($result) > 0)
        {
            foreach ($result as $k => $r)
            {
                $b = $this->db->select('*')
                ->from($this->table)
                ->where('id_book', $r->id_book)
                ->get()
                ->result();

                $books[$k] = get_object_vars($b[0]);
                $books[$k]['ebook'] = $r->ebook;
            }
        }

        return $books;
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

    /**
     * Récupère les infos customer book
     * Sert pour savoir si un customer possède l'ebook
     * 
     * @params $idCustomer Id du customer
     * 
     * @params $idBook Id du livre
     * 
     * @returns customer_book
     */
    public function getCustomerBook($idCustomer, $idBook)
    {
        $result = $this->db->select('*')
            ->from('customer_book')
            ->where('id_customer', $idCustomer)
            ->where('id_book', $idBook)
            ->get()
            ->result();

        return (count($result) > 0) ? $result[0] : false;
    }
    

    /**
     * Récupère les infos des livres en BDD
     * 
     * @params $idCustomer Id du customer
     * 
     * @returns les infos des livres
     */
    public function getBooksByGenre($idCustomer, $genre)
    {
        $books = array();
        $result = $this->db->select('*')
            ->from('customer_book')
            ->where('id_customer', $idCustomer)
            ->get()
            ->result();

        if (count($result) > 0) {
            foreach ($result as $k => $r) {
                $b = $this->db->select('*')
                ->from($this->table)
                ->where('id_book', $r->id_book)
                ->where('genre', trim($genre))
                ->get()
                ->result();

                if (count($b) > 0) {
                    $books[$k] = get_object_vars($b[0]);
                    $books[$k]['ebook'] = $r->ebook;
                }
            }
        }

        return $books;
    }

    /**
     * Recherche les informations suivant la variable
     * 
     * @params $search Mot à chercher
     * 
     * @returns 
     */
    public function getBooksSearch($search)
    {
        if (isset($search)) {
            return $this->db->select('* FROM `book` 
                WHERE CONCAT_WS( "~", COALESCE(`isbn`, ""), COALESCE(`author`, ""), COALESCE(`title`, ""), COALESCE(`genre`, ""))
                LIKE "%'.$search.'%"')
                ->get()
                ->result();
        }
        else {
            return false;
        }
    }

    /**
     * Vérifie si la valeur est bien un ISBN
     * 
     * @params $isbn valeur à vérifier
     * 
     * @returns integer or false
     */
    function isIsbn($isbn)
    {
        $regex = '/\b(?:ISBN(?:: ?| ))?((?:97[89])?\d{9}[\dx])\b/i';

        if (preg_match($regex, str_replace('-', '', $isbn), $matches)) {
            return (10 === strlen($matches[1])) ? 1 : false;
        }
        return false;
    }

    /**
     * Récupère les info du livre 
     */
    public function getBookFromUrl($isbn)
    {
        $this->load->database();

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
        $genre  = array();
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
                        foreach ($words as $word) {
                            if (strpos($domAuthor->textContent, $word)) {
                                $notWord = false;
                            }
                        }

                        if ($notWord)
                            $author .= $domAuthor->textContent.',';
                    }
                }
            }
        }

        $c = 0;
        // Element genre
        foreach ($page->getElementsByTagName('div') as $div) {
            if ($div->getAttribute('id') == "wayfinding-breadcrumbs_feature_div") {
                foreach ($div->getElementsByTagName('li') as $li) {
                    foreach ($li->getElementsByTagName('a') as $a) {
                        if ($a->getAttribute('class') == "a-link-normal a-color-tertiary") {
                                $genre[] = trim($a->textContent);
                        }
                    }    
                }
            }
        }

        $genre = ($genre) ? end($genre) : '';
        $author = ($author) ? substr($author, 0, -1) : '';


        if ($title) {
            $this->setBook($isbn, $title, $genre, $author, $imgUrl);
        }
    }

    public function setDescription($idBook, $description)
    {
        return $this->db->set('resume',  $description)
            ->set('date_upd', 'NOW()', false)
            ->where('id_book', $idBook)
            ->update($this->table);
    }

    public function isDescription($idBook)
    {
        $result = $this->db->select('resume')
            ->from($this->table)
            ->where('id_book', $idBook)
            ->get()
            ->result();

        if ($result[0]->resume == NULL) {
            return 0;
        }

        return 1;
    }
}