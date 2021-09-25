		<?php include("partials-front/navbar.php"); ?>
		<!-- Categories Section **add container around image and title -->
		<section class="categories">
			<h2>Explore Categories</h2>
			<?php
				$sql = "SELECT * FROM Categories WHERE active=1";
				try {
					$res = $conn->query($sql);
					$count = $conn->query('SELECT COUNT(*) FROM Categories WHERE active=1')->fetchColumn();
					if($count>0){
						foreach($res as $row){
							$category_id = $row["category_id"];
							$name = $row["name"];
							$image = $row["image"];
							//Display the values in our tables
							?>
							<a href="<?php echo URL; ?>select-category.php?category_id=<?php echo $category_id; ?>">
								<?php
									//check if image is available
									if($image==""){
										echo "<div class='error'>Image not Available</div>";	
									}
									else{
										?>
										<img src="<?php echo URL; ?>images/category/<?php echo $image; ?>" alt="Category img">
										<?php
									}	
								?>
								<h3><?php echo $name; ?></h3>
							</a>
							<?php
						}	
					}
					else{
						echo "<div class='error'>Category not Added.</div>";	
					}
				}
				catch (PDOException $e) { echo "did not execute."; }
			?>
		</section>
		<!-- End Categories Section -->

		<?php include("partials-front/footer.php"); ?>
