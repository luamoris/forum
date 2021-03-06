<?php
include $_SERVER['DOCUMENT_ROOT'] . "/configs/db.php";

$sql = "SELECT topics.* FROM topics ORDER BY (SELECT count(*) FROM comments WHERE comments.topic_id = topics.id) DESC";
$result = mysqli_query($connect, $sql);
$topics_num = mysqli_num_rows($result);

?>

<nav class="content__products">

	<ul class="products__list">
		<?php
		$count = 1;
		while ($count <= $topics_num) {

			$topic = mysqli_fetch_assoc($result);

			echo "<a href='?topic_id=" . $topic["id"] . "'>";
				echo"<li class=\"products__item\">";

				echo "<div class=\"icon\"><img src='" . $topic['img'] . "' ></div>";

				echo "<div class=\"item__content\">";

				echo "<div class=\"item__title\">";		

				echo "<span>" . $topic["title"] . "</span>";

				echo "<div class=\"item__message\">";		

				echo "<div class=\"icon\"><img src=\"assets/img/mes.svg\"></div>";

				$sql_comments_num = "SELECT * FROM comments WHERE topic_id =" . $topic['id'];
				$sql_comments_num_result = mysqli_query($connect, $sql_comments_num);
				$comments_num = mysqli_num_rows($sql_comments_num_result);

				echo "<span>" . $comments_num . "</span>";

				$latest_comment = "SELECT * FROM comments WHERE topic_id =" . $topic['id'] ." ORDER BY id DESC LIMIT 1";
				$sql_comments_num_result = mysqli_query($connect, $latest_comment);
				$lat_com = mysqli_fetch_assoc($sql_comments_num_result);

				$latest_user = "SELECT * FROM users WHERE id =" . $lat_com['person_id'];
				$sql_user_num_result = mysqli_query($connect, $latest_user);
				$lat_user = mysqli_fetch_assoc($sql_user_num_result);

				echo "</div>";
				echo "</div>";
				echo "<div class=\"item__about\">";		
				echo "<span>" . $lat_user['username'] . ": <span>" . $lat_com['comment'] . "</span></span>";			
				echo "</div>";		
				echo "</div>";	
				echo "</li>";
			echo "</a>";
			$count++;
		}
		?>
	</ul>
	
</nav>