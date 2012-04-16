<!DOCTYPE html>
<html>
	<head>
		<title>Lyrics Commander</title>
			<link rel="stylesheet" type="text/css" href="indexstyle.css" />
				<script src="_js/jquery-1.7.js"></script>
				<script>
					$(document).ready(function(){
						$(".registerfield").focus(function(srcc){
							if ($(this).val() == $(this).attr('title')){
								$(this).css('color', 'black');
								$(this).val("");
							}
						});
						$(".registerfield").blur(function(){
							if ($(this).val() == ""){
								$(this).css('color', '#E0E0E0');
								$(this).val($(this).attr('title'));
							}
						});
						$(".registerfield").blur();
					});
				</script>
	</head>
	<body>
		<div id="titlebar">
			<span id="titletext">Lyrics Commander</span>
		</div>
		
		<div id="containerdiv">
			<div id="centerdiv">
				<table id="centertable">
					<tr>
						<td id="left">
							<form id="registerform">
								<input type="text" name="username" id="username" class="registerfield" maxlength="31" width="25" title="Username"/>
								<br /><input type="password" name="password" id="password" class="registerfield" maxlength="31" width="25" title="Password"/>
								<br /><input type="text" name="email" id="email" class="registerfield" maxlength="127" width="25" title="Email Address"/>
								<br /><input type="submit" name="submit_register" id="submit_register" value="Submit" />
							</form>
						</td>
						<td id="right">
							What can Lyrics Commander do for you?
						</td>
					</tr>
				</table>
			</div>
		</div>
	</body>
</html>