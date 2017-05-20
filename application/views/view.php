<html>
	<head>
		<title>Webservices</title>
	</head>
<body>
<h3>(1)login(login)</h3>
<form action="<?php echo base_url()?>webservice/login" method="post" enctype="multipart/form-data">
<table>
<tr><td>phoneno<input type="text" name="phoneno" required>phoneno</td></tr>
<tr><td>password<input type="password" name="password" required>password</td></tr>
<tr><td>country Code <input type="text" name="country_code">country_code</td></tr> 
<tr><td>device_id<span style="color: #FF0000;">*</span><input type="text" name='device_id' >device_id</td></tr>
<tr><td>device_type<span style="color: #FF0000;">*</span><input type="text" name='device_type' >device_type</td></tr>
<tr><td><input type="submit" name="submit" value="Submit"></input></td></tr>
</table>
</form>
*********************************************************************************</br>
<h3>(2)register(register)</h3>
 <form method="post" action="<?php echo base_url()?>webservice/register" enctype="multipart/form-data">
    <table>
    <tr><td>First Name</td>
               <td> <input type="text" name="fname">fname </td></tr>
        <tr><td>Last Name</td>
               <td> <input type="text" name="lname">lname </td></tr>
       <tr><td>Email</td>
               <td> <input type="text" name="email">email</td></tr>           
        <tr><td>Password</td>
               <td> <input type="password" name="password">password</td></tr>
        <tr><td>telephone no.</td>
              <td>  <input type="text" name="phoneno">phoneno</td></tr> 
         <tr><td>gender</td>
              <td>  <input type="text" name="gender">gender</td></tr> 
		 <tr><td>ID card no</td>
			<td>  <input type="text" name="id_card">id_card</td></tr> 
		 <tr><td>dob</td>
			<td> <input type="text" name="dob">dob</td></tr> 
		 <tr><td>Nationality</td>
			<td> <input type="text" name="nationality">nationality</td></tr> 
		 <tr><td>Address</td>
			<td> <input type="text" name="address">address</td></tr>        
		 <tr><td>country Code</td>
			<td> <input type="text" name="country_code">country_code</td></tr>        
		 <tr><td>country Name</td>
			<td> <input type="text" name="country_name">country_name</td></tr>        
        <tr><td>Device Id  </td>
               <td> <input type="text" name="device_id">device_id</td></tr>
        <tr><td>Device Type  </td>
                <td><input type="text" name="device_type">device_type(A=Andriod, I= iphone)</td></tr>
        <tr><td><input type="submit" value="User Registration" name="userRegistration"></tr>
    </table>
</form>
*********************************************************************************</br>
<h3>(3)Forgot Password(forgot)</h3>

<form action="<?php echo base_url()?>webservice/forgot" method="post" enctype="multipart/form-data">
<table>
<tr><td>Phone Number<span style="color: #FF0000;">*</span><input type="text" name="phoneno" required>phoneno</td></tr>
<tr><td>Country Code<span style="color: #FF0000;">*</span><input type="text" name="country_code" >country_code</td></tr>
<tr><td><input type="submit" name="submit" value="Submit"></input></td></tr>
</table>
</form>
*********************************************************************************</br>
<h3>(4)New Password(new_password)</h3>

<form action="<?php echo base_url()?>webservice/new_password" method="post" enctype="multipart/form-data">
<table>
<tr><td>country_code<span style="color: #FF0000;">*</span><input type="text" name="country_code" >country_code</td></tr
><tr><td>Phone Number<span style="color: #FF0000;">*</span><input type="text" name="phoneno" required>phoneno</td></tr>
<tr><td>Unique number<span style="color: #FF0000;">*</span><input type="text" name="random_number" required>random_number</td></tr>
<tr><td>New password<span style="color: #FF0000;">*</span><input type="text" name="password" required>password</td></tr>
<tr><td><input type="submit" name="submit" value="Submit"></input></td></tr>
</table>
</form>
*********************************************************************************</br>
<h3 style="color:red;">(5)Get Appointment Button(get_appointment_button)</h3>

<form action="<?php echo base_url()?>webservice/get_appointment_button" method="post" enctype="multipart/form-data">
<table>
<!--<tr><td>Type<span style="color: #FF0000;">*</span><input type="text" name="type" required>type(P= physical Examaination, M= Medical scan, E = Endoscopy)</td></tr>-->
<tr><td><input type="submit" name="submit" value="Submit"></input></td></tr>
</table>
</form>
*********************************************************************************</br>
<h3 style="color:red;">(6)Get Packages(get_packages)</h3>

<form action="<?php echo base_url()?>webservice/get_packages" method="post" enctype="multipart/form-data">
<table>
<!--<tr><td>Type<span style="color: #FF0000;">*</span><input type="text" name="type" required>type(P= physical Examaination, M= Medical scan, E = Endoscopy)</td></tr>-->
<tr><td><input type="submit" name="submit" value="Submit"></input></td></tr>
</table>
</form>
*********************************************************************************</br>
<h3 style="color:red;">(7)Get Services(get_services)</h3>

<form action="<?php echo base_url()?>webservice/get_services" method="post" enctype="multipart/form-data">
<table>
<!--<tr><td>Type<span style="color: #FF0000;">*</span><input type="text" name="type" required>type(P= physical Examaination, M= Medical scan, E = Endoscopy)</td></tr>-->
<tr><td><input type="submit" name="submit" value="Submit"></input></td></tr>
</table>
</form>
*********************************************************************************</br>
<h3 > (8)Get All Doctor(get_all_doctors)</h3>

<form action="<?php echo base_url()?>webservice/get_all_doctors" method="post" enctype="multipart/form-data">
<table>
<tr><td>Type<span style="color: #FF0000;">*</span><input type="text" name="type" required>type(E=english, S= simplified, T=traditional)</td></tr>
<tr><td><input type="submit" name="submit" value="Submit"></input></td></tr>
</table>
</form>
*********************************************************************************</br>
<h3 >(9)Get Doctor Locations(get_doctors_location)</h3>

<form action="<?php echo base_url()?>webservice/get_doctors_location" method="post" enctype="multipart/form-data">
<table>
<tr><td>Type<input type="text" name="type" required>type(E=english, S= simplified, T=traditional)</td></tr>
<tr><td>Doctor Id<input type="text" name="doc_id" required>doc_id</td></tr>
<tr><td><input type="submit" name="submit" value="Submit"></input></td></tr>
</table>
</form>
*********************************************************************************</br>
<h3 >(10)Get Locations for clinics(get_locations)</h3>

<form action="<?php echo base_url()?>webservice/get_locations" method="post" enctype="multipart/form-data">
<table>
<tr><td>Type<input type="text" name="type" required>type(E=english, S= simplified, T=traditional)</td></tr>
<tr><td>services<input type="text" name="services_id" required>services_id(mutilple id's in comma)</td></tr>
<tr><td><input type="submit" name="submit" value="Submit"></input></td></tr>
</table>
</form>
*********************************************************************************</br>
<h3>(11)Get Disabled(get_disabled_dates)</h3>

<form action="<?php echo base_url()?>webservice/get_disabled_dates" method="post" enctype="multipart/form-data">
<table>
<tr><td>location Id<span style="color: #FF0000;">*</span><input type="text" name="loc_id" required>loc_id(use loc_id for clinics and also as doc_id to get disables date for doctors)</td></tr>
<tr><td>Type<span style="color: #FF0000;">*</span><input type="text" name="type" required>type(medical,doctor) (use type = doctor for get disables date and for other medical)</td></tr>
<tr><td><input type="submit" name="submit" value="Submit"></input></td></tr>
</table>
</form>
*********************************************************************************</br>
<h3>(12)time_slots(time_slots)</h3>

<form action="<?php echo base_url()?>webservice/time_slots" method="post" enctype="multipart/form-data">
<table>
<tr><td>Booking Date<span style="color: #FF0000;">*</span><input type="text" name="booking_date" required>booking_date</td></tr>
<tr><td>location ID<span style="color: #FF0000;">*</span><input type="text" name="location_id" required>location_id</td></tr>
<tr><td>Type<span style="color: #FF0000;">*</span><input type="text" name="type">type(medical,doctor) (use type = doctor for get disables date and for other medical)</td></tr>
<tr><td><input type="submit" name="submit" value="Submit"></input></td></tr>
</table>
</form>
*********************************************************************************</br>
<h3 style="color:red;">(13)Set Appointment(set_appointment)</h3>

<form action="<?php echo base_url()?>webservice/set_appointment" method="post" enctype="multipart/form-data">
<table>
<tr><td>User Id<span style="color: #FF0000;">*</span><input type="text" name="user_id" required>(user_id)</td></tr>
<tr><td>Doc Id<span style="color: #FF0000;">*</span><input type="text" name="doc_id" required>(doc_id)(set 0 if appointment not for doc)</td></tr>
<tr><td>Loc Id<span style="color: #FF0000;">*</span><input type="text" name="loc_id" required>(loc_id (only if appointment for doc otherwise set 0))</td></tr>
<tr><td>Clinic Id<span style="color: #FF0000;">*</span><input type="text" name="clinic_id" required>(clinic_id)(set 0 if appointment not for clinic)</td></tr>
<tr><td>Booking Date<span style="color: #FF0000;">*</span><input type="text" name="booking_date" required>(booking_date)</td></tr>
<tr><td>Booking Start Time<span style="color: #FF0000;">*</span><input type="text" name="booking_s_time" required>(booking_s_time (Time format : 24 HR - > 11:00:00))</td></tr>
<tr><td>Booking End Time<span style="color: #FF0000;">*</span><input type="text" name="booking_e_time" required>(booking_e_time)</td></tr>
<tr><td>Package Id<span style="color: #FF0000;">*</span><input type="text" name="package_id">(package_id) (only if appointment for clinic user comma's for multiple package)</td></tr>
<tr><td>Services Id<span style="color: #FF0000;">*</span><input type="text" name="services_id">(services_id) (only if appointment for clinic user comma's for multiple services)</td></tr>
<tr><td>Consultant Fee<span style="color: #FF0000;">*</span><input type="text" name="cons_fee">(cons_fee) (P=phone consult, D= Doctor Consult)</td></tr>
<tr><td><input type="submit" name="submit" value="Submit"></input></td></tr>
</table>
</form>
*********************************************************************************</br>
<h3 style="color:red;">(14)get Appointment(get_appointments)</h3>

<form action="<?php echo base_url()?>webservice/get_appointments" method="post" enctype="multipart/form-data">
<table>
<tr><td>User Id<span style="color: #FF0000;">*</span><input type="text" name="user_id" required>(user_id)</td></tr>
<tr><td><input type="submit" name="submit" value="Submit"></input></td></tr>
</table>
</form>

*********************************************************************************</br>
<h3>(15)Get All Clinic(get_all_clinics)</h3>

<form action="<?php echo base_url()?>webservice/get_all_clinics" method="post" enctype="multipart/form-data">
<table>
<tr><td>Type<input type="text" name="type" required>type(E=english, S= simplified, T=traditional)</td></tr>

<tr><td><input type="submit" name="submit" value="Submit"></input></td></tr>
</table>
</form>
*********************************************************************************</br>
<h3>(16)Set Authorized Doctor(set_authorized_doctors)</h3>

<form action="<?php echo base_url()?>webservice/set_authorized_doctors" method="post" enctype="multipart/form-data">
<table>
<tr><td>User Id<span style="color: #FF0000;">*</span><input type="text" name="user_id" required>(user_id)</td></tr>
<tr><td>Doc Id<span style="color: #FF0000;">*</span><input type="text" name="doc_id" required>(doc_id)</td></tr>
<tr><td><input type="submit" name="submit" value="Submit"></input></td></tr>
</table>
</form>
*********************************************************************************</br>
<h3>(17)Get All Authorized Doctor(get_all_authorized_doctors)</h3>

<form action="<?php echo base_url()?>webservice/get_all_authorized_doctors" method="post" enctype="multipart/form-data">
<table>
<tr><td>User Id<span style="color: #FF0000;">*</span><input type="text" name="user_id" required>(user_id)</td></tr>
<tr><td><input type="submit" name="submit" value="Submit"></input></td></tr>
</table>
</form>
*********************************************************************************</br>
<h3>(18)Delete Authorized Doctor(del_authorized_doctor)</h3>

<form action="<?php echo base_url()?>webservice/del_authorized_doctor" method="post" enctype="multipart/form-data">
<table>
<tr><td>ID<span style="color: #FF0000;">*</span><input type="text" name="id" required>(id)</td></tr>
<tr><td><input type="submit" name="submit" value="Submit"></input></td></tr>
</table>
</form>
*********************************************************************************</br>
<h3 >(19)Get e-Information(get_all_einfo)</h3>

<form action="<?php echo base_url()?>webservice/get_all_einfo" method="post" enctype="multipart/form-data">
<table>
<tr><td>Type<span style="color: #FF0000;">*</span><input type="text" name="type" required>(E=english, S= simplified, T=traditional)</td></tr>
<tr><td><input type="submit" name="submit" value="Submit"></input></td></tr>
</table>
</form>
*********************************************************************************</br>
<h3>(20)Get other content(get_other_content)</h3>

<form action="<?php echo base_url()?>webservice/get_other_content" method="post" enctype="multipart/form-data">
<table>
<tr><td>Type<span style="color: #FF0000;">*</span><input type="text" name="type" required>(about = about us info, privacy = privacy policy content, terms = for terms of use,content = for contact us)</td></tr>
<tr><td>Language<span style="color: #FF0000;">*</span><input type="text" name="language" required>(E = english, T = traditional, S= simplified)</td></tr>
<tr><td><input type="submit" name="submit" value="Submit"></input></td></tr>
</table>
</form>
*********************************************************************************</br>
<h3>(21)Get Einfo Filters (getEinfoFilters)</h3>

<form action="<?php echo base_url()?>webservice/getEinfoFilters" method="post" enctype="multipart/form-data">
<table>
<tr><td><input type="submit" name="submit" value="Submit"></input></td></tr>
</table>
</form>
*********************************************************************************</br>
<h3>(22)Get advertise images(get_adver_images)</h3>

<form action="<?php echo base_url()?>webservice/get_adver_images" method="post" enctype="multipart/form-data">
<table> 
<tr><td>Language<span style="color: #FF0000;">*</span><input type="text" name="language" required>language(E = english, T = traditional, S= simplified)</td></tr>
<tr><td><input type="submit" name="submit" value="Submit"></input></td></tr>
</table>
</form>
*********************************************************************************</br>
<h3>(23)Search Doctor & Medical(searchDoctorMedical)</h3>

<form action="<?php echo base_url()?>webservice/searchDoctorMedical" method="post" enctype="multipart/form-data">
<table>
<tr><td>Name<span style="color: #FF0000;">*</span><input type="text" name="name" required>(name)</td></tr>
<tr><td>Type<span style="color: #FF0000;">*</span><input type="text" name="type" required>type(E=english, S= simplified, T=traditional)</td></tr>
<tr><td><input type="submit" name="submit" value="Submit"></input></td></tr>
</table>
</form>
*********************************************************************************</br>
<h3>(24)Get Analysis & Medical Scan Report(getReports)</h3>

<form action="<?php echo base_url()?>webservice/getReports" method="post" enctype="multipart/form-data">
<table>
<tr><td><input type="submit" name="submit" value="Submit"></input></td></tr>
</table>
</form>
*********************************************************************************</br>
<h3>(25)Get All Reports(Translated OR Non-Translated)(getAllReports)</h3>

<form action="<?php echo base_url()?>webservice/getAllReports" method="post" enctype="multipart/form-data">
<table>
<tr><td>User Id<span style="color: #FF0000;">*</span><input type="text" name="user_id" required>(user_id)</td></tr>
<tr><td>Report Cat Id<span style="color: #FF0000;">*</span><input type="text" name="cat_id" required>(cat_id)</td></tr>
<tr><td>Report Cat Id<span style="color: #FF0000;">*</span><input type="text" name="ios_cat_id" required>(ios_cat_id)</td></tr>
<tr><td>Multiple<span style="color: #FF0000;">*</span><input type="text" name="ios_multi" required>(ios_multi) (y/n)</td></tr>
<tr><td><input type="submit" name="submit" value="Submit"></input></td></tr>
</table>
</form>
*********************************************************************************</br>
<h3>(26)Request Report Translate(requestTranslate){Send multiple report id and language by comma separated}</h3>

<form action="<?php echo base_url()?>webservice/requestTranslate" method="post" enctype="multipart/form-data">
<table>
<tr><td>User Id<span style="color: #FF0000;">*</span><input type="text" name="user_id" required>(user_id)</td></tr>
<tr><td>Report Id<span style="color: #FF0000;">*</span><input type="text" name="report_id" required>(report_id)</td></tr>
<tr><td>Language<span style="color: #FF0000;">*</span><input type="text" name="language" required>(language)(CN=simplified,TW=traditional)</td></tr>
<tr><td><input type="submit" name="submit" value="Submit"></input></td></tr>
</table>
</form>
*********************************************************************************</br>
<h3 style="color:red;">(27)shoping list(shoping_list)</h3>

<form action="<?php echo base_url()?>webservice/shoping_list" method="post">
<table>
<tr><td>User Id<span style="color: #FF0000;">*</span><input type="text" name="user_id" required>(user_id)</td></tr>
<tr><td><input type="submit" name="submit" value="Submit"></input></td></tr>
</table>
</form>
*********************************************************************************</br>
<h3 style="color:red;">(28)Add Payment Status(add_payment_status)</h3>

<form action="<?php echo base_url()?>webservice/add_payment_status" method="post">
<table>
<tr><td>User Id<span style="color: #FF0000;">*</span><input type="text" name="user_id" required>(user_id)</td></tr>
<tr><td>Transaction Id<span style="color: #FF0000;">*</span><input type="text" name="transaction_id" required>(transaction_id)</td></tr>
<!--<tr><td>Amount<span style="color: #FF0000;">*</span><input type="text" name="amount" required>(amount)</td></tr>-->
<tr><td>Request ID<span style="color: #FF0000;">*</span><input type="text" name="request_id" required>(request_id)(multiple request id with comma's)</td></tr>
<tr><td>Create Time<span style="color: #FF0000;">*</span><input type="text" name="create_time" required>(create_time)</td></tr>
<tr><td>Status <span style="color: #FF0000;">*</span><input type="text" name="status" required>(status)</td></tr>
<tr><td><input type="submit" name="submit" value="Submit"></input></td></tr>
</table>
</form>
*********************************************************************************</br>
<h3>(29)Delete Translated Request(delete_translated_request)</h3>

<form action="<?php echo base_url()?>webservice/delete_translated_request" method="post">
<table>
<tr><td>Request Id<span style="color: #FF0000;">*</span><input type="text" name="request_id" required>(request_id)</td></tr>
<tr><td><input type="submit" name="submit" value="Submit"></input></td></tr>
</table>
</form>
*********************************************************************************</br>
<h3>(30)Get Profile(get_user_profile)</h3>

<form action="<?php echo base_url()?>webservice/get_user_profile" method="post">
<table>
<tr><td>User Id<span style="color: #FF0000;">*</span><input type="text" name="user_id" required>(user_id)</td></tr>
<tr><td><input type="submit" name="submit" value="Submit"></input></td></tr>
</table>
</form>
*********************************************************************************</br>
<h3  >(31)edit_profile(edit_profile)</h3>
 <form method="post" action="<?php echo base_url()?>webservice/edit_profile" enctype="multipart/form-data">
    <table>
        <tr><td>User ID</td>
               <td> <input type="text" name="userID">userID </td></tr>
        <tr><td>First Name</td>
               <td> <input type="text" name="fname">fname </td></tr>
        <tr><td>Last Name</td>
               <td> <input type="text" name="lname">lname </td></tr>
         <tr><td>gender</td>
              <td>  <input type="text" name="gender">gender</td></tr> 
		 <tr><td>ID card no</td>
			<td>  <input type="text" name="id_card">id_card</td></tr> 
		 <tr><td>dob</td>
			<td> <input type="text" name="dob">dob</td></tr> 
		 <tr><td>Nationality</td>
			<td> <input type="text" name="nationality">nationality</td></tr> 
		 <tr><td>Address</td>
			<td> <input type="text" name="address">address</td></tr>        
		 <tr><td>country Code</td>
			<td> <input type="text" name="country_code">country_code</td></tr>        
		 <tr><td>country Name</td>
			<td> <input type="text" name="country_name">country_name</td></tr>
			<tr><td><input type="submit" name="submit" value="Submit"></input></td></tr>        
    </table>
</form>
*********************************************************************************</br>
<h3  >(32)change_phneNo(change_phneNo)</h3>
 <form method="post" action="<?php echo base_url()?>webservice/change_phneNo">
    <table>
        <tr><td>User ID</td>
               <td> <input type="text" name="userID">userID </td></tr>
	   <tr><td>Phone Number</td>
		<td> <input type="text" name="phoneno">phoneno</td></tr>
		<tr><td>country Code</td>
			<td> <input type="text" name="country_code">country_code</td></tr>
		<tr><td><input type="submit" name="submit" value="Submit"></input></td></tr>        
    </table>
</form>
*********************************************************************************</br>
<h3  >(33)confirm_change_phneNo(confirm_change_phneNo)</h3>
 <form method="post" action="<?php echo base_url()?>webservice/confirm_change_phneNo">
    <table>
        <tr><td>User ID</td>
               <td> <input type="text" name="userID">userID </td></tr>
        <tr><td>Phone Number</td>
				<td> <input type="text" name="phoneno">phoneno</td></tr>
		<tr><td>country Code</td>
			   <td> <input type="text" name="country_code">country_code</td></tr>
	    <tr><td>Unique Code</td>
				<td> <input type="text" name="unique_code">unique_code</td></tr>
		<tr><td><input type="submit" name="submit" value="Submit"></input></td></tr>        
    </table>
</form>
*********************************************************************************</br>
<h3 >(34)Get doctor or medical(get_doc_medical)</h3>

<form action="<?php echo base_url()?>webservice/get_doc_medical" method="post" enctype="multipart/form-data">
<table>
<tr><td>Type<span style="color: #FF0000;">*</span><input type="text" name="type" required>type(E=english, S= simplified, T=traditional)</td></tr>
<tr><td><input type="submit" name="submit" value="Submit"></input></td></tr>
</table>
</form>
*********************************************************************************</br>
<h3 style="color:red;">(35)Get transaction record(get_transaction_record)</h3>

<form action="<?php echo base_url()?>webservice/get_transaction_record" method="post" enctype="multipart/form-data">
<table>
<tr><td>User ID<span style="color: #FF0000;">*</span><input type="text" name="user_id" required>user_id</td></tr>
<tr><td><input type="submit" name="submit" value="Submit"></input></td></tr>
</table>
</form>
*********************************************************************************</br>
<h3 style="color:red;">(36)Get Consultation Price(get_consultation_price)</h3>

<form action="<?php echo base_url()?>webservice/get_consultation_price" method="post">
<table>
<tr><td><input type="submit" name="submit" value="Submit"></input></td></tr>
</table>
</form>
*********************************************************************************</br>
</body>
</html>
