<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\VisitorPassStoreRequest;
use App\Http\Resources\VisitorPassResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Visitorpass;
use App\Traits\ResponseTrait;

class VisitorPassController extends Controller
{
    use ResponseTrait;

    public function index(Request $request)
    {
        $tenantid = $request->get('tenantid');
        $resident = $request->get('resident');
        $search = $request->get('search');
         $visitorpass = Visitorpass::query()
             ->when($tenantid != null, function ($query) use($tenantid) {
                 $query->where('tenant', $tenantid);
             })
             ->when($resident != null, function ($query) use($resident){
                 $query->where('passid', $resident)
                     ->orderBy('statuspass', 'ASC');
             })
             ->when($search != null, function ($query) use($search){
                 $query->where('passid', $search);
             })
             ->orderBy('statuspass', 'ASC')
             ->orderBy('created_at', 'DESC')
             ->get();

         return $this->successResponse('list of visitor passes', 200, VisitorPassResource::collection($visitorpass));
    }

    public function visitorpassresident($tenantid)
    {
        $visitorpass = DB::table('visitor_passes')
        ->select('visitor_passes.*','residents.surname','residents.othername','residents.phone','residents.email')
        ->leftJoin('residents', 'residents.id', '=', 'visitor_passes.passid')
        ->where("visitor_passes.tenant", "=", $tenantid)
        ->where(function($query) use ($tenantid){
            $query->where("visitor_passes.statuspass", "Pending")
                ->orWhere("visitor_passes.statuspass", "Active");
        })
        ->orderBy('visitor_passes.id', 'desc')
        ->get();
        return $visitorpass;
    }

    public function visitorpass($tenantid,$resident)
    {
         $visitorpass = DB::table('visitor_passes')
        ->select('visitor_passes.*',DB::raw("TIMESTAMPDIFF(hour, now(), dateexpires) AS expiresleft"))
        ->where("visitor_passes.tenant", "=", $tenantid)
        ->where("visitor_passes.passid", "=", $resident)
        ->where(function($query) use ($tenantid){
            $query->where("visitor_passes.statuspass", "Pending")
                ->orWhere("visitor_passes.statuspass", "Active");
        })
        ->orderBy('visitor_passes.id', 'desc')
        ->get();
        return $visitorpass;
    }

    public function indexmultiple($tenantid,$feild,$search)
        {
             $visitorpass = DB::table('visitor_passes')
            ->select('visitor_passes.*')
            ->where(function($query) use ($tenantid){
                $query->where("visitor_passes.tenant", $tenantid)
                    ->orWhere("visitor_passes.tenant", "0");
            })
            ->where("visitor_passes.".$feild, "=", $search)
            ->orderBy('visitor_passes.id', 'desc')
            ->get();
            return $visitorpass;
        }
    public function indexmultiple2($tenantid,$feild,$search,$feild2,$search2)
        {
             $visitorpass = DB::table('visitor_passes')
            ->select('visitor_passes.*')
            ->where(function($query) use ($tenantid){
                $query->where("visitor_passes.tenant", $tenantid)
                    ->orWhere("visitor_passes.tenant", "0");
            })
            ->where("visitor_passes.".$feild, "=", $search)
            ->where("visitor_passes.".$feild2, "=", $search2)
            ->orderBy('visitor_passes.id', 'desc')
            ->get();
            return $visitorpass;
        }

    public function search($tenantid,$search)
    {
        $visitorpass = DB::table('visitor_passes')
        ->select('visitor_passes.*','residents.surname','residents.othername','residents.phone','residents.email', DB::raw("TIMESTAMPDIFF(hour, now(), visitationdate) AS minutetodue,TIMESTAMPDIFF(hour, now(), dateexpires) AS minutetoexpire"))
        ->leftJoin('residents', 'residents.id', '=', 'visitor_passes.passid')
        ->where("visitor_passes.tenant", "=", $tenantid)
        ->where("visitor_passes.generatedcode", "=", $search)
        ->orderBy('visitor_passes.id', 'desc')
        ->get();
        return $visitorpass;
    }

    public function searchsub($tenantid,$feild,$feildvalue,$search)
    {
        $results = DB::select(
            DB::raw("SELECT * FROM visitor_passes WHERE (tenant = '$tenantid' OR tenant = '0') AND `$feild` = '$feildvalue'
             AND (surname LIKE '%$search%' OR gender LIKE '%$search%' OR statuspass LIKE '%$search%') ORDER BY id DESC"),
        );
        return $results;
    }

    public function indexone($tenantid,$id)
    {
        $visitorpass = DB::table('visitor_passes')
        ->select('visitor_passes.*','residents.surname','residents.othername','residents.phone','residents.email')
        ->leftJoin('residents', 'residents.id', '=', 'visitor_passes.passid')
        ->where("visitor_passes.id", "=", $id)
        ->get();
        return $visitorpass;

    }

    public function store(VisitorPassStoreRequest $request)
    {
        try {
            $id = mt_rand(1000000,9999999);
            $request->merge(['date' => date('Y-m-d')]);
            $request = $request->validated();
            $request += ['date' => date('Y-m-d', strtotime($request['visitationdate'])),
                'generatedcode' => $id, 'statuspass' => "inactive", 'passid' => $request['user']];
            $visitorpass = Visitorpass::create($request);
            return $this->successResponse('Pass successfully created', 200, $visitorpass);
        } catch (\Exception $e)
        {
          return $this->failedResponse('Unable to create visitor pass, contact administrator');
        }
    }

        public function processguest($id,$status)
        {
            $codeupdate = Visitorpass::where('id', $id)->update(array('statuspass' => $status));
            return response()->json($codeupdate, 201);
        }
    public function update(Request $request, $id)
    {
        $visitationdate = $request['visitationdate'];
        $dateexpires = $request['dateexpires'];
        $recurrentpass = $request['recurrentpass'];
        $visitationdate2 = date('Y-m-d', strtotime($visitationdate));
        $dateexpires2 = date('Y-m-d', strtotime($dateexpires));
        /*if($recurrentpass == 'Recurring'){
            $dateexpires = $request['dateexpires'];
            $dateexpires2 = date('Y-m-d', strtotime($dateexpires));
        }*/
        $visitorpass = Visitorpass::where('id', $id)
            ->update(
                array(
                        'recurrentpass' => $recurrentpass,
                        'visitationdate' => $visitationdate2,
                        'guestname' => $request['guestname'],
                        'gender' => $request['gender'],
                        'dateexpires' => $dateexpires2
                    )
            );

        return response()->json($visitorpass, 200);
    }
    public function cancelgatepass($tenantid,$id)
    {
        $visitorpass = Visitorpass::where('id', $id)
            ->update(
                array(
                        'statuspass' => 'Cancel'
                    )
            );

        return response()->json($visitorpass, 200);
    }
    public function delete(Request $request, $id)
    {
        $visitorpass = Visitorpass::findOrFail($id);
        $visitorpass->delete();

        return response()->json(null, 204);
    }

}
