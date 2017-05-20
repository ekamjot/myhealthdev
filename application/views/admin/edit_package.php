<div id="content" class="col-lg-10 col-sm-10">
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
			<?php if($this->session->flashdata('success_msg')){
				echo "<h2 style='text-align:center'>".$this->session->flashdata('success_msg')."</h2>";
			}
				?>
          <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-edit"></i> Edit Package Name</h2>
            </div>
            <div class="box-content">
                <form role="form" method="post" id="edit_package_name"  enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="firstname">Button Name in English</label>
                        <input type="text" class="form-control"  placeholder="Button Name in English" name="english_name" value="<?php echo $package_detail['english_name']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="firstname">Button Name in Traditional Chinese</label>
                        <input type="text" class="form-control"  placeholder="Button Name(In Traditional)" name="traditional_chinese_name" value="<?php echo $package_detail['traditional_chinese_name']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Button Name in Simplified Chinese</label>
                        <input type="text" class="form-control"  placeholder="Button Name(In Simplified)" name="simplified_chinese_name" value="<?php echo $package_detail['simplified_chinese_name']; ?>" required>
                    </div>          
                    
                    <input type="submit" class="btn btn-primary" value="Submit" name="submit">
                </form>

            </div>
        </div>
    </div>
</div><!--/row-->
</div>