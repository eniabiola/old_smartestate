<?php include("conn.php");?>
<?php include("message.php");?>
<?php
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $qry = "SELECT * FROM `billings` WHERE bill_target = 'New Residents Only' AND statusbill = 'Active' ORDER BY id";
    $stmt = $db->query($qry);
    $row_edt = $stmt->fetch(PDO::FETCH_ASSOC);
    $bill_target = $row_edt['bill_target'];
    
    $qry1 = "SELECT * FROM residents WHERE tenant = '$tenant' AND regstatus = 'Active' AND (id = '$id' OR idsession = '$id') AND id NOT IN 
                (SELECT surname FROM invoices WHERE tenant = '$tenant' AND invoiceno = '$invoiceno') ORDER BY id DESC";
    $stmt1 = $db->query($qry1);
    
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

?>