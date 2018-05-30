<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Document</title>
	<?php $this->load->view("include/css");?>
</head>
<body>

<div id="page-login">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-4"></div>
			<div class="col-sm-4 login-div">
				<h3 class="text-center">Login to CRM</h3>
				<form id="login_form">
					<div class="form-group">
						<input type="text" class="form-control" name="username" id="username" autofocus>
					</div>
					<div class="form-group">
						<input type="password" class="form-control" name="password" id="password">
					</div>
				</form>
				<button class="btn my-btn-primary-large btn-block" id="login_btn"></button>
			</div>
			<div class="col-sm-4"></div>
		</div>
	</div>
</div>

<?php $this->load->view("include/footer");?>

<script type="text/javascript">
var Module = function(app) {
    var self = this;
    this.init = function () {
    	this.init_rule();
    	this.attach();
    };
 	
 	this.init_rule = function(){
 		$("#login_btn").html(app.my_options.btn_login);

 		$("#login_form").validate({                
            rules: {
                username: { required: true },
                password: { required: true },
            }
        });

        $("#username, #password").keyup(function(e){
        	e.preventDefault();
        	if(e.keyCode == 13){
        		$("#login_btn").click();
        	}
        });
 	};

    this.attach = function() {
    	this.login_api();
    };

    this.login_api = function(){
    	$("#login_btn").click(function(){
    		$("#login_btn").attr('disabled', true);
        	$("#login_btn").html(app.my_options.btn_login_submit);
        	form_data = $("#login_form").serialize();
        	if($("#login_form").valid()){
        		$.ajax({
		            url: "<?php echo base_url('api/Auth/login'); ?>",
		            type:'post',
		            data: form_data,
		            dataType: "json",
		            success: function(response) {
		                console.log(response);
		                if(response.status){
		                	// put token in local storage
		                	localStorage.setItem("api_token", response.api_token);
		                	app.notify_success(response.message);
		                	app.redirect("<?php echo base_url('hr/employee');?>", response.api_token);
		                }else{
		                	// show error message
		                	app.notify_error(response.message);
		                }
		                $("#login_btn").attr('disabled', false);
		                $("#login_btn").html(app.my_options.btn_login);
		            },
		            error: function(xhr) {
		                console.log(xhr);
		            }
		        });
        	}
    	});
    }
};

$(document).ready(function() {
    var js = new Module(new App());
    js.init();
});
</script>