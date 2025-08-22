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
        // Check if user is authenticated
        if (!auth()->check()) {
            return view('login');
        }

        $user = auth()->user();
        return view('index', ['user' => $user]);

    }

    public function login(Request $request){
        $data = $request->all();

        $username = trim($data['username']);
        $password = trim($data['password']);

        //May hash

        $user = Login::where('LGN_Username','=', $username)->where('LGN_Password','=',$password)->get();

        if($user->isEmpty()){
            return response()->json(['success'=> false, 'message' => 'Incorrect Username or Password']);
        }else{
            $user = $user->first();
            // session(['NAME' => $username]);
            // session(['PASSWORD' => $password]);
            Auth::login($user);
            
            return redirect(route('committee.dashboard'));
        }
    }

    public function dashboard(Request $request){
        $user = Auth::user();
        $applications = Application::orderBy('APL_Cycle', 'desc')
            ->orderBy('APL_ID', 'desc')
            ->paginate(20);
        
        return view('committee-dashboard', ['user' => $user, 'applications' => $applications]);
    }
    

    public function getUserID(Request $request){
        $data = $request->all();

        $applicant = Application::/* where('APL_ShortList','=','Y')-> */where('APL_ID','=', $data['searchValue'])->get();

        if($applicant->isEmpty()){
            return response()->json(['success'=> false, 'message' => 'Applicant does not exist']);
        }else{
            $applicant = $applicant->first();

            // $ts = '<table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
            //         <tr>
            //             <th>ID</th>
            //             <th>First Name</th>
            //             <th>Middle Name</th>
            //             <th>Last Name</th>
            //         </tr><tr class = "cursor" onClick = getProfile('.$applicant->APL_ID.')><td>'.$applicant->APL_ID.'</td><td>'.$applicant->APL_FName.'</td><td>'.$applicant->APL_MName.'</td><td>'.$applicant->APL_LName.'</td></tr></table>';

            $ts = '<table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
                        <tr>
                            <th>ID</th>
                            <th>Nominee Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>City/Town</th>
                        </tr>
                        <tbody id = "resultBody">
                            <tr class = "cursor" onClick = getProfile('.$applicant->APL_ID.') ><td>'.$applicant->APL_ID.'</td> <td>'.$applicant->APL_FName.' '.$applicant->APL_Mname.' '.$applicant->APL_LName.'</td><td>'.$applicant->APL_PPhone.' <br> '.$applicant->APL_APhone.'</td><td>'.$applicant->APL_Email.'</td><td>'.$applicant->APL_Address_3.'</td></tr>
                        </tbody>
                    </table>';
            return response()->json(['success'=> true, 'data' => $ts, 'count' => "1"]);
        }
    }

    public function paginate(){
        $applicant = Application::paginate(5);

        return view('paginate_data',['data' => $applicant]);
    }

    public function getUserName(Request $request){
        $data = $request->all();

        $searchValue = $data['searchValue'];

        $applicant = Application::/* where('APL_ShortList','=','Y')-> */where(function($query) use ($searchValue){
            $query->where('APL_FName','Like', '%'.$searchValue.'%')
                ->orWhere('APL_Mname','Like', '%'.$searchValue.'%')
                ->orWhere('APL_LName','Like', '%'.$searchValue.'%')
                ->where('APL_Dup','=','N');
        })->get();

        if($applicant->isEmpty()){
            return response()->json(['success'=> false, 'message' => 'Applicant does not exist']);
        }else{

            $ts = '
            <div class="col-md-12">
                <div class="position-relative form-group">
                    <label for="FName" class="card-title">Valid Applications</label>
                </div>
            </div>
            ';
            $ts .= '<table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
                    <tr>
                        <th>ID</th>
                        <th>Nominee Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>City/Town</th>
                    </tr><tbody id = "resultBody">';
            foreach($applicant as $ap){
                $ts .= '<tr class = "cursor" onClick = getProfile('.$ap->APL_ID.') ><td>'.$ap->APL_ID.'</td> <td>'.$ap->APL_FName.' '.$ap->APL_Mname.' '.$ap->APL_LName.'</td><td>'.$ap->APL_PPhone.' <br> '.$ap->APL_APhone.'</td><td>'.$ap->APL_Email.'</td><td>'.$ap->APL_Address_3.'</td></tr>';
            }
            $ts .= '</tbody></table>';

            $count = count($applicant);
            return response()->json(['success'=> true, 'data' => $ts, 'count' => $count, 'applicants' => $applicant]);
        }
    }

    public function score(Request $request){
        $request->session()->regenerate();

        $data = $request->all();

        $username = session('NAME');
        $password = session('PASSWORD');

        $user = Login::where('LGN_Username','=', $username)->where('LGN_Password','=',$password)->get();



        if($user->isEmpty()){
            return view('login');
        }

        $user = $user->first();

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
            $newScore->SCR_Score = trim($data['score']);
            $newScore->SCR_Score_2 = trim($data['score2']);
            $newScore->SCR_Score_3 = trim($data['score3']);
            $newScore->SCR_Score_4 = trim($data['score4']);
            $newScore->save();
        }else{
            if($user->LGN_Role === 0){
                Score::where('APL_ID','=', $data['id'])->where('LGN_ID','=', $user->LGN_ID)
                    ->update(['SCR_Score' => trim($data['score']), 'SCR_Score_2' => trim($data['score2']), 'SCR_Score_3' => trim($data['score3']), 'SCR_Score_4' => trim($data['score4'])]);
            }else{
                Score::where('APL_ID','=', $data['id'])->where('LGN_ID','=', $data['userID'])
                    ->update(['SCR_Score' => trim($data['score']), 'SCR_Score_2' => trim($data['score2']), 'SCR_Score_3' => trim($data['score3']), 'SCR_Score_4' => trim($data['score4'])]);
            }
        }

        $numScores = Score::where('APL_ID','=', $data['id'])->get()->count();

        if ($numScores === 2) {
            Application::where('APL_ID','=', $data['id'])
                        ->update(['APL_Scored' => 'Y']);
        }
        return response()->json(['success'=> true]);
    }

    public function comment(Request $request){
        $request->session()->regenerate();

        $data = $request->all();

        $username = session('NAME');
        $password = session('PASSWORD');

        $user = Login::where('LGN_Username','=', $username)->where('LGN_Password','=',$password)->get();

        if($user->isEmpty()){
            return view('login');
        }

        $user = $user->first();

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


        return response()->json(['success'=> true]);
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

    public function profile2(Request $request, $id){
        $request->session()->regenerate();
        try {
            $username = session('NAME');
            $password = session('PASSWORD');
            if($id != 453){
                return view('login');
            }
            $user = Login::where('LGN_Username','=', $username)->where('LGN_Password','=',$password)->get();

            if($user->isEmpty()){
                return view('login');
            }

            $user = $user->first();

            $applicant = Application::join('areas','APL_Area','=','areas.Board')
                                        // ->join('economics','APL_Economic','=','economics.Econ_Code')
                                        // ->join('employs','APL_Employ','=','employs.Employ_Code')
                                        // ->join('hloes','APL_HLOE','=', 'hloes.Hloe_Code')
                                        // ->join('housings','APL_Housing','=', 'housings.HOU_Code')
                                        // ->join('livings','APL_Living','=','livings.LIV_Code')
                                        // ->join('maritals','APL_Marital','=','maritals.MAR_Code')
                                        // ->join('programmes','APL_Programme','=','programmes.PRO_Code')
                                        /* ->where('APL_ShortList','=','Y') */
                                        ->where('APL_ID','=', $id)
                                        ->get();


            if($applicant->isEmpty()){
                return view('profile',['error' => 'There was an error processing your request', 'applicant' => null]);
            }else{
                $applicant = $applicant->first();

                $uploads = Upload::where('UPD_APL_ID','=',$applicant->APL_ID)->get();

                return view('profile2',['error' => null, 'applicant' => $applicant, 'user' => $user]);
            }
        }
        catch (\Exception $e) {
            Log::channel('applicant')->info('Error: '.$e);
            return response()->json(['success' => false, 'errorCode' => 'a1'],500);
        }
    }

    public function getFile($id){

        $upload = Upload::where('UPD_ID','=',$id)->get()->first();

        /* $pos = strrpos($upload->UPD_DocName,".");
        $newTest = substr($upload->UPD_DocName,$pos);

        if(substr_count($newTest,'-') === 1){
            $pos2 = strrpos($upload->UPD_DocName,"-");
            $uploadName = substr($upload->UPD_DocName,'0', $pos2);
        }else{
            $uploadName = $upload->UPD_DocName;
        } */

		return Storage::disk('local')->download($upload->UPD_FilePath,$upload->UPD_DocName);
    }


    public function next($id){
        $applicant = Application::where('APL_ID','>',$id)->orderBy('APL_ID','asc')->get()->first();

        if($applicant === null){
            $applicant = Application::orderBy('APL_ID','asc')->get()->first();
        }

        return redirect()->route('profile', ['id' => $applicant->APL_ID]);
    }

    public function previous($id){
        $applicant = Application::where('APL_ID','<',$id)->orderBy('APL_ID','desc')->get()->first();

        if($applicant === null){
            $applicant = Application::orderBy('APL_ID','desc')->get()->first();
        }

        return redirect()->route('profile', ['id' => $applicant->APL_ID]);
    }

    public function duplicate(Request $request){
        $request = $request->all();
        $applicant = Application::where('APL_ID','=',$request['applicantID'])->get()->first();


        if ($applicant === null) {
            Log::channel('applicant')->info('Error for applicant(email: '.$request['applicantID'].'): Application not found.');
        }

        Application::where('APL_ID', '=', $request['applicantID'])
                    ->update(['APL_Dup' => $request['duplicateOptions'], 'APL_DupUser' => $request['user']]);
        $applicant = Application::where('APL_ID','=',$request['applicantID'])->get()->first();

        return redirect()->route('profile', ['id' => $applicant->APL_ID]);
    }

    public function viewDuplicates(Request $request){
        $request->session()->regenerate();

        $username = session('NAME');
        $password = session('PASSWORD');

        $user = Login::where('LGN_Username','=', $username)->where('LGN_Password','=',$password)->get();

        if($user->isEmpty()){
            return view('login');
        }

        $user = $user->first();

        try{
            $collect = Application::where('APL_Dup','=','Y')
                                        ->get();
            $applications = $collect->sortBy(['APL_LName', 'asc']);

            $title = "Duplicate Applications";
            return view('data-table', compact('applications', 'user', 'title'));
            // return ($duplicates);
        }
        catch (\Exception $e) {
            Log::channel('applicant')->info('Error: '.$e);
            return response()->json(['success' => false, 'errorCode' => 'a1'],500);
        }
    }

    public function allApplications(Request $request) {
        $user = Auth::user();

        $applications = Application::orderBy('APL_Cycle', 'desc')
            ->orderBy('APL_ID', 'desc')
            ->paginate(20);
        $title = "Master List";
        return view('components.data-table', compact('applications', 'user', 'title'));
    }

    public function scoredApplications(Request $request) {
        $request->session()->regenerate();

        $username = session('NAME');
        $password = session('PASSWORD');

        $user = Login::where('LGN_Username','=', $username)->where('LGN_Password','=',$password)->get();

        if($user->isEmpty()){
            return view('login');
        }

        $user = $user->first();

        $applications = Application::where('APL_Scored','=','Y')
                                    ->where('APL_Dup','=','N')
                                    ->paginate(20);
        $title = "Scored Applications";
        return view('data-table', compact('applications', 'user', 'title'));
    }

    public function unscoredApplications (Request $request){
        $request->session()->regenerate();

        $username = session('NAME');
        $password = session('PASSWORD');

        $user = Login::where('LGN_Username','=', $username)->where('LGN_Password','=',$password)->get();

        if($user->isEmpty()){
            return view('login');
        }

        $user = $user->first();

        $applications = Application::where('APL_Scored','=','N')
                                    ->where('APL_Dup','=','N')
                                    ->paginate(20);
        $title = "Unscored Applications";
        return view('data-table', compact('applications', 'user', 'title'));
    }

    public function assignedApplications(Request $request) {
        $request->session()->regenerate();

        $username = session('NAME');
        $password = session('PASSWORD');

        $user = Login::where('LGN_Username','=', $username)->where('LGN_Password','=',$password)->get();

        if($user->isEmpty()){
            return view('login');
        }

        $user = $user->first();

        $applications = Application::paginate(20);
        $title = "Assigned Applications";
        return view('data-table', compact('applications', 'user', 'title'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('committee.index');
    }
}
