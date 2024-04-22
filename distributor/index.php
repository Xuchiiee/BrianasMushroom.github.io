<?php
include("../includes/config.php");
session_start();

if (isset($_SESSION['dist_id'])) {
    $id = $_SESSION['dist_id'];

    // Query to get distributor information
    $queryDistributorInfo = "SELECT dist_name, password, dist_email, dist_phone, dist_address 
                            FROM distributor 
                            WHERE dist_id = '$id'";
    $resultDistributorInfo = mysqli_query($con, $queryDistributorInfo);
    $row_selectdistributor = mysqli_fetch_array($resultDistributorInfo);
	


} else {
    header('Location:../index.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Retailer: Home</title>
    <link rel="stylesheet" href="../includes/main_style.css" />
</head>
<body>
    <?php
    include("../includes/header.inc.php");
    include("../includes/nav_distributor.inc.php");
    ?>
	<section>
		Welcome <?php echo $_SESSION['sessUsername']; ?>
		<article>
			<h2>My Profile</h2>
			<table class="table_displayData">
				<tr>
					<th>Username</th>
					<th>Area Code</th>
					<th>Phone</th>
					<th>Email</th>
					<th>Address</th>
					
				</tr>
				<tr>
					<td> <?php echo $row_selectdistributor['dist_name']; ?> </td>
					<td> <?php echo $row_selectdistributor['password']; ?> </td>
					<td> <?php echo $row_selectdistributor['dist_phone']; ?> </td>
					<td> <?php echo $row_selectdistributor['dist_email']; ?> </td>
					<td> <?php echo $row_selectdistributor['dist_address']; ?> </td>
					
				</tr>
			</table>
		</article>
		
	</section>
			
	<?php
		include("../includes/footer.inc.php");
		exit();
	?>