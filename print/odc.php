<?php
		require_once("../application/config/database.php");
		$hostname = $db['default']['hostname'];
		$database = $db['default']['database'];
		$username = $db['default']['username'];
		$password = $db['default']['password'];
		$conn = new mysqli($hostname,$username,$password,$database);
		if ($conn->connect_error) {
    				die("Connection failed: " . $conn->connect_error);
		} 
		$masterdata["odc_number"]=$_GET["odc_no"];
		$sql = "select * from company_setting";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
   			 // output data of each row
   			 while($row = $result->fetch_assoc()) {
				$masterdata["company_name"]=$row["company_name"];
				$masterdata["company_address"]=$row["company_address"];
				$masterdata["company_state"] = "Haryana";
				$masterdata["company_country"] = "India";
				$masterdata["company_city"] = $row["company_city"];
				$masterdata["company_contact_number"] = $row["company_contact_number"];
				$masterdata["company_gstin"] = $row["company_gstin"];
				$masterdata["company_email_id"] = $row["company_email_id"];
			}
		}
		if(isset($_GET["odc_no"])){
			
			$odc_type = "";
			$odc_remarks = "";
			$shipping_address="";
			$state_name = "";
			$country_name = "";
			$client_name = "";
			$client_company = "";
			$client_gstn = "";
			$city_name = "";
			$odc_date = "";
			$idc_ref = "";
			$idc_id = "";
			$vehicle_no = "";
			$client_id = "";
			$odc_challan_no = "";
			$odcmaster_query = "SELECT cm.client_id,odcm.vehicle_no, odcm.shipping_city,odcm.odc_master_id, odcm.odc_type, odcm.odc_remarks, odcm.fk_idc_id,odcm.shipping_address, sm.state_name, com.country_name, cm.client_name, cm.client_company_name, cm.client_gstn, odcm.date, odcm.odc_challan_no FROM odc_master odcm, client_master cm, country_master com, state_master sm WHERE odcm.fk_client_id = cm.client_id AND odcm.shipping_state = sm.state_id AND odcm.shipping_country = com.country_id and odcm.odc_master_id=". $_GET["odc_no"];
			$odc_result = $conn->query($odcmaster_query);
			if($odc_result->num_rows > 0){
				while($row = $odc_result->fetch_assoc()) {
					$client_name = $row["client_name"];
					$client_company = $row["client_company_name"];
					$client_gstn = $row["client_gstn"];
					$odc_type = $row["odc_type"];
					$odc_remarks = $row["odc_remarks"];
					$shipping_address = $row["shipping_address"];
					$state_name = $row["state_name"];
					$country_name = $row["country_name"];
					$city_name = $row["shipping_city"];
					$odc_date = $row["date"];
					$idc_id = $row["fk_idc_id"];
					$vehicle_no = $row["vehicle_no"];
					$client_id = $row["client_id"];
					$odc_challan_no = $row["odc_challan_no"];
				}

			}
		}

?>


<?php 
		$odc_count_query="select distinct odc_seq_number from odc_product_details where fk_odc_master_id =".$_GET["odc_no"];
		$odc_count_result = $conn->query($odc_count_query);
		$odc_count=0;
		$idc_seq=array();
	//	echo $odc_count_query;
		while($odc_row=$odc_count_result->fetch_assoc())
		{
			
			$odc_count++;
			$idc_seq[$odc_count]=$odc_row["odc_seq_number"];
		}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Outward Challan</title>
    <link rel="stylesheet" href="style.css" media="all" />
  </head>
  <body>
<?php for($type=0;$type<3;$type++)
		{
?>
<?php for($o=1;$o<=$odc_count;$o++)
		{
			$idc_ch=array();
	//		print_r($idc_seq);
			$distinct_idc_query = "select distinct a.fk_idc_id,b.idc_challan_no from odc_product_details a, idc_master b where odc_seq_number =".$idc_seq[$o]." and a.fk_idc_id=b.idc_id and fk_odc_master_id =".$_GET["odc_no"];
	//		echo $distinct_idc_query;
	//		die();
			$distinct_idc_result = $conn->query($distinct_idc_query);
			$idc_count=0;
			while($idc_row = $distinct_idc_result->fetch_assoc())
			{
				$idc_id[$idc_count]=$idc_row["fk_idc_id"];
				
				$idc_ch[$idc_count]=$idc_row["idc_challan_no"];
				$idc_count++;
			}
			$challan_product_query = "select idcm.idc_challan_no, pm.product_name, sum(odcpd.quantity) as quantity  from odc_product_details odcpd, idc_master idcm, product_master pm where odcpd.fk_idc_id = idcm.idc_id and odcpd.fk_product_master_id = pm.product_master_id and odc_seq_number =".$idc_seq[$o]." and fk_odc_master_id =".$_GET["odc_no"]." group by  idcm.idc_challan_no, pm.product_name order by 2,1";

?>
    <header class="clearfix">
      <div id="logo">
        <img src="logo.png">
      </div>
      <div id="company">

<?php if($type==0) 
			{ 
			echo "<u><h2 class='name'>Original for Recipient</h2></u>"; 
			} 
		else if($type==1) 
		{ echo "<u><h2 class=name>Duplicate for Supplier</h2></u>"; 
		}
		else if($type==2) 
		{ echo "<u><h2 class=name>Triplicate for Transporter</h2></u>"; 
		}?>
      <div><?php echo $masterdata["company_name"]; ?></div>
	 <div><?php echo $masterdata["company_address"].", ".$masterdata["company_city"].", ".$masterdata["company_state"].", ".$masterdata["company_country"]; ?></div>
	 <div><?php echo "GSTIN : ".$masterdata["company_gstin"]." Contact Number : ".$masterdata["company_contact_number"]; ?></div>
      </div>
      </div>
    </header>
    <main>
      <div id="details" class="clearfix">
        <div id="client">
          <div class="to">CHALLAN TO:</div>
	  <h2 class="name"><?php echo $client_company; ?></h2>
	  <div class="address"><?php echo $shipping_address.", ".$city_name.", ".$state_name.", ".$country_name; ?></div>
	  <div class="email"><?php echo "<b>GSTIN : </b>".$client_gstn; ?></div>

        </div>
        <div id="invoice">
	<h1>Challan # <?php 
					echo $odc_challan_no."/".$o; 
			?></h1>
	<div class="date">Challan Date : <?php echo $odc_date; ?></div>
          <div class="date">IDC Ref #: <?php for($m=0;$m<$idc_count;$m++){ echo $idc_ch[$m].", "; } ?></div>
        </div>
      </div>
      <h4>Goods Details</h4>
	<?php
		$items_sql = "SELECT odcpd.fk_product_master_id, odcm.odc_master_id, pm.product_name, odcpd.odc_seq_number, sum(odcpd.quantity) total_quantity, sum(odcpd.total_price) total_cost, sum(odcpd.job_work_price) total_jobwork_cost FROM odc_master odcm, odc_product_details odcpd, product_master pm WHERE odcpd.fk_odc_master_id = odcm.odc_master_id AND pm.product_master_id = odcpd.fk_product_master_id AND odcm.odc_master_id =".$masterdata["odc_number"]." and odcpd.odc_seq_number = ".$idc_seq[$o]." and fk_odc_master_id =".$_GET["odc_no"]." group by odcm.odc_master_id, pm.product_name, odcpd.odc_seq_number ";
			file_put_contents("test.txt", " $items_sql");
			
			$items_res = $conn->query($items_sql);
?>	
      <table border="0" cellspacing="0" cellpadding="0" frame=box>
        <thead>
          <tr>
            <td class="no">Sr #</td>
	    <td class="desc">DESCRIPTION</td>
	    <td class="qty">HSN</td>
            <td class="unit">UNIT PRICE</td>
	    <td class="qty">QUANTITY</td>
	    <td class="unit">GOODS COST</td>
            <td class="total">JOBWORK COST</td>
          </tr>
        </thead>
	<tbody>
<?php
		$i = 0;
		$subtotal = 0;
		$jobwork = 0;
		while($row=$items_res->fetch_assoc())
		{ $i++;
		$subtotal = $subtotal + $row["total_cost"];
		$jobwork = $jobwork+$row["total_jobwork_cost"]; 
		$hsnc = "NA";

		$hsn_query = "select hsn_code from product_hsn_mapping where fk_product_id =".$row["fk_product_master_id"];

		$hsn_query_result = $conn->query($hsn_query);
		while($hsn_row = $hsn_query_result->fetch_assoc())
		{
			$hsnc = $hsn_row["hsn_code"];
		}

		?>
		
          <tr>
	  <td class="no"><?php echo $i; ?></td>
	  <td class="desc"><?php echo $row["product_name"]; ?></td>
	  <td class="qty"><?php echo $hsnc; ?></td>
	  <td class="unit"><?php echo round($row["total_cost"]/$row["total_quantity"],2); ?></td>
	  <td class="qty"><?php echo $row["total_quantity"]; ?></td>
	  <td class="unit"><?php echo round($row["total_cost"],2); ?></td>
	  <td class="total"><?php echo round($row["total_jobwork_cost"],2); ?></td>
	  </tr>

	<?php } ?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="3"></td>
            <td colspan="3">SUBTOTAL GOODS</td>
	    <td><?php echo round($subtotal,2); ?></td>
          </tr>
          <tr>
            <td colspan="3"></td>
            <td colspan="3">SUBTOTAL JOBWORK</td>
            <td><?php echo round($jobwork,2); ?></td>
          </tr>
          <tr>
            <td colspan="3"></td>
            <td colspan="3">GRAND TOTAL</td>
            <td><?php echo round($subtotal+$jobwork,2); ?></td>
          </tr>
	</tfoot>

      </table>
	<table frame=box cellspacing="0" cellpadding="0">
	<tr>
		<td>IDC Challan No.</td>
		<td>Product Name</td>
		<td>Quantity</td>
	</tr>
<?php 	//echo $challan_product_query;
		$challan_product_result = $conn->query($challan_product_query);
	while($cprow = $challan_product_result->fetch_assoc())
	{
		echo "<tr><td>".$cprow["idc_challan_no"]."</td>";
		echo "<td>".$cprow["product_name"]."</td>";
		echo "<td>".$cprow["quantity"]."</td></tr>";
	}
?>
	

	</table>
 	<table border="0" cellspacing="0" cellpadding="0" frame=box>
	<tr><td class="desc">Vehicle Number : <?php echo $vehicle_no; ?></td>
		<td>Dispatch Date : <?php echo $odc_date; ?></td></tr>
	<tr><td class="desc">Received the above goods in order and good condition<br><br><br><br>Receiver's Signature</td>
		<td>For A. K. International<br><br><br><br>Auth. Singatory</td>
	</table>
		
      <div id="notices">
        <div>Thank You.</div>
        <div class="notice">In Case of any issues feel free to contact us at operations@akinternational.net.</div>
      </div>
    </main>
<p style="page-break-before: always">
<?php } } ?>
  </body>
</html>
