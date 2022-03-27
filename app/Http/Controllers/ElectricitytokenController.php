<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Electricitytoken;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ElectricitytokenController extends Controller
{
    use ResponseTrait;

    public function index(Request $request)
    {
        $tenantid = $request->get('tenantid');
        $user = $request->get('user');
         $electricitytoken = Electricitytoken::query()
         ->when($tenantid, function($query) use($tenantid){
             $query->where("tenant", "=", $tenantid);
         })
         ->when($user, function($query) use($user){
             $query->where("user", "=", $user);
         })
        ->orderBy('created_at', 'desc')
        ->get();

         return $this->successResponse("List of Electricity tokens", 200, $electricitytoken);
    }

    public function indexmultiple($tenantid,$feild,$search)
    {
         $electricitytoken = DB::table('electricity_tokens')
        ->select('electricity_tokens.*')
        ->where(function($query) use ($tenantid){
            $query->where("electricity_tokens.tenant", $tenantid)
                ->orWhere("electricity_tokens.tenant", "0");
        })
        ->where("electricity_tokens.".$feild, "=", $search)
        ->orderBy('electricity_tokens.id', 'desc')
        ->get();
        return $electricitytoken;
    }

    public function indexmultiple2($tenantid,$feild,$search,$feild2,$search2)
    {
         $electricitytoken = DB::table('electricity_tokens')
        ->select('electricity_tokens.*')
        ->where(function($query) use ($tenantid){
            $query->where("electricity_tokens.tenant", $tenantid)
                ->orWhere("electricity_tokens.tenant", "0");
        })
        ->where("electricity_tokens.".$feild, "=", $search)
        ->where("electricity_tokens.".$feild2, "=", $search2)
        ->orderBy('electricity_tokens.id', 'desc')
        ->get();
        return $electricitytoken;
    }


    public function search($tenantid,$search)
    {
        $results = DB::select(
            DB::raw("SELECT * FROM electricity_tokens WHERE (tenant = '$tenantid' OR tenant = '0') AND
            (surname LIKE '%$search%') ORDER BY id DESC"),
        );
        return $results;
    }

    public function searchsub($tenantid,$feild,$feildvalue,$search)
    {
        $results = DB::select(
            DB::raw("SELECT * FROM electricity_tokens WHERE (tenant = '$tenantid' OR tenant = '0') AND `$feild` = '$feildvalue'
             AND (surname LIKE '%$search%') ORDER BY id DESC"),
        );
        return $results;
    }

    public function indexone($tenantid,$id)
    {
         $electricitytoken = DB::table('electricity_tokens')
            ->select('electricity_tokens.*')
->where('electricity_tokens.id', '=', $id)
        ->get();
        return $electricitytoken;
    }

    public function store(Request $request)
    {
        $id = uniqid('', true);
        $request->request->add(['id' => $id]);
        $electricitytoken = Electricitytoken::create($request->all());

        return response()->json($electricitytoken, 201);
    }

    public function update(Request $request, $id)
    {
        $electricitytoken = Electricitytoken::findOrFail($id);
        $electricitytoken->update($request->all());

        return response()->json($electricitytoken, 200);
    }

    public function delete(Request $request, $id)
    {
        $electricitytoken = Electricitytoken::findOrFail($id);
        $electricitytoken->delete();

        return response()->json(null, 204);
    }

    public function verifyMeterNo(Request $request)
    {
        $curl = curl_init();
        $meter_no = $request->meter_no;
        $requestUrl = env('MMECOL_BASE_URL').'/webresources/IdentificationV2/101/'.$meter_no;

        curl_setopt_array($curl, array(
          CURLOPT_URL => $requestUrl,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $jsonRes = json_decode($response);
        return response()->json($jsonRes, 200);
    }

}
