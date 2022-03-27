<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Landlord;

class LandlordController extends Controller
{
    public function index($tenantid)
    {
         $landlord = DB::table('landlords')
        ->select('landlords.*')
        ->where("landlords.tenant", "=", $tenantid)
        ->orWhere("landlords.tenant", "=", "0")
        ->orderBy('landlords.id', 'desc')
        ->get();
        return $landlord;
    }
public function indexmultiple($tenantid,$feild,$search)
    {
         $landlord = DB::table('landlords')
        ->select('landlords.*')
        ->where(function($query) use ($tenantid){
            $query->where("landlords.tenant", $tenantid)
                ->orWhere("landlords.tenant", "0");
        })
        ->where("landlords.".$feild, "=", $search)
        ->orderBy('landlords.id', 'desc')
        ->get();
        return $landlord;
    }
public function indexmultiple2($tenantid,$feild,$search,$feild2,$search2)
    {
         $landlord = DB::table('landlords')
        ->select('landlords.*')
        ->where(function($query) use ($tenantid){
            $query->where("landlords.tenant", $tenantid)
                ->orWhere("landlords.tenant", "0");
        })
        ->where("landlords.".$feild, "=", $search)
        ->where("landlords.".$feild2, "=", $search2)
        ->orderBy('landlords.id', 'desc')
        ->get();
        return $landlord;
    }


    public function search($tenantid,$search)
    {
        $results = DB::select(
            DB::raw("SELECT * FROM landlords WHERE (tenant = '$tenantid' OR tenant = '0') AND
            (email LIKE '%$search%' OR phone LIKE '%$search%') ORDER BY id DESC"),
        );
        return $results;
    }

    public function searchsub($tenantid,$feild,$feildvalue,$search)
    {
        $results = DB::select(
            DB::raw("SELECT * FROM landlords WHERE (tenant = '$tenantid' OR tenant = '0') AND `$feild` = '$feildvalue'
             AND (email LIKE '%$search%' OR phone LIKE '%$search%') ORDER BY id DESC"),
        );
        return $results;
    }

    public function indexone($tenantid,$id)
    {
         $landlord = DB::table('landlords')
            ->select('landlords.*')
->where('landlords.id', '=', $id)
        ->get();
        return $landlord;
    }

    public function store(Request $request)
    {
        $id = uniqid('', true);
        $request->request->add(['id' => $id]);
        $landlord = Landlord::create($request->all());
        $autoid = "".str_pad($landlord['id'], 5, '0', STR_PAD_LEFT);
        $codeupdate = Landlord::where('id', $landlord['id'])->update(array('landlordid' => $autoid));
        return response()->json($landlord, 201);
    }

    public function update(Request $request, $id)
    {
        $landlord = Landlord::findOrFail($id);
        $landlord->update($request->all());

        return response()->json($landlord, 200);
    }

    public function delete(Request $request, $id)
    {
        $landlord = Landlord::findOrFail($id);
        $landlord->delete();

        return response()->json(null, 204);
    }

}