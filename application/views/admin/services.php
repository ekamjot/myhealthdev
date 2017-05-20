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
						<a href="#" data-toggle="modal" data-target="#add_location" class="btn btn-info btn-sm">Add Services</a>
						<a href="#" data-toggle="modal" data-target="#add_category" class="btn btn-info btn-sm">Add Category</a>
						<a href="#" data-toggle="modal" data-target="#category_list" class="btn btn-info btn-sm">Category List</a>
					</div>
                    
                </div>
                <div class="box-content">
					<form method="post">
                    <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
						
                        <thead>
                        <tr>
							<th>No</th>
							<th>Service Name</th>
                            <th>Name(In Simplified)</th>
                            <th>Name(In Traditional)</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>

      <?php 
      $i = 1;
      foreach($locations as $loc) { ?>
                        <tr>
							<td><?php echo $i; ?></td>
                            <td><?php echo $loc['service_name']; ?></td>
                            <td><?php echo $loc['service_name_s']; ?></td>
                            <td><?php echo $loc['service_name_t']; ?></td>
                            <td><?php echo $loc['price']; ?></td>
                            <td class="center">
										<a href="<?php echo base_url(); ?>admin/edit_service?id=<?php echo $loc['id']; ?>" class="btn btn-info">
											<i class="glyphicon glyphicon-edit icon-white"></i>
											Edit
										</a>
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
		<form method="post" action=<?php echo base_url().'admin/add_services'; ?>>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add Service</h4>
      </div>
      <div class="modal-body">
			<div class="form-group">
				<label for="firstname">Service Name</label>
				<input type="text" class="form-control"  name="service_name" value="" required>
		   </div>
		   <div class="form-group">
				<label for="firstname">Service Name(In simplified)</label>
				<input type="text" class="form-control"  name="service_name_s" value="" required>
		   </div>
		   <div class="form-group">
				<label for="firstname">Service Name(In traditional)</label>
				<input type="text" class="form-control" name="service_name_t" value="" required>
		   </div>
		    <div class="form-group">
				<label for="firstname">Price</label>
				<input type="text" class="form-control" name="price" value="" required>
		   </div>
		    <div class="control-group">
                        <label for="firstname">Category</label>
                        <div class="controls">
							<select  class="form-control" name="category">
							<?php 
							  foreach($service_cat as $ss) { 
							      echo "<option value='".$ss['id']."'>".$ss['cat_name']."</option>";
							 } ?>      
							</select>
						</div>                  
                    </div>
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" value="Add" name="add_location">
      </div> </form>
    </div>
  </div>
</div>






<div class="modal fade" id="add_category" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content"> 
		<form method="post" action=<?php echo base_url().'admin/add_category'; ?>>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add Category</h4>
      </div>
      <div class="modal-body">
			<div class="form-group">
				<label for="firstname">category Name</label>
				<input type="text" class="form-control"  name="cat_name" value="" required>
		   </div>
		   <div class="form-group">
				<label for="firstname">category Name(In simplified)</label>
				<input type="text" class="form-control"  name="cat_name_s" value="" required>
		   </div>
		   <div class="form-group">
				<label for="firstname">category Name(In traditional)</label>
				<input type="text" class="form-control" name="cat_name_t" value="" required>
		   </div>
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" value="Add" name="add_category">
      </div> </form>
    </div>
  </div>
</div>



<div class="modal fade" id="category_list" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content"> 
		<form method="post">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Service List</h4>
      </div>
      <div class="modal-body">
			<form method="post">
                    <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
						
                        <thead>
                        <tr>
							<th>No</th>
							<th>Category Name</th>
                            <th>Name(In Simplified)</th>
                            <th>Name(In Traditional)</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>

				  <?php 
				  $i = 1;
				  foreach($service_cat as $cat) { ?>
                        <tr>
							<td><?php echo $i; ?></td>
                            <td><?php echo $cat['cat_name']; ?></td>
                            <td><?php echo $cat['cat_name_s']; ?></td>
                            <td><?php echo $cat['cat_name_t']; ?></td>
                            <td class="center">
									<a href="<?php echo base_url(); ?>admin/edit_category?id=<?php echo $cat['id']; ?>" class="btn btn-info">
											<i class="glyphicon glyphicon-edit icon-white"></i>
											Edit
										</a>
                                    <button type="submit" name="delete1" value="<?php echo  $cat['id']; ?>" onClick="return confirm('Are you sure you want to delete?');" class="btn btn-danger">Delete</button>
                            </td>
                        </tr>
				 <?php 
				 ++$i;
				 } ?>              
                        </tbody>
                    </table>
                    </form>
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div> </form>
    </div>
  </div>
</div>



