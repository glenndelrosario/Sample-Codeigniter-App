<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends Admin_Controller {

	function __construct()
	{
		parent::__construct();	
	}

	function index()
	{
		$data['webtitle'] = 'Dashboard';
		
		$this->db->limit('10');
		$this->db->where('acknowledged',0);
		$this->db->order_by('date_submitted','DESC');
		$data['results'] = $this->db->get('appointments');
		
		$this->_displayPage('backend/dashboard',$data);
		
	}
}

/* End of file dashboard.php */