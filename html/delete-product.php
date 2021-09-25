<html>
	<head>
		<title>Delete Item</title>
		<link rel="stylesheet" href="css/front.css">
	</head>
	<body>
		<?php include("config/constants.php"); ?>
		<?php
		if(isset($_GET['index']) && (isset($_SESSION['Cart']) || $_SESSION['Cart'] != '')){
			$index = $_GET['index'];						
			$product_id_array = explode(" ", $_SESSION['Cart']);
			echo $product_id_array[1];
			print_r(array_values($product_id_array));
		}
		else{
			$_SESSION['delete-item'] = "<div class='error'>product_id or cart not set</div>";
			header('location:'.URL."cart.php");
		}
		print($_SESSION['Cart']);
		print_r(array_values($product_id_array));
		unset($product_id_array[$index]);
		$product_id_array = array_values($product_id_array);
		print_r(array_values($product_id_array));

		$_SESSION['Cart'] = implode(" ", $product_id_array);

	header('location:'.URL."cart.php");
		?>
	</body>
</html>
