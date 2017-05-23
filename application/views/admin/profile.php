<style>
	.addressii{display:inline-block;width:92%}
</style>
<script>
	$(document).ready(function() {	
		$("#addcategory").validate({});
	});
	
</script>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&sensor=false&language=zh-CN"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery.geocomplete.min.js"></script>
 <div id="content" class="col-lg-10 col-sm-10">
            <!-- content starts -->
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
			<?php if($this->session->flashdata('success_msg')){
				echo "<h2 style='text-align:center'>".$this->session->flashdata('success_msg')."</h2>";
			}
				?>
          <?php  if(@$type == 'admin' ) { ?>
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-edit"></i> Edit Profile </h2>
            </div>
            <div class="box-content">
                <form role="form" method="post" id="addcategory"  enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="firstname">First Name</label>
                        <input type="text" class="form-control"  placeholder="First Name" name="fname" value="<?php echo $user['fname']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Last Name</label>
                        <input type="text" class="form-control"  placeholder="Last Name" name="lname" value="<?php echo $user['lname']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Email</label>
                        <input type="text" class="form-control" disabled placeholder="Email" name="email" value="<?php echo $user['email']; ?>">
                    </div>
					<div class="form-group">
                      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">Change Password</button>
                   <?php echo $err;?> </div>
                    <div class="form-group">
                        <label for="firstname">Picture</label>
                        <input type="file" name="picture"><br>
                        <?php
                        if($user['picture'] != ''){ ?>
							<img src="<?php echo base_url(); ?>/public/uploads/<?php echo $user['picture']; ?>" width= "50" height="50">
						<?php }
                        ?>
                    </div>
                   

                    <input type="submit" class="btn btn-primary" value="Submit" name="submit">
                </form>

            </div>
             <?php } elseif(@$type == 'doctor' ) { ?>
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-edit"></i> Edit Profile</h2>
            </div>
            <div class="box-content">
                <form role="form" method="post" id="addcategory"  enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="firstname">First Name</label>
                        <input type="text" class="form-control"  placeholder="First Name" name="fname" value="<?php echo $user['fname']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Last Name</label>
                        <input type="text" class="form-control"  placeholder="Last Name" name="lname" value="<?php echo $user['lname']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Email</label>
                        <input type="text" class="form-control" disabled placeholder="Email" name="email" value="<?php echo $user['email']; ?>">
                    </div>
					<div class="form-group">
                      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">Change Password</button>
                   <?php echo $err;?> </div>
                    <div class="form-group">
                        <label for="firstname">Picture</label>
                        <input type="file" name="picture"><br>
                        <?php
                        if($user['picture'] != ''){ ?>
							<img src="<?php echo base_url(); ?>/public/uploads/<?php echo $user['picture']; ?>" width= "50" height="50">
						<?php }
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Phone Number</label>
                        <input type="text" class="form-control"  placeholder="Phone Number" name="phoneno" value="<?php echo $user['phoneno']; ?>" required>
                    </div>
                     <div class="form-group">
                        <label for="firstname">Appointment Fees</label>
                        <input type="text" class="form-control"  placeholder="Appointment Fees" name="price" value="<?php echo $user['price']; ?>" required>
                    </div>
                     <div class="form-group">
                        <label for="firstname">Clinic Name</label>
                        <input type="text" class="form-control"  placeholder="Clinic Name" name="clinic_name" value="<?php echo $user['clinic_name']; ?>" required>
                    </div>
                    <div class="form-group input_fields_wrap" > 
						<?php 
                    $i = 1;
                    foreach($addr_info as $adr) { 
						if($i>1){
							$x = $i;
						}else{
							$x = 0;
						}
						?>
                    
                    <div class="geo-details<?php echo $x; ?>">
						<div class="form-group">
							<label for="firstname">Address <?php echo $i; ?></label><br>
							<input type="text" class="form-control <?php echo (($x!=0)?'addressii':''); ?>" id="address<?php echo $x; ?>" placeholder="Address" name="address[]" value="<?php echo $adr['address'];?>">
							<input type="hidden" data-geo="lat" value="<?php echo $adr['lat'];?>"   name="lat[]" class="location">  
						    <input type="hidden" data-geo="lng" value="<?php echo $adr['long'];?>"  name="long[]" class="location">
						    <?php echo (($x!=0)?'<a class="remove_field btn btn-danger btn-sm" href="#"> Remove</a>':''); ?>
						</div>
                    </div>
                     <?php ++$i;} ?>
                    </div>
                    
                    <a class="add_field_button btn btn-primary btn-sm">Add More Fields</a>
                    <div class="form-group">
                        <label for="firstname">District</label>
                        <input type="text" class="form-control"  placeholder="District" name="district" value="<?php echo $user['district']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Introduction</label>
                        <input type="text" class="form-control"  placeholder="Introduction" name="introduction" value="<?php echo $user['introduction']; ?>" required>
                    </div>
                   <div class="form-group">
                        <label for="firstname">Education</label>
                        <input type="text" class="form-control"  placeholder="Education" name="education" value="<?php echo $user['education']; ?>" required>
                    </div>
                     <div class="form-group">
                        <label for="firstname">Service Start Time</label>
                        <input type="time" class="form-control"  placeholder="Service Start Time (h:m)" name="service_start_time" value="<?php echo $user['service_start_time']; ?>" required>
                    </div>
                     <div class="form-group">
                        <label for="firstname">Service End Time</label>
                        <input type="time" class="form-control"  placeholder="Service End Time (h:m)" name="service_end_time" value="<?php echo $user['service_end_time']; ?>" required>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Submit" name="submit">
                </form>

            </div>
             <?php } elseif(@$type  == 'translator' ) { ?>
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-edit"></i> Edit Profile</h2>
            </div>
            <div class="box-content">
                <form role="form" method="post" id="addcategory"  enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="firstname">First Name</label>
                        <input type="text" class="form-control"  placeholder="First Name" name="fname" value="<?php echo $user['fname']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Last Name</label>
                        <input type="text" class="form-control"  placeholder="Last Name" name="lname" value="<?php echo $user['lname']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Email</label>
                        <input type="text" class="form-control" disabled  placeholder="Email" name="email" value="<?php echo $user['email']; ?>">
                    </div>
					<div class="form-group">
                      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">Change Password</button>
                    <?php echo $err;?></div>
                    <div class="form-group">
                        <label for="firstname">Picture</label>
                        <input type="file" name="picture"><br>
                        <?php
                        if($user['picture'] != ''){ ?>
							<img src="<?php echo base_url(); ?>/public/uploads/<?php echo $user['picture']; ?>" width= "50" height="50">
						<?php }
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Phone Number</label>
                        <input type="text" class="form-control"  placeholder="Phone Number" name="phoneno" value="<?php echo $user['phoneno']; ?>" required>
                    </div>
                    <?php 
                    $i = 1;
                    foreach($addr_info as $adr) { 
						?>                   
                    <div class="geo-details">
						<div class="form-group">
							<label for="firstname">Address</label><br>
							<input type="text" class="form-control" id="address" placeholder="Address" name="address[]" value="<?php echo $adr['address'];?>">
							<input type="hidden" data-geo="lat" value="<?php echo $adr['lat'];?>"   name="lat[]" class="location">  
						    <input type="hidden" data-geo="lng" value="<?php echo $adr['long'];?>"  name="long[]" class="location">
						</div>
                    </div>
                     <?php ++$i;} ?>
                    <div class="form-group">
                        <label for="firstname">District</label>
                        <input type="text" class="form-control"  placeholder="District" name="district" value="<?php echo $user['district']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Introduction</label>
                        <input type="text" class="form-control"  placeholder="Introduction" name="introduction" value="<?php echo $user['introduction']; ?>" required>
                    </div>
                   <div class="form-group">
                        <label for="firstname">Education</label>
                        <input type="text" class="form-control"  placeholder="Education" name="education" value="<?php echo $user['education']; ?>" required>
                    </div>

                    <input type="submit" class="btn btn-primary" value="Submit" name="submit">
                </form>

            </div>
               <?php } elseif(@$type  == 'medical' ) { ?>
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-edit"></i> Edit Profile </h2>
            </div>
            <div class="box-content">
                <form role="form" method="post" id="addcategory"  enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="firstname">Clinic Name</label>
                        <input type="text" class="form-control"  placeholder="Clinic Name" name="clinic_name" value="<?php echo $user['clinic_name']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Clinic Type</label>
                        <input type="text" class="form-control"  placeholder="Clinic Type" name="clinic_type" value="<?php echo $user['clinic_type']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Email</label>
                        <input type="text" class="form-control" disabled placeholder="Email" name="email" value="<?php echo $user['email']; ?>">
                    </div>
					<div class="form-group">
                      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">Change Password</button>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Picture</label>
                        <input type="file" name="picture"><br>
                        <?php
                        if($user['picture'] != ''){ ?>
							<img src="<?php echo base_url(); ?>/public/uploads/<?php echo $user['picture']; ?>" width= "50" height="50">
						<?php }
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Phone Number</label>
                        <input type="text" class="form-control"  placeholder="Phone Number" name="phoneno" value="<?php echo $user['phoneno']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Fax</label>
                        <input type="text" class="form-control"  placeholder="Fax" name="fax" value="<?php echo $user['fax']; ?>" required>
                    </div>
                     <?php 
                    $i = 1;
                    foreach($addr_info as $adr) { 
						?>                   
                    <div class="geo-details">
						<div class="form-group">
							<label for="firstname">Address</label><br>
							<input type="text" class="form-control" id="address" placeholder="Address" name="address[]" value="<?php echo $adr['address'];?>">
							<input type="hidden" data-geo="lat" value="<?php echo $adr['lat'];?>"   name="lat[]" class="location">  
						    <input type="hidden" data-geo="lng" value="<?php echo $adr['long'];?>"  name="long[]" class="location">
						</div>
                    </div>
                     <?php ++$i;} ?>
                    <div class="form-group">
                        <label for="firstname">District</label>
                        <input type="text" class="form-control"  placeholder="District" name="district" value="<?php echo $user['district']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Introduction</label>
                        <input type="text" class="form-control"  placeholder="Introduction" name="introduction" value="<?php echo $user['introduction']; ?>" required>
                    </div>
                     <div class="form-group">
                        <label for="firstname">Service Start Time</label>
                        <input type="time" class="form-control"  placeholder="Service Start Time (h:m)" name="service_start_time" value="<?php echo $user['service_start_time']; ?>" required>
                    </div>
                     <div class="form-group">
                        <label for="firstname">Service End Time</label>
                        <input type="time" class="form-control"  placeholder="Service End Time (h:m)" name="service_end_time" value="<?php echo $user['service_end_time']; ?>" required>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Submit" name="submit">
                </form>

            </div>
              <?php } ?>



<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Change Password</h4>
      </div>
      <div class="modal-body">
    <form role="form" method="post" id="addcategory317" action="<?php echo site_url('admin/profile');?>" enctype="multipart/form-data">
                   <div class="form-group">
                        <label for="firstname">Old Password</label>
                        <input type="text" class="form-control"   placeholder="Old Password" name="oldpswd" value="" required>
                    </div>	              
				  <div class="form-group">
                        <label for="firstname">Password</label>
                        <input type="hidden" class="form-control"   placeholder="Change Password" name="id" value="<?php echo $user['id']; ?>"> 
						<input type="hidden" class="form-control"   placeholder="Change Password" name="type" value="<?php echo $user['type']; ?>">
                        <input type="text" class="form-control"   placeholder="Change Password" name="password" required >
                    </div>
					<div class="form-group">
                        <label for="firstname">Confirm Password</label>
                        <input type="text" class="form-control"   placeholder="Change Password" name="cpassword" value="" required>
                    </div>
					<div class="form-group">
                       
                        <input type="submit" class="form-control"   name="change" value="change">
                    </div>
	</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

        </div>
    </div>
</div><!--/row-->

    <!-- content ends -->
    </div><!--/#content.col-md-0-->
<style>
.map_canvas {
    height: 250px;
    margin: 10px 20px 10px 0;
    width: 400px;
}

</style>
<script>
$(function () {	
	$("#address").geocomplete({
           
	  details: ".geo-details",
	  detailsAttribute: "data-geo",
	});
	/*$("#address").bind("geocode:dragged", function(event, latLng){
          $("input[name=lat]").val(latLng.lat());
          $("input[name=long]").val(latLng.lng());
        });
		//});
		 $("#address").trigger("geocode");
        }).click();*/
  });      $(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
   
    var x = <?php echo $i-1; ?>; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append(' <div class="geo-details'+x+'"><div class="form-group"><label for="firstname">Address '+x+'</label><br><input type="text" class="form-control addressii" id="address'+x+'" placeholder="Address" name="address[]" value=""><input type="hidden" data-geo="lat" value=""   name="lat[]" class="location"><input type="hidden" data-geo="lng" value=""  name="long[]" class="location"><a href="#" class="remove_field btn btn-danger btn-sm" style="margin-left: 4px;"> Remove</a></div>'); //add input box
        }
        $("#address"+x).geocomplete({
           
	  details: ".geo-details"+x,
	  detailsAttribute: "data-geo",
	});
    });
   
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    });
    
 });
</script>
