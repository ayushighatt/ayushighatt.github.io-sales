<?php

//customer_action.php

include('database_connection.php');

if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'Add')
	{

                $cust_name  =	$_POST["cust_name"];
				$cust_addr  =	$_POST["cust_addr"];
				$cust_phone =	$_POST["cust_phone"];

		$query = "INSERT INTO customer (cust_name,cust_addr,cust_phone,cust_status)VALUES ('$cust_name', '$cust_addr', $cust_phone, 'active')";
		$statement = $connect->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Customer Details Added';
		}
	}
	
	if($_POST['btn_action'] == 'fetch_single')
	{
		$query = "SELECT * FROM customer WHERE cust_id = :cust_id";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':cust_id'	=>	$_POST["cust_id"]
			)
		);
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output['cust_name'] = $row['cust_name'];
			$output['cust_addr'] = $row['cust_addr'];
			$output['cust_phone'] = $row['cust_phone'];
		}
		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'Edit')
	{
		$query = "
		UPDATE customer set cust_name = :cust_name , cust_addr=:cust_addr,cust_phone=:cust_phone
		WHERE cust_id = :cust_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':cust_name'	=>	$_POST["cust_name"],
				':cust_addr'	=>	$_POST["cust_addr"],
				':cust_phone'	=>	$_POST["cust_phone"],
				':cust_id'		=>	$_POST["cust_id"]
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Customer Details Edited';
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
		UPDATE customer 
		SET customer_status = :customer_status 
		WHERE cust_id = :cust_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':customer_status'	=>	$status,
				':cust_id'		=>	$_POST["cust_id"]
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'Customer status change to ' . $status;
		}
	}
}

?>