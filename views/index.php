<head>
<title>Sports Quiz</title>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>web/css/style.css" media="screen">
<script type="text/javascript" src="<?php echo base_url(); ?>web/js/jquery.min.js"></script>
</head>
<body>
	<div id="content">
		<div class="header"><div style="float:left">Sports Quiz</div> <div style="float:right;padding-left:10px"><a href="http://facebook.com"><img src="<?php echo base_url(); ?>web/images/facebook.png" height="30px" width="30px"></a></div><div style="float:right;padding-left:10px"><a href="http://twitter.com"><img src="<?php echo base_url(); ?>web/images/twitter.png" height="30px" width="30px"></a></div><div style="float:right;padding-left:10px"><a href="http://plus.google.com"><img src="<?php echo base_url(); ?>web/images/googleplus.png" height="30px" width="30px"></a></div><div style="float:right;padding-left:10px"><a href="http://instagram.com"><img src="<?php echo base_url(); ?>web/images/instagram.png" height="30px" width="30px"></a></div><div style="float:right;padding-left:10px"><a href="http://linkedin.com/in/waqar-malik-416236ba"><img src="<?php echo base_url(); ?>web/images/linkedin.png" height="30px" width="30px"></a></div> </br></br></div>
		<div id="wrapper">
			<div class="homer1">
				<ul style="list-style: none outside none;">
				<li style="float: left;display: block;width: 350px;height: 210px;"><a href="#" onclick="javascript:$('#category').val(1);$('#categoryform').submit();"><img height="200px" width="250px" src="<?php echo base_url(); ?>/web/images/cricket.jpg"></a></li>
				<li style="float: left;display: block;width: 350px;height: 210px;"><a href="#" onclick="javascript:$('#category').val(2);$('#categoryform').submit();"><img height="200px" width="250px" src="<?php echo base_url(); ?>/web/images/football.jpg"></a>
				</li>
				</ul>
				<ul style="list-style: none outside none;">
				<li style="float: left;display: block;width: 350px;height: 50px;"><a href="#" onclick="javascript:$('#category').val(1);$('#categoryform').submit();"><img src="<?php echo base_url(); ?>web/images/cricket.png"></a></li>
				<li style="float: left;display: block;width: 350px;height: 50px;"><a href="#" onclick="javascript:$('#category').val(2);$('#categoryform').submit();"><img src="<?php echo base_url(); ?>web/images/football.png"></a></li>
				</ul>



				<ul style="list-style: none outside none;">
				<li style="float: left;display: block;width: 350px;height: 210px;"><a href="#" onclick="javascript:$('#category').val(3);$('#categoryform').submit();"><img height="200px" width="250px" src="<?php echo base_url(); ?>/web/images/rugby.jpg"></a></li>
				<li style="float: left;display: block;width: 350px;height: 210px;"><a href="#" onclick="javascript:$('#category').val(4);$('#categoryform').submit();"><img height="200px" width="250px" src="<?php echo base_url(); ?>/web/images/tennis.jpg"></a>
				</li>
				</ul>
				<ul style="list-style: none outside none;">
				<li style="float: left;display: block;width: 350px;height: 50px;"><a href="#" onclick="javascript:$('#category').val(3);$('#categoryform').submit();"><img src="<?php echo base_url(); ?>web/images/rugby.png"></a></li>
				<li style="float: left;display: block;width: 350px;height: 50px;" onclick="javascript:$('#category').val(4);$('#categoryform').submit();"><a href="#"><img src="<?php echo base_url(); ?>web/images/tennis.png"></a></li>
				</ul>
			</div>
		</div>
	</div>

	<form name="categoryform" id="categoryform" method="post" action="<?php echo base_url(); ?>/index.php/sportsquiz">
		<input type="hidden" name="category" id="category" value=""/>
	</form>
</body>
</html>