<script type="text/javascript" src="<?php echo base_url(); ?>public/ckeditor/ckeditor.js"></script>
<div id="content" class="col-lg-10 col-sm-10">
            <!-- content starts -->
   <form method="post" enctype="multipart/form-data" >
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
			<?php if($this->session->flashdata('success_msg')){
				echo "<h2 style='text-align:center'>".$this->session->flashdata('success_msg')."</h2>";
			}
				?>
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-edit"></i> <?php echo $title; ?></h2>
            </div>
            <div class="box-content">
					<div class="form-group">
								<label for="firstname">Uploader Name</label>
								<input type="text" class="form-control"  placeholder="Uploader Name" name="uploader_name" value="<?php echo $einfo['uploader_name']; ?>" required>
							</div>
					 <div class="form-group">
								<label for="firstname">Picture</label>
								<input type="file" name="picture">
								<?php if($einfo['image']){
									echo '<img src="'.base_url().'public/uploads/others/'.$einfo['image'].'" width="80" height="40">';
								} ?>
                    </div>           
                    <div class="form-group">
                        <label for="firstname">Title</label>
                        <input type="text" class="form-control"   placeholder="Title" name="title" value="<?php echo $einfo['title']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Type</label>
                        <select class="form-control" name="type">
							<option>Select Type</option>
							<?php
							foreach($cats as $cat){ ?>
							<option <?php echo (($einfo['type'] ==$cat['id'])?'selected':''); ?> value="<?php echo $cat['id']; ?>"><?php echo $cat['cat_name']; ?></option>
							<?php } ?>
						</select>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Text</label>
                        <?php
                        echo $this->ckeditor->editor("content1",$einfo['content']);
                        ?>
                    </div>
                   <div class="form-group">
								<label for="firstname">Picture</label>
								<input type="file" name="e_image">
								<?php if($einfo['e_image']){
									echo '<img src="'.base_url().'public/uploads/others/'.$einfo['e_image'].'" width="80" height="40">';
								} ?>
                    </div>   
                   
            </div>
           
        </div>
    </div>
</div><!--/row-->


<!------------------- Simplified --------------------------->
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-edit"></i> <?php echo $title; ?> Simplified</h2>
            </div>
            <div class="box-content">
                    <div class="form-group">
                        <label for="firstname">Uploader Name</label>
                        <input type="text" class="form-control"  placeholder="Uploader Name" name="uploader_name2" value="<?php echo $einfo1['uploader_name']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Title</label>
                        <input type="text" class="form-control"   placeholder="Title" name="title2" value="<?php echo $einfo1['title']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Text</label>
                        <?php
                        echo $this->ckeditor->editor("content2",$einfo1['content']);
                        ?>
                    </div>
            </div>
           
        </div>
    </div>
</div><!--/row-->


<!---------------------------- Traditional ----------------------------------->
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-edit"></i> <?php echo $title; ?> Traditional language</h2>
            </div>
            <div class="box-content">
				<div class="form-group">
                        <label for="firstname">Uploader Name</label>
                        <input type="text" class="form-control"  placeholder="Uploader Name" name="uploader_name3" value="<?php echo $einfo2['uploader_name']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Title</label>
                        <input type="text" class="form-control"   placeholder="Title" name="title3" value="<?php echo $einfo2['title']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Text</label>
                        <?php
                        echo $this->ckeditor->editor("content3",$einfo2['content']);
                        ?>
                    </div>                 
                    <br>
                    <input type="submit" class="btn btn-primary" value="Submit" name="submit">
               

            </div>
           
        </div>
    </div>
</div><!--/row-->
 </form>


    <!-- content ends -->
    </div><!--/#content.col-md-0-->

