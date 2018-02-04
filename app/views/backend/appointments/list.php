 <div class="row">
       <div class="col-lg-12">
            <h1><?=$header?><small> <?=$small?></small></h1>
            <ol class="breadcrumb">
              <li><a href="<?=base_url()?>cmspanel/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
              <li class="active"><?=$breadcrumb?></li>
            </ol>
          </div>
 </div><!-- /.row -->

       <div class="row">
          <div class="col-lg-12">
          <?php
		  if($this->session->flashdata('message')){
			   echo '<div id="message" style="display:none;" class="alert alert-dismissable alert-success">
              			<button data-dismiss="alert" class="close" type="button">×</button>
              		'.$this->session->flashdata('message').'
            		</div>';
			   }
		  ?>
            <div class="table-responsive">
              <table id="cms-rates" class="table table-bordered table-hover table-striped tablesorter">
                <tr>           
				<td>Name</td>
                <td>Email</td>
                <td>Phone</td>                
                <td>Company Name</td>                                
	          	<td>Actions</td>           
                </tr>
                
                <?php
				$this->load->helper('text');
				if($results->num_rows() > 0)
				{
					$i=0;						
					foreach ($results->result() as $row)
					{						
					 echo '
						<tr>
						<td>'.$row->name.'</td>
						<td>'.$row->email.'</td>
						<td>'.$row->phone.'</td>
						<td>'.$row->company.'</td>						
						<td class="text-center">
						<a href="'.base_url().$this->config->item('backend_controller').$controller.'/view_details/'.$row->aid.'"><span class="label label-default">View</span></a>
						<a href="'.base_url().$this->config->item('backend_controller').$controller.'/delete/'.$row->aid.'" onClick="return confirm(\'Do you want to delete this entry? Deletion is permanent.\')" title="Delete Appointment"><span class="label label-danger">Delete</span></a>
						</td>
						</tr>
                  		';
						$i++;
					}
				}
				?>
                  
                
              </table>
             
            </div>
          </div>
    </div><!-- Row-->