<div class="container-fluid" id="page-header">
	<div class="row">
		<div class="col-sm-6">
			<ol class="breadcrumb">
			    <li><a href="#">Home</a></li>
			    <li><a href="#">HR</a></li>
			    <li><a href="#">Employee</a></li>
			    <li class="active">View</li>        
			</ol>
		</div>
		<div class="col-sm-6">
			<div class="pull-right">
				<button class="btn my-btn-primary">Add</button>
			</div>
		</div>
	</div>
</div>

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="data-table-div">
                <table id="data_table" class="table">
                    <thead>
                        <tr>
                            <th class="col-md-2">USERNAME</th>
                            <th class="col-md-2">EMAIL</th>
                            <th class="col-md-1">PHONE</th>
                            <th class="col-md-2">DEPARTMENT</th>
                            <th class="col-md-2">ROLE</th>
                            <th class="col-md-1">STATUS</th>
                            <th class="col-md-1">CREATED AT</th>
                            <th class="col-md-1">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
		</div>
	</div>
</div>

<?php $this->load->view("include/footer");?>

<script type="text/javascript">
var Module = function(app) {
    var self = this;
    this.init = function () {
    	self.init_rule();
    	self.attach();
    };
 	
 	this.init_rule = function(){
 		
 	};

    this.attach = function() {
    	self.attach_data_table();
    };

    this.attach_data_table = function() {
        var filter_data = self.get_filter_data();
        self.data_table = $("#data_table").DataTable({
                                "processing": false,
                                // 'serverSide': true,
                                'responsive': true,
                                "pageLength": 50,
                                "ajax": {
                                       url: app.url("<?php echo base_url('api/hr/employee');?>", "<?php echo $_GET['api_token'];?>"),
                                       type: 'POST',
                                       data: filter_data,
                                       dataSrc: 'users',
                                    },
                                "columns": [
							        { data: 'user_name' },
							        { data: 'email' },
							        { data: 'phone' },
							        { data: 'department_name' },
							        { data: 'role_name' },
							        { data: 'user_status' },
							        { data: 'created_at' },
							        { data: 'user_id'}
							    ],
                                // "columnDefs": [
                                //         { 
                                //             "targets": [4,5], //first column / numbering column
                                //             "orderable": false, //set not orderable
                                //         }
                                //     ]
                                 
                        });
        return self.data_table;
    };

    this.get_filter_data = function(){
        var arr = [];
        return arr;
    };
};

$(document).ready(function() {
    var js = new Module(new App());
    js.init();
});
</script>