<?php
echo <<<_HDOC
		<div id="titlebar">
			<span id="titletext">Lyrics Commander</span>
_HDOC;
			<?php
				if ($loggedin) echo "<a href='' id='logouttext'>Logout</a>";
			?>
echo "</div>";
?>