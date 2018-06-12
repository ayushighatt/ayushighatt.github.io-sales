<?php
//customer.php

include('database_connection.php');

if(!isset($_SESSION['type']))
{
	header('location:login.php');
}

if($_SESSION['type'] != 'master')
{
	header("location:index.php");
}

include('header.php');

?>

	<span id="alert_action"></span>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
                <div class="panel-heading">
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                        <div class="row">
                            <h3 class="panel-title">Customer List</h3>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                        <div class="row" align="right">
                             <button type="button" name="add" id="add_button" data-toggle="modal" data-target="#customerModal" class="btn btn-success btn-xs">Add</button>   		
                        </div>
                    </div>
                    <div style="clear:both"></div>
                </div>
                <div class="panel-body">
                    <div class="row">
                    	<div class="col-sm-12 table-responsive">
                    		<table id="customer_data" class="table table-bordered table-striped">
                    			<thead><tr>
									<th>ID</th>
                                    <th>Customer Name</th>
                                    <th>Customer Address</th>
                                    <th>Contact No.</th>
                                    <th>Status</th>
									<th>Edit</th>
									<th>Delete</th>
								</tr></thead>
                    		</table>
                    	</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="customerModal" class="modal fade">
    	<div class="modal-dialog">
    		<form method="post" id="customer_form">
    			<div class="modal-content">
    				<div class="modal-header">
    					<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-plus"></i> Add Customer</h4>
    				</div>
    				<div class="modal-body">
    					
                            <div class="form-group">
                                <label>Enter Customer Name</label>
                                <input type="text" name="cust_name" id="cust_name" class="form-control" required />
                            </div>
                            <div class="form-group">
                                <label>Enter Customer Address</label>
                                <textarea name="cust_addr" id="cust_addr" class="form-control" rows="5" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Enter Customer Contact No.</label>
                                <input type="text" name="cust_phone" id="cust_phone" class="form-control" required  />
                            </div>
                         
    				</div>

    				<div class="modal-footer">
    					<input type="hidden" name="cust_id" id="cust_id"/>
    					<input type="hidden" name="btn_action" id="btn_action"/>
    					<input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
    					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    				</div>
    			</div>
    		</form>
    	</div>
    </div>
<script>
$(document).ready(function(){

	$('#add_button').click(function(){
		$('#customer_form')[0].reset();
		$('.modal-title').html("<i class='fa fa-plus'></i> Add Customer");
		$('#action').val('Add');
		$('#btn_action').val('Add');
	});

	$(document).on('submit','#customer_form', function(event){
		event.preventDefault();
		$('#action').attr('disabled','disabled');
		var form_data = $(this).serialize();
		$.ajax({
			url:"customer_action.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{
				$('#customer_form')[0].reset();
				$('#customerModal').modal('hide');
				$('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
				$('#action').attr('disabled', false);
				customerdataTable.ajax.reload();
			}
		})
	});

	$(document).on('click', '.update', function(){
		var cust_id = $(this).attr("id");
		var btn_action = 'fetch_single';
		$.ajax({
			url:"customer_action.php",
			method:"POST",
			data:{cust_id:cust_id, btn_action:btn_action},
			dataType:"json",
			success:function(data)
			{
				$('#customerModal').modal('show');
				$('#cust_name').val(data.cust_name);
				$('#cust_addr').val(data.cust_addr);
				$('#cust_phone').val(data.cust_phone);
				$('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Customer");
				$('#cust_id').val(cust_id);
				$('#action').val('Edit');
				$('#btn_action').val("Edit");
			}
		})
	});

	var customerdataTable = $('#customer_data').DataTable({
		"processing":true,
		"serverSide":true,
		"order":[],
		"ajax":{
			url:"customer_fetch.php",
			type:"POST"
		},
		"columnDefs":[
			{
				"targets":[5, 6],
				"orderable":false,
			},
		],
		"pageLength": 25
	});
	$(document).on('click', '.delete', function(){
		var cust_id = $(this).attr('id');
		var cust_status = $(this).data("cust_status");
		var btn_action = 'delete';
		if(confirm("Are you sure you want to change status?"))
		{
			$.ajax({
				url:"customer_action.php",
				method:"POST",
				data:{cust_id:cust_id, cust_status:cust_status, btn_action:btn_action},
				success:function(data)
				{
					$('#alert_action').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
					customerdataTable.ajax.reload();
				}
			})
		}
		else
		{
			return false;
		}
	});
});
</script>

<?php
include('footer.php');
?>


				