<html>
<head>
<title>Sports Quiz Administration</title>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>web/css/style.css" media="screen">
<script type="text/javascript" src="<?php echo base_url(); ?>web/js/jquery.min.js"></script>
</head>
<body>

<div id="content">
<div class="header"><div style="float:left">Sports Quiz </div> <div style="float:right;padding-left:10px"><a href="http://facebook.com"><img src="<?php echo base_url(); ?>web/images/facebook.png" height="30px" width="30px"></a></div><div style="float:right;padding-left:10px"><a href="http://twitter.com"><img src="<?php echo base_url(); ?>web/images/twitter.png" height="30px" width="30px"></a></div><div style="float:right;padding-left:10px"><a href="http://plus.google.com"><img src="<?php echo base_url(); ?>web/images/googleplus.png" height="30px" width="30px"></a></div><div style="float:right;padding-left:10px"><a href="http://instagram.com"><img src="<?php echo base_url(); ?>web/images/instagram.png" height="30px" width="30px"></a></div><div style="float:right;padding-left:10px"><a href="http://linkedin.com/in/waqar-malik-416236ba"><img src="<?php echo base_url(); ?>web/images/linkedin.png" height="30px" width="30px"></a></div> </br></br></div>
		<div id="quizwrapper">
			<div class="quizwrapperimage"></div>
			<div class="quizwrappertext">
				<div id="sportsquestions">
					<div class="questionheader">
						Administrator Login		
					</div>
					<!--Admin Form to enter username and password -->
					<div class="adminform">
						<div class="login">
						  <form method="post" action="<?php echo base_url(); ?>index.php/loginvalidation" id="adminactionform" name="adminactionform">
							<p><input type="text" name="username" value="" placeholder="Username"></p>
							<p><input type="password" name="password" value="" placeholder="Password"></p>
							<p class="submit"><input type="submit" name="commit" value="Login"></p>
						  </form>
						</div>

					</div>
				</div>		
		</div>
	</div>
</div>

</body>
</html>