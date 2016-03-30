<?php

defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH . '/libraries/REST_Controller.php';
/*
Api where all the business logics for various methods are available

*/

class Restapi extends REST_Controller {


    function __construct()
    {		
        parent::__construct();
		//load the model
		$this->load->model('Model');
    }

/*
URL: /fetch_question
Type: POST
Description: Gets a question from database for the category selected one by one and displayed to user (pagination concept)
Parameter: id
*/

	public function fetch_question_post()
    {

        $id = $this->post('id');
		$category = $this->post('category');
		$id=(int)$id;
		//query to retrieve the question from the database
		if($id==1)
		$query="select id, question_text, answer_option1, answer_option2, answer_option3, answer_option4,image_location from q_data where category=".$category." order by id limit ".$id; 
		else
		$query="select id, question_text, answer_option1, answer_option2, answer_option3, answer_option4,image_location from q_data where category=".$category." order by id limit ".($id-1).", 1"; 
		//execute the query
		$db_response = $this->Model->fetch($query);
		if($id==1)
		{
		//get the total number of questions from the database in the first request from UI
		$count_query="select count(*) as number_questions from q_data where category=".$category; 
		$number_questions = $this->Model->fetch($count_query);
		}

        if ($db_response)
        {
			//set the question data and number of question in the response and send the response back to the client
			if($id==1)
			$response = array('response' => $db_response,'number_questions'=>$number_questions);
			else
			$response = array('response' => $db_response);
            $this->set_response($response, REST_Controller::HTTP_OK);   
        }
        else
        {
			//set an error message if no records found
            $this->set_response(['response_status' => FALSE,'message' => 'Record could not be found'], REST_Controller::HTTP_OK); 
        }
    }

/*
URL: /validate_answer
Type: POST
Description: Validates the answer submitted by the user for the question. If the answer is correct '0' is sent in response and '1'/'2' for invalid answer
Parameter: questionid
*/

	public function validateanswer_post()
    {
		$json_response="";
        $id = $this->post('questionid');
		$id=(int)$id;
        $answer = $this->post('answer');
        $count = $this->post('count');
        $number_of_questions = $this->post('number_of_questions');
		//query to check whether the entered answer is correct or wrong
		$query="select id, correct_answer from q_data where id = ".$id; 		
		$db_response = $this->Model->fetch_resultset_data($query);
	
        if ($db_response)
        {
			$correct_answer="";
			//find the answer of the question from the database
			foreach($db_response as $row)
			{
			$correct_answer = $row->correct_answer;
			}
			//compare the user given answer with answer in the database
			if($answer == $correct_answer)
			{
				//for correct answer 0 is set
				$json_response = array('response' => "0");
			}
			else
			{
				//for incorrect answer 0 is set
				$json_response = array('response' => "1");
			}			
			
        }
        else
        {
			//for incorrect answer or no row data 2 is set
            $json_response = array('response' => "2");
        }
		//send the response back to client
		$this->set_response($json_response, REST_Controller::HTTP_OK);    
    }

/*
URL: /viewquestion/(:num)
Type: GET
Description: Gets the question data from the database for the given question id
Parameter: id - question id
*/

    public function fetch_question_db_get()
    {
        $id = $this->get('id');
		$id=(int)$id;
		//query to fetch the rowdata from database with help of question id
		$query="select id, correct_answer,category, question_text, answer_option1, answer_option2, answer_option3, answer_option4,image_location from q_data where id=".$id; 
		$data = $this->Model->fetch($query);

        if ($data)
        {
			//set the data got from database in the response back to client
			$data = array('response' => $data);
            $this->set_response($data, REST_Controller::HTTP_OK);   
        }
        else
        {
			//set error response for any errors
            $this->set_response(['status' => FALSE,'error' => 'Record could not be found'], REST_Controller::HTTP_OK); 
        }
    }

/*
URL: getquestionsbycategory/(:num)
Type: GET
Description: Gets all questions from the database for the Category selected in admin page
Parameter: category - category selected by the admin in the admin page
*/


	public function get_allquestionsbycategory_get()
    {
		$category= $this->get('category');
		//query to get all the questions from the table q_data for the selected category		
        $query="select a.id, a.question_text,b.category from q_data a, category b where a.category=b.category_id and a.category=".$category." order by a.id, a.category"; 
		
		$data = $this->Model->fetch($query);
        if ($data)
        {
			$this->set_response($data, REST_Controller::HTTP_OK);   
        }
        else
        {
            $this->set_response(array(['status' => FALSE,'error' => 'Record could not be found']), REST_Controller::HTTP_OK); 
        }
    }

/*
URL: /submit_results
Type: POST
Description: Find the average score and total number of plays, inserts the user score into database
Parameter: correct_answer, number_questions, score, category
*/

	public function submitresults_post()
    {
		$avg_user_score=0;
		$total_no_plays=0;
		$correct_answers = $this->post('correct_answers');
		$number_of_questions=$this->post('number_of_questions');
		//calculate your score percentage
		$your_score_percentage=round(((int)$correct_answers)/((int)$number_of_questions)*100);
		$score=$this->post('score');
		$category=$this->post('category');
		//query to find the average score by other users for the selected category
		$avg_score_query="select round((sum(score)/(sum(attempted_questions)*10))*100) as avg_user_score, count(id)+1 as totalnumberofplays from avgscore where category = ".$category;
		$avguserscore_result = $this->Model->fetch_resultset_data($avg_score_query);	
		
		if ($avguserscore_result)
        {
			$avg_user_score="";
			foreach($avguserscore_result as $row)
			{
			$avg_user_score = $row->avg_user_score;
			$total_no_plays=$row->totalnumberofplays;
			}
		
			if($avg_user_score == "null")
			{
				$avg_user_score = 0;
			}
		
			
        }
		//insert the user score into database
		$inserintodatabase = array('correct_answers' => $correct_answers, 'attempted_questions' => $number_of_questions,'score'=>$score,'category'=>$category); 
		$this->db->insert("avgscore", $inserintodatabase);
		//set the average score scored by other users, user scoring percentage, total number of questions and total number of plays in response and send it back to Client
		$response = array('avg_user_score'=>$avg_user_score,'score'=>$your_score_percentage,'attempted_questions'=>$number_of_questions,'correct_answers'=>$correct_answers,'total_no_plays'=>$total_no_plays);
        $this->set_response($response, REST_Controller::HTTP_CREATED);
    }

/*
URL: /uploadfile
Type: POST
Description: Upload the file selected by Administrator
Parameter: imageToUpload
*/


	public function upload_file_post()
    {
		//Upload the browsed image to database
		//Generate a unique file name using the current date / time and encrypting it
		$tempfilename=md5(date('Y-m-d H:i:s:u'));
		//folder where all the images will be stored
		$targetDir = "web/images/uploads/".$tempfilename.$_FILES['imageToUpload']['name'];
		$status="false";
		$filename="";
		if(is_array($_FILES)) 
		{
			if(is_uploaded_file($_FILES['imageToUpload']['tmp_name'])) 
			{
				if(move_uploaded_file($_FILES['imageToUpload']['tmp_name'],$targetDir)) 
				{
				$status="true";
				$filename=$tempfilename.$_FILES['imageToUpload']['name'];
				}
			}
		}
		//when upload of file is complete/successful, send back the filename in response back to Client
		$response = array('status'=>$status,'filename'=>$filename);
        $this->set_response($response,  REST_Controller::HTTP_OK);
    }


/*
URL: /savequestion
Type: POST
Description: Edit / Save the question data to database. If quizid is available data is updated in database, if no quizid is available the data will be newly inserted into database
Parameter: question_data, question_option,question_option1_text,question_option2_text,question_option3_text,question_option4_text,selectcategory, image_name, quizid
*/

	public function save_question_post()
    {

		$request = json_decode(file_get_contents('php://input'));

		$question_data = $request->{'question_data'};
		$question_option =  $request->{'question_option'};
		$question_option1_text = $request->{'question_option1_text'};
		$question_option2_text = $request->{'question_option2_text'};
		$question_option3_text =$request->{'question_option3_text'};
		$question_option4_text = $request->{'question_option4_text'};
		$id = $request->{'quizid'};
		$selectcategory = $request->{'selectcategory'};
		$image_name = $request->{'image_name'};


		$data = array(
       'question_text' => $question_data,
       'correct_answer' => $question_option,
       'answer_option1' => $question_option1_text,
	    'answer_option2' => $question_option2_text,
		'answer_option3' => $question_option3_text,
		'answer_option4' => $question_option4_text,
		'category'=> $selectcategory,
		'image_location'=>$image_name);
		
		if($id != "0")
		{
		//update the question in database
		$result =$this->Model->update("q_data",$data,$id,"id");
		}
		else
		{
		//insert the question in database
		$result = $this->Model->insert("q_data",$data);
		}

		if($result)
		{
		$response = array('status'=>TRUE);
		}
		else
		{
		$response = array('status'=>FALSE);
		}
		
        $this->set_response($response,  REST_Controller::HTTP_OK);
    }

/*
URL: deletequestion/(:num)
Type: delete
Description: delete a row item from the database for the specified quiz id
Parameter: id- quiz id to be deleted
*/
    public function delete_question_delete()
    {
        $id = (int) $this->get('id');
		//delete the selected question from database for the input question id.
        $data=$this->Model->delete_row($id,"q_data");
       if ($data)
        {
			$this->set_response(['status' => $data,'error' => 'Record deleted'], REST_Controller::HTTP_OK);   
        }
        else
        {
            $this->set_response(['status' => FALSE,'error' => 'Record could not be found'], REST_Controller::HTTP_OK); 
        }
	}

}
