
        <div id="content" class="col-lg-10 col-sm-10">

    <div class="row">
        <div class="box col-md-12">
            <div class="box-inner">
                <div class="box-header well" data-original-title="">
                    <h2><i class="glyphicon glyphicon-user"></i> <?php echo $title; ?> </h2>
                    <div style="float:right;">	
						<a href="<?php echo base_url(); ?>admin/add_einformation" class="btn btn-info btn-sm">Add E-info</a>					
					</div>
                    
                </div>
                <div class="box-content">
					<form method="post">
                    <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
						
                        <thead>
                        <tr>
							<th>No</th>
							<th>Title</th>
                            <th>Uploader</th>
                            <th>Released date</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>

      <?php 
      $i = 1;
      foreach($einformation as $info) { ?>
                        <tr>
							<td><?php echo $i; ?></td>
                            <td><?php echo $info['title']; ?></td>
                            <td><?php echo $info['uploader_name']; ?></td>
                            <td class="center"><?php echo  $info['created']; ?></td>
                            <td class="center">
							   <a href="<?php echo base_url(); ?>admin/edit_einformation?id=<?php echo $info['id']; ?>" class="btn btn-info">
									<i class="glyphicon glyphicon-edit icon-white"></i>
									Edit</a>
                                    <button type="submit" name="delete" value="<?php echo  $info['id']; ?>" onClick="return confirm('Are you sure you want to delete?');" class="btn btn-danger">Delete</button>
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
