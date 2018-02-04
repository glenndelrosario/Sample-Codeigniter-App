<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Appointment extends Public_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{		
		$data['webtitle'] = 'Schedule Appointment';
		$data['contact'] = $this->_get_contact();
		
		$this->load->library('form_validation');
		//$this->form_validation->set_rules('category', 'Vehicle Category', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('type', 'Type', 'trim|required|xss_clean');
		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');		
		$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
		$this->form_validation->set_rules('phone', 'Contact No.', 'trim|required|xss_clean');
		$this->form_validation->set_rules('company', 'Company', 'trim|required|xss_clean');
		$this->form_validation->set_rules('message', 'Message', 'trim|required|xss_clean');
		$this->form_validation->set_rules('availability', 'Availability', 'trim|required|xss_clean');						
	    $this->form_validation->set_rules('preferred', 'Preferred Session', 'trim|required|xss_clean');	
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-dismissable alert-danger">', '</div>');

		
		if ($this->form_validation->run() == FALSE)
		{	
			$data['results']['contents'] = $this->load->view('frontend/modules/appointment',$data,TRUE);				
			$this->load->view('frontend/pages/template',$data);	
		}
		else
		{
			$values['type'] = $this->input->post('type');	
			$values['name'] = $this->input->post('name');
			$values['email'] = $this->input->post('email');
			$values['phone'] = $this->input->post('phone');
			$values['company'] = $this->input->post('company');
			$values['message'] = $this->input->post('message');	
			$values['availability'] = $this->input->post('availability');	
			$values['preferred'] = $this->input->post('preferred');	
			$values['date_submitted'] = date('Y-m-d H:i:s');
			
			$this->db->insert('appointments',$values);
			
			$data['results']['contents'] = '
			<div align="center" style="padding:50px 0px;">
			<h2>THANK YOU.</h2>
			<p>Your appointment request has been successfully submitted to us. We will get back to you on the confirmation of appointment.</p>

			</div>';
				
			$this->load->view('frontend/pages/template',$data);	
		}		
	}	
	
	private function _get_contact()
	{
		$this->db->where('page_url','contact-us');
		$query = $this->db->get('site_contents');
		
		if($query->num_rows() > 0)
		{
			$i=0;
			foreach($query->result() as $row)
			{
				$data['contents'][$i] = $row->contents;
				$i++;
			}		
			return $data;
		}
	}	
}
/* End of file work.php */
/* Location: ./application/controllers/work.php */