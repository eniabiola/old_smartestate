<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Housetype;

class HousetypeController extends Controller
{
    public function index($tenantid)
    {
         $housetype = DB::table('housetypes')
        ->select('housetypes.*')
        ->where("housetypes.tenant", "=", $tenantid)
        ->orWhere("housetypes.tenant", "=", "0")
        ->orderBy('housetypes.id', 'desc')
        ->get();
        return $housetype;
    }
public function indexmultiple($tenantid,$feild,$search)
    {
         $housetype = DB::table('housetypes')
        ->select('housetypes.*')
        ->where(function($query) use ($tenantid){
            $query->where("housetypes.tenant", $tenantid)
                ->orWhere("housetypes.tenant", "0");
        })
        ->where("housetypes.".$feild, "=", $search)
        ->orderBy('housetypes.id', 'desc')
        ->get();
        return $housetype;
    }
public function indexmultiple2($tenantid,$feild,$search,$feild2,$search2)
    {
         $housetype = DB::table('housetypes')
        ->select('housetypes.*')
        ->where(function($query) use ($tenantid){
            $query->where("housetypes.tenant", $tenantid)
                ->orWhere("housetypes.tenant", "0");
        })
        ->where("housetypes.".$feild, "=", $search)
        ->where("housetypes.".$feild2, "=", $search2)
        ->orderBy('housetypes.id', 'desc')
        ->get();
        return $housetype;
    }


    public function search($tenantid,$search)
    {
        $results = DB::select(
            DB::raw("SELECT * FROM housetypes WHERE (tenant = '$tenantid' OR tenant = '0') AND
            (housetype LIKE '%$search%') ORDER BY id DESC"),
        );
        return $results;
    }

    public function searchsub($tenantid,$feild,$feildvalue,$search)
    {
        $results = DB::select(
            DB::raw("SELECT * FROM housetypes WHERE (tenant = '$tenantid' OR tenant = '0') AND `$feild` = '$feildvalue'
             AND (housetype LIKE '%$search%') ORDER BY id DESC"),
        );
        return $results;
    }

    public function indexone($tenantid,$id)
    {
         $housetype = DB::table('housetypes')
            ->select('housetypes.*')
->where('housetypes.id', '=', $id)
        ->get();
        return $housetype;
    }

    public function store(Request $request)
    {
        $id = uniqid('', true);
        $request->request->add(['id' => $id]);
        $housetype = Housetype::create($request->all());
        
        return response()->json($housetype, 201);
    }

    public function update(Request $request, $id)
    {
        $housetype = Housetype::findOrFail($id);
        $housetype->update($request->all());

        return response()->json($housetype, 200);
    }

    public function delete(Request $request, $id)
    {
        $housetype = Housetype::findOrFail($id);
        $housetype->delete();

        return response()->json(null, 204);
    }

}