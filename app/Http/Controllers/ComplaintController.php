<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Complaints;

class ComplaintsController extends Controller
{
    public function index($tenantid)
    {
         $complaints = DB::table('complaints')
        ->select('complaints.*','residents.surname','residents.othername','residents.phone','residents.email')
        ->leftJoin('residents', 'residents.id', '=', 'complaints.residentid')
        ->where("complaints.tenant", "=", $tenantid)
        ->where(function($query) use ($tenantid){
            $query->where("complaintstatus", "Pending")
                ->orWhere("complaintstatus", "Active");
        })
        ->orderBy('complaints.id', 'desc')
        ->get();
        return $complaints;
    }
    public function complaintresident($tenantid,$resident)
    {
         $complaints = DB::table('complaints')
        ->select('complaints.*')
        ->where("complaints.tenant", "=", $tenantid)
        ->where("complaints.residentid", "=", $resident)
        ->where(function($query) use ($tenantid){
            $query->where("complaintstatus", "Pending")
                ->orWhere("complaintstatus", "Active");
        })
        ->orderBy('complaints.id', 'desc')
        ->get();
        return $complaints;
    }

public function indexmultiple($tenantid,$feild,$search)
    {
         $complaints = DB::table('complaints')
        ->select('complaints.*')
        ->where(function($query) use ($tenantid){
            $query->where("complaints.tenant", $tenantid)
                ->orWhere("complaints.tenant", "0");
        })
        ->where("complaints.".$feild, "=", $search)
        ->orderBy('complaints.id', 'desc')
        ->get();
        return $complaints;
    }
public function indexmultiple2($tenantid,$feild,$search,$feild2,$search2)
    {
         $complaints = DB::table('complaints')
        ->select('complaints.*')
        ->where(function($query) use ($tenantid){
            $query->where("complaints.tenant", $tenantid)
                ->orWhere("complaints.tenant", "0");
        })
        ->where("complaints.".$feild, "=", $search)
        ->where("complaints.".$feild2, "=", $search2)
        ->orderBy('complaints.id', 'desc')
        ->get();
        return $complaints;
    }


    public function search($tenantid,$search)
    {
        $results = DB::select(
            DB::raw("SELECT * FROM complaints WHERE (tenant = '$tenantid' OR tenant = '0') AND
            (surname LIKE '%$search%' OR jobcategory LIKE '%$search%' OR priority LIKE '%$search%') ORDER BY id DESC"),
        );
        return $results;
    }

    public function searchsub($tenantid,$feild,$feildvalue,$search)
    {
        $results = DB::select(
            DB::raw("SELECT * FROM complaints WHERE (tenant = '$tenantid' OR tenant = '0') AND `$feild` = '$feildvalue'
             AND (surname LIKE '%$search%' OR jobcategory LIKE '%$search%' OR priority LIKE '%$search%') ORDER BY id DESC"),
        );
        return $results;
    }

    public function indexone($tenantid,$id)
    {
        $complaints = DB::table('complaints')
            ->select('complaints.*')
            ->where('complaints.id', '=', $id)
            ->get();
        return $complaints;
    }

    public function requestresident($tenantid,$id)
    {
        $complaints = DB::table('complaints')
        ->select('complaints.*','residents.surname','residents.othername','residents.phone','residents.email')
        ->leftJoin('residents', 'residents.id', '=', 'complaints.residentid')
        ->where('complaints.id', '=', $id)
        ->orderBy('complaints.id', 'desc')
        ->get();
        return $complaints;
    }

    public function store(Request $request)
    {
        $id = uniqid('', true);
        $request->request->add(['idsession' => $id]);
        $complaints = Complaints::create($request->all());
        $getcode = DB::table('complaints')->select('id')->where("idsession", "=", $id)->get();
        $autoid = str_pad($getcode[0]->id, 5, '0', STR_PAD_LEFT);
        $codeupdate = Complaints::where('idsession', $id)->update(array('ticketno' => $autoid));
        return response()->json($complaints, 201);
    }
    
    public function storeresponse(Request $request){
        $requestid = $request->requestid;
        $results = DB::select(
            DB::raw("UPDATE complaints SET complaintstatus = 'Active' WHERE complaintstatus = 'Pending' AND id = '$requestid'"),
        );
        $idsession = uniqid('', true);
        $tenantuser = DB::insert('INSERT INTO complaints_feedback (idsession,feedbacknote,feedbackdate,requestid,`residentid`,tenant,user) 
        VALUES (:idsession,:feedbacknote,:feedbackdate,:requestid,:residentid,:tenant,:user)',
        array(
            'idsession' => $idsession,
            'feedbacknote' => $request->feedbacknote,
            'feedbackdate' => $request->feedbackdate,
            'requestid' => $request->requestid,
            'residentid' => $request->residentid,
            'tenant' => $request->tenant,
            'user' => $request->user,
            )
        );
        
        return response()->json($idsession, 201);
    }
    
    public function storeresponselist($tenantid,$requestid)
    {
        $results = DB::select(
            DB::raw("SELECT complaints_feedback.*, usermanagements.userfullname FROM complaints_feedback,usermanagements WHERE complaints_feedback.user = usermanagements.id AND requestid = '$requestid' ORDER BY id DESC"),
        );
        return $results;
    }
    
    public function requestclose($tenantid,$requestid)
    {
        $results = DB::select(
            DB::raw("UPDATE complaints SET complaintstatus = 'Closed' WHERE id = '$requestid'"),
        );
        return $results;
    }
    public function requestcancel($tenantid,$requestid)
    {
        $results = DB::select(
            DB::raw("UPDATE complaints SET complaintstatus = 'Cancel' WHERE id = '$requestid'"),
        );
        return $results;
    }
    public function storeUpload(Request $request)
    {
        $idsession = $request->idsession;
        $file = $request->file;
        $codeupdate = Complaints::where('idsession', $idsession)
        ->update(array('attachdoc' => $file));
        return response()->json($codeupdate, 201);
    }
    public function update(Request $request, $id)
    {
        $complaints = Complaints::findOrFail($id);
        $complaints->update($request->all());

        return response()->json($complaints, 200);
    }

    public function delete(Request $request, $id)
    {
        $complaints = Complaints::findOrFail($id);
        $complaints->delete();

        return response()->json(null, 204);
    }

}