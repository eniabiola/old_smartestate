<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\State;

class StateController extends Controller
{
    public function index($tenantid)
    {
         $state = DB::table('states')
        ->select('states.*')
        ->where("states.tenant", "=", $tenantid)
        ->orWhere("states.tenant", "=", "0")
        ->orderBy('states.id', 'desc')
        ->get();
        return $state;
    }
public function indexmultiple($tenantid,$feild,$search)
    {
         $state = DB::table('states')
        ->select('states.*')
        ->where(function($query) use ($tenantid){
            $query->where("states.tenant", $tenantid)
                ->orWhere("states.tenant", "0");
        })
        ->where("states.".$feild, "=", $search)
        ->orderBy('states.id', 'desc')
        ->get();
        return $state;
    }
public function indexmultiple2($tenantid,$feild,$search,$feild2,$search2)
    {
         $state = DB::table('states')
        ->select('states.*')
        ->where(function($query) use ($tenantid){
            $query->where("states.tenant", $tenantid)
                ->orWhere("states.tenant", "0");
        })
        ->where("states.".$feild, "=", $search)
        ->where("states.".$feild2, "=", $search2)
        ->orderBy('states.id', 'desc')
        ->get();
        return $state;
    }


    public function search($tenantid,$search)
    {
        $results = DB::select(
            DB::raw("SELECT * FROM states WHERE (tenant = '$tenantid' OR tenant = '0') AND
            (state LIKE '%$search%') ORDER BY id DESC"),
        );
        return $results;
    }

    public function searchsub($tenantid,$feild,$feildvalue,$search)
    {
        $results = DB::select(
            DB::raw("SELECT * FROM states WHERE (tenant = '$tenantid' OR tenant = '0') AND `$feild` = '$feildvalue'
             AND (state LIKE '%$search%') ORDER BY id DESC"),
        );
        return $results;
    }

    public function indexone($tenantid,$id)
    {
         $state = DB::table('states')
            ->select('states.*')
->where('states.id', '=', $id)
        ->get();
        return $state;
    }

    public function store(Request $request)
    {
        $id = uniqid('', true);
        $request->request->add(['id' => $id]);
        $state = State::create($request->all());
        
        return response()->json($state, 201);
    }

    public function update(Request $request, $id)
    {
        $state = State::findOrFail($id);
        $state->update($request->all());

        return response()->json($state, 200);
    }

    public function delete(Request $request, $id)
    {
        $state = State::findOrFail($id);
        $state->delete();

        return response()->json(null, 204);
    }

}