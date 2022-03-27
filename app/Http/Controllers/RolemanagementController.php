<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Rolemanagement;

class RolemanagementController extends Controller
{
    public function index($tenantid)
    {
         $rolemanagement = DB::table('rolemanagements')
        ->select('rolemanagements.*')
        ->where("rolemanagements.tenant", "=", $tenantid)
        ->orWhere("rolemanagements.tenant", "=", "0")
        ->orderBy('rolemanagements.id', 'desc')
        ->get();
        return $rolemanagement;
    }
public function indexmultiple($tenantid,$feild,$search)
    {
         $rolemanagement = DB::table('rolemanagements')
        ->select('rolemanagements.*')
        ->where(function($query) use ($tenantid){
            $query->where("rolemanagements.tenant", $tenantid)
                ->orWhere("rolemanagements.tenant", "0");
        })
        ->where("rolemanagements.".$feild, "=", $search)
        ->orderBy('rolemanagements.id', 'desc')
        ->get();
        return $rolemanagement;
    }
public function indexmultiple2($tenantid,$feild,$search,$feild2,$search2)
    {
         $rolemanagement = DB::table('rolemanagements')
        ->select('rolemanagements.*')
        ->where(function($query) use ($tenantid){
            $query->where("rolemanagements.tenant", $tenantid)
                ->orWhere("rolemanagements.tenant", "0");
        })
        ->where("rolemanagements.".$feild, "=", $search)
        ->where("rolemanagements.".$feild2, "=", $search2)
        ->orderBy('rolemanagements.id', 'desc')
        ->get();
        return $rolemanagement;
    }


    public function search($tenantid,$search)
    {
        $results = DB::select(
            DB::raw("SELECT * FROM rolemanagements WHERE (tenant = '$tenantid' OR tenant = '0') AND
            () ORDER BY id DESC"),
        );
        return $results;
    }

    public function searchsub($tenantid,$feild,$feildvalue,$search)
    {
        $results = DB::select(
            DB::raw("SELECT * FROM rolemanagements WHERE (tenant = '$tenantid' OR tenant = '0') AND `$feild` = '$feildvalue'
             AND () ORDER BY id DESC"),
        );
        return $results;
    }

    public function indexone($tenantid,$id)
    {
         $rolemanagement = DB::table('rolemanagements')
            ->select('rolemanagements.*')
->where('rolemanagements.id', '=', $id)
        ->get();
        return $rolemanagement;
    }

    public function store(Request $request)
    {
        $id = uniqid('', true);
        $request->request->add(['id' => $id]);
        $rolemanagement = Rolemanagement::create($request->all());
        
        return response()->json($rolemanagement, 201);
    }

    public function update(Request $request, $id)
    {
        $rolemanagement = Rolemanagement::findOrFail($id);
        $rolemanagement->update($request->all());

        return response()->json($rolemanagement, 200);
    }

    public function delete(Request $request, $id)
    {
        $rolemanagement = Rolemanagement::findOrFail($id);
        $rolemanagement->delete();

        return response()->json(null, 204);
    }

}