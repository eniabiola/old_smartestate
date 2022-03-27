<?php include("conn.php");?>
<?php include("message.php");?>
<?php
$qry = "SELECT * FROM `billings` WHERE statusbill = 'Active' ORDER BY id";
$stmt = $db->query($qry);
while($row_edt = $stmt->fetch(PDO::FETCH_ASSOC)){
    $id = $row_edt['id'];
    $tenant = $row_edt['tenant'];
    $billname = $row_edt['billname'];
    $title = "$billname Bill is Due.";
    $qry111 = "SELECT * FROM `subscribers` WHERE id = '$tenant'";
    $stmt111 = $db->query($qry111);
    $row_edt111 = $stmt111->fetch(PDO::FETCH_ASSOC);
    $msgorg = $row_edt111['businessname'];
    $user = $row_edt['user'];
    $frequency = $row_edt['frequency'];
    $bill_target = $row_edt['bill_target'];
    $amount = $row_edt['amount'];
    $invoiceno = $row_edt['id'];
    $billitemcode = $row_edt['billitemcode'];
    $msg = "";
    if($frequency == "One-Off"){
        $msg = "";
        if($bill_target == "Current Residents"){
            $qry1 = "SELECT COUNT(*) AS rescount FROM residents WHERE tenant = '$tenant' AND regstatus = 'Active' AND id NOT IN 
            (SELECT surname FROM invoices WHERE tenant = '$tenant' AND invoiceno = '$invoiceno')";
        $stmt1 = $db->query($qry1);
        $row_edt1 = $stmt1->fetch(PDO::FETCH_ASSOC);
        $rescount = $row_edt1['rescount'];
        if($rescount == 0){
            $qry22 = "UPDATE `billings` SET statusbill = 'Closed' WHERE statusbill = '$id'";
            $stmt22 = $db->query($qry22);
        }
        }

        $qry1 = "SELECT * FROM residents WHERE tenant = '$tenant' AND regstatus = 'Active' AND id NOT IN 
            (SELECT surname FROM invoices WHERE tenant = '$tenant' AND invoiceno = '$invoiceno') ORDER BY id DESC";
        $stmt1 = $db->query($qry1);
        while($row_edt1 = $stmt1->fetch(PDO::FETCH_ASSOC)){
            $msg = "";
            $surname = $row_edt1['id'];
            $to = $row_edt1['email'];
            $name = $row_edt1['surname']." ".$row_edt1['othername'];
            $msg .= "Dear $name<br><br>";
            $msg .= "This is to notify you that your invoice for $billname is now due.<br>";
            $msg .= "Amount Due: $amount<br><br>";
            $msg .= "Best Regards";
            send_email($msgorg,$to,$title,$msg);
            $qry2 = "INSERT INTO invoices (`date`,invoiceyear,invoicemonth,invoiceday,surname,invoiceno,billitemcode,amount,`invoicestatus`,tenant,user) 
            VALUES (CURDATE(),'All','All','All','$surname','$invoiceno','$billitemcode','$amount','Not Paid','$tenant','$user')";
            $stmt2 = $db->query($qry2);
        }
    } elseif($frequency == "Yearly"){
        $msg = "";
         $qry1 = "SELECT * FROM residents WHERE tenant = '$tenant' AND regstatus = 'Active' AND id NOT IN 
            (SELECT surname FROM invoices WHERE tenant = '$tenant' AND invoiceno = '$invoiceno' 
                AND invoiceyear = YEAR(CURDATE())) ORDER BY id";
        $stmt1 = $db->query($qry1);
        while($row_edt1 = $stmt1->fetch(PDO::FETCH_ASSOC)){
            $msg = "";
            $surname = $row_edt1['id'];
            $to = $row_edt1['email'];
            $name = $row_edt1['surname']." ".$row_edt1['othername'];
            $msg .= "Dear $name<br><br>";
            $msg .= "This is to notify you that your invoice for $billname is now due.<br>";
            $msg .= "Amount Due: $amount<br><br>";
            $msg .= "Best Regards";
            send_email($msgorg,$to,$title,$msg);
            $qry2 = "INSERT INTO invoices (`date`,invoiceyear,invoicemonth,invoiceday,surname,invoiceno,billitemcode,amount,`invoicestatus`,tenant,user) 
            VALUES (CURDATE(),YEAR(CURDATE())),'Year','Year','$surname','$invoiceno','$billitemcode','$amount','Not Paid','$tenant','$user')";
            $stmt2 = $db->query($qry2);
        }
    } elseif($frequency == "Quarterly"){
        $msg = "";
        $qry0 = "SELECT * FROM billings_payperiod WHERE frequency = 'Quarterly' AND payperiod = MONTH(CURDATE())";
        $stmt0 = $db->query($qry0);
        $row_edt0 = $stmt0->fetch(PDO::FETCH_ASSOC);
        $invoiceday = $row_edt0['invoiceday'];
        if($invoiceday != ""){
            $qry1 = "SELECT * FROM residents WHERE tenant = '$tenant' AND regstatus = 'Active' AND id NOT IN 
            (SELECT surname FROM invoices WHERE tenant = '$tenant' AND invoiceno = '$invoiceno' 
                AND invoiceyear = YEAR(CURDATE()) AND invoicemonth = MONTH(CURDATE())) ORDER BY id DESC";
            $stmt1 = $db->query($qry1);
            while($row_edt1 = $stmt1->fetch(PDO::FETCH_ASSOC)){
                $msg = "";
                $surname = $row_edt1['id'];
                $to = $row_edt1['email'];
                $name = $row_edt1['surname']." ".$row_edt1['othername'];
                $msg .= "Dear $name<br><br>";
                $msg .= "This is to notify you that your invoice for $billname is now due.<br>";
                $msg .= "Amount Due: $amount<br><br>";
                $msg .= "Best Regards";
                send_email($msgorg,$to,$title,$msg);
                $qry2 = "INSERT INTO invoices (`date`,invoiceyear,invoicemonth,invoiceday,surname,invoiceno,billitemcode,amount,`invoicestatus`,tenant,user) 
                VALUES (CURDATE(),YEAR(CURDATE())),MONTH(CURDATE()),'Quarter','$surname','$invoiceno','$billitemcode','$amount','Not Paid','$tenant','$user')";
                $stmt2 = $db->query($qry2);
            }       
        }
    } elseif($frequency == "Monthly"){
        $msg = "";
        $qry0 = "SELECT * FROM billings_payperiod WHERE frequency = 'Monthly' AND payperiod = MONTH(CURDATE())";
        $stmt0 = $db->query($qry0);
        $row_edt0 = $stmt0->fetch(PDO::FETCH_ASSOC);
        $invoiceday = $row_edt0['invoiceday'];
        if($invoiceday != ""){
            $qry1 = "SELECT * FROM residents WHERE tenant = '$tenant' AND regstatus = 'Active' AND id NOT IN 
            (SELECT surname FROM invoices WHERE tenant = '$tenant' AND invoiceno = '$invoiceno' 
                AND invoiceyear = YEAR(CURDATE()) AND invoicemonth = MONTH(CURDATE())) ORDER BY id DESC";
            $stmt1 = $db->query($qry1);
            while($row_edt1 = $stmt1->fetch(PDO::FETCH_ASSOC)){
                $msg = "";
                $surname = $row_edt1['id'];
                $to = $row_edt1['email'];
                $name = $row_edt1['surname']." ".$row_edt1['othername'];
                $msg .= "Dear $name<br><br>";
                $msg .= "This is to notify you that your invoice for $billname is now due.<br>";
                $msg .= "Amount Due: $amount<br><br>";
                $msg .= "Best Regards";
                send_email($msgorg,$to,$title,$msg);
                $qry2 = "INSERT INTO invoices (`date`,invoiceyear,invoicemonth,invoiceday,surname,invoiceno,billitemcode,amount,`invoicestatus`,tenant,user) 
                VALUES (CURDATE(),YEAR(CURDATE())),MONTH(CURDATE()),'Month','$surname','$invoiceno','$billitemcode','$amount','Not Paid','$tenant','$user')";
                $stmt2 = $db->query($qry2);
               
            }       
        }
    } elseif($frequency == "Daily"){
        $msg = "";
        $qry0 = "SELECT * FROM billings_payperiod WHERE frequency = 'Daily' AND payperiod = DAYOFYEAR(CURDATE())";
        $stmt0 = $db->query($qry0);
        $row_edt0 = $stmt0->fetch(PDO::FETCH_ASSOC);
        $invoiceday = $row_edt0['invoiceday'];
        if($invoiceday != ""){
           $qry1 = "SELECT * FROM residents WHERE tenant = '$tenant' AND regstatus = 'Active' AND id NOT IN 
            (SELECT surname FROM invoices WHERE tenant = '$tenant' AND invoiceno = '$invoiceno' 
                AND invoiceyear = YEAR(CURDATE()) AND invoicemonth = MONTH(CURDATE()) AND invoiceday = DAYOFYEAR(CURDATE())) ORDER BY id DESC";
            $stmt1 = $db->query($qry1);
            while($row_edt1 = $stmt1->fetch(PDO::FETCH_ASSOC)){
                $msg = "";
                $surname = $row_edt1['id'];
                $to = $row_edt1['email'];
                $name = $row_edt1['surname']." ".$row_edt1['othername'];
                $msg .= "Dear $name<br><br>";
                $msg .= "This is to notify you that your invoice for $billname is now due.<br>";
                $msg .= "Amount Due: $amount<br><br>";
                $msg .= "Best Regards";
                send_email($msgorg,$to,$title,$msg);
                $qry2 = "INSERT INTO invoices (`date`,invoiceyear,invoicemonth,invoiceday,surname,invoiceno,billitemcode,amount,`invoicestatus`,tenant,user) 
                VALUES (CURDATE(),YEAR(CURDATE()),MONTH(CURDATE()),DAYOFYEAR(CURDATE()),'$surname','$invoiceno','$billitemcode','$amount','Not Paid','$tenant','$user')";
                $stmt2 = $db->query($qry2);
            }       
        }
    }
}
?>
<?php
$qry = "SELECT * FROM `invoices` WHERE invoicestatus = 'Not Paid' ORDER BY id";
$stmt = $db->query($qry);
while($row_edt = $stmt->fetch(PDO::FETCH_ASSOC)){
    $id = $row_edt['surname'];
    $qry = "SELECT invoices.*,billings.billname AS billname,billings.amount AS amount 
	    FROM invoices,billings WHERE invoices.invoiceno = billings.id AND invoices.surname = '$id' 
	    AND invoices.invoicestatus = 'Not Paid' ORDER BY billings.amount DESC";
		$stmt = $db->query($qry);
		while($row_edt = $stmt->fetch(PDO::FETCH_ASSOC)){
		    $iddd = uniqid('', true);
		    $transid = $iddd;
            $walletid = $row_edt['surname'];
            $surname = $row_edt['billname'];
            $debit = $row_edt['amount'];
            $transref = $row_edt['id'];
            $transtatus = 'Successful';
            $tenant = $row_edt['tenant'];
            $user = $row_edt['user'];
            $qry33 = "SELECT sum(credit) - sum(debit)  balance FROM wallets WHERE walletid = '$id' AND transtatus = 'Successful'";
		    $stmt33 = $db->query($qry33);
		    $row_edt33 = $stmt33->fetch(PDO::FETCH_ASSOC);
		    $walletbal = $stmt33['balance'];
		    if(($walletbal > $debit) || ($walletbal == $debit)){
    		    $tenantuser = "INSERT INTO wallets (`date`,transid,walletid,surname,debit,transref,`transtatus`,tenant,user) 
                VALUES (CURDATE(),'$transid','$walletid','$surname','$debit','$transref','$transtatus','$tenant','$user')";
                $db->query($tenantuser);
                $tenantuser = "UPDATE invoices SET invoicestatus = 'Paid' WHERE id = '$transref'";
                $db->query($tenantuser); 
		    }
		}
}
?>