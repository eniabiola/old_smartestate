<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Message;

class MessageController extends Controller
{
    public function messagerecipient($tenantid,$messageid)
    {
         $message = DB::table('message_recipeient')
        ->select('message_recipeient.*','residents.*')
        ->leftJoin('residents', 'residents.id', '=', 'message_recipeient.recipeintid')
        ->where("message_recipeient.tenant", "=", $tenantid)
        ->where("message_recipeient.messageid", "=", $messageid)
        ->orderBy('message_recipeient.id', 'desc')
        ->get();
        return $message;
    }
    
    public function index($tenantid)
    {
         $message = DB::table('messages')
        ->select('messages.*','messagetemplates.templatetitle AS templatetitle','messagetemplates.id AS templatetitleid','rents.tenantname AS tenantname','rents.id AS tenantnameid')
        ->leftJoin('messagetemplates', 'messages.templatetitle', '=', 'messagetemplates.id')
        ->leftJoin('rents', 'messages.tenantname', '=', 'rents.id')
        ->where("messages.tenant", "=", $tenantid)
        ->orWhere("messages.tenant", "=", "0")
        ->orderBy('messages.id', 'desc')
        ->get();
        return $message;
    }

    public function indexmultiple($tenantid,$feild,$search)
    {
         $message = DB::table('messages')
        ->select('messages.*','messagetemplates.templatetitle AS templatetitle','messagetemplates.id AS templatetitleid','rents.tenantname AS tenantname','rents.id AS tenantnameid')
        ->leftJoin('messagetemplates', 'messages.templatetitle', '=', 'messagetemplates.id')
        ->leftJoin('rents', 'messages.tenantname', '=', 'rents.id')
        ->where(function($query) use ($tenantid){
            $query->where("messages.tenant", $tenantid)
                ->orWhere("messages.tenant", "0");
        })
        ->where("messages.".$feild, "=", $search)
        ->orderBy('messages.id', 'desc')
        ->get();
        return $message;
    }
    
    public function indexmultiple2($tenantid,$feild,$search,$feild2,$search2)
    {
         $message = DB::table('messages')
        ->select('messages.*','messagetemplates.templatetitle AS templatetitle','messagetemplates.id AS templatetitleid','rents.tenantname AS tenantname','rents.id AS tenantnameid')
        ->leftJoin('messagetemplates', 'messages.templatetitle', '=', 'messagetemplates.id')
        ->leftJoin('rents', 'messages.tenantname', '=', 'rents.id')
        ->where(function($query) use ($tenantid){
            $query->where("messages.tenant", $tenantid)
                ->orWhere("messages.tenant", "0");
        })
        ->where("messages.".$feild, "=", $search)
        ->where("messages.".$feild2, "=", $search2)
        ->orderBy('messages.id', 'desc')
        ->get();
        return $message;
    }


    public function search($tenantid,$search)
    {
        $results = DB::select(
            DB::raw("SELECT * FROM messages WHERE (tenant = '$tenantid' OR tenant = '0') AND
            (templatetitle LIKE '%$search%' OR sentcount LIKE '%$search%' OR statussent LIKE '%$search%') ORDER BY id DESC"),
        );
        return $results;
    }

    public function searchsub($tenantid,$feild,$feildvalue,$search)
    {
        $results = DB::select(
            DB::raw("SELECT * FROM messages WHERE (tenant = '$tenantid' OR tenant = '0') AND `$feild` = '$feildvalue'
             AND (templatetitle LIKE '%$search%' OR sentcount LIKE '%$search%' OR statussent LIKE '%$search%') ORDER BY id DESC"),
        );
        return $results;
    }

    public function indexone($tenantid,$id)
    {
        $message = DB::table('messages')
        ->select('messages.*','messagetemplates.templatetitle AS templatetitle_get','rents.tenantname AS tenantname_get')
        ->where('messages.id', '=', $id)
        ->leftJoin('messagetemplates', 'messages.templatetitle', '=', 'messagetemplates.id')
        ->leftJoin('rents', 'messages.tenantname', '=', 'rents.id')
        ->get();
        return $message;
    }

    public function store(Request $request)
    {
        $id = uniqid('', true);
        $request->request->add(['id' => $id]);
        $message = Message::create($request->all());
        
        return response()->json($message, 201);
    }

    public function storerecipient(Request $request)
    {
        $opt = $request->opt;
        $messageid = $request->messageid;
        $recipeintid = $request->recipeintid;
        $tenant = $request->tenant;
        if($opt == "single"){
            $q = DB::select(DB::raw("SELECT * FROM residents WHERE id = '$recipeintid'"));
            foreach($q as $row) {
                    $recipeintid2 = $row->id;
                    $email = $row->email;
                    $fullname = $row->surname . " " . $row->othername;
                    DB::delete(DB::raw("DELETE FROM message_recipeient WHERE messageid = '$messageid' AND recipeintid = '$recipeintid2' AND tenant = '$tenant'"));
                    $message = DB::insert('INSERT INTO message_recipeient (messageid,recipeintid,email,fullname,tenant) values (?, ?, ?, ?, ?)', [$messageid,$recipeintid2,$email,$fullname,$tenant]);
                }
        }else if($opt == "street"){
            if($recipeintid == "All"){
                $q = DB::select(DB::raw("SELECT * FROM residents WHERE tenant = '$tenant'"));
                foreach($q as $row) {
                    $recipeintid2 = $row->id;
                    $email = $row->email;
                    $fullname = $row->surname . " " . $row->othername;
                    DB::delete(DB::raw("DELETE FROM message_recipeient WHERE messageid = '$messageid' AND recipeintid = '$recipeintid2' AND tenant = '$tenant'"));
                    $message = DB::insert('INSERT INTO message_recipeient (messageid,recipeintid,email,fullname,tenant) values (?, ?, ?, ?, ?)', [$messageid,$recipeintid2,$email,$fullname,$tenant]);
                }
            }else{
                $q = DB::select(DB::raw("SELECT * FROM residents WHERE tenant = '$tenant' AND street = '$recipeintid'"));
                foreach($q as $row) {
                    $recipeintid2 = $row->id;
                    $email = $row->email;
                    $fullname = $row->surname . " " . $row->othername;
                    DB::delete(DB::raw("DELETE FROM message_recipeient WHERE messageid = '$messageid' AND recipeintid = '$recipeintid2' AND tenant = '$tenant'"));
                    $message = DB::insert('INSERT INTO message_recipeient (messageid,recipeintid,email,fullname,tenant) values (?, ?, ?, ?, ?)', [$messageid,$recipeintid2,$email,$fullname,$tenant]);
                }
            }
        }else if($opt == "remove"){
            $message = DB::delete(DB::raw("DELETE FROM message_recipeient WHERE messageid = '$messageid' AND recipeintid = '$recipeintid' AND tenant = '$tenant'"));
        }

        return response()->json($message, 201);
    }

    public function sendmessage(Request $request)
    {
        $messageid = $request->messageid;
        $messagetitle = $request->messagetitle;
        $messagecontent = $request->messagecontent;
        $message2 = DB::table('messagetemplates')
            ->where('id', $messageid)
            ->update([
                'templatetitle' =>$messagetitle,
                'messagecontent' =>$messagecontent,
                'sentstatus' =>'1',
                ]);
        $message = DB::table('message_recipeient')
            ->where('messageid', $messageid)
            ->update([
                'sentstatus' =>'1'
                ]);

        return response()->json($message2, 201);
    }
    
    public function update(Request $request, $id)
    {
        $message = Message::findOrFail($id);
        $message->update($request->all());

        return response()->json($message, 200);
    }

    public function delete(Request $request, $id)
    {
        $message = Message::findOrFail($id);
        $message->delete();

        return response()->json(null, 204);
    }

}