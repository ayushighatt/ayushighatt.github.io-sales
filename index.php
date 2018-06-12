<?php
//index.php
include('database_connection.php');
include('function.php');

if(!isset($_SESSION["type"]))
{
	header("location:login.php");
}

include('header.php');

?>

<div class="container">

	<div class="row">
	<?php
	if($_SESSION['type'] == 'master')
	{
	?>

		<div class="table-responsive ">
  		<table class="table table-striped">
  			
  			<tr><th>Total User</th><td><?php echo count_total_user($connect); ?></td></tr>
  			<tr><th>Total Brands</th><td><?php echo count_total_brand($connect); ?></td></tr>
  			<tr><th>Total Item in Stock</th><td><?php echo count_total_product($connect); ?></td></tr>
			<tr><th>Total Order Value</th><td><?php echo count_total_order_value($connect); ?></td></tr>
			<tr><th>Total Cash Order Value</th><td><?php echo count_total_cash_order_value($connect); ?></td></tr>
			<tr><th>Total Credit Order Value</th><td><?php echo count_total_credit_order_value($connect);?></td></tr>
		    <tr><th colspan="2"><center>Total Order Value User wise</center></th></tr>
			<tr><td colspan="2"><?php echo get_user_wise_total_order($connect); ?></td></tr>
		
		<?php
		}
		?>

</table>
</div>
</div>
</div>

<?php
include("footer.php");
?>