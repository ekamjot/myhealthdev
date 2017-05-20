<div id="content" class="col-lg-10 col-sm-10">
    <div class="row">
        <div class="box col-md-12">
            <div class="box-inner">
				<?php if($this->session->flashdata('success_msg')){
				echo "<h2 style='text-align:center'>".$this->session->flashdata('success_msg')."</h2>";
			}
				?>
                <div class="box-header well" data-original-title="">
                    <h2><i class="glyphicon glyphicon-user"></i> <?php echo $title; ?> </h2>

                </div>
                <div class="box-content">
					<form method="post" enctype="multipart/form-data">
                    <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">

                        <thead>
                        <tr>
                          <th>Report No</th>
                          <th>Patient Name</th>
                          <th>transaction_id</th>
                          <th>amount</th>
                          <th>Payment Date</th>
                          <th>Translated</th>
                          <th>Original File</th>
                          <th>Translated File</th>
                        </tr>
                        </thead>
                        <tbody>

					  <?php
					  $i = 1;
					  foreach($reports as $report) { ?>
						<tr>
							<td><?php echo $report['report_number']; ?></td>
							<td><?php echo $report['fname'].' '.$report['lname']; ?></td>
							<td><?php echo $report['transaction_id']; ?></td>
							<td><?php echo $report['amount']; ?></td>
							<td><?php
							$date = explode('T',$report['create_time']);
							echo $date[0]; ?></td>
							<td><?php
							if($report['translate']=='Y'){
								echo '<button class="btn btn-round btn-success btn-sm"><i class="glyphicon glyphicon-ok"></i></button>';
							}else{
								echo '<button class="btn btn-round btn-danger btn-sm"><i class="glyphicon glyphicon-remove"></i></button>';
							}
							?>
							</td>
							<td><a href="<?php echo $report['report_file']; ?>" target="_blank"> View Here</a></td>
							<td>
							<?php if($report['translate']=='Y'){ ?>
								<a href="<?php echo $report['report_file']; ?>" target="_blank"> View Here</a>
							<?php } else{ ?>
								<div data-id="<?php echo $report['id']; ?>" id="report_file<?php echo $report['id']; ?>">
								<input type="file" name="report_file" style="font-size: 9px;">
								<input type="hidden" name="report_id" value="<?php echo $report['report_id']; ?>">
								<input type="hidden" name="user_id" value="<?php echo $report['user_id']; ?>">
								</div>
							<?php
							} ?>
							</td>
						</tr>
						 <?php
						 ++$i;
						 } ?>
                        </tbody>
                    </table>
                    </form>
                </div>
            </div>
        </div>
    </div><!--/row-->
 </div><!--/#content.col-md-0-->
 <script>
$(document).ready(function() {
  $("input[name='report_file']").change(function() {
	  val = $(this).parent().data('id');
     report_id = $("#report_file"+val+" input[name='report_id']").val();
     user_id =  $("#report_file"+val+" input[name='user_id']").val();
	var formdata=new FormData();
	formdata.append('report_file', $(this)[0].files[0]); //use get('files')[0]
	formdata.append('report_id',report_id);
	formdata.append('user_id',user_id);
	formdata.append('payment_id',val);
    $.ajax({
        url: "<?php echo base_url().'admin/reports_info_ajax'; ?>",
        type: 'POST',
        data: formdata,
        async: false,
        success: function (data) {
           if(data==1){
			   location.reload(true);
		   }else{
			   alert('upload failed!!!');
		   }
        },
        cache: false,
        contentType: false,
        processData: false
    });

    return false;
  });
});
</script>
