 <div id="content" class="col-lg-10 col-sm-10">

     <!--- Advertisement Section starts--->	
<div id="advertisement" class="currenttt">               
	<div class="row">
		<div class="box col-md-12">
			<div class="box-inner">
				<div class="box-header well">
					<h2><i class="glyphicon glyphicon-info-sign"></i> Advertisement</h2>
					<div class="box-icon">	
						<a href="#" class="btn btn-minimize btn-round btn-default"><i
								class="glyphicon glyphicon-chevron-up"></i></a>						
					</div>
					</div>
					<div class="box-content">
					<form role="form" method="post" enctype="multipart/form-data" >
						<div class="form-group">
							<label for="firstname">Upload Pic</label>
							<input type="file"   name="upload_adver">
						</div>
						<div class="form-group">
							<label for="firstname">link</label>
							<input type="text"   name="link" >
						</div>
						<div class="form-group">
							<label for="firstname">Language</label>
							<input type="radio"   name="language" value="e">English
							<input type="radio"   name="language" value="t">Traditional chinese 
							<input type="radio"   name="language" value="s">Simplified chinese 
						</div>
					<input type="submit" class="btn btn-primary btn-sm" value="Submit" name="adver_submit">
					</form>
					<br>
					<strong>(English List)</strong>
					<br>
					<form method="post">
                    <table class="table table-striped table-bordered responsive">
						
                        <thead>
                        <tr>
							 <th>File Name</th>
                            <th>file_path</th>
                            <th>Featured</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>

      <?php 
      foreach(@$adver_images as $user) { ?>
                        <tr>	
                            <td><?php echo $user['file_name']; ?></td>
                            <td><img width="50" height="50" src="<?php echo base_url(); ?>/public/uploads/others/<?php echo $user['file_path']; ?>"></td>
                            <td class="center"><?php
								if($user['featured'] == 'yes') $checked =  "checked"; 
								else $checked =  "";
								?>
								<input type="checkbox" value="<?php echo  $user['featured']; ?>" data-id="<?php echo  $user['id']; ?>" class="featuredd" name="featured" <?php echo $checked; ?>></td>
                            <td class="center">
                                    <button type="submit" name="delete" value="<?php echo  $user['id']; ?>" onClick="return confirm('Are you sure you want to delete?');" class="btn btn-danger btn-sm">Delete</button>
                            </td>
                        </tr>
         <?php } ?>              
                        </tbody>
                    </table>
                    </form>
                
					<br>
					<strong>(Traditional Chinese List)</strong>
					<br>
					<form method="post">
                    <table class="table table-striped table-bordered responsive">
						
                        <thead>
                        <tr>
							 <th>File Name</th>
                            <th>file_path</th>
                            <th>Featured</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>

      <?php 
      foreach(@$adver_images_t as $user) { ?>
                        <tr>	
                            <td><?php echo $user['file_name']; ?></td>
                            <td><img width="50" height="50" src="<?php echo base_url(); ?>/public/uploads/others/<?php echo $user['file_path']; ?>"></td>
                            <td class="center"><?php
								if($user['featured'] == 'yes') $checked =  "checked"; 
								else $checked =  "";
								?>
								<input type="checkbox" value="<?php echo  $user['featured']; ?>" data-id="<?php echo  $user['id']; ?>" class="featuredd" name="featured" <?php echo $checked; ?>></td>
                            <td class="center">
                                    <button type="submit" name="delete" value="<?php echo  $user['id']; ?>" onClick="return confirm('Are you sure you want to delete?');" class="btn btn-danger btn-sm">Delete</button>
                            </td>
                        </tr>
         <?php } ?>              
                        </tbody>
                    </table>
                    </form>
                
					<br>
					<strong>(Simplified Chinese List)</strong>
					<br>
					<form method="post">
                    <table class="table table-striped table-bordered responsive">
						
                        <thead>
                        <tr>
							 <th>File Name</th>
                            <th>file_path</th>
                            <th>Featured</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>

      <?php 
      foreach(@$adver_images_s as $user) { ?>
                        <tr>	
                            <td><?php echo $user['file_name']; ?></td>
                            <td><img width="50" height="50" src="<?php echo base_url(); ?>/public/uploads/others/<?php echo $user['file_path']; ?>"></td>
                            <td class="center"><?php
								if($user['featured'] == 'yes') $checked =  "checked"; 
								else $checked =  "";
								?>
								<input type="checkbox" value="<?php echo  $user['featured']; ?>" data-id="<?php echo  $user['id']; ?>" class="featuredd" name="featured" <?php echo $checked; ?>></td>
                            <td class="center">
                                    <button type="submit" name="delete" value="<?php echo  $user['id']; ?>" onClick="return confirm('Are you sure you want to delete?');" class="btn btn-danger btn-sm">Delete</button>
                            </td>
                        </tr>
         <?php } ?>              
                        </tbody>
                    </table>
                    </form>
                
					</div>
				
			</div>
		</div>
	</div>
</div> 
    <!--- Advertisement Section ends --->	
    <!--- e information section starts --->
  
<div id="einformation" class="currenttt"> 
 <div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well">
                <h2><i class="glyphicon glyphicon-info-sign"></i> E-information Pic</h2>

                <div class="box-icon">
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i
                            class="glyphicon glyphicon-chevron-up"></i></a>
                </div>
            </div>
					<div class="box-content">
					<form role="form" method="post"  enctype="multipart/form-data" >
						<div class="form-group">
							<label for="firstname">Upload Pic</label>
							<input type="file" name="upload_einfo">
						</div>
						<div class="form-group">
							<label for="firstname">link</label>
							<input type="text"   name="link" >
						</div>
						<div class="form-group">
							<label for="firstname">Language</label>
							<input type="radio"   name="language" value="e">English
							<input type="radio"   name="language" value="t">Traditional chinese 
							<input type="radio"   name="language" value="s">Simplified chinese 
						</div>
					<input type="submit" class="btn btn-primary btn-sm" value="Submit" name="info_submit">
					</form>
					<br>
					<strong>In English</strong>
					<br>
					<form method="post">
                    <table class="table table-striped table-bordered responsive">
						
                        <thead>
                        <tr>
							 <th>File Name</th>
                            <th>file_path</th>
                            <th>Featured</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>

      <?php 
      foreach(@$einfo_images as $user) { ?>
                        <tr>	
                            <td><?php echo $user['file_name']; ?></td>
                           <td><img width="50" height="50" src="<?php echo base_url(); ?>/public/uploads/others/<?php echo $user['file_path']; ?>"></td>
                            <td class="center"><?php
								if($user['featured'] == 'yes') $checked =  "checked"; 
								else $checked =  "";
								?>
								<input type="checkbox" value="<?php echo  $user['featured']; ?>" class="featuredd" data-id="<?php echo  $user['id']; ?>" name="featured" <?php echo $checked; ?>></td>
                            <td class="center">
                                    <button type="submit" name="delete" value="<?php echo  $user['id']; ?>" onClick="return confirm('Are you sure you want to delete?');" class="btn btn-danger btn-sm">Delete</button>
                            </td>
                        </tr>
         <?php } ?>              
                        </tbody>
                    </table>
                    </form>
					<br>
					<strong>In Traditional Chinese</strong>
					<br>
					<form method="post">
                    <table class="table table-striped table-bordered responsive">
						
                        <thead>
                        <tr>
							 <th>File Name</th>
                            <th>file_path</th>
                            <th>Featured</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>

      <?php 
      foreach(@$einfo_images1 as $user) { ?>
                        <tr>	
                            <td><?php echo $user['file_name']; ?></td>
                           <td><img width="50" height="50" src="<?php echo base_url(); ?>/public/uploads/others/<?php echo $user['file_path']; ?>"></td>
                            <td class="center"><?php
								if($user['featured'] == 'yes') $checked =  "checked"; 
								else $checked =  "";
								?>
								<input type="checkbox" value="<?php echo  $user['featured']; ?>" class="featuredd" data-id="<?php echo  $user['id']; ?>" name="featured" <?php echo $checked; ?>></td>
                            <td class="center">
                                    <button type="submit" name="delete" value="<?php echo  $user['id']; ?>" onClick="return confirm('Are you sure you want to delete?');" class="btn btn-danger btn-sm">Delete</button>
                            </td>
                        </tr>
         <?php } ?>              
                        </tbody>
                    </table>
                    </form>
					<br>
					<strong>In Simplified Chinese</strong>
					<br>
					<form method="post">
                    <table class="table table-striped table-bordered responsive">
						
                        <thead>
                        <tr>
							 <th>File Name</th>
                            <th>file_path</th>
                            <th>Featured</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>

      <?php 
      foreach(@$einfo_images2 as $user) { ?>
                        <tr>	
                            <td><?php echo $user['file_name']; ?></td>
                           <td><img width="50" height="50" src="<?php echo base_url(); ?>/public/uploads/others/<?php echo $user['file_path']; ?>"></td>
                            <td class="center"><?php
								if($user['featured'] == 'yes') $checked =  "checked"; 
								else $checked =  "";
								?>
								<input type="checkbox" value="<?php echo  $user['featured']; ?>" class="featuredd" data-id="<?php echo  $user['id']; ?>" name="featured" <?php echo $checked; ?>></td>
                            <td class="center">
                                    <button type="submit" name="delete" value="<?php echo  $user['id']; ?>" onClick="return confirm('Are you sure you want to delete?');" class="btn btn-danger btn-sm">Delete</button>
                            </td>
                        </tr>
         <?php } ?>              
                        </tbody>
                    </table>
                    </form>
                
					</div>
				</div>
    </div>
</div>
</div> 
    <!--- e information Section ends --->	
    <!--- About Us section starts --->
<div id="about_us" class="currenttt"> 
 <div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well">
                <h2><i class="glyphicon glyphicon-info-sign"></i> About Us</h2>

                <div class="box-icon">
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i
                            class="glyphicon glyphicon-chevron-up"></i></a>
                </div>
            </div>
					<div class="box-content">
					<form role="form" method="post">
						<div class="form-group">
							<label for="firstname"> About Us</label>
							<textarea name="about_us" class="form-control" rows="10"><?php echo $about_us['content']; ?></textarea>
						</div>
					<input type="submit" class="btn btn-primary btn-sm" value="Submit" name="about_submit">
					</form>
					</div>
				</div>
    </div>
</div>
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well">
                <h2><i class="glyphicon glyphicon-info-sign"></i> About Us(In Traditional Chinese)</h2>

                <div class="box-icon">
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i
                            class="glyphicon glyphicon-chevron-up"></i></a>
                </div>
            </div>
					<div class="box-content">
					<form role="form" method="post">
						<div class="form-group">
							<label for="firstname"> About Us(In Traditional Chinese)</label>
							<textarea name="about_us" class="form-control" rows="10"><?php echo $about_us['content_t']; ?></textarea>
						</div>
					<input type="submit" class="btn btn-primary btn-sm" value="Submit" name="about_submit_t">
					</form>
					</div>
				</div>
    </div>
</div>
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well">
                <h2><i class="glyphicon glyphicon-info-sign"></i> About Us(In Simplified Chinese)</h2>

                <div class="box-icon">
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i
                            class="glyphicon glyphicon-chevron-up"></i></a>
                </div>
            </div>
					<div class="box-content">
					<form role="form" method="post">
						<div class="form-group">
							<label for="firstname"> About Us(In Simplified Chinese)</label>
							<textarea name="about_us" class="form-control" rows="10"><?php echo $about_us['content_s']; ?></textarea>
						</div>
					<input type="submit" class="btn btn-primary btn-sm" value="Submit" name="about_submit_s">
					</form>
					</div>
				</div>
    </div>
</div>
</div>
    <!--- About Us Section ends --->	
    <!--- Privacy Policy section starts --->
<div id="privacy_policy" class="currenttt"> 
 <div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well">
                <h2><i class="glyphicon glyphicon-info-sign"></i> Privacy Policy</h2>

                <div class="box-icon">
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i
                            class="glyphicon glyphicon-chevron-up"></i></a>
                </div>
            </div>
           <div class="box-content">
					<form role="form" method="post">
						<div class="form-group">
							<label for="firstname"> Privacy Policy</label>
							<textarea name="privacy_policy" class="form-control" rows="10"><?php echo $privacy_policy['content']; ?></textarea>
						</div>
					<input type="submit" class="btn btn-primary btn-sm" value="Submit" name="pp_submit">
					</form>
					</div></div>
    </div>
</div>
 <div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well">
                <h2><i class="glyphicon glyphicon-info-sign"></i> Privacy Policy(In Traditional Chinese)</h2>

                <div class="box-icon">
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i
                            class="glyphicon glyphicon-chevron-up"></i></a>
                </div>
            </div>
           <div class="box-content">
					<form role="form" method="post">
						<div class="form-group">
							<label for="firstname"> Privacy Policy(In Traditional Chinese)</label>
							<textarea name="privacy_policy" class="form-control" rows="10"><?php echo $privacy_policy['content_t']; ?></textarea>
						</div>
					<input type="submit" class="btn btn-primary btn-sm" value="Submit" name="pp_submit_t">
					</form>
					</div></div>
    </div>
</div>
 <div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well">
                <h2><i class="glyphicon glyphicon-info-sign"></i> Privacy Policy(In Simplified Chinese)</h2>

                <div class="box-icon">
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i
                            class="glyphicon glyphicon-chevron-up"></i></a>
                </div>
            </div>
           <div class="box-content">
					<form role="form" method="post">
						<div class="form-group">
							<label for="firstname"> Privacy Policy(In Simplified Chinese)</label>
							<textarea name="privacy_policy" class="form-control" rows="10"><?php echo $privacy_policy['content_s']; ?></textarea>
						</div>
					<input type="submit" class="btn btn-primary btn-sm" value="Submit" name="pp_submit_s">
					</form>
					</div></div>
    </div>
</div>
</div>
    <!--- Privacy Policy Section ends --->	
    <!--- Contact Us section starts --->
<div id="contact_us" class="currenttt"> 
 <div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well">
                <h2><i class="glyphicon glyphicon-info-sign"></i> Contact Us</h2>

                <div class="box-icon">
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i
                            class="glyphicon glyphicon-chevron-up"></i></a>
                </div>
            </div>
           <div class="box-content">
					<form role="form" method="post">
						<div class="form-group">
							<label for="firstname"> Contact Us</label>
							<textarea name="contact_us" class="form-control" rows="10"><?php echo $contact_us['content']; ?></textarea>
						</div>
					<input type="submit" class="btn btn-primary btn-sm" value="Submit" name="contact_submit">
					</form>
					</div></div>
    </div>
</div>
 <div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well">
                <h2><i class="glyphicon glyphicon-info-sign"></i> Contact Us(In Traditional Chinese)</h2>

                <div class="box-icon">
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i
                            class="glyphicon glyphicon-chevron-up"></i></a>
                </div>
            </div>
           <div class="box-content">
					<form role="form" method="post">
						<div class="form-group">
							<label for="firstname"> Contact Us(In Traditional Chinese)</label>
							<textarea name="contact_us" class="form-control" rows="10"><?php echo $contact_us['content_t']; ?></textarea>
						</div>
					<input type="submit" class="btn btn-primary btn-sm" value="Submit" name="contact_submit_t">
					</form>
					</div></div>
    </div>
</div>
 <div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well">
                <h2><i class="glyphicon glyphicon-info-sign"></i> Contact Us(In Simplified Chinese)</h2>

                <div class="box-icon">
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i
                            class="glyphicon glyphicon-chevron-up"></i></a>
                </div>
            </div>
           <div class="box-content">
					<form role="form" method="post">
						<div class="form-group">
							<label for="firstname"> Contact Us(In Simplified Chinese)</label>
							<textarea name="contact_us" class="form-control" rows="10"><?php echo $contact_us['content_s']; ?></textarea>
						</div>
					<input type="submit" class="btn btn-primary btn-sm" value="Submit" name="contact_submit_s">
					</form>
					</div></div>
    </div>
</div>
</div>
    <!--- Contact Us Section ends --->	
    <!--- Terms Use section starts --->
<div id="terms_use" class="currenttt"> 
 <div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well">
                <h2><i class="glyphicon glyphicon-info-sign"></i> Terms of Use</h2>

                <div class="box-icon">
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i
                            class="glyphicon glyphicon-chevron-up"></i></a>
                </div>
            </div>
          <div class="box-content">
					<form role="form" method="post">
						<div class="form-group">
							<label for="firstname"> Terms of Use</label>
							<textarea name="terms_use" class="form-control" rows="10"><?php echo $terms_use['content']; ?></textarea>
						</div>
					<input type="submit" class="btn btn-primary btn-sm" value="Submit" name="term_submit">
					</form>
					</div></div>
    </div>
</div>
 <div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well">
                <h2><i class="glyphicon glyphicon-info-sign"></i> Terms of Use(In Traditional Chinese)</h2>

                <div class="box-icon">
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i
                            class="glyphicon glyphicon-chevron-up"></i></a>
                </div>
            </div>
          <div class="box-content">
					<form role="form" method="post">
						<div class="form-group">
							<label for="firstname"> Terms of Use(In Traditional Chinese)</label>
							<textarea name="terms_use" class="form-control" rows="10"><?php echo $terms_use['content_t']; ?></textarea>
						</div>
					<input type="submit" class="btn btn-primary btn-sm" value="Submit" name="term_submit_t">
					</form>
					</div></div>
    </div>
</div>
 <div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well">
                <h2><i class="glyphicon glyphicon-info-sign"></i> Terms of Use(In Simplified Chinese)</h2>

                <div class="box-icon">
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i
                            class="glyphicon glyphicon-chevron-up"></i></a>
                </div>
            </div>
          <div class="box-content">
					<form role="form" method="post">
						<div class="form-group">
							<label for="firstname"> Terms of Use(In Simplified Chinese)</label>
							<textarea name="terms_use" class="form-control" rows="10"><?php echo $terms_use['content_s']; ?></textarea>
						</div>
					<input type="submit" class="btn btn-primary btn-sm" value="Submit" name="term_submit_s">
					</form>
					</div></div>
    </div>
</div>
</div>
<!-- content ends -->
    </div><!--/#content.col-md-0-->
<script>
	

$('.featuredd').click(function() {
	id = $(this).data("id");
	val = $(this).val();
	if(val=='no'){
          featured = 'yes';
     }else{
          featured = 'no';
     }
			   $.ajax({
			  url: "<?php echo base_url(); ?>admin/make_featured_images",
			  method: "POST",
			  data: { featured : featured,id:id},
			  success: function(result){
				  if(result == 1){ 
					  console.log($('input[data-id='+id+'].featuredd').val(featured));
				}
				  else {  alert('connection problem'); return false;}
				}
			});
});
</script>
