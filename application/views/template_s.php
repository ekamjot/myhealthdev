<?php $this->load->view('template/header'); ?>
<body>
    <!-- topbar starts -->
<div class="ch-container">
    <div class="row">
 <?php 
 $this->load->view('template/top_nav_re');  
 $this->load->view(@$file); ?>  

 <?php $this->load->view('template/footer'); ?>  
 </div>
</body>
</html>

