<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('site_url'))
{
    function site_url($uri = '')
    {       
        if( ! is_array($uri))
        {
            //  Tous les paramètres sont insérés dans un tableau
            $uri = func_get_args();
        }

        //  On ne modifie rien ici
        $CI =& get_instance();  

        return $CI->config->site_url($uri);
    }
}

if ( ! function_exists('url'))
{
    function url($text, $uri = '')
    {
        if( ! is_array($uri))
        {
            //  Suppression de la variable $text
            $uri = func_get_args();

            array_shift($uri);
        }

        echo '<a href="' . site_url($uri) . '">' . htmlentities($text) . '</a>';

        return '';
    }
}

if ( ! function_exists('css_url'))
{
    function css_url($nom)
    {
        return base_url() . 'assets/css/' . $nom . '.css';
    }
}

if ( ! function_exists('js_url'))
{
    function js_url($nom)
    {
        return base_url() . 'assets/js/' . $nom . '.js';
    }
}

if ( ! function_exists('img_url'))
{
    function img_url($nom)
    {
        return base_url() . 'assets/img/' . $nom;
    }
}

if ( ! function_exists('img'))
{
    function img($nom, $alt = '')
    {
        return '<img src="' . img_url($nom) . '" alt="' . $alt . '" />';
    }
}