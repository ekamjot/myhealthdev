  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style>/*#calendar1{width:500px;}*/</style>
<?php
	if(!empty($dates)){
		foreach($dates as $d){
			 //echo $d['nondate']; 
			?>
			<style>
				td[data-date="<?php echo $d['nondate']; ?>"]{background:red;}
			</style>
			
			<?php
			
		}
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
                <h2><i class="glyphicon glyphicon-edit"></i> Disable Your Dates in Calender</h2>
            </div>
            <div class="box-content">
                <form role="form" method="post" id="addcategory" >
                   <!-- <div class="form-group">
                        <label for="firstname">Select Service Type</label>
                        <?php
                        if(isset($_GET['type'])){
							$user = $_GET['type'];
						}else{
							$user='P';
						}
						?>
                        <select id="cattype" name="user_type" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);" class="form-control" >
							<option value="#" data-id="">Select Type</option>
							<option <?php echo (($user=='P')?'selected':'');?> value="<?php echo base_url().'admin/check_dates?type=P'; ?>" data-id="P">Physical examination</option>
							<option <?php echo (($user=='D')?'selected':'');?> value="<?php echo base_url().'admin/check_dates?type=D'; ?>" data-id="D">Appointment for doctor</option>
							<option <?php echo (($user=='M')?'selected':'');?> value="<?php echo base_url().'admin/check_dates?type=M'; ?>" data-id="M">Appointment for Medicalscan</option>
							<option <?php echo (($user=='E')?'selected':'');?> value="<?php echo base_url().'admin/check_dates?type=E'; ?>" data-id="E">Endoscopy</option>
					   </select>
                    </div>-->
                    <div id='calendar1'></div>
                </form>

            </div>
        </div>
    </div>
</div><!--/row-->

    <!-- content ends -->
    </div><!--/#content.col-md-0-->

<div id="fullCalModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
                <h4 id="modalTitle" class="modal-title"></h4>
            </div>
            <div id="modalBody" class="modal-body">
				<strong>Description:</strong><div id ="desc"></div><br>
				<strong>Appointment Detail:</strong><div id ="appointment_detail"></div><br>
				
				<strong>Date:</strong><div id ="date"></div><br>
				<strong>Time:</strong><div id ="time"></div><br>
            </div>
        </div>
    </div>
</div>

    
<script>
	$(document).ready(function() {

    // page is now ready, initialize the calendar...

    $('#calendar1').fullCalendar({
		eventSources: [<?php echo json_encode(@$tasks); ?>,<?php echo json_encode(@$tasks1); ?>],
        header: {left: '',center: 'prev title next',right: ''},
        eventLimit: true, 
       eventClick:  function(event, jsEvent, view) {
            $('#modalTitle').html(event.title); 
            $('#desc').html(event.title1);
            $('#date').html(event.date);
            $('#time').html(event.time);
			$('#appointment_detail').html(event.appointment_detail);
			//$('#service').html(event.services_detail); 
            $('#fullCalModal').modal();
        },
        dayClick: function (date, jsEvent, view) {
		/*  if(confirm('Are you sure?')){ 
			   $("td[data-date="+date.format('YYYY-MM-DD')+"]").css("background",'red');
			   val = $('#cattype').find(':selected').data("id");
			   $.ajax({
			  url: "<?php echo base_url(); ?>admin/disabled_dates",
			  method: "POST",
			  data: { nondate : date.format('YYYY-MM-DD'),type :  val},
			  success: function(result){
				  if(result==0){
					$.ajax({
					  url: "<?php echo base_url(); ?>admin/disabled_dates_remove",
					  method: "POST",
					  data: { nondate : date.format('YYYY-MM-DD'),type :  val},
					  success: function(result){
						  $("td[data-date="+date.format('YYYY-MM-DD')+"]").css("background",'none');
						  alert(result);
						  
						}
					});
				}
				}
			});
		
		}else{
			return false;
		}*/
		
		$('<div></div>').appendTo('body')
    .html('<div><h6>Are you sure?</h6></div>')
    .dialog({
        modal: true,
        title: 'Delete message',
        zIndex: 10000,
        autoOpen: true,
        width: '300px',
        resizable: false,
        buttons: {
            Yes: function () {
                $("td[data-date="+date.format('YYYY-MM-DD')+"]").css("background",'red');
			   val = $('#cattype').find(':selected').data("id");
			   $.ajax({
			  url: "<?php echo base_url(); ?>admin/disabled_dates",
			  method: "POST",
			  data: { nondate : date.format('YYYY-MM-DD'),type :  val},
			  success: function(result){
				  if(result==0){
					$.ajax({
					  url: "<?php echo base_url(); ?>admin/disabled_dates_remove",
					  method: "POST",
					  data: { nondate : date.format('YYYY-MM-DD'),type :  val},
					  success: function(result){
						  $("td[data-date="+date.format('YYYY-MM-DD')+"]").css("background",'none');
						  alert(result);
						  
						}
					});
				}
				}
				
			});
			 $(this).dialog("close");
            },
            No: function () {
                $(this).dialog("close");
            }
        },
        close: function (event, ui) {
            $(this).remove();
        }
    });
		
	   }
    })

});
</script>
