<?php $this->load->view('template/header'); ?>
<body>
    <!-- topbar starts -->
 <?php 
 $this->load->view('template/top_nav_admin');  
 $this->load->view('template/left_menu');
 $this->load->view(@$file); ?>  

 <?php $this->load->view('template/footer'); ?>  
</body>
</html>

