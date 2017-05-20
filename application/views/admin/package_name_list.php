
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
                            <th>Number</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>

      <?php $i=1; foreach($package_name as $package) { ?>
                        <tr>
							<td><?php echo $i; ?></td>
                            <td><?php echo $package['english_name']; ?></td>
                            <td class="center">
								 <a href="<?php echo base_url(); ?>admin/edit_package_name?id=<?php echo $package['id']; ?>" class="btn btn-info">
									<i class="glyphicon glyphicon-edit icon-white"></i>
									Edit
								</a>
								<a href="#" data-toggle="modal" data-target="#package_detail<?php echo $package['id']; ?>" class="btn btn-success">
									<i class="glyphicon glyphicon-zoom-in icon-white"></i>
									View
								</a>
							<!--  Detail Modal      -->
							<div id="package_detail<?php echo $package['id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
							<div class="modal-dialog modal-lg" role="document">
								<div class="modal-content"> 
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title">Package Name Detail</h4>
									</div>
									<div class="modal-body">
										<table class="table table-bordered table-striped">
												<tbody>
												<tr>
													<td>Button Name in English</td>
													<td><?php echo $package['english_name']; ?></td>
												</tr>
												<tr>
													<td>Button Name in Traditional Chinese</td>
													<td><?php echo $package['traditional_chinese_name']; ?></td>
												</tr>
												<tr>
													<td>Button Name in Simplified Chinese</td>
													<td><?php echo $package['simplified_chinese_name']; ?></td>
												</tr>
												</tbody>
											</table>			
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									</div>
								</div>
							</div>
							</div>
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
	

