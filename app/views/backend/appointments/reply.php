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
           
           <div id="reply-wrapper">
           <div class="col-md-6 col-lg-6">
           <?=form_open(base_url().'cmspanel/appointments/send_reply');?>
           <p>To: <?=$email?></p>
           <div class="form-group">
           <label>Subject:</label>
           <input type="text" name="subject" class="form-control" value="<?=set_value('subject');?>" />
           </div>
           <textarea name="message" rows="15" class="form-control">Dear <?=$name?>, </textarea>
           <input type="hidden" name="email" value="<?=$email?>" />
           <input type="hidden" name="id" value="<?=$id?>" />
		   <br />
           <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Send" />
            <p class="pull-right"><a href="<?=base_url()?>cmspanel/appointments/" class="btn btn-danger">Cancel</a></p>
           </div>
		   <?=form_close()?>
           </div>
           
           </div>
                      
           
          </div><!-- col-lg-12-->
    </div><!-- Row-->