
<?php
//validate whether user is logged in, username and password is validated and user info is already set in the session
if (!isset($this->session->userdata['adminlogininfo'])) {
//route to administrator login page if the user is not already logged
header("location: ".base_url() ."index.php/administrator");
}
else{
$username = ($this->session->userdata['adminlogininfo']['username']);
}
?>

<html>
<head>
<title>Sports Quiz Administration</title>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>web/css/style.css" media="screen">
<script type="text/javascript" src="<?php echo base_url(); ?>web/js/jquery.min.js"></script>
</head>
<body>


<div id="content">
<div class="header"><div style="float:left">Sports Quiz</div> <div style="float:right;padding-left:10px"><a href="http://facebook.com"><img src="<?php echo base_url(); ?>web/images/facebook.png" height="30px" width="30px"></a></div><div style="float:right;padding-left:10px"><a href="http://twitter.com"><img src="<?php echo base_url(); ?>web/images/twitter.png" height="30px" width="30px"></a></div><div style="float:right;padding-left:10px"><a href="http://plus.google.com"><img src="<?php echo base_url(); ?>web/images/googleplus.png" height="30px" width="30px"></a></div><div style="float:right;padding-left:10px"><a href="http://instagram.com"><img src="<?php echo base_url(); ?>web/images/instagram.png" height="30px" width="30px"></a></div><div style="float:right;padding-left:10px"><a href="http://linkedin.com/in/waqar-malik-416236ba"><img src="<?php echo base_url(); ?>web/images/linkedin.png" height="30px" width="30px"></a></div> </br></br></div>
		<div id="quizwrapper">
			<div class="quizwrapperimage"></div>
			<div class="quizwrappertext">
				<div id="sportsquestions">
				<!--Show welcome section with username, logout and welcome message -->
						<div class="questionheader">
							<div style="float:left">Welcome <?php echo $username ?></div><div style="padding:right:200px;float:right"><a href="<?php echo base_url(); ?>/index.php/adminhome"><img height="40px" width="40px" src="<?php echo base_url(); ?>/web/images/home.png"></a></div><div style="float:right"><a href="logout"><img src="<?php echo base_url(); ?>/web/images/logout.png"></a></div></br>	
						</div>

						<div style="width:960px">					
							<div style="float:left">
								<p class="submit"><input type="submit" name="addquestion" class="addquestionbutton" value="Add Question"></p>
							</div>
							<div style="float:right" class="filter">
								<select name="filter"  id="filter" onchange="javascript:viewquestions();">
									<option value="1">Cricket</option>
									<option value="2" selected>Football</option>
									<option value="3">Rugby</option>
									<option value="4">Tennis</option>
									<option value="5">Level2</option>
								</select>

							</div>
						</div>
						<!--process the template in backbone and insert the results template(viewallquestionstemplate) in the div below -->
						<div class="question_resultset" style="display:none">
						
						</div>
						<!--show loading image -->
						<div id="ajaxloading" style="display:none">
						<div><img src="<?php echo base_url(); ?>web/images/processing.gif" width="250" height="250" border="0" alt=""></div>
						</div>
						<!--Show status text -->
						<p id="statustext"></p>
						<div id="addquestion" style="float:left;display:none">
						<form name="addquestionform" id="addquestionform" method="post" enctype="multipart/form-data">	

								<p>
								<textarea name="question_data" id="question_data" rows="4" cols="75" placeholder="Enter question"></textarea>						
								</p>
								<p>
								  <br/><input type="file" name="imageToUpload" id="imageToUpload" size="18" onchange="readURL(this);"/><img id="quiz_image" src="#" alt="" />
								</p>
								
								<p>
								<br/>
								<select name="selectcategory"  id="selectcategory">
									<option value="">Select Category</option>
									<option value="1">Cricket</option>
									<option value="2">Football</option>
									<option value="3">Rugby</option>
									<option value="4">Tennis</option>
									<option value="5">Level2</option>
								</select>
								</p>
								<p>
									<ul class="adminoptionsrow">
									<li id="admin_option1_1"><input type="radio" class="radioinput" id="choice_radio1" name="question_option" value="1"/></li>
									<li id="admin_option1_2"><input type="text"  class="optioninput" placeholder="Enter Choice 1" name="question_option1_text" id="question_option1_text" value=""/></li>


									<li id="admin_option2_1"><input type="radio" class="radioinput" id="choice_radio2" name="question_option" value="2"/></li>
									<li id="admin_option2_2"><input type="text" class="optioninput" placeholder="Enter Choice 2" name="question_option2_text" id="question_option2_text" value=""/></li>
									</ul>	
									<br/><br/>
									<ul class="adminoptionsrow">
									<li id="admin_option3_1"><input type="radio" class="radioinput" id="choice_radio3" name="question_option" value="3"/></li>
									<li id="admin_option3_2"><input type="text"  class="optioninput" placeholder="Enter Choice 3" name="question_option3_text" id="question_option3_text" value=""/></li>


									<li id="admin_option4_1"><input type="radio" class="radioinput" id="choice_radio4" name="question_option" value="4"/></li>
									<li id="admin_option4_2"><input type="text" class="optioninput" placeholder="Enter Choice 4" name="question_option4_text" id="question_option4_text" value=""/></li>
									</ul>	
									<input type="hidden" name="quiz_id" id="quiz_id" value=""/>
									

								</p>
								<p>
								<br/><br/><br/>
								</p>

								<div style="width:1000px;text-align:center">
								<div style="padding-left:400px;float:left">
								<input type="submit" name="submit" class="formbutton" value="Save"/>
								</div>
								<div style="padding-left:10px;float:left">
								<input id="reset" type="reset" name="reset" class="formbutton" value="Reset"/>
								</div>
								</div>

						</form>
						</div>

				</div>		
			</div>
		</div>
	</div>
<!-- 
Defining the template to use for Backbone. Defining the template using underscore js and it will compile the template and then when the data is passed to this template, it will return the html view as per the code.
-->
	<script id="viewallquestionstemplate" type="text/template">
					<div class="table">						
						<div class="row header">
						  <div class="cell">
							No
						  </div>
						  <div class="cell">
							Question
						  </div>
						  <div class="cell">
							Category
						  </div>
						  <div class="cell">
							Edit/Delete
						  </div>
						</div>	
						<% i=1 %>
						<% _.each(data,function(item){ %>
						<div class="row">
						  <div class="cell">
							<%- i %>
						  </div>
						  <div class="cell">
							<%- item.question_text %>
						  </div>
						  <div class="cell">
							<%- item.category %>
						  </div>
						  <div class="cell">
							<a href="#" onclick="javascript:record_delete(<%- item.id %>);"><img src="<?php echo base_url(); ?>web/images/delete.png" height="30px" width="30px"?></a>
							<a href="#" onclick="javascript:fetchquestionfunc(<%- item.id %>);" ><img src="<?php echo base_url(); ?>web/images/edit.png" height="30px" width="30px"?></a>
						  </div>
						</div>
					<% i++ %>
					<% }); %>
				  </div>
	</script>

	<!--Implementation of Backbone.js -->
<script src="<?php echo base_url(); ?>web/js/underscore.js"></script>
<script src="<?php echo base_url(); ?>web/js/backbone.js"></script>
<script type="text/javascript">
//Function to show the image when the image is browsed while adding or editing question
var imagechangeflag=0;
function readURL(input) 
{
	$("#quiz_image").attr('src', "");
	if (input.files && input.files[0]) 
	{
		var reader = new FileReader();

		reader.onload = function (e) {
		$('#quiz_image')
		.attr('src', e.target.result)
		.width(100)
		.height(75);
		};

		reader.readAsDataURL(input.files[0]);
		imagechangeflag=1;
	}
}


var backbone_View;
var imagefilename="";
$(document).ready(function()
{	
		$('.addquestionbutton').click(function(){
		$('.question_resultset').hide();
		$('#addquestion').show();
		resetform();
		});
		
		$('#addquestionform').on('submit', function(e) {
		e.preventDefault();// This event fires when a button is clicked
		var filename="";
		//AJAX request to REST API uploadfile to upload the image to database
		$.ajax({
			url: '<?php echo base_url(); ?>/index.php/uploadfile/',        // Url to which the request is send
			type: "POST",             // Type of request to be send, called as method
			data: new FormData($("#addquestionform")[0]), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
			contentType: false,       // The content type used when sending data to the server.
			cache: false,             // To unable request pages to be cached
			processData:false,        // To send DOMDocument or non processed data file it is set to false
			success: function(data)   // A function to be called if request succeeds
			{
						//while editing/inserting the question from admin page, if the image is changed then the new image is uploaded into database and used to insert into database
						if(imagechangeflag==1)
						filename=data.filename;
						//while editing/inserting the question from admin page, if the image is unchanged then the unchanged file name is used to update into database
						else
						filename=imagefilename;
						//form validation to check whether all information is entered while adding the question to database
						if($("#question_data").val() == "" || typeof($('input:radio[name=question_option]:checked').val())=="undefined" || $("input[name=question_option1_text]").val()=="" || $("input[name=question_option2_text]").val()==""  || $("input[name=question_option3_text]").val()==""  || $("input[name=question_option4_text]").val()=="" || $("#selectcategory").val()=="")
						{
						$("#statustext").html("Please complete all the details in the form");
						return;
						}
						var quiz_id="0";
						$("#question_resultset").hide();
						$("#ajaxloading").show();
						quiz_id=$("#quiz_id").val();
						if(quiz_id=="")
						quiz_id="0";
						//Use of Backbone model to save question
						var backbone_model = Backbone.Model.extend({
						//Calling REST API savequestion
						url: '<?php echo base_url(); ?>/index.php/savequestion/'
						});
						backbone_model_obj=new backbone_model({quizid:quiz_id,question_data:$("#question_data").val(), question_option:$('input:radio[name=question_option]:checked').val(), question_option1_text:$("input[name=question_option1_text]").val(),  question_option2_text:$("input[name=question_option2_text]").val(), question_option3_text:$("input[name=question_option3_text]").val(), question_option4_text:$("input[name=question_option4_text]").val(),selectcategory: $("#selectcategory").val(),image_name:filename });
						//Use of Backbone to save the user entered data in admin page to database
						backbone_model_obj.save(null,{
						success: function (response) {
						response=response.toJSON();
						if(response.status==true)
						{
						alert("Question saved to database");
						}
						else
						{
						alert("Error while saving question to database");
						}
						$('#addquestion').hide();
						//process the question list template and show it in admin home page
						backbone_View.loading();
						backbone_View.render();
						},
						error: function (model, xhr, options) {
						alert("Error while saving question to database");
						$('#addquestion').hide();
						//process the question list template and show it in admin home page
						backbone_View.loading();
						backbone_View.render();
						}
						});
				}
			});
		});
});


	function viewquestions()
	{	
	category=$("#filter").val();
	//implementation of back bone to load the user defined template
	_.templateSettings.variable = "rc";
	var template=_.template($('#viewallquestionstemplate').html());
	var backbone_question_model = Backbone.Model.extend();
	//Backbone collection to use the model
	var backbone_question_collection = Backbone.Collection.extend({
	model: backbone_question_model,
	url: '<?php echo base_url(); ?>/index.php/getquestionsbycategory/'+category
	});
	//display the collection retrieved from database in the admin page
	var backbone_question_collectionresultset = new backbone_question_collection();
	var backbone_question_view = Backbone.View.extend({
	model:backbone_question_collection,
	loading:function(){
	$(".question_resultset").hide();
	$("#ajaxloading").show();
	},
	//apply the response from REST API and process the user defined template
	render: function(){
	this.$el.html(); // lets render this view
	var self = this;
	this.model.fetch({success: function(userdata){
	outputdata=userdata.toJSON();
	if(typeof(outputdata[0].status) == "undefined" && outputdata[0].status != "false")
	{
	$(".question_resultset").html(template({data:outputdata}));
	}
	else
	{
	$(".question_resultset").html('<div id="statustext"></br>No questions in the database. Please add quiz questions</div>');
	}

	$(".question_resultset").show();
	$("#ajaxloading").hide();
	}});
	}
	});
	//Back bone: Show the list of questions retrieved from database by passing the div element where the result set is to be inserted and the collection result set
	backbone_View = new backbone_question_view({ el: $(".question_resultset"), model: backbone_question_collectionresultset });
	backbone_View.loading();
	backbone_View.render();
	}
	viewquestions();
	//Delete a record from database when delete button is clicked
	function record_delete(id)
	{
		var r = confirm("Are you sure you want to delete the question?");
		if (r != true) {
		return false;
		}

		$(".question_resultset").hide();
		$("#ajaxloading").show();
		//backbone implementation to send request to REST API deletequestion
		var backbone_delete_model = Backbone.Model.extend({
		url: '<?php echo base_url(); ?>/index.php/deletequestion/',
		initialize: function(options) {
		this.id = options.quizid;
		this.url= this.url+this.id;
		},

		});

		//Implementation of Backbone delete model
		backbone_delete_modelobj=new backbone_delete_model({quizid:id});
		//Implementation of Backbone destroy(delete) method
		backbone_delete_modelobj.destroy({
		success: function (model, response, options) {
		alert("Question deleted from the database");
		backbone_View.loading();
		backbone_View.render();
		},
		error: function (model, xhr, options) {
		alert("Error while deleting question");
		}
		});
	}

	function resetform()
	{
	$("#question_data").val("");
	$('#imageToUpload').val("");
	$("#quiz_image").attr('src', "");
	$("#question_option1_text").val("");
	$("#question_option2_text").val("");
	$("#question_option3_text").val("");
	$("#question_option4_text").val("");
	$("#quiz_id").val("");
	$('#choice_radio1').prop('checked', false);
	$('#choice_radio2').prop('checked', false);
	$('#choice_radio3').prop('checked', false);
	$('#choice_radio4').prop('checked', false);
	}

	//fetch a question from database
	function fetchquestionfunc(id)
	{
	imagechangeflag=0;
	$(".question_resultset").hide();
	$("#ajaxloading").show();
	//Backbone model to call the REST API viewquestion
	var backbone_fetch_model = Backbone.Model.extend({
	url: '<?php echo base_url(); ?>/index.php/viewquestion/',
	initialize: function(options) {
	this.id = options.quizid;
	this.url= this.url+this.id;
	},

	});


	backbone_fetch_modelobj=new backbone_fetch_model({quizid:id});
	//Backbone implementation to fetch the results from database, based on the quiz id selected the fetch method retrieves the question data from the database
	backbone_fetch_modelobj.fetch({
	success: function (data) {
	data=data.toJSON();
	$("#ajaxloading").hide();
	$('#addquestion').show();
	resetform();
	$("#question_data").val(data.response[0].question_text);
	var answer=data.response[0].correct_answer;
	//set the answer to radio choices
	switch (answer) {
	case '1':
	$('#choice_radio1').prop('checked', true);
	break;
	case '2':
	$('#choice_radio2').prop('checked', true);
	break;
	case '3':
	$('#choice_radio3').prop('checked', true);
	break;
	case '4':
	$('#choice_radio4').prop('checked', true);
	break;
	}
	//set choices from response
	$("#question_option1_text").val(data.response[0].answer_option1);
	$("#question_option2_text").val(data.response[0].answer_option2);
	$("#question_option3_text").val(data.response[0].answer_option3);
	$("#question_option4_text").val(data.response[0].answer_option4);
	$("#selectcategory  > [value='"+data.response[0].category+"']").attr("selected", "selected");
	//show image
	imagefilename=data.response[0].image_location;
	if(imagefilename != "" && imagefilename !=null)
	$("#quiz_image").attr("src","<?php echo base_url(); ?>web/images/uploads/"+ imagefilename).width(100).height(75);
	else
	$("#quiz_image").attr("src","").width(0).height(0);

	$("#quiz_id").val(data.response[0].id);
	$("#reset").hide();

	},
	error: function (model, xhr, options) {
	alert("Error while retrieving the details");
	}
	});
	}
	</script>

</body>
</html>