<div id="content" class="col-lg-10 col-sm-10">
            <!-- content starts -->
   <form method="post" enctype="multipart/form-data" >
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-edit"></i> <?php echo $title; ?></h2>
            </div>
            <div class="box-content">
				<strong><a href="<?php echo base_url();?>admin/patient_list" ><i class="glyphicon glyphicon-arrow-left"></i> Back</a></strong>
                   <table class="table table-bordered table-striped">
						<tbody>
						<tr>
							<td>First Name</td>
							<td><?php echo $patient['fname']; ?></td>
						</tr>
						<tr>
							<td>Last Name</td>
							<td><?php echo $patient['lname']; ?></td>
						</tr>
						<tr>
							<td>Email</td>
							<td><?php echo $patient['email']; ?></td>
						</tr>
						<tr>
							<td>Gender</td>
							<td><?php echo $patient['gender']; ?></td>
						</tr>
						<tr>
							<td>Phone Number</td>
							<td><?php echo '('.$patient['country_code'].') '.$patient['phoneno']; ?></td>
						</tr>
						<tr>
							<td>Identity Card Number</td>
							<td><?php echo $patient['country_name'].' - '.$patient['id_card']; ?></td>
						</tr>
						<tr>
							<td>Date Of Birth</td>
							<td><?php echo $patient['dob']; ?></td>
						</tr>
						<tr>
							<td>Address</td>
							<td><?php echo $patient['address']; ?></td>
						</tr>
						</tbody>
					</table>
            </div>
           
        </div>
    </div>
</div><!--/row-->


