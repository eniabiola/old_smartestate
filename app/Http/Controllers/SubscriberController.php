<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubscriberRequest;
use App\Http\Requests\SubscriberUpdateRequest;
use App\Usermanagement;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Subscriber;
use Illuminate\Support\Facades\Hash;
use App\Traits\ResponseTrait;
use App\Traits\Utilities;

class SubscriberController extends Controller
{

    use ResponseTrait, Utilities;

    public function checkduplicate($val){

            $results = DB::table('subscribers')
             ->select(DB::raw('count(*) as count'))
             ->where("email", "=", $val)
            ->orWhere("phone", "=", $val)
            ->get();
            $checkcount1 = $results[0]->count;

            $results = DB::table('residents')
             ->select(DB::raw('count(*) as count'))
             ->where("email", "=", $val)
            ->orWhere("phone", "=", $val)
            ->get();
            $checkcount2 = $results[0]->count;

            $results = DB::table('usermanagements')
             ->select(DB::raw('count(*) as count'))
             ->where("email", "=", $val)
            ->orWhere("phone", "=", $val)
            ->get();
            $checkcount3 = $results[0]->count;

            $checkall = $checkcount1+$checkcount2+$checkcount3;
            $result = [
                "check1"=>$checkcount1,
                "check2"=>$checkcount2,
                "check3"=>$checkcount3,
                "checkall"=>$checkall,
            ];

            return response()->json($result, 200);
    }

    public function superadmindboard($tenantid){
        //estatecount
        $results = DB::select(DB::raw("SELECT count(*) as totalestates FROM subscribers WHERE tenant <> '00'"));
        $estatecount = $results[0]->totalestates;

        //total residents
        $results = DB::select(DB::raw("SELECT count(*) as totalresident FROM residents"));
        $residentcount = $results[0]->totalresident;

        //total wallet balance
        $results = DB::select(DB::raw("SELECT SUM(credit)-SUM(debit) AS totalwallet FROM wallets WHERE transtatus = 'Successful'"));
        $walletbalance = $results[0]->totalwallet;

        //total payment due
        $results = DB::table('invoices')
         ->select(DB::raw('sum(invoices.amount) AS balance'))
         ->leftJoin('billings', 'billings.id', '=', 'invoices.invoiceno')
         ->where("invoicestatus", "=", "Not Paid")
        ->get();
        $totalpaymentdue = $results[0]->balance;

        $result = [
            "totalestates"=>$estatecount,
            "totalresident"=>$residentcount,
            "totalwalletbalance"=>$walletbalance,
            "totalpaymentdue"=>$totalpaymentdue,
        ];

        return response()->json($result, 200);
    }

    public function admindashboard($tenantid){
        //residents
        $totalresident = DB::table('residents')
            ->where('tenant', $tenantid)
            ->where('regstatus', "Active")
            ->count();

        //request
        $activerequests = DB::table('complaints')
        ->where(function($query) use ($tenantid){
            $query->where("complaintstatus", "Pending")
                ->orWhere("complaintstatus", "Active");
        })
        ->where('tenant', $tenantid)
        ->count();

        //request
       /* $activevisitorpass = DB::table('visitor_passes')
        ->where(function($query) use ($tenantid){
            $query->where("statuspass", "Pending")
                ->orWhere("statuspass", "Active");
        }) */
        $activevisitorpass = DB::table('visitor_passes')
        ->where("statuspass", "=", "Active")
        ->where('tenant', $tenantid)
        ->count();

        //total wallet balance
        $results = DB::select(DB::raw("SELECT SUM(credit)-SUM(debit) AS totalwallet FROM wallets WHERE tenant = '$tenantid' AND transtatus = 'Successful'"));
        $totalwalletbal = $results[0]->totalwallet;

        $results = DB::table('invoices')
         ->select(DB::raw('sum(billings.amount) AS balance'))
         ->leftJoin('billings', 'billings.id', '=', 'invoices.invoiceno')
         ->where("invoicestatus", "=", "Not Paid")
         ->where("invoices.tenant", "=", "$tenantid")
        ->get();
        $totalpaymentdue = $results[0]->balance;

        $results = DB::table('invoices')
         ->select(DB::raw('sum(billings.amount) AS balance'))
         ->leftJoin('billings', 'billings.id', '=', 'invoices.invoiceno')
         ->where("invoicestatus", "=", "Paid")
         ->where("invoices.tenant", "=", "$tenantid")
        ->get();
        $totalservicecharge = $results[0]->balance;

        $result = [
            "totalresident"=>$totalresident,
            "activevisitorpass"=>$activevisitorpass,
            "activerequests"=>$activerequests,
            "totalwalletbal"=>$totalwalletbal,
            "totalpaymentdue"=>$totalpaymentdue,
            "totalservicecharge"=>$totalservicecharge,
        ];

        return response()->json($result, 200);
    }

    public function index($tenantid)
    {
         $subscriber = DB::table('subscribers')
        ->select('subscribers.*','states.state AS state','states.id AS stateid','cities.city AS city','cities.id AS cityid','banks.bank AS bank','banks.id AS bankid')
->leftJoin('states', 'subscribers.state', '=', 'states.id')
->leftJoin('cities', 'subscribers.city', '=', 'cities.id')
->leftJoin('banks', 'subscribers.bank', '=', 'banks.id')
->where("subscribers.tenant", "!=", "00")
        ->orderBy('subscribers.id', 'desc')
        ->get();
        return $subscriber;
    }

    public function indexmultiple($tenantid,$feild,$search)
        {
             $subscriber = DB::table('subscribers')
            ->select('subscribers.*','states.state AS state','states.id AS stateid','cities.city AS city','cities.id AS cityid','banks.bank AS bank','banks.id AS bankid')
            ->leftJoin('states', 'subscribers.state', '=', 'states.id')
            ->leftJoin('cities', 'subscribers.city', '=', 'cities.id')
            ->leftJoin('banks', 'subscribers.bank', '=', 'banks.id')
            ->where("subscribers.".$feild, "=", $search)
            ->where("subscribers.tenant", "!=", "00")
            ->orderBy('subscribers.id', 'desc')
            ->get();
            return $subscriber;
        }

    public function indexmultiple2($tenantid,$feild,$search,$feild2,$search2)
        {
             $subscriber = DB::table('subscribers')
            ->select('subscribers.*','states.state AS state','states.id AS stateid','cities.city AS city','cities.id AS cityid','banks.bank AS bank','banks.id AS bankid')
    ->leftJoin('states', 'subscribers.state', '=', 'states.id')
    ->leftJoin('cities', 'subscribers.city', '=', 'cities.id')
    ->leftJoin('banks', 'subscribers.bank', '=', 'banks.id')
            ->where(function($query) use ($tenantid){
                $query->where("subscribers.tenant", $tenantid)
                    ->orWhere("subscribers.tenant", "0");
            })
            ->where("subscribers.".$feild, "=", $search)
            ->where("subscribers.".$feild2, "=", $search2)
            ->where("subscribers.tenant", "!=", "00")
            ->orderBy('subscribers.id', 'desc')
            ->get();
            return $subscriber;
        }

    public function checkdomain($tenantid,$id)
    {
         $tenant = DB::table('subscribers')
         ->where('domainname', '=', $id)
         ->get();
        return $tenant;
    }

    public function search($tenantid,$search)
    {
        $results = DB::select(
            DB::raw("SELECT * FROM subscribers WHERE (tenant = '$tenantid' OR tenant = '0') AND
            (businessname LIKE '%$search%' OR email LIKE '%$search%' OR phone LIKE '%$search%' OR state LIKE '%$search%' OR city LIKE '%$search%') ORDER BY id DESC"),
        );
        return $results;
    }

    public function searchsub($tenantid,$feild,$feildvalue,$search)
    {
        $results = DB::select(
            DB::raw("SELECT * FROM subscribers WHERE (tenant = '$tenantid' OR tenant = '0') AND `$feild` = '$feildvalue'
             AND (businessname LIKE '%$search%' OR email LIKE '%$search%' OR phone LIKE '%$search%' OR state LIKE '%$search%' OR city LIKE '%$search%') ORDER BY id DESC"),
        );
        return $results;
    }

    public function verifycode($tenantid)
    {
         $subscriber = DB::table('subscribers')
        ->select('subscribers.*','states.state AS state_get','cities.city AS city_get','banks.bank AS bank_get')
        ->where('subscribers.estatepin', '=', $tenantid)
        ->leftJoin('states', 'subscribers.state', '=', 'states.id')
        ->leftJoin('cities', 'subscribers.city', '=', 'cities.id')
        ->leftJoin('banks', 'subscribers.bank', '=', 'banks.id')
        ->get();
        return $subscriber;
    }

    public function indexone($tenantid,$id)
    {
         $subscriber = DB::table('subscribers')
            ->select('subscribers.*','states.state AS state_get','cities.city AS city_get','banks.bank AS bank_get')
->where('subscribers.id', '=', $id)
->leftJoin('states', 'subscribers.state', '=', 'states.id')
->leftJoin('cities', 'subscribers.city', '=', 'cities.id')
->leftJoin('banks', 'subscribers.bank', '=', 'banks.id')
        ->get();
        return $subscriber;
    }

    public function store(SubscriberRequest $request)
    {
        $id = uniqid('', true);
        $estatepin = mt_rand(111,999).mt_rand(1111,9999);

        if ($request->has('image'))
        {
            try {
           $imageUploadAction = $this->uploadImageBase64($request->image, "subscriberimages/");
            if($imageUploadAction['status'] === false){
                $message = "The file upload must be an image!";
                $statuscode = 400;
                return $this->failedResponse($message, $statuscode);
            $filename = $imageUploadAction['data'];
                } else {
                $filename = "default.jpg";
                }
            }
            catch (\Exception $e)
            {
                 $message = "The file upload must be an image!";
                 return $this->failedResponse($message, 400);
            }
        }
        $request = $request->validated();
        $request += ['idsession' => $id, 'imagename' => $filename];
//        return $request;
        $subscriber = Subscriber::query()
        ->create($request);
        $autoid = str_pad($id, 5, '0', STR_PAD_LEFT);
        $tenantId = "".str_pad($id, 3, '0', STR_PAD_LEFT);


        Subscriber::query()
        ->find($subscriber->id)
            ->update(
            array(
                'tenantid' => $tenantId,
                'estatepin' => $estatepin
            )
        );
        Usermanagement::query()
            ->create([
                'userfullname' => $subscriber->businessname,
                'username' => $subscriber->email,
                'email' => $subscriber->email,
                'phone' => $subscriber->phone,
                'passwords' => Hash::make('password'),
                'tenant' => $subscriber->id,
                'user' => $subscriber->user,
                'userlevel' => 'Admin',
                'userstatus' => 'Active'
            ]);

        return $this->successResponse("Estate Subscriber successfully created", 201, $subscriber);
    }

    public function update(SubscriberUpdateRequest $request, $id)
    {
        $subscriber = Subscriber::findOrFail($id);
        if ($request->has('image'))
        {
            try {
                $imageUploadAction = $this->uploadImageBase64($request->image, "subscriberimages/");
                if($imageUploadAction['status'] === false){
                    $message = "The file upload must be an image!";
                    $statuscode = 400;
                    return $this->failedResponse($message, $statuscode);
                    $filename = $imageUploadAction['data'];
                } else {
                    $filename = $subscriber->imagename;
                }
            }
            catch (\Exception $e)
            {
                $message = "The file upload must be an image!";
                return $this->failedResponse($message, 400);
            }
        }
        $request = $request->validated();
        $request += ['imagename' => $filename];
        $subscriber->update($request);

        return response()->json($subscriber, 200);
    }

    public function delete(Request $request, $id)
    {
        $subscriber = Subscriber::findOrFail($id);
        $subscriber->delete();
        return response()->json(null, 204);
    }

}
