<?php
				$page =  $_SERVER['PHP_SELF'];
// Begin Page Jump	
				if ($pageCount > 1) {
					echo '<div align="center"><table border=0 style=""><tr>';
					echo '<td align="left" width="40">';
					if ($currPage != 1) {
						echo "<a href=\"$page?searchOffset=";
						echo ($currPage - 2) * $resultCount;
						echo '&q=' . $searchString . '">'; 
						#echo 'Prev.';
						echo "<img src='/images/buttons/small/Prev-arrow.gif'/>";
						echo '</a>';
					}
					echo '</td><td align="center">';
					if ($pageStart != 1) {
						echo "<a href=\"$page?searchOffset=";
						echo ($pageStart - 10 - 1) * $resultCount;
						echo '&q=' . $searchString . '">'; 
						echo '&#60;&#60;';
						echo '</a>';
						echo '&#8230; ';
					}
					for ($i=$pageStart; $i<= $pageEnd; $i++) {
						if ($i != $currPage) {
							echo "<a href=\"$page?searchOffset=";
							echo ($i -1) * $resultCount;
							echo '&q=' . $searchString . '">';
							echo $i;
							echo '</a>';
						} else
							echo $i;
						echo ' ';
					}
					if ($pageEnd != $pageCount) {
						echo ' &#8230;';
						echo "<a href=\"$page?searchOffset=";
						echo $pageEnd * $resultCount;
						echo '&q=' . $searchString . '">'; 
						echo '&#62;&#62;';
						echo '</a>';
					}
					echo '</td><td align="right" width="40">';
					if ($currPage != $pageCount) {
						echo "<a href=\"$page?searchOffset=";
						echo $currPage * $resultCount;
						echo '&q=' . $searchString . '">'; 
						#echo 'Next';
						echo "<img src='/images/buttons/small/Next-arrow.gif'/>";
						echo '</a>';
					}
					echo '</td></tr>';
					echo '</table></div>';
				}
// End Page Jump
?>
