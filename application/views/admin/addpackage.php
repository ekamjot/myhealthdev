
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
<div id="content" class="col-lg-10 col-sm-10">
            <!-- content starts -->
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
			<?php if($this->session->flashdata('success_msg')){
				echo "<h2 style='text-align:center'>".$this->session->flashdata('success_msg')."</h2>";
			}
				?>
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-edit"></i><?php echo $title; ?></h2>
            </div>
            <div class="box-content">
                <form role="form" method="post">
                    <div class="form-group">
                        <label for="firstname">Package Name</label>
                        <input type="text" class="form-control"  placeholder="Package Name" name="package_name" value="<?php echo (isset($user)?$user['package_name']:'');?>" >
                    </div>
                    <div class="form-group">
                        <label for="firstname">Package Name(In Simplified)</label>
                        <input type="text" class="form-control"  placeholder="Package Name (In Simplified)" name="package_name_s" value="<?php echo (isset($user)?$user['package_name_s']:'');?>" >
                    </div>
                    <div class="form-group">
                        <label for="firstname">Package Name(In Traditional)</label>
                        <input type="text" class="form-control"  placeholder="Package Name (In Traditional)" name="package_name_t" value="<?php echo (isset($user)?$user['package_name_t']:'');?>" >
                    </div>
                    <div class="form-group">
                        <label for="firstname">Price(in $)</label>
                        <input type="text" class="form-control"  placeholder="Price" name="price" value="<?php echo (isset($user)?$user['price']:'');?>">
                    </div>
                     <div class="form-group">
                        <label for="firstname">Package detail</label>
                        <textarea class="form-control"  placeholder="Package detail" name="package_detail"><?php echo (isset($user)?$user['package_detail']:'');?></textarea>
                    </div>
                     <div class="form-group">
                        <label for="firstname">Package detail (In Simplified)</label>
                        <textarea class="form-control"  placeholder="Package detail (In Simplified)" name="package_detail_s"><?php echo (isset($user)?$user['package_detail_s']:'');?></textarea>
                    </div>
                     <div class="form-group">
                        <label for="firstname">Package detail (In Traditional)</label>
                        <textarea class="form-control"  placeholder="Package detail (In Traditional)" name="package_detail_t"><?php echo (isset($user)?$user['package_detail_t']:'');?></textarea>
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
                    <br>
                    <br>
                    <input type="submit" class="btn btn-primary" value="Submit" name="submit">
                </form>

            </div>

        </div>
    </div>
</div><!--/row-->

    <!-- content ends -->
    </div><!--/#content.col-md-0-->
