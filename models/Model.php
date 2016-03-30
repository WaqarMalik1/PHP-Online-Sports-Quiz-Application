<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
This class Model is designed to work with information in database. It contains all functions to insert, update, delete and retrieve the data from database
*/
class Model extends CI_Model{

//Fetch data from database
	public function fetch($query){
        $resultset = $this->db->query($query);
        return $resultset->result_array();
    }

//insert data into database and return true/false if insert is successful/unsuccessful
    public function insert($tablename, $data){
        $this->db->insert($tablename, $data);
		$result = $this->db->affected_rows();
        if ($result>0)
		   $result=TRUE;
	    else
		   $result=FALSE;
	    return $result;
    }
//delete a row from database and return whether the delete is successful or not
    public function delete_row($id,$tablename){
	   $this->db->where('id', $id);	 
	   $this->db->delete($tablename);
	   $result = $this->db->affected_rows();
	   if ($result>0)
		   $result=TRUE;
	   else
		   $result=FALSE;
	   return $result;
        }

//update the information in database
	public function update($tablename,$data,$id,$colname){
		$this->db->where("id", $id);
		$this->db->update($tablename, $data);
        $result = $this->db->affected_rows();
	   if ($result>0)
		   $result=TRUE;
	   else
		   $result=FALSE;
	   return $result;
     
    }
//fetch the question data from database
		public function fetch_resultset_data($query){
        $resultset = $this->db->query($query);
        return $resultset->result();
    }
}