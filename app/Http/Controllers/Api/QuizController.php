<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Level;
use App\Models\QuizUserReport;
use App\Models\UserGameLevelStatus;
use Validator;
class QuizController extends Controller
{
    //
	public function level(request $request){
	$levels = Level::all();
		if (count($levels) == 0) {
			return response()->json([
				"success"=> "0",
				"status"=> "200",
				'message' => "No Level found",
				"data"=>array()
			], 200);
		}
		$user = $request->user();
		
		
		
		
		
		
		$data = array();
		 $flag = "";
		
		 $i=0;
		 foreach ($levels as $val) {
			 if($i==0){
			  $currentLevel = str_replace("Level","",$val->level_name);
			 }
			 
			
			 
				$stus ="locked";
				$wh = array("user_id"=>$user->id,"level_id"=>$val->id);
					$levelstatus = UserGameLevelStatus::where($wh)->get();
					$currno="1";
					if(count($levelstatus) > 0){
						
					 $stus = $levelstatus[0]->status;
						
						if($levelstatus[0]->status == "started")
						{
							$findlevel = Level::find($val->id + 1);
								if(!empty($findlevel)){
									$wh = array("user_id"=>$user->id,"level_id"=>$val->id + 1);
									$levelstatus1 = UserGameLevelStatus::where($wh)->get();
									if(count($levelstatus1) == 0){
										$inserdata['level_id']=$val->id + 1;
										$inserdata['user_id']=$user->id;
										$inserdata['game']="quiz";
										$inserdata['gems']="0";
										$inserdata['currentQuestion']="0";
										$inserdata['status']="locked";
										$createquery = UserGameLevelStatus::create($inserdata);
										$createquery->save();
									}
								}
							$currentLevel = str_replace("Level","",$val->level_name);
							
							$wherearr=array("user_id"=>$user->id,"level_id"=>$val->id);
							
							$res = QuizUserReport::select('quizid')->orderBy('quizid','DESC')->where($wherearr)->limit(1)->get();
							
							if(count($res) > 0){
							$currno = $res[0]->quizid;
							}else{
								$currno = 1;
							}
							
						} else if($levelstatus[0]->status == "completed"){
						
							$findlevel = Level::find($val->id + 1);
							
								if(!empty($findlevel)){
									$wh = array("user_id"=>$user->id,"level_id"=>$val->id + 1);
									$levelstatus1 = UserGameLevelStatus::where($wh)->get();
									
									if(count($levelstatus1) == 0){
										
									
										$inserdata['level_id']=$val->id + 1;
										$inserdata['user_id']=$user->id;
										$inserdata['game']="quiz";
										$inserdata['gems']="0";
										$inserdata['currentQuestion']="0";
										$inserdata['status']="started";
										$createquery = UserGameLevelStatus::create($inserdata);
										$createquery->save();
										$stus ="started";
									}
								}
							$currentLevel = str_replace("Level","",$val->level_name);
							
							$wherearr=array("user_id"=>$user->id,"level_id"=>$val->id);
							
							$res = QuizUserReport::select('quizid')->orderBy('quizid','DESC')->where($wherearr)->limit(1)->get();
							
							if(count($res) > 0){
							$currno = $res[0]->quizid;
							}else{
								$currno = 1;
							}
												
						}else{
							
							
							$wherearr=array("user_id"=>$user->id,"level_id"=>$val->id);
							
							$res = QuizUserReport::select('quizid')->orderBy('quizid','DESC')->where($wherearr)->limit(1)->get();
							
							if(count($res) > 0){
							$currno = $res[0]->quizid;
							}else{
								$currno = 1;
							}
						}
						
					}else{
						if($i == 0){
							$inserdata['level_id']=$val->id;
							$inserdata['user_id']=$user->id;
							$inserdata['game']="quiz";
							$inserdata['gems']="0";
							$inserdata['status']="started";
							
							$createquery = UserGameLevelStatus::create($inserdata);
							$createquery->save();
							$stus ="started";
						}
					}
					
			 if($stus == "locked"){
				 $icon = config('adminlte.imageurl')."/img/lock.png";
			 }else{
				  $icon = config('adminlte.imageurl')."/img/unlock.png";
			 }
				
			 $cq = $this->getCurrentQuestion($val->id,$user->id);
			 if(count($cq) == 0)
			 {
				 $ques=1;
			 }
			else{
				$ques=$cq[0]->currentQuestion + 1;
			}
			 /* if($val->no_of_question == $currno){
				 $cq = 1;
			 }else{
				  $cq = $currno+1;
			 } */
				 $result['level_id'] = (string)$val->id;
				 $result['level_name'] = (string)str_replace("Level","",$val->level_name);
				 $result['level_status'] = (string)$stus;
				 $result['current_que_no'] = (string)$ques;
				 $result['no_of_question'] = (string)$val->no_of_question;
				 $result['level_icon'] = (string)$icon;
			 
			 $data['levels'][] = $result;
			 $i++;
		 }
		$data['current_level']=(string)$currentLevel;
		 return response()->json([
			"success"=> "1",
			"status"=> "200",
			"message"=> "Level list got successfully",
			"data"=>$data],200);
		
	}
	public function quiz(request $request)
	{
		$quiz = Quiz::where('level_id',$request->level_id)->get();
		$levels = Level::find($request->level_id);
		
		if(empty($levels)){
			return response()->json([
				"success"=> "0",
				"status"=> "200",
				'message' => "No Level found",
				"data"=>array()
			], 200);
		}
		$quezno = $request->quizNo;
			
			$quizarr=  array();
			$i=1;
		foreach($quiz as $val)
		{
			$remain =$levels->no_of_question - $i;
			$data['questionNo']=(string)$i;
			$data['quizid']=(string)$val->id;
			$data['question']=(string)$val->question;
			$data['option1']=(string)$val->option1;
			$data['option2']=(string)$val->option2;
			$data['option3']=(string)$val->option3;
			$data['option4']=(string)$val->option4;
			$data['remainquestion']=(string)$remain;
			$data['correct_answer']=(string)$val->correct_answer;
			
			$quizarr[]= $data;
			$i++;
		}
		 return response()->json([
			"success"=> "1",
			"status"=> "200",
			"message"=> "Level list got successfully",
			"data"=>$quizarr],200);
	}
	public function quizReport(request $request)
	{
		
		$rules= [
        'level_id' => 'required',
        'score' => 'required',
        'quizid' => 'required',
		];
		
		 $validator = Validator::make($request->all(),$rules);  
       if ($validator->fails()) {
		 return response()->json([
			"success"=> "0",
			"status"=> "201",
            'message' => $validator->errors()
        ], 201);
        
		}else{
			$data = $request->all();
			$user = $request->user();
						
			$data['user_id'] = $user->id;
			$wherearr=array('level_id'=>$request->level_id,"quizid"=>$request->quizid);
				$res = QuizUserReport::where($wherearr)->count();
				
			if($res == 0)
			{	
			
			$QuizUserReport = QuizUserReport::create($data);
			
			$QuizUserReport->save();
			 return response()->json([
				"success"=> "1",
				"status"=> "200",
				"message"=> "record add successfully"
				],200);
			
			}else{
				 return response()->json([
				"success"=> "1",
				"status"=> "200",
				"message"=> "record add successfully"
				],200);
			}
		}
	}
	public function quizScore(request $request)
	{
		$rules= [
        'level_id' => 'required'
       
		];
		
		 $validator = Validator::make($request->all(),$rules);  
       if ($validator->fails()) {
		 return response()->json([
			"success"=> "0",
			"status"=> "201",
            'message' => $validator->errors()
        ], 201);
        }else{
			$level = $request->level_id;
			$user = $request->user();
				$wherearr=array('level_id'=>$request->level_id,"user_id"=>$user->id);
				$res = QuizUserReport::where($wherearr)->sum('score');
				$levels = Level::find($request->level_id);
				$data['score']=$res;
				$data['total']=$levels->no_of_question * $levels->plus_point_per_que;
				
				 return response()->json([
				"success"=> "1",
				"status"=> "200",
				"message"=> "get score",
				"data"=>$data
				],200);
		}
		
	}
	public function submitAnswer(request $request)
	{
		$rules= [
        'level_id' => 'required',
        'question_id' => 'required',
       
		];
		$totalNoOfQue = 15;
		 $validator = Validator::make($request->all(),$rules);  
       if ($validator->fails()) {
		 return response()->json([
			"success"=> "0",
			"status"=> "201",
            'message' => $validator->errors()
        ], 201);
        }else{
			$data = $request->all();
			$user = $request->user();
						
			$levels = Level::find($data['level_id']);
			
			if (empty($levels)) {
				return response()->json([
					"success"=> "0",
					"status"=> "200",
					'message' => "No Level found",
					'data'=>array()
				], 200);
			}
			
			$totalNoOfQue = (string)$levels->no_of_question;
			
			if($totalNoOfQue < $data['question_id'])
			{
				return response()->json([
					"success"=> "0",
					"status"=> "200",
					'message' => "Please pass proper question number",
					'data'=>array()
				], 200);
			}
			
			
			$levelName = (string)str_replace("Level","",$levels->level_name);;
			
		if($data['user_answer'] == ""){
			$data['user_answer'] = 0;
		}
			//for score
				$score =0;
			if($data['user_answer'] == $data['correct_answer']){
				$score =1;
			}	
				
			$wherearr=array('level_id'=>$request->level_id,"user_id"=>$user->id,"quizid"=>$request->question_id);
			$res = QuizUserReport::where($wherearr)->get();
			
				
			
			if(count($res) == 0)
			{	
		
			$inserdata['level_id']=$data['level_id'];
			$inserdata['quizid']=$data['question_id'];
			$inserdata['useranswer']=$data['user_answer'];
			$inserdata['user_id']=$user->id;
			$inserdata['score']=$score;
			
			
			$QuizUserReport = QuizUserReport::create($inserdata);
			
			$QuizUserReport->save();
			
			
				$gamedatas['currentQuestion']=$data['question_id'];
				$whrs = array("level_id"=>$data['level_id'],"user_id"=>$user->id);
				
			UserGameLevelStatus::where($whrs)->update($gamedatas);
			
			$correct_answer = $this->getscore($data['level_id'],$user->id);
			
			$status = "started";
			
			
			if($totalNoOfQue == $data['question_id'])
			{
				
				
				$status = "completed";
				$gamedata['status']="completed";
				$gamedata['currentQuestion']="0";
				$whr = array("level_id"=>$data['level_id'],"user_id"=>$user->id);
				UserGameLevelStatus::where($whr)->update($gamedata);
				
				$gamedata1['status']="started";
				$whr = array("level_id"=>$data['level_id'] + 1,"user_id"=>$user->id);
				UserGameLevelStatus::where($whr)->update($gamedata1);
				
				
				
			}
			
			$resdata['level_id']=(string)$data['level_id'];
			$resdata['level_name']=(string)$levelName;
			$resdata['level_status']=(string)$status;
			$resdata['total_que_count']=(string)$totalNoOfQue;
			$resdata['correct_que_count']=(string)$correct_answer;
			
			
			
			 return response()->json([
				"success"=> "1",
				"status"=> "200",
				"message"=> "record add successfully",
				"data"=>$resdata
				],200);
			
			}else{
				
			$inserdata['level_id']=$data['level_id'];
			$inserdata['quizid']=$data['question_id'];
			$inserdata['useranswer']=$data['user_answer'];
			$inserdata['user_id']=$user->id;
			$inserdata['score']=$score;
			//$inserdata['status']=$status;
			$whr = array("id"=>$res[0]->id);
			$quesans = QuizUserReport::where($whr)->update($inserdata);
				$gamedatas['currentQuestion']=$data['question_id'];
				$whrs = array("level_id"=>$data['level_id'],"user_id"=>$user->id);
				
			UserGameLevelStatus::where($whrs)->update($gamedatas);
			$correct_answer = $this->getscore($data['level_id'],$user->id);
			
			$status = "started";
			
			
			if($totalNoOfQue == $data['question_id'])
			{
				
				
				$status = "completed";
				$updata['status']="completed";
				$updata['currentQuestion']="0";
				$whr = array("level_id"=>$data['level_id'],"user_id"=>$user->id);
				UserGameLevelStatus::where($whr)->update($updata);
				
				$updata1['status']="started";
				$whr = array("level_id"=>$data['level_id'] + 1,"user_id"=>$user->id);
				UserGameLevelStatus::where($whr)->update($updata1);
				
				
				
			}
			
			$resdata['level_id']=(string)$data['level_id'];
			$resdata['level_name']=(string)$levelName;
			$resdata['level_status']=(string)$status;
			$resdata['total_que_count']=(string)$totalNoOfQue;
			$resdata['correct_que_count']=(string)$correct_answer;
			 return response()->json([
				"success"=> "1",
				"status"=> "200",
				"message"=> "record add successfully",
				"data"=>$resdata
				],200);
			}
		}
		
		
		
		
	}
	function getScore($level_id,$user_id)
	{
			
		$wherearr=array('level_id'=>$level_id,"user_id"=>$user_id,'score'=>1);
		$res = QuizUserReport::where($wherearr)->count('score');
		return $res;
	}
	function getCurrentQuestion($levelid,$userid)
	{
		$wherearr=array('level_id'=>$levelid,"user_id"=>$userid);
		return UserGameLevelStatus::select('currentQuestion')->where($wherearr)->get();
	}
}
