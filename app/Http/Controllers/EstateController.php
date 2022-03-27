<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Estate;

class EstateController extends Controller
{
    public function index($tenantid)
    {
         $estate = DB::table('estates')
        ->select('estates.*')
        ->where("estates.tenant", "=", $tenantid)
        ->orWhere("estates.tenant", "=", "0")
        ->orderBy('estates.id', 'desc')
        ->get();
        return $estate;
    }
public function indexmultiple($tenantid,$feild,$search)
    {
         $estate = DB::table('estates')
        ->select('estates.*')
        ->where(function($query) use ($tenantid){
            $query->where("estates.tenant", $tenantid)
                ->orWhere("estates.tenant", "0");
        })
        ->where("estates.".$feild, "=", $search)
        ->orderBy('estates.id', 'desc')
        ->get();
        return $estate;
    }
public function indexmultiple2($tenantid,$feild,$search,$feild2,$search2)
    {
         $estate = DB::table('estates')
        ->select('estates.*')
        ->where(function($query) use ($tenantid){
            $query->where("estates.tenant", $tenantid)
                ->orWhere("estates.tenant", "0");
        })
        ->where("estates.".$feild, "=", $search)
        ->where("estates.".$feild2, "=", $search2)
        ->orderBy('estates.id', 'desc')
        ->get();
        return $estate;
    }


    public function search($tenantid,$search)
    {
        $results = DB::select(
            DB::raw("SELECT * FROM estates WHERE (tenant = '$tenantid' OR tenant = '0') AND
            () ORDER BY id DESC"),
        );
        return $results;
    }

    public function searchsub($tenantid,$feild,$feildvalue,$search)
    {
        $results = DB::select(
            DB::raw("SELECT * FROM estates WHERE (tenant = '$tenantid' OR tenant = '0') AND `$feild` = '$feildvalue'
             AND () ORDER BY id DESC"),
        );
        return $results;
    }

    public function indexone($tenantid,$id)
    {
         $estate = DB::table('estates')
            ->select('estates.*')
->where('estates.id', '=', $id)
        ->get();
        return $estate;
    }

    public function store(Request $request)
    {
        $id = uniqid('', true);
        $request->request->add(['id' => $id]);
        $estate = Estate::create($request->all());
        $autoid = "".str_pad($estate['id'], 5, '0', STR_PAD_LEFT);
        $codeupdate = Estate::where('id', $estate['id'])->update(array('estateid' => $autoid));
        return response()->json($estate, 201);
    }

    public function update(Request $request, $id)
    {
        $estate = Estate::findOrFail($id);
        $estate->update($request->all());

        return response()->json($estate, 200);
    }

    public function delete(Request $request, $id)
    {
        $estate = Estate::findOrFail($id);
        $estate->delete();

        return response()->json(null, 204);
    }

}