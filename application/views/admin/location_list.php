<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&sensor=false&language=zh-CN"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery.geocomplete.min.js"></script>
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
						<a href="#" data-toggle="modal" data-target="#add_location" class="btn btn-info btn-sm">Add Location</a>
					</div>
                    
                </div>
                <div class="box-content">
					<form method="post">
                    <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
						
                        <thead>
                        <tr>
							<th>No</th>
							<th>Address</th>
                            <th>Lat</th>
                            <th>Long</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>

      <?php 
      $i = 1;
      foreach($locations as $loc) { ?>
                        <tr>
							<td><?php echo $i; ?></td>
                            <td><?php echo $loc['address']; ?></td>
                            <td><?php echo $loc['lat']; ?></td>
                            <td class="center"><?php echo  $loc['long']; ?></td>
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
		<form method="post" action=<?php echo base_url().'admin/add_location'; ?>>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add Location</h4>
      </div>
      <div class="modal-body">
       
          <div id="loc" class="geo-details">
                    <div class="form-group">
                        <label for="firstname">Address</label>
                        <input type="text" class="form-control" id="address" placeholder="Address" name="address" value="" required>
                        <input type="hidden" data-geo="lat" value=""  id="setting_latitude" name="lat" class="location">  
				      <input type="hidden" data-geo="lng" value="" id="setting_longitude" name="long" class="location">
				   </div>
					 <div class="map_canvas"></div>
          </div>
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" value="Add Location" name="add_location">
      </div> </form>
    </div>
  </div>
</div>
<style>
.map_canvas {
    height: 250px;
    margin: 10px 20px 10px 0;
    width: 400px;
}
 .pac-container { z-index:2000 !important; }
</style>
<script>
$("#add_location").on("shown.bs.modal", function () {
    $("#address").geocomplete({
           
	  details: ".geo-details",
	  detailsAttribute: "data-geo",
	    map: ".map_canvas"
	});
});
</script>
