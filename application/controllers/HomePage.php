<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HomePage extends CI_Controller
{
	public function __construct()
    {
        parent::__construct();
	}
	
	/**
	 * Index Page for this controller.
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		//$this->session->sess_destroy();

		$session = false;
		//  Chargement des bibliothèques
		$this->load->library('layout');
		$this->load->library('form_validation');
		$this->load->helper('url');
	
		//  Le formulaire est invalide ou vide
		if (null != $this->session->userdata('member-id'))
			$session = true;

		$data = array(
			'email'      => $this->input->post('email'),
			'password'   => $this->input->post('password'),
			'url_login'  => site_url(array('homePage', 'login')),
			'url_create' => site_url(array('homePage', 'create')),
			'banner'     => array(
				'session'         => $session,
				'url_deconnexion' => site_url(array('homePage', 'deconnexion')),
				'firstname'       => $this->session->userdata('firstname'),
                'lastname'        => $this->session->userdata('firstname'),
			),
		);

		$this->loadForm($data, array('banner'));
	}

	public function loadForm($data, $views)
	{
		$this->layout->view('home_page', $data, $views);
	}

	public function login()
	{
		$this->load->library('layout');
		$this->load->helper('url');

		$data = array(
			'mail'     => $this->input->post('mail'),
			'password' => $this->input->post('password'),
		);

		$this->load->model('customer_model', 'customerManager');

		// On verifie si le customer existe et on créé la session
		if ($customer = $this->customerManager->isCustomerExist($data))
		{
			$this->session->set_userdata('member-id', $customer->id_customer);
			$this->session->set_userdata('firstname', $customer->firstname);
			$this->session->set_userdata('lastname', $customer->lastname);

			redirect('customer/list');
		}
		else
		{
			$data['error']['error_text'] = 'Erreur Email ou Mot de passe';

			$this->loadForm($data, array('banner', 'error'));
		}
	}

	public function create()
	{
		$this->load->library('layout');
		$this->load->library('form_validation');
		$this->load->helper('url');

		// On vérifie si les paramètres saisies sont bon
		$this->form_validation->set_rules('mail', '"E-mail"', 'required|valid_email|is_unique[customer.mail]');
		$this->form_validation->set_rules('password', '"Mot de passe"', 'trim|required|min_length[5]|max_length[52]|alpha_dash|encode_php_tags');
		
		if ($this->form_validation->run())
		{
			$data = array(
				'firstname' => $this->input->post('firstname'),
				'lastname'  => $this->input->post('lastname'),
				'mail'      => $this->input->post('mail'),
				'password'  => md5($this->input->post('password')),
				'date_add'  => date('Y-m-d H:i:s'),
				'date_upd'  => date('Y-m-d H:i:s'),
			);

			$this->load->model('customer_model', 'customerManager');

			// si la création c'est bien passé on créé la session
			if ($this->customerManager->addCustomer($data))
			{
				$customerData = array(
					'mail'     => $this->input->post('mail'),
					'password' => $this->input->post('password'),
				);

				$customer = $this->customerManager->isCustomerExist($customerData);

				$this->session->set_userdata('member-id', $customer->id_customer);
				$this->session->set_userdata('firstname', $customer->firstname);
				$this->session->set_userdata('lastname', $customer->lastname);

				redirect('customer/list');
			}
			else
			{
				$data['error']['error_text'] = 'Erreur Lors de la création du compte';

				$this->loadForm($data, array('banner', 'error'));
			}
		}
		else
		{
			$data['error']['error_text'] = 'Cet email existe déjà';

			$this->loadForm($data, array('banner', 'error'));
		}
	}

	public function deconnexion()
	{
		//  Détruit la session
		$this->session->sess_destroy();

		//  Redirige vers la page d'accueil
		redirect();
	}
}
