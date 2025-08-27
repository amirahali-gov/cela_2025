<?php

namespace App\Http\Controllers;

use DB;

use App\Models\Login;
use App\Models\Score;
use App\Models\Upload;
use App\Models\Comment;
use App\Models\Application;
use App\Models\Dependent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;


class CommitteeController extends Controller
{

    public function index(Request $request){
        if (!Auth::check()) return view('login');
        return redirect(route('committee.dashboard'));
    }

    public function login(Request $request){
        $data = $request->all();
        $username = trim($data['username']);
        $password = trim($data['password']);

        $user = Login::where('LGN_Username','=', $username)->first();
        
        if ($user && password_verify($password, $user->LGN_Password)) {
            Auth::login($user);
            return redirect(route('committee.dashboard'));
        } 
        else {
            $request->session()->flash('error', 'Invalid username or password');
            return view('login');
        }
        
    }

    public function dashboard(Request $request){
        $user = Auth::user();
        $applications = Application::where('APL_Cycle', '=', 3)
            ->orderBy('APL_ID', 'desc')
            ->paginate(20);
        
        return view('committee-dashboard', ['user' => $user, 'applications' => $applications]);
    }
    
    public function score(Request $request){
        $user = Auth::user();
        $data = $request->all();

        $applicant = Application::where('APL_ID','=', $data['id'])->get()->first();
        if($user->LGN_Role === 0){
            $currentScore = Score::where('APL_ID','=', $data['id'])->where('LGN_ID','=', $user->LGN_ID)->get();
        }else{
            $currentScore = Score::where('APL_ID','=', $data['id'])->where('LGN_ID','=', $data['userID'])->get();
        }

        if($currentScore->isEmpty()){
            $newScore = new Score();
            $newScore->APL_ID = $applicant->APL_ID;
            $newScore->LGN_ID = $user->LGN_ID;
            $newScore->SCR_Score = trim($data['score_interest']);
            $newScore->SCR_Score_2 = trim($data['score_social']);
            $newScore->SCR_Score_3 = trim($data['score_education']);
            $newScore->SCR_Score_4 = trim($data['score_attributes']);
            $newScore->save();
        }else{
            if($user->LGN_Role === 0){
                Score::where('APL_ID','=', $data['id'])->where('LGN_ID','=', $user->LGN_ID)
                    ->update(['SCR_Score' => trim($data['score_interest']), 'SCR_Score_2' => trim($data['score_social']), 'SCR_Score_3' => trim($data['score_education']), 'SCR_Score_4' => trim($data['score_attributes'])]);
            }else{
                Score::where('APL_ID','=', $data['id'])->where('LGN_ID','=', $data['userID'])
                    ->update(['SCR_Score' => trim($data['score_interest']), 'SCR_Score_2' => trim($data['score_social']), 'SCR_Score_3' => trim($data['score_education']), 'SCR_Score_4' => trim($data['score_attributes'])]);
            }
        }

        $numScores = Score::where('APL_ID','=', $data['id'])->get()->count();

        if ($numScores === 2) {
            Application::where('APL_ID','=', $data['id'])
                        ->update(['APL_Scored' => 'Y']);
        }
        return redirect()->route('profile', ['id' => $data['id']]);
    }

    public function comment(Request $request){
        $user = Auth::user();
        $data = $request->all();

        $newComment = Comment::where('APL_ID','=', $data['id'])->where('LGN_ID','=',$user->LGN_ID)->get();

        if($newComment->isEmpty()){
            $newComment1 = new Comment();
            $newComment1->APL_ID = $data['id'];
            $newComment1->LGN_ID = $user->LGN_ID;
            $newComment1->Com_Comment = $data['comment'];
            $newComment1->save();
        }else{
            Comment::where('APL_ID','=', $data['id'])->where('LGN_ID','=',$user->LGN_ID)->update(['Com_Comment'=> $data['comment']]);
        }


        return redirect()->route('profile', ['id' => $data['id']]);
    }

    public function profile(Request $request, $id){
        $user = Auth::user();

        try{

            $applicant = Application::where('APL_ID', $id)->first();

            if($applicant === null){
                return view('index',['user' => $user]);
            }else{
                $dependents = Dependent::join('age_groups', "DPT_Value", "=", "AGE_Code" )
                                        ->where('APL_ID','=', $applicant->APL_ID)
                                        ->get();

                $uploads = Upload::where('UPD_APL_ID','=',$applicant->APL_ID)->get();

                $score = Score::where('APL_ID','=',$applicant->APL_ID)->where('LGN_ID','=', $user->LGN_ID)->get();

                $userComment = Comment::join('logins','comments.LGN_ID','=','logins.LGN_ID')->where('APL_ID','=',$applicant->APL_ID)->where('comments.LGN_ID','=', $user->LGN_ID)->first();
                $comment = Comment::join('logins','comments.LGN_ID','=','logins.LGN_ID')->where('APL_ID','=',$applicant->APL_ID)->get(['logins.LGN_Name', 'COM_Comment', 'comments.created_at']);

                $calculateScores = Score::join('logins','scores.LGN_ID','=','logins.LGN_ID')->where('APL_ID','=',$applicant->APL_ID)->get();

                //$allScores = Scores::where('APL_ID','=',$applicant->APL_ID)->get();
                $counter = 0;
                $totalMean = 0;
                $mean = 0;

                $chairman = 0;
                if($user->LGN_Role === 1){
                    $chairman = 1;
                }

                if(!$calculateScores->isEmpty()){
                    foreach($calculateScores as $as){
                        $counter++;

                        $mean = $mean + ($as->SCR_Score * 10);
                        $mean = $mean + ($as->SCR_Score_2 * 10);
                        $mean = $mean + ($as->SCR_Score_3 * 5);
                        $mean = $mean + ($as->SCR_Score_4 * 5);
                    }

                    $totalMean = round($mean/$counter);
                }


                $score = $score->first();



                return view('profile',['error' => null, 'applicant' => $applicant, 'dependents' => $dependents, 'score' => $score, 'comment' => $comment, 'totalMean' => $totalMean, 'user' => $user, "uploads" => $uploads, 'chairman' => $chairman, 'count' => count($calculateScores), 'calculateScores' => $calculateScores, 'userComment' => $userComment]);
            }

        }
        catch (\Exception $e) {
            Log::channel('applicant')->info('Error: '.$e);
            return response()->json(['success' => false, 'error' => $e],500);
        }
    }


    public function allApplications(Request $request) {
        $user = Auth::user();

        $applications = Application::where('APL_Cycle', 3)
            ->orderBy('APL_ID', 'desc')
            ->paginate(20);
        $title = "Master List";
        return view('components.data-table', compact('applications', 'user', 'title'));
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('committee.login');
    }
}
