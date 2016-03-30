<?php
$category="";
/*
Set the category value based on the image clicked in home page
*/
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if(isset($_POST['category']) && $_POST['category'] !="")
	$category = $_POST['category'];
	else
	{
	header("location: ".base_url());
	}
}
else
{
header("location: ".base_url());
}
?>


<html>
<head>
<title>Quiz</title>
<!-- load all css and js files -->
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
					<div class="questionheader">
						<div class="questionnumber"></div>
						<div class="userscore">
						<!--Display score -->
							<div id="scorestyle">Score: <span id="scoretext">0</span></div>
						</div>
						<div style="float:right"><a href="<?php echo base_url(); ?>/index.php"><img height="40px" width="40px" src="<?php echo base_url(); ?>/web/images/home.png"></a></div>
						<!-- Display timer -->
						<div class="usertimer">00:<span id="counter"></span></div>				
					</div>
					<!--show question -->
					<div id="questiontext"></div>
					<!--show image if available -->
					<div id="questionimage"></div>
					<!--Display choices -->
					<div class="questionoptions">
						<ul class="ansrow">
						<li id="option1"></li>
						<li class="separator">&nbsp;</li>
						<li id="option2"></li>
						</ul>	
						<ul class="ansrow">
						<li id="option3"></li>
						<li class="separator">&nbsp;</li>
						<li id="option4"></li>
						</ul>	
						<form name="validataanswer" id="validateanswer" action="validateanswer">
						<input type="hidden" name="question_id" id="question_id" value=""/>
						<input type="hidden" name="user_answer" id="user_answer" value=""/>
						</form>
					</div>
				</div>
			<!--show processing image when request is sent to rest api -->
			<div id="ajaxloading" style="display:none">
			<div><img src="<?php echo base_url(); ?>web/images/processing.gif" width="250" height="250" border="0" alt=""></div>
			</div>
			
			<!--Showing results after all questions are answered -->
			<div id="display_result"   style="display:none">
				<div class="questionheader">
				<div style="float:left">Thank you for completing the quiz. Your quiz results are shown below!</div>
				<div style="float:right"><a href="<?php echo base_url(); ?>/index.php"><img height="40px" width="40px" src="<?php echo base_url(); ?>/web/images/home.png"></a></div>
				</div>
				<!-- Show graph comparing user score vs average score-->
				<div id="bargraph">
					<div class="left">
					<table>
					<caption>Score</caption>
					<tbody>
					<tr><td>Average score</td><td id="avgscore_allusers"></td><td style="background-color:green;width:40px">&nbsp;</td></tr>
					<tr><td>Your score</td><td id="youruserscore"></td><td style="background-color:red;width:40px">&nbsp;</td></tr>
					<tr><td>Total plays</td><td id="total_plays"></td><td style="width:40px">&nbsp;</td></tr>
					</tbody></table>
					<div>
					</div>

					</div>
					<div class="left">
					<div id="baseline">
					<div class="line" style="top:25%"><div>75%</div></div>
					<div class="line" style="top:50%"><div>50%</div></div>
					<div class="line" style="top:75%"><div>25%</div></div>
					<div id="col0" style="left:0; background-color:green;" class="column"></div>
					<div id="col1" style="left:25%; background-color:red;" class="column"></div>					
					</div>
					</div>					
				</div>
				<!--show whether user has got good score or bad score with feedback text. Next level will be unlocked if the user scores greater than 70% -->
					<div id="resultstext"></div>
					<div style="padding-top:10px" id="resultsimage"><a href='#' onclick="javscript:$('#categoryform').submit();"><img src="<?php echo base_url(); ?>web/images/playnextlevel.png"/></a></div>

			</div>			
		</div>
	</div>
	<!--Route to level 2 questions when play next level is clicked-->
	<form name="categoryform" id="categoryform" method="post" action="<?php echo base_url(); ?>/index.php/sportsquiz">
		<input type="hidden" name="category" id="category" value="5"/>
	</form>

<script type="text/javascript">
//Function to show graph using css
function viewGraph(){
$('.column').css('height','0');
$('table tr').each(function(index) {
var ha = $(this).children('td').eq(1).text();
$('#col'+index).animate({height: ha}, 1500).html("<div>"+ha+"</div>");
});
}

//Function to show timer.A counter is used to decrease from 60 to 0. If the timer is up the answer is automatically validated
var mytimer;
var count=1;
var number_of_questions=0;
var correct_answers=0;
var score=0;
var cssbutton=0;
var category="<?php echo $category ?>";

//to show timer
function timerscript()
{
    var sec = 60;
    mytimer=setInterval(function(){		
		if(sec>=0 && sec<10)
        $("#counter").html("0"+sec) ;
		else if(sec>10)
		$("#counter").html(sec) ;

        sec--;
        if(sec < 0)
        {
            sec=0;
			validate_answer(0);

        }
        },1000);
}

//show question one by one to user
function show_question()
{
	//show count down timer 
	timerscript();

	if(cssbutton !=0)
	{
	//reset the color of the choices on hover and normal to grey and dark grey
	$("#option"+cssbutton).css('background-color', '#D8D3CF');
	$("#option"+cssbutton ).on( "mouseout", function() {
			  $( this ).css( "background-color",'#D8D3CF' );
			});
	$("#option"+cssbutton ).on( "mouseover", function() {
			  $( this ).css( "background-color",'#BFB7B0' );
			});
	cssbutton=0;
	}
	//Ajax request to fetch question one by one from database. 
	$.ajax({ 
		//Rest API fetch_question is called with datatype JSON
		url: '<?php echo base_url(); ?>/index.php/fetch_question', 
		dataType: 'json',
		type:"POST",
		//show processing image when the ajax request is sent
		beforeSend: function(){
        $("#display_result").hide();
		$("#sportsquestions").hide();
		$("#ajaxloading").show();
		},
		//send the parameters / input to REST API
		data: {'category': category,'id':count} ,
		})
		.done(function(res) {
		//res variable has the json response from REST API
		//when response received, process the response and display to user
		$("#display_result").hide();
		$("#sportsquestions").show();
		$("#ajaxloading").hide();
		//display the number of questions
		if(count==1)
		{
		number_of_questions=res.number_questions[0].number_questions
		}
		//show question number received from response from REST API
		$(".questionnumber").html("Question "+count+" of "+number_of_questions);
		//show question text received from response from REST API
		$("#questiontext").html(res.response[0].question_text);
		//show choice1 received from response from REST API
		$("#option1").html(res.response[0].answer_option1);
		//show choice2 received from response from REST API
		$("#option2").html(res.response[0].answer_option2);
		//show choice3 received from response from REST API
		$("#option3").html(res.response[0].answer_option3);
		//show choice4 received from response from REST API
		$("#option4").html(res.response[0].answer_option4);
		//set question id received from response from REST API
		$("#question_id").val(res.response[0].id);
		//show image received from response from REST API
		var imglocation=res.response[0].image_location;
		if(imglocation != "" && imglocation !=null)
		$("#questionimage").html('<img src="<?php echo base_url(); ?>web/images/uploads/'+imglocation+'" height="225px" width="300px">');
		else
		$("#questionimage").html("");
		count++;
		});
}
show_question();


$(document).ready(function(){
	//validate the user answer entered when each choice1, choice2, choice3, and choice4 is clicked
	$('#option1').on('click', function() {
	validate_answer(1);
	});

	$('#option2').on('click', function() {
	validate_answer(2);
	});

	$('#option3').on('click', function() {
	validate_answer(3);
	});

	$('#option4').on('click', function() {
	validate_answer(4);
	});



});

//validate the answer entered by user with answer from the database
function validate_answer(ans)
{
//clear or reset the timer interval when answer is submitted
clearInterval(mytimer);
//AJAX request to REST API /validate_answer to validate the answer submitted by user
$.ajax({ 
		url: '<?php echo base_url(); ?>/index.php/validate_answer', 
		dataType: 'json',
		type:"POST",
		//show loading image, hide the question and result section
		beforeSend: function(){
        $("#display_result").hide();
		$("#sportsquestions").hide();
		$("#ajaxloading").show();
		},
		//pass the parameters to REST API - answer, question id, count and number of questions
		data: {'answer': ans,'questionid':$("#question_id").val(),'count':count,'number_of_questions':number_of_questions} ,
		})
		.done(function(res) {
		//res variable has the response from REST API
		$("#display_result").hide();
		$("#sportsquestions").show();
		$("#ajaxloading").hide();
		//check whether the response value is 0 from REST API response for correct answer
		if(res.response=="0")
			{
				//increment the score for correct answer
				score=score+10;
				//count the total number of questions answered correctly
				correct_answers++;
				$("#scoretext").html(score);
				//change the background colour of the choice to green
				$("#option"+ans).css('background-color', '#43EA31');
				$("#option"+ans ).on( "mouseover", function() {
				  $( this ).css( "background-color",'#43EA31' );
				});			

				cssbutton=ans;
				alert("Thats right, Well done !");
			}
		else
			{
				if(ans!=0)
				{
				//change the background colour of the choice to red for incorrect answer
				$("#option"+ans).css('background-color', 'red');
				$("#option"+ans ).on( "mouseover", function() {
				  $( this ).css( "background-color",'red' );
				});
				cssbutton=ans;
				alert("Sorry, Thats not right");
				}
				else
				{
					alert("You haven't answered this question");
				}
			}
			if(count<=number_of_questions)
			{
			//show next question if there are still questions to answer
			show_question();
			}
			else
			{
			clearInterval(mytimer);
			//show results if there are no questions to answer
			showresults();
			}

			});
}

//show results when all questions are answered
function showresults()
{
	//AJAX reqeuest to know the final results by submitting the request to REST API /submit_results
	$.ajax({ 
		url: '<?php echo base_url(); ?>/index.php/submit_results', 
		dataType: 'json',
		type:"POST",
		beforeSend: function(){
        $("#display_result").hide();
		$("#sportsquestions").hide();
		$("#ajaxloading").show();
		},
		//submit the details of correct answers, number of questions, score and category to REST API
		data: {'correct_answers': correct_answers,'number_of_questions':number_of_questions,'score':score,'category':category} ,
		})
		.done(function(res) {
		//display the graph based on the response from the REST API
		$("#display_result").show();
		$("#sportsquestions").hide();
		$("#ajaxloading").hide();
		if(res.avg_user_score==null)
			$("#avgscore_allusers").html("0%");
		else
		$("#avgscore_allusers").html(res.avg_user_score+"%");

		$("#youruserscore").html(res.score+"%");
		$("#total_plays").html(res.total_no_plays);
		if(res.score>=70)
		{
			if(category != 5)
			{
			$("#resultstext").html('Congratulations, well done impressive indeed! You scored above 70% and have unlocked level 2! which contains general sports questions. ARE YOU READY FOR THE NEXT LEVEL?');
			$("#resultsimage").show();
			}
			else
			{
			$("#resultstext").html('Thank you for completing the quiz. You can either exit the application or try other quizzes');
			$("#resultsimage").hide();
			}
		}
		else
		{
		$("#resultstext").html('Pretty bad your better then that!, TRY AGAIN!');
		$("#resultsimage").hide();
		}
		//Show bar graph
		viewGraph();			
		});
}
</script>




</body>
</html>