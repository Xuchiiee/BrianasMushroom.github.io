<?php
	require("../includes/config.php");
	session_start();
	if(isset($_SESSION['dist_id'])) {
		if(isset($_GET['id'])){
			$order_id = $_GET['id'];
			$query_selectOrderItems = "SELECT *,order_items.quantity AS quantity FROM orders,order_items,products WHERE order_items.order_id='$order_id' AND order_items.pro_id=products.pro_id AND order_items.order_id=orders.order_id";
			$result_selectOrderItems = mysqli_query($con,$query_selectOrderItems);
			$query_selectOrder = "SELECT date,status FROM orders WHERE order_id='$order_id'";
			$result_selectOrder = mysqli_query($con,$query_selectOrder);
			$row_selectOrder = mysqli_fetch_array($result_selectOrder);
	
			$invoice_id = $_GET['id'];
			$queryInvoiceItems = "SELECT *,invoice_items.quantity as quantity FROM invoice,invoice_items,products WHERE invoice.invoice_id='$invoice_id' AND invoice_items.product_id=products.pro_id AND invoice_items.invoice_id=invoice.invoice_id";
			$resultInvoiceItems = mysqli_query($con, $queryInvoiceItems);
			$queryInvoiceproduct = "SELECT products.pro_id, products.pro_name, products.pro_desc, products.pro_price, products.unit, products.pro_cat, products.quantity 
                      FROM invoice, invoice_items, products 
                      WHERE invoice.invoice_id='$invoice_id' 
                        AND invoice_items.product_id=products.pro_id 
                        AND invoice_items.invoice_id=invoice.invoice_id";
			$resultInvoiceproduct = mysqli_query($con, $queryInvoiceItems);
			$querySelectInvoice = "SELECT * FROM invoice,retailer,distributor,area WHERE invoice_id='$invoice_id' AND invoice.retailer_id=retailer.retailer_id AND retailer.area_id=area.area_id AND invoice.dist_id=distributor.dist_id";
			$resultSelectInvoice = mysqli_query($con, $querySelectInvoice);
			$rowSelectInvoice = mysqli_fetch_array($resultSelectInvoice);
			$rowInvoiceItems = mysqli_fetch_array($resultInvoiceproduct);

			// Check if data is available in the result sets
			if ($resultInvoiceItems && $resultSelectInvoice) {
				// Additional check for specific array offsets
				$rowInvoiceItems = mysqli_fetch_array($resultInvoiceItems);
				if ($rowInvoiceItems !== null) {
					// Your existing code to display the invoice items
				} else {
					// Handle the case where invoice items are not available
				}

				if ($rowSelectInvoice !== null) {
					// Your existing code to display the invoice details
				} else {
					// Handle the case where invoice details are not available
				}

				// Reset the pointer to the beginning of the result set
				mysqli_data_seek($resultInvoiceItems, 0);
			} else {
				// Handle the case where there is an issue with the query execution
			}
		}
	}
	else {
		header('Location:../index.php');
	}
?>

<!DOCTYPE html>
<html>
<center>
<head>

	<title> View Invoice Details </title>
	<link rel="stylesheet" href="../includes/main_style.css">
	<script type="text/javascript">    
	 function PrintDiv() {
			document.getElementById("signature").style.display = "block";
			document.getElementById("footer").style.display = "block";
			var divToPrint = document.getElementById('divToPrint');
			var popupWin = window.open('', '_blank', '');
			popupWin.document.open();
			popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
			document.getElementById("signature").style.display = "none";
			document.getElementById("footer").style.display = "none";
			popupWin.document.close();
		}
     </script>
</head>
<body>
	<?php
		include("../includes/header.inc.php");
		include("../includes/nav_distributor.inc.php");

	?>
<section>
	
			<div id="divToPrint" style="clear:both;" >
				<h1 style="text-align:center;">Sales Invoice</h1>
				<h2 style="text-align:center;"> Briana's mushroom</h2>
				<table class="table_infoFormat">
				<tr>
			<td><b> Invoice No: </b></td>
			<td> <?php echo isset($rowSelectInvoice['invoice_id']) ? $rowSelectInvoice['invoice_id'] : 'N/A'; ?> </td>
		</tr>
		<tr>
			<td><b> Order No: </b></td>
			<td> <?php echo isset($rowSelectInvoice['order_id']) ? $rowSelectInvoice['order_id'] : 'N/A'; ?> </td>
		</tr>
		<tr>
			<td><b> Retailer Name: </b></td>
			<td> <?php echo isset($rowSelectInvoice['username']) ? $rowSelectInvoice['username'] : 'N/A'; ?> </td>
		</tr>
		<tr>
			<td><b> Address: </b></td>
			<td> <?php echo isset($rowSelectInvoice['address']) ? $rowSelectInvoice['address'] : 'N/A'; ?> </td>
		</tr>
		<tr>
			<td><b> Distributor: </b></td>
			<td> <?php echo isset($rowSelectInvoice['dist_name']) ? $rowSelectInvoice['dist_name'] : 'N/A'; ?> </td>
		</tr>
		<tr>
			<td><b> Date: </b></td>
			<td> <?php echo isset($rowSelectInvoice['date']) ? date("d-m-Y",strtotime($rowSelectInvoice['date'])) : 'N/A'; ?> </td>
		</tr>
		
		</table>
		<form action="" method="POST" class="form">
		<table class="table_invoiceFormat" style="margin-top:50px;">
			<tr>
				<th style="padding-right:25px;"> Sr. No. </th>
				<th style="padding-right:150px;"> Products </th>
				<th style="padding-right:30px;"> Unit Price </th>
				<th style="padding-right:30px;"> Quantity </th>
				
			</tr>
			<?php $i=1; while($row_selectOrderItems = mysqli_fetch_array($result_selectOrderItems)) { ?>	
				<tr>
				<td> <?php echo $row_selectOrderItems['pro_name']; ?> </td>
				<td> <?php echo $row_selectOrderItems['pro_price']; ?> </td>
				<td> <?php echo $row_selectOrderItems['quantity']; ?> </td>
				<td> <?php echo $row_selectOrderItems['quantity']*$row_selectOrderItems['pro_price']; ?> </td>
			</tr>
			
			<?php $i++; } ?>
					<tr style="height:40px;vertical-align:bottom;">
						<td colspan="4" style="text-align:right;"><b> Grand Total: </b></td>
						<td>
						<?php
							mysqli_data_seek($resultInvoiceItems,0);
							$rowInvoiceItems = mysqli_fetch_array($resultInvoiceItems);
							echo isset($rowSelectInvoice['total_amount']) ? $rowSelectInvoice['total_amount'] : 'N/A';
						?>
						</td>
					</tr>
				</table><br/><br/>
				<b>Comments:</b> <br/> <?php echo isset($rowSelectInvoice['comments']) ? $rowSelectInvoice['comments'] : 'N/A'; ?>
				<br/><br/><br/><br/><br/><br/>
			<p id="signature" style="float:right;display:none;">(Authorized Signatory)</p>
			<p id="footer" style="clear:both;display:none;padding-bottom:20px;text-align:center;">Thank you for your Bussiness!</p>
		</div>
		<input type="button" value="Print Invoice" class="submit_button" onclick="PrintDiv();" />
		</form>
	</section>
	<?php
		include("../includes/footer.inc.php");
	?>
</body>
</html>
