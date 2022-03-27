<?php include("conn.php");?>
<?php include("message.php");?>
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