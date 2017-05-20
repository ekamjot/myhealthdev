<div id="content" class="col-lg-10 col-sm-10">
            <!-- content starts -->
          
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
			<?php if($this->session->flashdata('success_msg')){
				echo "<h2 style='text-align:center'>".$this->session->flashdata('success_msg')."</h2>";
			}
				?>
			<?php
			if($type=='s'){ 
			?>
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-edit"></i> Edit Service</h2>
            </div>
			<form method="post" enctype="multipart/form-data" >  
            <div class="box-content">
				<div class="form-group">
				<label for="firstname">Service Name</label>
				<input type="text" class="form-control"  name="service_name" value="<?php echo $services['service_name']; ?>" required>
		   </div>
		   <div class="form-group">
				<label for="firstname">Service Name(In simplified)</label>
				<input type="text" class="form-control"  name="service_name_s" value="<?php echo $services['service_name_s']; ?>" required>
		   </div>
		   <div class="form-group">
				<label for="firstname">Service Name(In traditional)</label>
				<input type="text" class="form-control" name="service_name_t" value="<?php echo $services['service_name_t']; ?>" required>
		   </div>
		    <div class="form-group">
				<label for="firstname">Price</label>
				<input type="text" class="form-control" name="price" value="<?php echo $services['price']; ?>" required>
		   </div>
		    <div class="control-group">
                        <label for="firstname">Category</label>
                        <div class="controls">
							<select  class="form-control" name="category">
							<?php 
							  foreach($service_cat as $ss) { 
							      echo "<option value='".$ss['id']."' ".(($ss['id']==$services['cat_id'])?'selected':'').">".$ss['cat_name']."</option>";
							 } ?>      
							</select>
						</div> 
<br>						
                    </div> 
			<?php } else{ ?>
			     <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-edit"></i> Edit Package</h2>
            </div>
			<form method="post" enctype="multipart/form-data" >  
            <div class="box-content">
				<div class="form-group">
				<label for="firstname">category Name</label>
				<input type="text" class="form-control"  name="cat_name" value="<?php echo $category['cat_name']; ?>" required>
		   </div>
		   <div class="form-group">
				<label for="firstname">category Name(In simplified)</label>
				<input type="text" class="form-control"  name="cat_name_s" value="<?php echo $category['cat_name_s']; ?>" required>
		   </div>
		   <div class="form-group">
				<label for="firstname">category Name(In traditional)</label>
				<input type="text" class="form-control" name="cat_name_t" value="<?php echo $category['cat_name_t']; ?>" required>
		   </div>
		   <br>
			<?php }			
			?>
			<input type="submit" class="btn btn-primary" value="Submit" name="submit">
           </div>
        </div>
    </div>
</div><!--/row-->


    <!-- content ends -->
    </div><!--/#content.col-md-0-->


    <!-- content ends -->
    </div><!--/#content.col-md-0-->

