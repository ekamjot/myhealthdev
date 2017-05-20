 <div id="content" class="col-lg-10 col-sm-10">
    <div class="row">
        <div class="box col-md-12">
            <div class="box-inner">
				<?php if($this->session->flashdata('success_msg')){
				echo "<h2 style='text-align:center'>".$this->session->flashdata('success_msg')."</h2>";
			}
				?>
                <div class="box-header well" data-original-title="">
                    <h2><i class="glyphicon glyphicon-user"></i> <?php echo $title; ?> </h2>
                    <div style="float:right;">	
						<a href="#" data-toggle="modal" data-target="#add_location" class="btn btn-info btn-sm">Add Report Category</a>
					</div>
                    
                </div>
                <div class="box-content">
					<form method="post">
                    <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
						
                        <thead>
                        <tr>
							<th>No</th>
							<th>Category Name</th>
                            <th>Name(In Simplified)</th>
                            <th>Name(In Traditional)</th>
                            <th>Type</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>

      <?php 
      $i = 1;
      foreach($locations as $loc) { ?>
                        <tr>
							<td><?php echo $i; ?></td>
                            <td><?php echo $loc['cat_name']; ?></td>
                            <td><?php echo $loc['cat_sim']; ?></td>
                            <td><?php echo $loc['cat_tra']; ?></td>
                            <td><?php echo  $loc['type']; ?></td>
                            <td class="center">
                                    <button type="submit" name="delete" value="<?php echo  $loc['id']; ?>" onClick="return confirm('Are you sure you want to delete?');" class="btn btn-danger">Delete</button>
                            </td>
                        </tr>
         <?php 
         ++$i;
         } ?>              
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
    <style>
		.del_btn{background:none;border:none;} 
    </style>
<div class="modal fade" id="add_location" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content"> 
		<form method="post" action=<?php echo base_url().'admin/add_report_cat'; ?>>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add Report Cat</h4>
      </div>
      <div class="modal-body">
			<div class="form-group">
				<label for="firstname">Category Name</label>
				<input type="text" class="form-control"  name="cat_name" value="" required>
		   </div>
		   <div class="form-group">
				<label for="firstname">Category Name(In simplified)</label>
				<input type="text" class="form-control"  name="cat_sim" value="" required>
		   </div>
		   <div class="form-group">
				<label for="firstname">Category Name(In traditional)</label>
				<input type="text" class="form-control" name="cat_tra" value="" required>
		   </div>
		   <div class="form-group">
				<label for="firstname">Type</label>
				<select class="form-control" name="type">
					<option value="M">Medical Scan</option>
					<option value="A">Analysis Report</option>
				</select>
		   </div>
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" value="Add" name="add_location">
      </div> </form>
    </div>
  </div>
</div>
