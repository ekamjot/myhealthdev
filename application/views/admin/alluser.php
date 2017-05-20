    <style>
		.del_btn{background:none;border:none;} 
    </style>
        <div id="content" class="col-lg-10 col-sm-10">

    <div class="row">
        <div class="box col-md-12">
            <div class="box-inner">
                <div class="box-header well" data-original-title="">
                    <h2><i class="glyphicon glyphicon-user"></i> <?php echo $title; ?> </h2>

                    
                </div>
                <div class="box-content">
					<form method="post">
                    <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
						
                        <thead>
                        <tr>
						<?php if($_GET['type']=='medical') { ?>
                            <th>Clinic Name</th>
                            <th>Clinic Type</th>
                         <?php } else{  ?>
							 <th>First Name</th>
                            <th>Last Name</th>
                            <?php } ?>  
                            <th>Email</th>
                            <th>phoneno</th>
                            <th>Created On</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>

      <?php foreach($users as $user) { ?>
                        <tr>
							<?php if($_GET['type']=='medical') { ?>
                            <td><?php echo $user['clinic_name']; ?></td>
                            <td><?php echo $user['clinic_type']; ?></td>
                            <?php } else{ ?>
							<td><?php echo $user['fname']; ?></td>
                            <td><?php echo $user['lname']; ?></td>
							<?php } ?>	
                            <td><?php echo $user['email']; ?></td>
                            <td><?php echo $user['phoneno']; ?></td>
                            <td class="center"><?php echo  $user['created']; ?></td>
                            <td class="center">
							   <a href="<?php echo base_url(); ?>admin/edit_user?id=<?php echo $user['id']; ?>" class="btn btn-info">
									<i class="glyphicon glyphicon-edit icon-white"></i>
									Edit
								</a>
								<div class="btn btn-danger btn-del" href="#">
                                    <button type="submit" name="delete" value="<?php echo  $user['id']; ?>" onClick="return confirm('Are you sure you want to delete?');" class="del_btn">Delete</button>
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

