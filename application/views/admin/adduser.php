<style>
	.addressii{display:inline-block;width:92%}
</style>
<script>
	$(document).ready(function() {	
		$("#addcategory").validate({
			rules: {
			    email: {
				  email: true,
				  remote: "<?php echo base_url(); ?>admin/check_email"
				},
				  /*  phoneno: {
				  remote: "<?php echo base_url(); ?>admin/check_phoneno"
				}*/
          },
          messages:
             {
                 email:
                 {
                    remote: jQuery.validator.format("{0} is already taken.")
                 },
                /* phoneno:
                 {
                    remote: jQuery.validator.format("{0} is already taken.")
                 },*/
			}
		});
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
				<?php if(!isset($_GET['type'])) { ?>
					 <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-edit"></i>Select User</h2>
            </div>
            <div class="box-content">
                <form role="form" method="post" id="addcategory"  enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="firstname">Select User Type</label>
                        <select name="user_type" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);" class="form-control" >
							<option value="#">Select User</option>
							<option value="<?php echo base_url().'admin/add_user?type=doctor'; ?>">Doctor</option>
							<option value="<?php echo base_url().'admin/add_user?type=medical'; ?>">Medical Center</option>
							<option value="<?php echo base_url().'admin/add_user?type=translator'; ?>">Translator</option>
							<!--<option value="<?php echo base_url().'admin/add_user?type=other'; ?>">Other</option>-->
					   </select>
                    </div>
                </form>

            </div>

				<?php } elseif(@$_GET['type'] == 'doctor' ) { ?>
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-edit"></i> Add Doctor</h2>
            </div>
            <div class="box-content">
                <form role="form" method="post" id="addcategory"  enctype="multipart/form-data" >
                    <div class="form-group">
                        <label for="firstname">First Name</label>
                        <input type="text" class="form-control"  placeholder="First Name" name="fname" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">First Name(In Simplified)</label>
                        <input type="text" class="form-control"  placeholder="First Name(In Simplified)" name="fname_s" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">First Name(In Traditional)</label>
                        <input type="text" class="form-control"  placeholder="First Name" name="fname_t" value="" required>
                    </div>                  
                    <div class="form-group">
                        <label for="firstname">Last Name</label>
                        <input type="text" class="form-control"  placeholder="Last Name" name="lname" value="" required>
                    </div> 
                    <div class="form-group">
                        <label for="firstname">Last Name(In Simplified)</label>
                        <input type="text" class="form-control"  placeholder="Last Name(In Simplified)" name="lname_s" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Last Name(In Traditional)</label>
                        <input type="text" class="form-control"  placeholder="Last Name(In Traditional)" name="lname_t" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Email</label>
                        <input type="text" class="form-control"  placeholder="Email" name="email" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Password</label>
                        <input type="password" class="form-control"  placeholder="Password" name="password" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Picture</label>
                        <input type="file" name="picture">
                    </div>
                    <div class="form-group">
                        <label for="firstname">Phone Number</label>
                        <input type="text" class="form-control"  placeholder="Phone Number" name="phoneno" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Appointment Fees</label>
                        <input type="text" class="form-control"  placeholder="Appointment Fees" name="price" value="" required>
                    </div>
                     <div class="form-group">
                        <label for="firstname">Clinic Name</label>
                        <input type="text" class="form-control"  placeholder="Clinic Name" name="clinic_name" value="" required>
                    </div>
                     <div class="form-group">
                        <label for="firstname">Clinic Name(In Simplified)</label>
                        <input type="text" class="form-control"  placeholder="Clinic Name(In Simplified)" name="clinic_name_s" value="" required>
                    </div>
                     <div class="form-group">
                        <label for="firstname">Clinic Name(In Traditional)</label>
                        <input type="text" class="form-control"  placeholder="Clinic Name(In Traditional)" name="clinic_name_t" value="" required>
                    </div>
                    <div class="form-group input_fields_wrap" >
                    <div id="loc" class="geo-details">
						<div class="form-group">
							<label for="firstname">Address</label>
							<input type="text" class="form-control" id="address" placeholder="Address" name="address[]" value="" required>
                           
							<input type="hidden" data-geo="lat" value=""  id="setting_latitude" name="lat[]" class="location">  
						    <input type="hidden" data-geo="lng" value="" id="setting_longitude" name="long[]" class="location">
						</div>
						<div class="form-group">
						 <label for="firstname">Address(In Simplified)</label>
							<input type="text" class="form-control" id="address_s" placeholder="Address" name="address_s[]" value="" required>
						</div>
						<div class="form-group">	
							<label for="firstname">Address(In Traditional)</label>
							<input type="text" class="form-control" id="address_t" placeholder="Address" name="address_t[]" value="" required>
						</div>
                    </div>
                     <div class="form-group">
                        <label for="firstname">District</label>
                        <input type="text" class="form-control"  placeholder="District" name="district[]" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">District(In Simplified)</label>
                        <input type="text" class="form-control"  placeholder="District(In Simplified)" name="district_s[]" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">District(In Traditional)</label>
                        <input type="text" class="form-control"  placeholder="District(In Traditional)" name="district_t[]" value="" required>
                    </div>
                    </div>
                    <button class="add_field_button btn btn-primary btn-sm">Add More Fields</button>
                    
                    <div class="form-group">
                        <label for="firstname">Introduction</label>
                        <input type="text" class="form-control"  placeholder="Introduction" name="introduction" value="" required>
                    </div>
                     <div class="form-group">
                        <label for="firstname">Introduction(In Simplified)</label>
                        <input type="text" class="form-control"  placeholder="Introduction(In Simplified)" name="introduction_s" value="" required>
                    </div>
                     <div class="form-group">
                        <label for="firstname">Introduction(In Traditional)</label>
                        <input type="text" class="form-control"  placeholder="Introduction(In Traditional)" name="introduction_t" value="" required>
                    </div>
                   <div class="form-group">
                        <label for="firstname">Education</label>
                        <input type="text" class="form-control"  placeholder="Education" name="education" value="" required>
                    </div>
                     <div class="form-group">
                        <label for="firstname">Education (In Simplified)</label>
                        <input type="text" class="form-control"  placeholder="Education (In Simplified)" name="education_s" value="" required>
                    </div>
                     <div class="form-group">
                        <label for="firstname">Education (In Traditional)</label>
                        <input type="text" class="form-control"  placeholder="Education (In Traditional)" name="education_t" value="" required>
                    </div>
                     <div class="form-group">
                        <label for="firstname">Service Start Time</label>
                        <input type="text" class="form-control"  placeholder="Service Start Time (h:m)" name="service_start_time" value="" required>
                    </div>
                     <div class="form-group">
                        <label for="firstname">Service End Time</label>
                        <input type="text" class="form-control"  placeholder="Service End Time (h:m)" name="service_end_time" value="" required>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Submit" name="submit">
                </form>

            </div>
             <?php } elseif(@$_GET['type'] == 'translator' ) { ?>
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-edit"></i> Add Translator</h2>
            </div>
            <div class="box-content">
                <form role="form" method="post" id="addcategory"  enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="firstname">First Name</label>
                        <input type="text" class="form-control"  placeholder="First Name" name="fname" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">First Name(In Simplified)</label>
                        <input type="text" class="form-control"  placeholder="First Name(In Simplified)" name="fname_s" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">First Name(In Traditional)</label>
                        <input type="text" class="form-control"  placeholder="First Name" name="fname_t" value="" required>
                    </div>                  
                    <div class="form-group">
                        <label for="firstname">Last Name</label>
                        <input type="text" class="form-control"  placeholder="Last Name" name="lname" value="" required>
                    </div> 
                    <div class="form-group">
                        <label for="firstname">Last Name(In Simplified)</label>
                        <input type="text" class="form-control"  placeholder="Last Name(In Simplified)" name="lname_s" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Last Name(In Traditional)</label>
                        <input type="text" class="form-control"  placeholder="Last Name(In Traditional)" name="lname_t" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Email</label>
                        <input type="text" class="form-control"  placeholder="Email" name="email" value="" required>
                    </div>
                     <div class="form-group">
                        <label for="firstname">Password</label>
                        <input type="text" class="form-control"  placeholder="Password" name="password" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Picture</label>
                        <input type="file" name="picture">
                    </div>
                    <div class="form-group">
                        <label for="firstname">Phone Number</label>
                        <input type="text" class="form-control"  placeholder="Phone Number" name="phoneno" value="" required>
                    </div>
                    

                    <input type="submit" class="btn btn-primary" value="Submit" name="submit">
                </form>

            </div>
               <?php } elseif(@$_GET['type'] == 'medical' ) { ?>
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-edit"></i> Add Medical Center </h2>
            </div>
            <div class="box-content">
                <form role="form" method="post" id="addcategory"  enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="firstname">Clinic Name</label>
                        <input type="text" class="form-control"  placeholder="Clinic Name" name="clinic_name" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Clinic Name(In Simplified)</label>
                        <input type="text" class="form-control"  placeholder="Clinic Name(In Simplified)" name="clinic_name_s" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Clinic Name(In Traditional)</label>
                        <input type="text" class="form-control"  placeholder="Clinic Name(In Traditional)" name="clinic_name_t" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Clinic Type</label>
                        <input type="text" class="form-control"  placeholder="Clinic Type" name="clinic_type" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Clinic Type(In Simplified)</label>
                        <input type="text" class="form-control"  placeholder="Clinic Type(In Simplified)" name="clinic_type_s" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Clinic Type(In Traditional)</label>
                        <input type="text" class="form-control"  placeholder="Clinic Type(In Traditional)" name="clinic_type_t" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Picture</label>
                        <input type="file" name="picture">
                    </div>
                      <div class="form-group">
                        <label for="firstname">Email</label>
                        <input type="text" class="form-control"  placeholder="Email" name="email" value="" required>
                    </div>
                     <div class="form-group">
                        <label for="firstname">Password</label>
                        <input type="text" class="form-control"  placeholder="Password" name="password" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Phone Number</label>
                        <input type="text" class="form-control"  placeholder="Phone Number" name="phoneno" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Fax</label>
                        <input type="text" class="form-control"  placeholder="Fax" name="fax" value="" required>
                    </div>
                    <div id="loc" class="geo-details">
                    <div class="form-group" >
                        <label for="firstname">Address</label>
                        <input type="text" class="form-control" id="address" placeholder="Address" name="address" value="" required>
                        <input type="hidden" data-geo="lat" value=""  id="setting_latitude" name="lat" class="location">  
				      <input type="hidden" data-geo="lng" value="" id="setting_longitude" name="long" class="location">
				   </div>
                    </div>
                    <div class="form-group" >
                        <label for="firstname">Address(In Simplified)</label>
                        <input type="text" class="form-control" id="address_s" placeholder="Address" name="address_s" value="" required>
				   </div>
				   <div class="form-group" >
                        <label for="firstname">Address(In Traditional)</label>
                        <input type="text" class="form-control" id="address_t" placeholder="Address" name="address_t" value="" required>
				   </div>
                    <div class="form-group">
                        <label for="firstname">District</label>
                        <input type="text" class="form-control"  placeholder="District" name="district" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">District(In Simplified)</label>
                        <input type="text" class="form-control"  placeholder="District(In Simplified)" name="district_s" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">District(In Traditional)</label>
                        <input type="text" class="form-control"  placeholder="District(In Traditional)" name="district_t" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Introduction</label>
                        <input type="text" class="form-control"  placeholder="Introduction" name="introduction" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Introduction(In Simplified)</label>
                        <input type="text" class="form-control"  placeholder="Introduction(In Simplified)" name="introduction_s" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Introduction(In Traditional)</label>
                        <input type="text" class="form-control"  placeholder="Introduction(In Traditional)" name="introduction_t" value="" required>
                    </div>
                     <div class="form-group">
                        <label for="firstname">Service Start Time</label>
                        <input type="text" class="form-control"  placeholder="Service Start Time (h:m)" name="service_start_time" value="" required>
                    </div>
                     <div class="form-group">
                        <label for="firstname">Service End Time</label>
                        <input type="text" class="form-control"  placeholder="Service End Time (h:m)" name="service_end_time" value="" required>
                    </div>
                     <div class="control-group">
                        <label for="firstname">Services</label>
                        <div class="controls">
							<select multiple class="form-control" data-rel="chosen" name="services[]">
							<?php 
							  foreach($services as $ser) { 
								 
							      echo "<option value='".$ser['id']."'>".$ser['service_name']."</option>";
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

<script>
$(function () {	
	$("#address").geocomplete({
           
	  details: ".geo-details",
	  detailsAttribute: "data-geo",
	});
	$("#address_s").geocomplete({
	});
	$("#address_t").geocomplete({
	});
});
$(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
   
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append(' <div class="geo-details'+x+'"><div class="form-group"><label for="firstname">Address '+x+'</label><br><input type="text" class="form-control addressii" id="address'+x+'" placeholder="Address" name="address[]" value=""><input type="hidden" data-geo="lat" value=""   name="lat[]" class="location"><input type="hidden" data-geo="lng" value=""  name="long[]" class="location">   <div class="form-group"><label for="firstname">Address (In sim)'+x+'</label><br><input type="text" class="form-control addressii" id="address_s'+x+'" placeholder="Address" name="address_s[]" value=""></div><div class="form-group"><label for="firstname">Address (In Tra)'+x+'</label><br><input type="text" class="form-control addressii" id="address_t'+x+'" placeholder="Address" name="address_t[]" value=""></div><div class="form-group"> <label for="firstname">District</label> <input type="text" class="form-control"  placeholder="District" name="district[]" value="" required></div>    <div class="form-group">  <label for="firstname">District(In Simplified)</label> <input type="text" class="form-control"  placeholder="District(In Simplified)" name="district_s[]" value="" required> </div> <div class="form-group"> <label for="firstname">District(In Traditional)</label><input type="text" class="form-control"  placeholder="District(In Traditional)" name="district_t[]" value="" required> </div><a href="#" class="remove_field btn btn-danger btn-sm"> Remove</a></div>'); //add input box
        }
        $("#address"+x).geocomplete({
           
	  details: ".geo-details"+x,
	  detailsAttribute: "data-geo",
	});
	$("#address_s"+x).geocomplete({
	});
	$("#address_t"+x).geocomplete({
	});
    });
   
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    });
    
});
</script>
