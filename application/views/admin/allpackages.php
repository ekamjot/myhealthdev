
        <div id="content" class="col-lg-10 col-sm-10">

    <div class="row">
        <div class="box col-md-12">
            <div class="box-inner">
                <div class="box-header well" data-original-title="">
                    <h2><i class="glyphicon glyphicon-user"></i> Packages List</h2>

                    
                </div>
                <div class="box-content">
					<form method="post">
                    <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
						
                        <thead>
                        <tr>
                            <th>Package Name</th>
                            <th>Price</th>
                            <th>Detail</th>
                            <th>Type</th>
                            <th>Created On</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>

      <?php foreach($packages as $package) { ?>
                        <tr>
                            <td><?php echo $package['package_name']; ?></td>
                            <td><?php echo $package['price']; ?></td>
                            <td><?php echo $package['package_detail']; ?></td>
                            <td><?php 
                                   if($package['type']=='P'){
									   echo "Physical Examination";
								   }elseif($package['type']=='M'){
									   echo "Medical Scan";
								   }elseif($package['type']=='E'){
									   echo "Endoscopy";
								   }
                            ?></td>
                            <td class="center"><?php echo  $package['created']; ?></td>
                            <td class="center">
								 <a href="<?php echo base_url(); ?>admin/edit_package?id=<?php echo $package['id']; ?>" class="btn btn-info">
									<i class="glyphicon glyphicon-edit icon-white"></i>
									Edit
								</a>
								<div class="btn btn-danger btn-del" href="#">
                                    <button type="submit" name="delete" value="<?php echo  $package['id']; ?>" onClick="return confirm('Are you sure you want to delete?');" class="del_btn">Delete</button>
                                </div>
                            </td>
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
    <style>
		.del_btn{background:none;border:none;} 
    </style>
