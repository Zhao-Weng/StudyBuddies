<!-- Match -->
	<div>
		<?php 	
		$result = mysqli_query($conn, "SELECT username, email, image FROM User  WHERE email = ANY(SELECT S2.useremail FROM Schedule S1, Schedule S2 WHERE S1.useremail = '$session' AND S1.coursecode = S2.coursecode AND S1.useremail <> S2.useremail GROUP BY S2.useremail HAVING COUNT(S2.useremail) >= 2) ORDER BY RAND()");
		$num = mysqli_num_rows($result);
		if($num == 0){
			echo "<h1>Sorry we can't find any matches...</h1>";
		}
		else{ 
			echo '<center>';
			echo '<div class="carousel slide" data-ride="carousel" id="featured" data-interval="false" >';
			echo '<div class="carousel-inner" style="height:400px; width:300px">';
			echo '<div class = "item active" style="height:400px; width:300px" >';
			echo '<img width="300" style="height:400px; width:300px" src="images/match.jpg">';	
			echo '</div>';
			while($row = mysqli_fetch_array($result)){
				echo '<div class = "item">';
				echo '<div class = "blur-img" style="height:400px; width:300px"><img src="data:image;base64,'.$row['image'].'">';	
				echo '<button type="submit" name="like" value="'.$row['email'].'">like</button>';
				echo '</div>';
				echo '</div>';
			}
			echo '</div>';
			echo '<a href="#featured" id="leftc" class="left carousel-control" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>';
			echo '<a href="#featured" id="rightc" class="right carousel-control" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>';
			echo '</div></center>';
		}
		?>
	</div>

	<!-- Result -->
	<div class="message">
		<h1 id="re"> </h1>
	</div>

	<script type="text/javascript">
	$(document).ready(function(){
		$("#leftc").click(function(){
			$("#re").text("");
		})
		$("#rightc").click(function(){
			$("#re").text("");
		})
		$("button").click(function(){
			var me = "<?php echo $session?>";
			var you = $(this).attr("value");
			$.ajax({
				url:"scripts/like.php",
				type:"GET",
				data: {u1: me, u2: you},
				success:function(data, textStatus, jqXHR)
				{
					$("#re").text(jqXHR.responseText);
				},
				error: function (jqXHR, textStatus, errorThrown)
				{

				}
			});
		});
	});
	</script>
	