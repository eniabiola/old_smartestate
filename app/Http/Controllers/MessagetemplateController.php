<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Messagetemplate;

class MessagetemplateController extends Controller
{
    public function index($tenantid)
    {
         $messagetemplate = DB::table('messagetemplates')
        ->select('messagetemplates.*')
        ->where("messagetemplates.tenant", "=", $tenantid)
        ->orWhere("messagetemplates.tenant", "=", "0")
        ->orderBy('messagetemplates.id', 'desc')
        ->get();
        return $messagetemplate;
    }
public function indexmultiple($tenantid,$feild,$search)
    {
         $messagetemplate = DB::table('messagetemplates')
        ->select('messagetemplates.*')
        ->where(function($query) use ($tenantid){
            $query->where("messagetemplates.tenant", $tenantid)
                ->orWhere("messagetemplates.tenant", "0");
        })
        ->where("messagetemplates.".$feild, "=", $search)
        ->orderBy('messagetemplates.id', 'desc')
        ->get();
        return $messagetemplate;
    }
public function indexmultiple2($tenantid,$feild,$search,$feild2,$search2)
    {
         $messagetemplate = DB::table('messagetemplates')
        ->select('messagetemplates.*')
        ->where(function($query) use ($tenantid){
            $query->where("messagetemplates.tenant", $tenantid)
                ->orWhere("messagetemplates.tenant", "0");
        })
        ->where("messagetemplates.".$feild, "=", $search)
        ->where("messagetemplates.".$feild2, "=", $search2)
        ->orderBy('messagetemplates.id', 'desc')
        ->get();
        return $messagetemplate;
    }


    public function search($tenantid,$search)
    {
        $results = DB::select(
            DB::raw("SELECT * FROM messagetemplates WHERE (tenant = '$tenantid' OR tenant = '0') AND
            (monthsdue LIKE '%$search%' OR templatetitle LIKE '%$search%') ORDER BY id DESC"),
        );
        return $results;
    }

    public function searchsub($tenantid,$feild,$feildvalue,$search)
    {
        $results = DB::select(
            DB::raw("SELECT * FROM messagetemplates WHERE (tenant = '$tenantid' OR tenant = '0') AND `$feild` = '$feildvalue'
             AND (monthsdue LIKE '%$search%' OR templatetitle LIKE '%$search%') ORDER BY id DESC"),
        );
        return $results;
    }

    public function indexone($tenantid,$id)
    {
         $messagetemplate = DB::table('messagetemplates')
            ->select('messagetemplates.*')
->where('messagetemplates.id', '=', $id)
        ->get();
        return $messagetemplate;
    }

    public function store(Request $request)
    {
        $id = uniqid('', true);
        $request->request->add(['id' => $id]);
        $messagetemplate = Messagetemplate::create($request->all());
        
        return response()->json($messagetemplate, 201);
    }

    public function update(Request $request, $id)
    {
        $messagetemplate = Messagetemplate::findOrFail($id);
        $messagetemplate->update($request->all());

        return response()->json($messagetemplate, 200);
    }

    public function delete(Request $request, $id)
    {
        $messagetemplate = Messagetemplate::findOrFail($id);
        $messagetemplate->delete();

        return response()->json(null, 204);
    }

}