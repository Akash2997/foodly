<?php
	session_start();
	if(!isset($_SESSION['log_email'])){
		header("location:index.php");
	}
	$log_email=$_SESSION['log_email'];
	include 'connection.php';


?>
<!DOCTYPE html>
<html>
<head>
	<title>order status</title>
 <link rel="shortcut icon" href="images\logo.png" type="image/png">
    <link rel="stylesheet" type="text/css" href="css\order_status.css">
</head>
<body style="font-family: Helvetica;">
	 <div class="topnav">
        <img src="images/header_logo.jpeg" height= "45px" width = "150px" align="left"></div>


	<?php
        $q="select * from orders where order_by='$log_email';";
        $q1=mysqli_query($con,$q);
    ?>
    <div>
        <?php
        while ($row=mysqli_fetch_array($q1)){
           if($row['status']!="delivered" && $row['status']!="declined"){
            ?>
                <div>
                    order id:<?php echo $row['order_id']; ?>
                    <br>ordered from:<?php $order_from=$row['order_from'];
                    	echo $order_from; ?>
                    <br>items:<br><?php 
					$item_list  = preg_split("/ /", $row['items']);
					for($i=0;$i<sizeof($item_list);$i=$i+2){
						$q_itm="SELECT name FROM menu where sno='$item_list[$i]' and restaurant_id='$order_from' ;";
						$q1_itm=mysqli_query($con,$q_itm);
						$row_itm=mysqli_fetch_array($q1_itm);
						echo "<div>&nbsp;&nbsp;".$row_itm['name']." &times; ".$item_list[$i+1]."</div>";
			   		}
                    ?>
                    total:<?php echo $row['total']; ?>
                    <br>address:<?php echo $row['address']; ?>
                    <br>rider:<?php echo $row['rider']; ?>
                    <br>instance:<?php echo $row['instance']; ?>
                    <br>status:<?php echo $row['status']; ?>
                </div>
                <br>    
        <?php }
        }
        ?>
    </div>

     <div class="navbar">
       
       
        
        <div class="copy">&copy; foodly</div>
        </div>
</body>
</html>