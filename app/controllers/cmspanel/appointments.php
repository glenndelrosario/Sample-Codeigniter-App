<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Appointments extends Admin_Controller {

	function __construct()
	{
		parent::__construct();
		$this->controller = 'appointments';	
		$this->load->library('security');
		$this->load->library('pagination');
		$this->load->library('tank_auth');
		$this->lang->load('tank_auth');
	}
	
	function index()
	{
		$data['webtitle'] = 'Appointments';
		$data['controller'] = $this->controller;
		$data['header'] = 'Appointments';
		$data['small'] = 'Overview of Prospects';
		$data['breadcrumb'] = '<i class="fa fa-calendar"></i> Appointments';
		
		$config['base_url'] = base_url().$this->config->item('backend_controller').$this->controller.'/index/';
		$config['uri_segment'] = 5;
		$config['per_page'] = 15;
		$config['full_tag_open'] = '<p>';
		$config['full_tag_close'] = '</p>';
		$config['cur_tag_open'] = '<b>';
		$config['cur_tag_close'] = '</b>';
		$config['next_link'] = 'next';
		$config['prev_link'] = 'prev';
		$config['page_query_string'] = FALSE;
		$config['num_links'] = 10;	
		
		$this->db->from('appointments');
		$config['total_rows'] =  $this->db->count_all_results();
			
  		$page = $this->uri->segment(5);

		$limit= array('start'=>$config['per_page'],
    				  'end'=>$page
    					);
    	$this->pagination->initialize($config);
		
		/* START NUMBERING OF PAGES (TOTAL RESULT AND CURRENT RESULT PAGE) */
		$data['total_pages'] = $config['total_rows'];
		$data['current_page'] = $page + 1;
		if(($page != '') || ($page != 0)){
			if(intval($config['total_rows'] / $page) == 1){ $data['current_number'] = $config['total_rows']; }
			else{ $data['current_number'] = $page != '' ? ($page + 15) : $config['per_page'];}
		}else{ $data['current_number'] = $page != '' ? ($page + 15) : $config['per_page']; }
    	/* END OF NUMBERING OF PAGES */
				
		$data['pagination_links'] = $this->pagination->create_links();
		
		$this->db->limit($limit['start'], $limit['end']);
		$query = $this->db->get('appointments');				
	  	
		$data['results'] = $query;
		$this->_displayPage('backend/appointments/list',$data);
	
	}	
	
	public function acknowledge($id='')
	{
		if(ctype_digit($id))
		{
			$values['acknowledged'] = 1;
			$this->db->where('aid',$id); 
			$this->db->update('appointments',$values);
			
			$message = 'Please see <strong>Appointments</strong> for details and further actions.';			
			$this->session->set_flashdata('message', $message);
			
			redirect(base_url().'cmspanel/dashboard/');
		}
	}
	
	public function delete($id='')
	{
		if(ctype_digit($id))
		{
			$this->db->where('aid',$id); 
			$this->db->delete('appointments');
			
			$message = 'Entry has been successfully deleted.';			
			$this->session->set_flashdata('message', $message);
			
			redirect(base_url().'cmspanel/'.$this->controller);
		}
	}
	
	public function reply($id='')
	{
		if(ctype_digit($id))
		{
					
			$data['webtitle'] = 'Appointments';
			$data['controller'] = $this->controller;
			$data['header'] = 'Appointments';
			$data['small'] = 'Replying to Prospects';
			$data['breadcrumb'] = '<i class="fa fa-calendar"></i> Appointments';
			
			$this->db->where('aid',$id);
			$query = $this->db->get('appointments');				
			if($query->num_rows() == 1)
			{
				foreach ($query->result() as $row)
				{	
					$data['email'] = $row->email;
					$data['name'] = $row->name;
					$data['id'] = $row->aid;
				}
			}
			
			$this->_displayPage('backend/appointments/reply',$data);
		
		}
	}
	
	public function send_reply()
	{
		if($_POST)
		{			
			$this->load->library('form_validation');	
			$this->form_validation->set_rules('email', 'Email Address', 'trim|required|xss_clean|valid_email');			
			$this->form_validation->set_rules('subject', 'Subject', 'trim|required|xss_clean');
			$this->form_validation->set_rules('message', 'Message', 'trim|required|xss_clean');			
			$this->form_validation->set_error_delimiters('<div class="alert alert-dismissable alert-danger">', '</div>');
			
			if ($this->form_validation->run() == FALSE)
			{
			
			}
			else
			{							
				$this->load->library('email');
				$config['mailtype'] = 'html';
				$config['wordwrap'] = TRUE;
				$email = $this->input->post('email',TRUE);
				$subject = $this->input->post('subject',TRUE);
				$id = $this->input->post('id',TRUE);
				$data['message'] = $this->input->post('message',TRUE);
				$this->db->where('setting_name','email_settings');
				$query = $this->db->get('settings');
				
				if($query->num_rows() > 0)
				{
					foreach ($query->result() as $row)
					{
						$reply_to = $row->setting_value;						
					}
				}
		
				$this->email->initialize($config);
		
				$this->email->from($reply_to, $this->config->item('website_name', 'tank_auth'));
				$this->email->reply_to($reply_to, $this->config->item('website_name', 'tank_auth'));
				$this->email->to($email);
				$this->email->subject($subject);
				$this->email->message($this->load->view('backend/emails/reply', $data, TRUE));
				$this->email->send();
				
				$message = 'Reply has been successfully sent.';			
				$this->session->set_flashdata('message', $message);
				redirect(base_url().'cmspanel/appointments/reply/'.$id);
			}
		}
		else
		{
			redirect(base_url().'cmspanel/appointments/');
		}
	}
	
	public function view_details($id='')
	{
		$data['webtitle'] = 'Appointments';
		$data['controller'] = $this->controller;
		$data['header'] = 'Appointments';
		$data['small'] = 'Viewing Details';
		$data['breadcrumb'] = '<i class="fa fa-calendar"></i> Appointments';	
		
		$this->db->where('aid',$id);
		$data['results'] = $this->db->get('appointments');		
		
		$this->_displayPage('backend/appointments/details',$data);
	}
	
}
/* End of file Appointments.php */