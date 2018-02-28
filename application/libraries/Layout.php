<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Layout
{
	private $CI;
    private $var   = array();
    private $theme = 'default';
	
    public function __construct()
    {
        $this->CI =& get_instance();
        
        $this->var['output'] = '';
        
        //	Le titre est composé du nom de la méthode et du nom du contrôleur
        //	La fonction ucfirst permet d'ajouter une majuscule
        $this->var['titre'] = ucfirst($this->CI->router->fetch_method()) . ' - ' . ucfirst($this->CI->router->fetch_class());
        
        //	Nous initialisons la variable $charset avec la même valeur que
        //	la clé de configuration initialisée dans le fichier config.php
        $this->var['charset'] = $this->CI->config->item('charset');

        $this->var['css'] = array();
        $this->var['js'] = array();
    }
    
    public function setTheme($theme)
    {
        if(is_string($theme) AND !empty($theme) AND file_exists('./app/themes/' . $theme . '.php'))
        {
            $this->theme = $theme;

            return true;
        }

        return false;
    }

    public function setTitle($titre)
    {
        if(is_string($titre) AND !empty($titre))
        {
            $this->var['titre'] = $titre;
            return true;
        }
        return false;
    }

    public function setCharset($charset)
    {
        if(is_string($charset) AND !empty($charset))
        {
            $this->var['charset'] = $charset;
            return true;
        }
        return false;
    }

    public function addCss($nom)
    {
        if(is_string($nom) AND !empty($nom) AND file_exists('./assets/css/' . $nom . '.css'))
        {
            $this->var['css'][] = css_url($nom);

            return true;
        }

        return false;
    }

    public function addJs($nom)
    {
        if(is_string($nom) AND !empty($nom) AND file_exists('./assets/js/' . $nom . '.js'))
        {
            $this->var['js'][] = js_url($nom);

            return true;
        }

        return false;
    }

	public function view($name, $data=array(), $loadViews=array())
	{
        $this->addCss('bootstrap.min');
		
        $this->addJs('bootstrap.min');
		$this->addJs('jquery-1.11.2.min');
        
        foreach ($loadViews as $load)
        {
            if ($load == 'menu')
                $this->loadMenu($data[$load]);
            else if ($load == 'banner')
                $this->loadBanner($data[$load]);
            else
            {
                $this->views($load, $data[$load]);
            }
        }
        

		$this->var['output'] .= $this->CI->load->view($name, $data, true);

        $this->CI->load->view('../themes/' . $this->theme, $this->var);
	}
	
	public function views($name, $data=array())
	{
		$this->var['output'] .= $this->CI->load->view($name, $data, true);
		return $this;
    }
    
    public function loadMenu($data)
    {
        $this->addCss('bootstrap-theme.min');
        $this->addCss('menu');
        $this->addJs('npm');
        $this->views('menu', $data);
    }

    public function loadBanner($data)
    {
        $this->addCss('banner');
        $this->views('banner', $data);
    }
}