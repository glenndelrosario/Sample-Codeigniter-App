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
                <?php
				if($results->num_rows() > 0)
				{						
					foreach ($results->result() as $row)
					{						
					 echo '
						<tr>
						<td width="200">Name:</td><td>'.$row->name.'</td>
						</tr>
						<tr>
					    <td>Email</td><td>'.$row->email.'</td>
						</tr>
						<tr>
						<td>Phone</td><td>'.$row->phone.'</td>
						</tr>
						<tr>
						<td>Company Name</td> <td>'.$row->company.'</td>												
						</tr>
						
						<tr>
						<td>Message</td> <td>'.$row->message.'</td>												
						</tr>
						<tr>
						<td>Availability</td> <td>'.$row->availability.'</td>												
						</tr>						
						<tr>
						<td>Preferred Session</td> <td>'.$row->preferred.'</td>												
						</tr>						
						<tr>
						<td>Date Submitted</td> <td>'.date("d F Y", strtotime($row->date_submitted)).'</td>												
						</tr>						
						
                  		';
						$aid = $row->aid;
					}
				}
				?>
                  
                
              </table>
              <p class="pull-left"><a href="<?=base_url()?>cmspanel/appointments/">Back To List</a></p>
              <div class="pull-right"><a href="<?=base_url()?>cmspanel/appointments/reply/<?=$aid?>" class="btn btn-success">Reply</a> &nbsp; <a href="<?=base_url().$this->config->item('backend_controller').$controller.'/delete/'.$aid?>" onClick="return confirm('Do you want to delete this entry? Deletion is permanent.')" title="Delete Appointment"><span class="btn btn-danger" class="btn btn-danger">Delete</a></div>
             
            </div>
          </div>
    </div><!-- Row-->