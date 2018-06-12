<?php

//product_action.php

include('database_connection.php');

include('function.php');


if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'load_brand')
	{
		echo fill_brand_list($connect, $_POST['category_id']);
	}

	if($_POST['btn_action'] == 'load_product')
	{
		echo fill_productss_list($connect, $_POST['category_id'], $_POST['brand_id']);
	}

	if($_POST['btn_action'] == 'Add')
	{ 
	   	$query = "UPDATE product SET product_quantity= :product_quantity, stock_enter_by=:stock_enter_by,stock_entry_date= :stock_entry_date  where product_id= :product_id " ;
		$statement = $connect->prepare($query);
		$statement->execute(
		array(
				':product_id'			=>	$_POST['product_id'],
				':stock_enter_by'		=>	$_SESSION["user_id"],
				':product_quantity'     =>  $_POST["product_quantity"],
				':stock_entry_date'			=>	date("Y-m-d"),
			)
			);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo  'Stock Added';
		}
	}


	if($_POST['btn_action'] == 'stock_details')
	{
		$query = "
		SELECT * FROM product 
		INNER JOIN category ON category.category_id = product.category_id 
		INNER JOIN brand ON brand.brand_id = product.brand_id 
		INNER JOIN user_details ON user_details.user_id = product.stock_enter_by 
		WHERE product.product_id = '".$_POST["product_id"]."'
		";
		$statement = $connect->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		$output = '
		<div class="table-responsive">
			<table class="table table-boredered">
		';
		foreach($result as $row)
		{
			$status = '';
			if($row['product_status'] == 'active')
			{
				$status = '<span class="label label-success">Active</span>';
			}
			else
			{
				$status = '<span class="label label-danger">Inactive</span>';
			}
			$output .= '
			<tr>
				<td>Product Name</td>
				<td>'.$row["product_name"].'</td>
			</tr>
			<tr>
				<td>Category</td>
				<td>'.$row["category_name"].'</td>
			</tr>
			<tr>
				<td>Brand</td>
				<td>'.$row["brand_name"].'</td>
			</tr>
			<tr>
				<td>Available Quantity</td>
				<td>'.$row["product_quantity"].'</td>
			</tr>
			<tr>
				<td>Enter By</td>
				<td>'.$row["user_name"].'</td>
			</tr>
			<tr>
				<td>Status</td>
				<td>'.$status.'</td>
			</tr>
			';
		}
		$output .= '
			</table>
		</div>
		';
		echo $output;
	}



	if($_POST['btn_action'] == 'fetch_single')
	{
		$query = "SELECT * FROM product WHERE product_id = :product_id";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':product_id'	=>	$_POST["product_id"]
			)
		);
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output['category_id'] = $row['category_id'];
			$output['brand_id'] = $row['brand_id'];
			$output["brand_select_box"] = fill_brand_list($connect, $row["category_id"]);
			$output['product_id'] = $row['product_id'];
			$output["product_select_box"] = fill_productss_list($connect, $row['category_id'] , $row['brand_id']);
			$output['product_quantity'] = $row['product_quantity'];
			}
		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'Edit')
	{
		$query = "UPDATE product set product_quantity=:product_quantity WHERE product_id = :product_id";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':product_quantity'		=>	$_POST['product_quantity'],
				':product_id'			=>	$_POST['product_id'],
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Product Details Edited';
		}
	}
	if($_POST['btn_action'] == 'delete')
	{
		$status = 'active';
		if($_POST['status'] == 'active')
		{
			$status = 'inactive';
		}
		$query = "
		UPDATE product 
		SET product_status = :product_status 
		WHERE product_id = :product_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':product_status'	=>	$status,
				':product_id'		=>	$_POST["product_id"]
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Product status change to ' . $status;
		}
	}
}


?>