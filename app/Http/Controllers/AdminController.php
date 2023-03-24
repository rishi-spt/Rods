<?php

namespace App\Http\Controllers;
use Twilio\Rest\Client; 
use Illuminate\Http\Request;
use App\Models\ClientDetails;
use App\Models\Joblist;

class AdminController extends Controller
{
    function applyJob() {
        $page_data['page_name'] = 'applyJob';
        $page_data['page_title'] = 'Apply Job';
       

        return view('applyJob', $page_data);
    
    }
    
    function submitClientData(Request $data) {

        $clientData = new ClientDetails();

        $firstName            = $data->input('firstName');
        $lastName                     = $data->input('lastName');
        $contactNumber                = $data->input('contactNumber');
        $email                = $data->input('email');
        $addressLineOne                = $data->input('addressLineOne');
        $addressLineTwo                = $data->input('addressLineTwo');
        $skills             = $data->input('skills');
        $jobtitle             = $data->input('jobtitle');
      

        $clientData->firstName = $firstName;
        $clientData->lastName = $lastName;
        $clientData->contactNumber = $contactNumber;
        $clientData->email = $email;
        $clientData->addressLineOne = $addressLineOne;
        $clientData->addressLineTwo = $addressLineTwo;
        $clientData->skills = $skills;
        $clientData->jobtitle = $jobtitle;

        $check = ClientDetails::where(array('firstName' => $firstName, 'lastName' => $lastName))->get()->count();
        $check_mail = ClientDetails::where(array('email' => $email))->get()->count();
       
        if($check > 0 || $check_mail > 0){
        $returnArray['status'] = false;
            $returnArray['msg_type'] = 'error';
            $returnArray['message'] = 'User Already registered';
            echo json_encode($returnArray);exit();
       }
$skill_matched = false;
       $check1 = Joblist::select('Job_Skills')->get();
       foreach($check1 as $key => $value)
{
	   $jobSkills = explode(',',$value);
        $clientSkills = explode(',', $skills);
      $matched =  array_intersect($clientSkills, $jobSkills);
     $match_jobtitile = Joblist::where('Job_Title', 'like', '%'.$jobtitle.'%')->get()->count();
    // dd($match_jobtitile);
    if(!$matched || $match_jobtitile > 0) {
        $skill_matched =true;
    }
}
      
       $result = $clientData->save();
        if($skill_matched) {
           
 
$sid    = "SID HERE"; 
$token  = "TOKEN HERE"; 
$twilio = new Client($sid, $token); 
 $msg_body = "We have found a job that matches the skills (".$skills.") of ".$firstName.". If you're interested, please reply 'YES' and we will send you more details. Thank you!";

 $message = $twilio->messages 
                  ->create("+13068800834", // to 
                  
                           array(        
                            "from" => '+15674303469',
                               "body" => $msg_body 
                           ) 
                  ); 
 


            $returnArray['status'] = true;
            $returnArray['msg_type'] = 'success';
            $returnArray['message'] = 'Details submited';
            echo json_encode($returnArray);exit();
        }
        else
        {
            $returnArray['status'] = true;
            $returnArray['msg_type'] = 'success';
            $returnArray['message'] = 'Details submited';
            echo json_encode($returnArray);exit();
        }


    }

}
