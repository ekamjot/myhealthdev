<style>
		#selectError2_chosen {width: 200px !important;}
		.del_btn{background:none;border:none;} 
    </style>
        <div id="content" class="col-lg-10 col-sm-10">

    <div class="row">
        <div class="box col-md-12">
            <div class="box-inner">
                <div class="box-header well" data-original-title="">
                    <h2><i class="glyphicon glyphicon-user"></i> Patient List</h2>

                    
                </div>
                <div class="box-content">
					<form method="post">
                    <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
						
                        <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>phoneno</th>
                            <th>Created On</th>
                            <th>Reports</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>

      <?php $i = 0;
      foreach($users as $user) { ?>
                        <tr>
                            <td><?php echo $user['fname']; ?></td>
                            <td><?php echo $user['lname']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td><?php echo $user['country_code'].'-'.$user['phoneno']; ?></td>
                            <td class="center"><?php echo  $user['created']; ?></td> 
                            <td class="center">
								<a href="#" data-toggle="modal" data-target="#add_report" class="btn btn-info btn-sm" data-userid="<?php echo $user['id']; ?>">Add Report</a>
								<a href="#" data-toggle="modal" data-target="#report_list<?php echo $user['id']; ?>" class="btn btn-info btn-sm">Reports</a>
								<!------------------------------ Report List ------------------------------>
							<div class="modal fade" id="report_list<?php echo $user['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
							  <div class="modal-dialog modal-lg" role="document">
								<div class="modal-content"> 
									<form method="post" action="<?php echo base_url().'admin/add_report'; ?>" enctype="multipart/form-data">
								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title">Report List</h4>
								  </div>
								  <div class="modal-body">
										<table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
													
													<thead>
													<tr>
														<th>Report Number</th>
														<th>Date</th>
														<th>Report Type</th>
														<th>Report File</th>
														<th>Uploaded By</th>
														<th>Action</th>
													</tr>
													</thead>
													<tbody>

								  <?php foreach($reports[$i] as $report) { ?>
													<tr id="report_row<?php echo  $report['report_id']; ?>">
														<td><?php echo $report['report_number']; ?></td>
														<td><?php echo $report['report_date']; ?></td>
														<td><?php echo $report['cat_name']; ?></td>
														<td><a href="<?php echo $report['report_file']; ?>" target="_blank"> View Here</a></td>
														<td><?php 
														if($report['fname']!='')
														echo  $report['fname'].' '.$report['lname']; 
														else{
														echo  $report['clinic_name']; 
														}
														?></td> 
														<td>
															<a class="btn btn-danger btn-del delete_report" href="#" data-id="<?php echo  $report['report_id']; ?>">Delete</a>
														</td>
													</tr>
									 <?php } ?>              
													</tbody>
												</table>
								   
								  </div>
								  <div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								  </div> 
								  </form>
								</div>
							  </div>
							</div>
							</td>
                            <td class="center">
							   <a href="<?php echo base_url(); ?>admin/view_patient?id=<?php echo $user['id']; ?>" class="btn btn-success">
									<i class="glyphicon glyphicon-zoom-in icon-white"></i>
									View
								</a>
								<?php if($this->session->userdata('user_type')=='admin') { ?>
								<div class="btn btn-danger btn-del" href="#">
                                    <button href="submit" name="delete" value="<?php echo  $user['id']; ?>" onClick="return confirm('Are you sure you want to delete?');" class="del_btn">Delete</button>
                                </div>
                                <?php } ?>
                            </td>
                        </tr>
         <?php ++$i; } ?>              
                        </tbody>
                    </table>
                    </form>
                </div>
            </div>
        </div>
        <!--/span-->

    </div><!--/row-->

    <!-- content ends -->
    </div><!--/#content.col-md-0-->
    
    <!----------------------- ADD REPORT --------------------- -->

<div class="modal fade" id="add_report" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content"> 
		<form method="post" action="<?php echo base_url().'admin/add_report'; ?>" enctype="multipart/form-data">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add Report</h4>
      </div>
      <div class="modal-body">
			<div class="form-group">
				<label for="firstname">Report Number</label>
				<input type="text" class="form-control"  name="report_number" value="" required>
		   </div>
		   <div class="form-group">
				<label for="firstname">Item</label>
				<input type="text" class="form-control"  name="item" value="" required>
		   </div>
		   <div class="form-group">
				<label for="firstname">Category Type</label>
				<div class="controls">
					<?php //print_r($reports1);  ?>
				<select data-placeholder="Select" id="selectError2" name="report_type" data-rel="chosen">
					<option value=""></option>
					<optgroup label="Analysis Report">
						<?php foreach($reports1 as $rep){ ?>
							<option value="<?php echo $rep['id']; ?>"><?php echo $rep['cat_name']; ?></option>
						<?php } ?>
					</optgroup>
					<optgroup label="Medical Scan">
						<?php foreach($medical as $med){ ?>
							<option value="<?php echo $med['id']; ?>"><?php echo $med['cat_name']; ?></option>
						<?php } ?>
					</optgroup>
                </select>
		   </div></div>
		   <div class="form-group">
				<label for="firstname">Report File</label>
				<input type="file" class="form-control" name="report_file" value="">
				<input type="hidden" value="" name="user_id"> 
		   </div>
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" value="Add" name="add_location">
      </div> 
      </form>
    </div>
  </div>
</div>



<script>
$(document).ready(function() {
	$('#add_report').on('show.bs.modal', function(e) {
       var userid = $(e.relatedTarget).data('userid');
      $(e.currentTarget).find('input[name="user_id"]').val(userid);
    });
});
</script>
<script>
  $('.delete_report').click(function() {
	   if(confirm('Are you sure you want to delete?')){   
       var val = $(this).data('id');
       data1 = {report_id:val}
            $.ajax({
					type: 'POST',
					url: "<?php echo base_url(); ?>admin/delete_report_file",
					data: data1,
					success: function(data)
					{
						if(data ==1){
							   $('#report_row'+val).remove();
							}
							else{
							    alert('No Deleted!!')
							}
					}
						});
		}else{
			return false;
		}
  });
</script>
