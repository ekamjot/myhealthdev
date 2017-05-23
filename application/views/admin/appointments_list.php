<?php $this->load->view('template/header'); ?>
<body>
    <!-- topbar starts -->
<div class="ch-container">
    <div class="row">
 <?php 
 $this->load->view('template/top_nav_admin');  
 $this->load->view('template/left_menu'); 
 echo"<pre>";
print_r($reports);
 echo"</pre>";
	  ?> 
<style>
		#selectError2_chosen {width: 200px !important;}
		.del_btn{background:none;border:none;} 
		.modal-title {
    margin: 0;
    line-height: 1.42857143;
    color: #fff;
}
.modal-header {
    background: #2fa4e7;
    padding: 15px;
    border-bottom: 1px solid #e5e5e5;
    min-height: 16.428571px;
}
.delpatient.modal-body {
    font-size: 17px;
    margin: auto;
    text-align: center;
    font-weight: 500;
}
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
															<a class="btn btn-danger btn-del delete_report1" href="<?php echo  $report['report_id']; ?>" data-id="<?php echo  $report['report_id']; ?>">Delete</a>
																
														</td>
															<div class="modal fade" id="<?php echo  $report['report_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
									<div class="modal-dialog" role="document">
										<div class="modal-content"> 
											
										  <div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<h4 class="modal-title">Confirm<?php echo  $report['report_id']; ?></h4>
										  </div>
										  
										  <form method="post"  >
										   <div class="modal-body delpatient">
												Are you sure you want to delete?
										     <input type="hidden" value="<?php echo  $user['id']; ?>" name="delete"  >
										   </div>
										   <div class="modal-footer" style="text-align:center;">
											<input type="submit" value="YES" name="Delete" class="btn btn-default" >
											<button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
											
										  </div> 
									  </form>
										</div>
									  </div>
									</div>
													</tr>
									 <?php } ?>              
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



<script src="http://bootboxjs.com/bootbox.js"></script> 

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
 <?php $this->load->view('template/footer'); ?>  
 </div>
</body>
</html>
