<script>
	$(document).ready(function() {	
		$("#addcategory").validate({
			rules: {
				category: "required",
			},
				
		});
	});
	
</script>

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
                <h2><i class="glyphicon glyphicon-edit"></i>Edit Category</h2>
            </div>
            <div class="box-content">
                <form role="form" method="post" id="addcategory" >
                    <div class="form-group">
                        <label for="firstname">Category</label>
                        <input type="text" class="form-control"  placeholder="Category" name="category" value="<?php echo $category['name']; ?>">
                    </div>
                   

                    <input type="submit" class="btn btn-default" value="Submit" name="addcategorys">
                </form>

            </div>

        </div>
    </div>
</div><!--/row-->

    <!-- content ends -->
    </div><!--/#content.col-md-0-->
