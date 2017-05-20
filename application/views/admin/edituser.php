<?php
function in_multiarray($elem, $array, $field) {
    $top = sizeof($array) - 1;
    $bottom = 0;
    while ($bottom <= $top) {
        if ($array[$bottom][$field] == $elem)
            return true;
        else
        if (is_array($array[$bottom][$field]))
            if (in_multiarray($elem, ($array[$bottom][$field])))
                return true;

        $bottom++;
    }
    return false;
}
?>
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
          <?php  if(@$user['type'] == 'doctor' ) { ?>
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-edit"></i> Edit Doctor</h2>
            </div>
            <div class="box-content">
                <form role="form" method="post" id="addcategory"  enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="firstname">First Name</label>
                        <input type="text" class="form-control"  placeholder="First Name" name="fname" value="<?php echo $user['fname']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">First Name(In Simplified)</label>
                        <input type="text" class="form-control"  placeholder="First Name(In Simplified)" name="fname_s" value="<?php echo $user_s['fname']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">First Name(In Traditional)</label>
                        <input type="text" class="form-control"  placeholder="First Name" name="fname_t" value="<?php echo $user_t['fname']; ?>" required>
                    </div>          
                    <div class="form-group">
                        <label for="firstname">Last Name</label>
                        <input type="text" class="form-control"  placeholder="Last Name" name="lname" value="<?php echo $user['lname']; ?>" required>
                    </div>
                     <div class="form-group">
                        <label for="firstname">Last Name(In Simplified)</label>
                        <input type="text" class="form-control"  placeholder="Last Name(In Simplified)" name="lname_s" value="<?php echo $user_s['lname']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Last Name(In Traditional)</label>
                        <input type="text" class="form-control"  placeholder="Last Name(In Traditional)" name="lname_t" value="<?php echo $user_t['lname']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Email</label>
                        <input type="text" class="form-control" disabled placeholder="Email" name="email" value="<?php echo $user['email']; ?>">
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
                        <label for="firstname">Appointment Fees</label>
                        <input type="text" class="form-control"  placeholder="Appointment Fees" name="price" value="<?php echo $user['price']; ?>" required>
                    </div>
                     <div class="form-group">
                        <label for="firstname">Clinic Name</label>
                        <input type="text" class="form-control"  placeholder="Clinic Name" name="clinic_name" value="<?php echo $user['clinic_name']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Clinic Name(In Simplified)</label>
                        <input type="text" class="form-control"  placeholder="Clinic Name(In Simplified)" name="clinic_name_s" value="<?php echo $user_s['clinic_name']; ?>" required>
                    </div>
                     <div class="form-group">
                        <label for="firstname">Clinic Name(In Traditional)</label>
                        <input type="text" class="form-control"  placeholder="Clinic Name(In Traditional)" name="clinic_name_t" value="<?php echo $user_t['clinic_name']; ?>" required>
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
						    
						</div>
						<div class="form-group">
							<label for="firstname">Address (In Simplified)<?php echo $i; ?></label><br>
							<input type="text" class="form-control <?php echo (($x!=0)?'addressii':''); ?>" id="address_s<?php echo $x; ?>" placeholder="Address" name="address_s[]" value="<?php echo $adr['address_s'];?>">
							
						</div>
						<div class="form-group">
							<label for="firstname">Address (In Traditional)<?php echo $i; ?></label><br>
							<input type="text" class="form-control <?php echo (($x!=0)?'addressii':''); ?>" id="address_t<?php echo $x; ?>" placeholder="Address" name="address_t[]" value="<?php echo $adr['address_t'];?>">
							
						</div>
						<div class="form-group">
                        <label for="firstname">District</label>
                        <input type="text" class="form-control"  placeholder="District" name="district[]" value="<?php echo $adr['district']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">District(In Simplified)</label>
                        <input type="text" class="form-control"  placeholder="District(In Simplified)" name="district_s[]" value="<?php echo $adr['district_s']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">District(In Traditional)</label>
                        <input type="text" class="form-control"  placeholder="District(In Traditional)" name="district_t[]" value="<?php echo $adr['district_t']; ?>" required>
                    </div>
                    <?php echo (($x!=0)?'<a class="remove_field btn btn-danger btn-sm" href="#"> Remove</a>':''); ?>
                    </div>
                     <?php ++$i;} ?>
                    </div>
                    
                    <a class="add_field_button btn btn-primary btn-sm">Add More Fields</a>
                    
                    <div class="form-group">
                        <label for="firstname">Introduction</label>
                        <input type="text" class="form-control"  placeholder="Introduction" name="introduction" value="<?php echo $user['introduction']; ?>" required>
                    </div>
                     <div class="form-group">
                        <label for="firstname">Introduction(In Simplified)</label>
                        <input type="text" class="form-control"  placeholder="Introduction(In Simplified)" name="introduction_s" value="<?php echo $user_s['introduction']; ?>" required>
                    </div>
                     <div class="form-group">
                        <label for="firstname">Introduction(In Traditional)</label>
                        <input type="text" class="form-control"  placeholder="Introduction(In Traditional)" name="introduction_t" value="<?php echo $user_t['introduction']; ?>" required>
                    </div> 
                   <div class="form-group">
                        <label for="firstname">Education</label>
                        <input type="text" class="form-control"  placeholder="Education" name="education" value="<?php echo $user['education']; ?>" required>
                    </div>
                     <div class="form-group">
                        <label for="firstname">Education (In Simplified)</label>
                        <input type="text" class="form-control"  placeholder="Education (In Simplified)" name="education_s" value="<?php echo $user_s['education']; ?>" required>
                    </div>
                     <div class="form-group">
                        <label for="firstname">Education (In Traditional)</label>
                        <input type="text" class="form-control"  placeholder="Education (In Traditional)" name="education_t" value="<?php echo $user_t['education']; ?>" required>
                    </div>
                     <div class="form-group">
                        <label for="firstname">Service Start Time</label>
                        <input type="text" class="form-control"  placeholder="Service Start Time (h:m)" name="service_start_time" value="<?php echo $user['service_start_time']; ?>" required>
                    </div>
                     <div class="form-group">
                        <label for="firstname">Service End Time</label>
                        <input type="text" class="form-control"  placeholder="Service End Time (h:m)" name="service_end_time" value="<?php echo $user['service_end_time']; ?>" required>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Submit" name="submit">
                </form>

            </div>
             <?php } elseif(@$user['type'] == 'translator' ) { ?>
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-edit"></i> Edit Translator</h2>
            </div>
            <div class="box-content">
                <form role="form" method="post" id="addcategory"  enctype="multipart/form-data">
                   <div class="form-group">
                        <label for="firstname">First Name</label>
                        <input type="text" class="form-control"  placeholder="First Name" name="fname" value="<?php echo $user['fname']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">First Name(In Simplified)</label>
                        <input type="text" class="form-control"  placeholder="First Name(In Simplified)" name="fname_s" value="<?php echo $user_s['fname']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">First Name(In Traditional)</label>
                        <input type="text" class="form-control"  placeholder="First Name" name="fname_t" value="<?php echo $user_t['fname']; ?>" required>
                    </div>          
                    <div class="form-group">
                        <label for="firstname">Last Name</label>
                        <input type="text" class="form-control"  placeholder="Last Name" name="lname" value="<?php echo $user['lname']; ?>" required>
                    </div>
                     <div class="form-group">
                        <label for="firstname">Last Name(In Simplified)</label>
                        <input type="text" class="form-control"  placeholder="Last Name(In Simplified)" name="lname_s" value="<?php echo $user_s['lname']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Last Name(In Traditional)</label>
                        <input type="text" class="form-control"  placeholder="Last Name(In Traditional)" name="lname_t" value="<?php echo $user_t['lname']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Email</label>
                        <input type="text" class="form-control" disabled  placeholder="Email" name="email" value="<?php echo $user['email']; ?>">
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
                    

                    <input type="submit" class="btn btn-primary" value="Submit" name="submit">
                </form>

            </div>
               <?php } elseif(@$user['type'] == 'medical' ) { ?>
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-edit"></i> Edit Medical Center </h2>
            </div>
            <div class="box-content">
                <form role="form" method="post" id="addcategory"  enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="firstname">Clinic Name</label>
                        <input type="text" class="form-control"  placeholder="Clinic Name" name="clinic_name" value="<?php echo $user['clinic_name']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Clinic Name(In Simplified)</label>
                        <input type="text" class="form-control"  placeholder="Clinic Name(In Simplified)" name="clinic_name_s" value="<?php echo $user_s['clinic_name']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Clinic Name(In Traditional)</label>
                        <input type="text" class="form-control"  placeholder="Clinic Name(In Traditional)" name="clinic_name_t" value="<?php echo $user_t['clinic_name']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Clinic Type</label>
                        <input type="text" class="form-control"  placeholder="Clinic Type" name="clinic_type" value="<?php echo $user['clinic_type']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Clinic Type(In Simplified)</label>
                        <input type="text" class="form-control"  placeholder="Clinic Type(In Simplified)" name="clinic_type_s" value="<?php echo $user_s['clinic_type']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Clinic Type(In Traditional)</label>
                        <input type="text" class="form-control"  placeholder="Clinic Type(In Traditional)" name="clinic_type_t" value="<?php echo $user_t['clinic_type']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Email</label>
                        <input type="text" class="form-control" disabled placeholder="Email" name="email" value="<?php echo $user['email']; ?>">
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
						<div class="form-group">
							<label for="firstname">Address (In Simplified)</label><br>
							<input type="text" class="form-control" id="address_s" placeholder="Address" name="address_s[]" value="<?php echo $adr['address_s'];?>">
						</div>
						<div class="form-group">
							<label for="firstname">Address (In Traditional)</label><br>
							<input type="text" class="form-control" id="address_t" placeholder="Address" name="address_t[]" value="<?php echo $adr['address_t'];?>">
						</div>
                    </div>
                     
                    <div class="form-group">
                        <label for="firstname">District</label>
                        <input type="text" class="form-control"  placeholder="District" name="district[]" value="<?php echo $adr['district']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">District(In Simplified)</label>
                        <input type="text" class="form-control"  placeholder="District(In Simplified)" name="district_s[]" value="<?php echo $adr['district_s']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">District(In Traditional)</label>
                        <input type="text" class="form-control"  placeholder="District(In Traditional)" name="district_t[]" value="<?php echo $adr['district_t']; ?>" required>
                    </div>
                    <?php ++$i;} ?>
                    <div class="form-group">
                        <label for="firstname">Introduction</label>
                        <input type="text" class="form-control"  placeholder="Introduction" name="introduction" value="<?php echo $user['introduction']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Introduction(In Simplified)</label>
                        <input type="text" class="form-control"  placeholder="Introduction(In Simplified)" name="introduction_s" value="<?php echo $user_s['introduction']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Introduction(In Traditional)</label>
                        <input type="text" class="form-control"  placeholder="Introduction(In Traditional)" name="introduction_t" value="<?php echo $user_t['introduction']; ?>" required>
                    </div>
                     <div class="form-group">
                        <label for="firstname">Service Start Time</label>
                        <input type="text" class="form-control"  placeholder="Service Start Time (h:m)" name="service_start_time" value="<?php echo $user['service_start_time']; ?>" required>
                    </div>
                     <div class="form-group">
                        <label for="firstname">Service End Time</label>
                        <input type="text" class="form-control"  placeholder="Service End Time (h:m)" name="service_end_time" value="<?php echo $user['service_end_time']; ?>" required>
                    </div>
                    <div class="control-group">
                        <label for="firstname">Services</label>
                        <div class="controls">
							<select multiple class="form-control" data-rel="chosen" name="services[]">
							<?php 
							  foreach($services as $ser) { 
								  $arr = in_multiarray($ser['id'],$assigned_services, 'service_id' );
							      echo "<option value='".$ser['id']."' ".(($arr)?'selected':'').">".$ser['service_name']."</option>";
							 } ?>      
							</select>
						</div>                  
                    </div>
                    <input type="submit" class="btn btn-primary" value="Submit" name="submit">
                </form>

            </div>
              <?php } ?>

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
	$("#address_s").geocomplete();
	$("#address_t").geocomplete();
	<?php
	for($i = 0; $i <= count($addr_info);$i++){
		?>
		$("#address<?php echo $i; ?>").geocomplete({
           
	  details: ".geo-details",
	  detailsAttribute: "data-geo",
	});
		$("#address_s<?php echo $i; ?>").geocomplete({
	});
	$("#address_t<?php echo $i; ?>").geocomplete({
	});
		<?php
	}
	?>
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
            $(wrapper).append(' <div class="geo-details'+x+'"><div class="form-group"><label for="firstname">Address '+x+'</label><br><input type="text" class="form-control addressii" id="address'+x+'" placeholder="Address" name="address[]" value=""><input type="hidden" data-geo="lat" value=""   name="lat[]" class="location"><input type="hidden" data-geo="lng" value=""  name="long[]" class="location"></div><div class="form-group"><label for="firstname">Address (In sim)'+x+'</label><br><input type="text" class="form-control addressii" id="address_s'+x+'" placeholder="Address" name="address_s[]" value=""></div><div class="form-group"><label for="firstname">Address (In Tra)'+x+'</label><br><input type="text" class="form-control addressii" id="address_t'+x+'" placeholder="Address" name="address_t[]" value=""></div><div class="form-group"> <label for="firstname">District</label> <input type="text" class="form-control"  placeholder="District" name="district[]" value="" required></div>    <div class="form-group">  <label for="firstname">District(In Simplified)</label> <input type="text" class="form-control"  placeholder="District(In Simplified)" name="district_s[]" value="" required> </div> <div class="form-group"> <label for="firstname">District(In Traditional)</label><input type="text" class="form-control"  placeholder="District(In Traditional)" name="district_t[]" value="" required> </div><a href="#" class="remove_field btn btn-danger btn-sm"> Remove</a></div>'); //add input box
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
