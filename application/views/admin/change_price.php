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
                <h2><i class="glyphicon glyphicon-edit"></i> Charge Patients to translate a Document</h2>
            </div>
            <div class="box-content">
                <form role="form" method="post" id="addcategory"  enctype="multipart/form-data" >
                    <div class="form-group">
                        <label for="Price">Price</label>
                        <input type="number" class="form-control"  placeholder="Price" name="price" value="<?php echo $price['content']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="Price">Charge for Doctor consultation for report</label>
                        <input type="number" class="form-control"  placeholder="Price" name="cprice1" value="<?php echo $cprice1['content']; ?>" required>
                    </div> 
                     <div class="form-group">
                        <label for="Price">Charge for Phone consultation for report</label>
                        <input type="number" class="form-control"  placeholder="Price" name="cprice2" value="<?php echo $cprice2['content']; ?>" required>
                    </div>

                    <input type="submit" class="btn btn-primary" value="Submit" name="submit">
                </form>

            </div>
             
        </div>
    </div>
</div><!--/row-->

    <!-- content ends -->
    </div><!--/#content.col-md-0-->

