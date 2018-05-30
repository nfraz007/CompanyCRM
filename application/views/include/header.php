<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <?php $this->load->view("include/css");?>
        </head>
        <body>
        	<header id="header">
	    		<nav class="navbar">
				  	<div class="container-fluid">
				    	<div class="navbar-header">
				      		<a class="navbar-brand" href="#">CRM</a>
				    	</div>
				    	<ul class="nav navbar-nav">
				    		<li class="header-icon dropdown">
						        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-bars"></i></a>
						        <?php if(count($this->user["apps"]) > 0){?>
						        <ul class="dropdown-menu">
						        	<?php foreach($this->user["apps"] as $app){?>
						          	<li><a href="<?php echo $app["module"][0]["module_url"];?>"><?php echo $app["app_name"];?></a></li>
						          	<?php }?>
						        </ul>
						        <?php }?>
						    </li>
				      		<li id="header_app"><a href="#"><?php echo $this->app["app_name"]?></a></li>
				      		<?php foreach($this->user["modules"] as $module){?>
				      		<li class="header-module <?php echo ($this->app["module_id"] == $module["module_id"]) ? "active" : "" ;?>"><a href="<?php echo base_url($module['module_url']);?>"><?php echo $module["module_name"];?></a></li>
				      		<?php }?>
				    	</ul>
				    	<ul class="nav navbar-nav navbar-right">
				    		<li class="header-icon"><a href="#"><i class="fa fa-search"></i></a></li>
				    		<li class="header-icon"><a href="#"><i class="fa fa-comment"></i></a></li>
				      		<li class="header-icon dropdown">
				      			<a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-user-circle-o"></i></a>
						        <ul class="dropdown-menu">
						          	<li><a href="#">My Profile</a></li>
						          	<li><a href="#">Logout</a></li>
						        </ul>
				      		</li>
				    	</ul>
				  	</div>
				</nav>
			</header>