<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Layout
{
	private $CI;
    private $var   = array();
    private $theme = 'default';
	
    public function __construct()
    {
        $this->CI =& get_instance();
        
        $this->var['output']      = '';
        $this->var['banner']      = '';
        $this->var['menu']        = '';
        
        //	Le titre est composé du nom de la méthode et du nom du contrôleur
        //	La fonction ucfirst permet d'ajouter une majuscule
        $this->var['titre'] = ucfirst($this->CI->router->fetch_method()) . ' - ' . ucfirst($this->CI->router->fetch_class());
        
        //	Nous initialisons la variable $charset avec la même valeur que
        //	la clé de configuration initialisée dans le fichier config.php
        $this->var['charset'] = $this->CI->config->item('charset');

        $this->var['css'] = array();
        $this->var['js'] = array();
    }
    
    /**
     * Charge le theme
     * 
     * @params $theme Theme du site 
     * 
     * @returns Boolean
     */
    public function setTheme($theme)
    {
        if(is_string($theme) AND !empty($theme) AND file_exists('./app/themes/' . $theme . '.php'))
        {
            $this->theme = $theme;

            return true;
        }

        return false;
    }

    /**
     * Charge le titre de la page
     * 
     * @params $titre 
     * 
     * @returns Boolean
     */
    public function setTitle($titre)
    {
        if(is_string($titre) AND !empty($titre))
        {
            $this->var['titre'] = $titre;
            return true;
        }
        return false;
    }

    /**
     * Charge le charset
     * 
     * @params $charset 
     * 
     * @returns Boolean
     */
    public function setCharset($charset)
    {
        if(is_string($charset) AND !empty($charset))
        {
            $this->var['charset'] = $charset;
            return true;
        }
        return false;
    }

    /**
     * Charge le CSS dans la variable 
     * 
     * @params $nom Nom du CSS
     * 
     * @returns Boolean
     */
    public function addCss($nom)
    {
        if(is_string($nom) AND !empty($nom) AND file_exists('./assets/css/' . $nom . '.css'))
        {
            $this->var['css'][] = css_url($nom);

            return true;
        }

        return false;
    }

    /**
     * Charge le JS dans la variable 
     * 
     * @params $nom Nom du js
     * 
     * @returns Boolean
     */
    public function addJs($nom)
    {
        if(is_string($nom) AND !empty($nom) AND file_exists('./assets/js/' . $nom . '.js'))
        {
            $this->var['js'][] = js_url($nom);

            return true;
        }

        return false;
    }

    /**
     * Affiche toutes les vues
     * 
     * @params $name Nom de la vue principale
     * @params $data Tableau avec les valeurs pour les vues
     * @params $loadViews Toutes les vues à charger (ex: menu, ...)
     */
	public function view($name, $data=array(), $loadViews=array())
	{
        $this->addCss('bootstrap.min');
        $this->addCss('style');
        $this->addCss('annotations');
        $this->addCss('main');
        $this->addCss('normalize');
        $this->addCss('popup');
        $this->addCss('easy-autocomplete.min');
        $this->addCss('easy-autocomplete.theme.min');
        $this->addJs('jquery.min');
        $this->addJs('bootstrap.min');
        $this->addJs('jquery.easy-autocomplete.min');
        $this->addJs('epub.min');
        $this->addJs('reader.min');
        $this->addJs('highlight');
        $this->addJs('hooks.min');
        $this->addJs('screenfull.min');
        $this->addJs('zip.min');
        $this->addJs('ajax');
        $this->addJs('style');
        $this->addJs('plugins/hypothesis');
        $this->addJs('plugins/search');

        foreach ($loadViews as $load)
        {
            if ($load == 'menu') {
                $this->loadMenu($data[$load]);
            }
            else if ($load == 'banner') {
                $this->loadBanner($data[$load]);
            }
            else {
                $this->views($load, $data[$load]);
            }
        }
        

		$this->var['output'] .= $this->CI->load->view($name, $data, true);

        $this->CI->load->view('../themes/' . $this->theme, $this->var);
	}
    
    /**
     * Charge une vue dans la variable output.
     * 
     * @params $name Nom de la vue
     * @params $data Tableau pour la vue 
     */
	public function views($name, $data=array())
	{
		$this->var['output'] .= $this->CI->load->view($name, $data, true);
		return $this;
    }
    
    /**
     * Charge le menu et les css accompagnant
     * 
     * @params $data Tableau des infos pour le menu
     */
    public function loadMenu($data)
    {
        $this->addCss('bootstrap-theme.min');
        $this->addCss('menu');
 
        $this->var['menu'] .= $this->CI->load->view('menu', $data, true);
        return $this;
    }

    /**
     * Charge la bannière et le css accompagnant
     * 
     * @params $data Tableau des infos pour la bannière
     */
    public function loadBanner($data)
    {
        $this->addJs('jquery.autocomplete');
        $this->addCss('banner');
        $this->addCss('jquery.autocomplete');
        $this->var['banner'] .= $this->CI->load->view('banner', $data, true);
        return $this;
    }

    public function getOutput()
    {
        return $this->var['output'];
    }
}