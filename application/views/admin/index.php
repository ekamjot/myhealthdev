 <div id="content" class="col-lg-10 col-sm-10">
          <div class=" row">
    <div class="col-md-3 col-sm-3 col-xs-6">
        <a title="" class="well top-block" href="<?php echo base_url() ?>admin/patient_list">
            <i class="glyphicon glyphicon-user blue"></i>

            <div>Patients</div>
            
        </a>
    </div>
    <?php
		if($this->session->userdata('user_type')=='admin') {
		?>
     <div class="col-md-3 col-sm-3 col-xs-6">
        <a title="" class="well top-block" href="<?php echo base_url() ?>admin/package_list">
            <i class="glyphicon glyphicon-user blue"></i>

            <div>Packages</div>
            
        </a>
    </div>
    <?php } ?>
</div>
    <!-- content ends -->
    </div><!--/#content.col-md-0-->
