<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Userrole;

class UserroleController extends Controller
{
    public function index($tenantid)
    {
         $userrole = DB::table('userroles')
        ->select('userroles.*')
        ->where("userroles.tenant", "=", $tenantid)
        ->orWhere("userroles.tenant", "=", "0")
        ->orderBy('userroles.id', 'desc')
        ->get();
        return $userrole;
    }
public function indexmultiple($tenantid,$feild,$search)
    {
         $userrole = DB::table('userroles')
        ->select('userroles.*')
        ->where(function($query) use ($tenantid){
            $query->where("userroles.tenant", $tenantid)
                ->orWhere("userroles.tenant", "0");
        })
        ->where("userroles.".$feild, "=", $search)
        ->orderBy('userroles.id', 'desc')
        ->get();
        return $userrole;
    }
public function indexmultiple2($tenantid,$feild,$search,$feild2,$search2)
    {
         $userrole = DB::table('userroles')
        ->select('userroles.*')
        ->where(function($query) use ($tenantid){
            $query->where("userroles.tenant", $tenantid)
                ->orWhere("userroles.tenant", "0");
        })
        ->where("userroles.".$feild, "=", $search)
        ->where("userroles.".$feild2, "=", $search2)
        ->orderBy('userroles.id', 'desc')
        ->get();
        return $userrole;
    }


    public function search($tenantid,$search)
    {
        $results = DB::select(
            DB::raw("SELECT * FROM userroles WHERE (tenant = '$tenantid' OR tenant = '0') AND
            () ORDER BY id DESC"),
        );
        return $results;
    }

    public function searchsub($tenantid,$feild,$feildvalue,$search)
    {
        $results = DB::select(
            DB::raw("SELECT * FROM userroles WHERE (tenant = '$tenantid' OR tenant = '0') AND `$feild` = '$feildvalue'
             AND () ORDER BY id DESC"),
        );
        return $results;
    }

    public function indexone($tenantid,$id)
    {
         $userrole = DB::table('userroles')
            ->select('userroles.*')
->where('userroles.id', '=', $id)
        ->get();
        return $userrole;
    }

    public function store(Request $request)
    {
        $id = uniqid('', true);
        $request->request->add(['id' => $id]);
        $userrole = Userrole::create($request->all());
        
        return response()->json($userrole, 201);
    }

    public function update(Request $request, $id)
    {
        $userrole = Userrole::findOrFail($id);
        $userrole->update($request->all());

        return response()->json($userrole, 200);
    }

    public function delete(Request $request, $id)
    {
        $userrole = Userrole::findOrFail($id);
        $userrole->delete();

        return response()->json(null, 204);
    }

}