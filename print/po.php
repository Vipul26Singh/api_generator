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
		$masterdata["po_number"]=$_GET["po_no"];
		$sql = "select * from company_setting";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
   			 // output data of each row
   			 while($row = $result->fetch_assoc()) {
				$masterdata["company_name"]=$row["company_name"];
				$masterdata["company_address"]=$row["company_address"];
				$masterdata["company_state"] = $row["company_state"];
				$masterdata["company_country"] = $row["company_country"];
				$masterdata["company_city"] = $row["company_city"];
				$masterdata["company_contact_number"] = $row["company_contact_number"];
				$masterdata["company_gstin"] = $row["company_gstin"];
				$masterdata["company_email_id"] = $row["company_email_id"];
			}
		}


		//Query to get the detail of the PO
		$sql_po_master = "select * from po_master where po_master_id = ".$masterdata["po_number"];
	
		$result_pomaster = $conn->query($sql_po_master);
		$vendor_id="";
		$po_date="";
		$exp_date="";

		
			while($row = $result_pomaster->fetch_assoc())
			{	
				$vendor_id = $row["fk_vendor_id"];
				$po_date = $row["po_date"];
				$exp_date = $row["expected_delivery_date"];
			}
		
		$vendor_query = "select vm.vendor_name, vm.vendor_company_name, vm.vendor_address, vm.vendor_contact_number, vm.vendor_address_city, sm.state_name, cm.country_name, vm.vendor_gstn from vendor_master vm, state_master sm, country_master cm where vm.vendor_address_country = cm.country_id and vm.vendor_address_state = sm.state_id and vm.vendor_mast_id=".$vendor_id;
		
		
		$vendor_name;
		$vendor_company;
		$vendor_city;
		$vendor_state;
		$vendor_country;
		$vendor_contact;
		$vendor_gstn;	
		$vendor_address;	

		$vendor_result = $conn->query($vendor_query);
		while($row = $vendor_result->fetch_assoc())
		{
			$vendor_name = $row["vendor_name"];
			$vendor_company = $row["vendor_company_name"];
			$vendor_address = $row["vendor_address"];
			$vendor_city = $row["vendor_address_city"];
			$vendor_state = $row["state_name"];
			$vendor_country = $row["country_name"];
			$vendor_contact = $row["vendor_contact_number"];
			$vendor_gstn = $row["vendor_gstn"];

		}		
	
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Purchase Order</title>
    <link rel="stylesheet" href="style.css" media="all" />
  </head>
  <body>
    <header class="clearfix">
      <div id="logo">
        <img src="logo.png">
      </div>
      <div id="company">
        <h2 class="name"><?php echo $masterdata["company_name"]; ?></h2>
        <div><?php echo $masterdata["company_address"].", ".$masterdata["company_city"].", ".$masterdata["company_state"].", ".$masterdata["company_country"]; ?></div>
        <div><?php echo $masterdata["company_contact_number"]; ?></div>
        <div><?php echo $masterdata["company_email_id"]; ?></div>
      </div>
      </div>
    </header>
    <main>
      <div id="details" class="clearfix">
        <div id="client">
          <div class="to">Vendor</div>
          <h2 class="name"><?php echo $vendor_company; ?></h2>
          <div class="address"><?php echo $vendor_address.", ".$vendor_city.", ".$vendor_state.", ".$vendor_country; ?></div>
          <div class="email"><?php echo $vendor_contact; ?></div><br>
	  <div class="to">Ship To</div>
          <h2 class="name"><?php echo $masterdata["company_name"]; ?></h2>
          <div class="address"><?php echo $masterdata["company_address"].", ".$masterdata["company_city"].", ".$masterdata["company_state"].", ".$masterdata["company_country"]; ?></div>
          <div class="email"><?php echo $masterdata["company_contact_number"]; ?></div>
        </div>
        <div id="invoice">
          <h1>PO #<?php echo $masterdata["po_number"]; ?></h1>
          <div class="date">Purchase Order Date: <?php echo $po_date; ?></div>
          <div class="date">Expected Delivery Date: <?php echo $exp_date;?></div>
        </div>
      </div>
      <table border="0" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th class="no">ITEM#</th>
            <th class="desc">DESCRIPTION</th>
	    <th class="qty">HSN
            <th class="unit">UNIT PRICE</th>
            <th class="qty">QUANTITY</th>
	    <th class="unit">Tax</th>
            <th class="total">TOTAL</th>
          </tr>
        </thead>
        <tbody>
	<?php
		$item_query="select pm.product_name, pm.product_master_id,tm.tax_class_name, tm.cgst, tm.sgst, tm.igst, ppd.quantity, ppd.total_cost from po_master pom, po_product_detail ppd, product_master pm, tax_master tm where pm.product_master_id = ppd.fk_product_id and pom.po_master_id =".$masterdata["po_number"]." and pm.fk_tax_id = tm.tax_id and ppd.fk_po_master_id = pom.po_master_id";
		$item_query_result = $conn->query($item_query);
		$i=0;
		$total_tax=0;
		$subtotal = 0;
//		echo $item_query."<br>";

		while($row = $item_query_result -> fetch_assoc())
		{
			$subtotal=$subtotal+$row["total_cost"];
			$i++;
			$hsnc = "NA";
			$hsn_sql = "select hsn_code from product_hsn_mapping where fk_product_id = ".$row["product_master_id"];
			$hsn_sql_result = $conn->query($hsn_sql);
			if($hsn_sql_result->num_rows>0)
			{
				while($hsnrow = $hsn_sql_result -> fetch_assoc())
				{
					$hsnc = $row["hsn_code"];
				}
			}


	?>
          <tr>
            <td class="no"><?php echo $i; ?></td>
            <td class="desc"><h3><?php echo $row["product_name"]; ?></h3></td>
            <td class="qty"><?php echo $hsnc; ?></td>
	    <td class="unit"><?php echo $row["total_cost"]/$row["quantity"]; ?></td>
            <td class="qty"><?php echo $row["quantity"]; ?></td>
	    <td class="unit"><?php 
				$tcgst=$row["total_cost"]*$row["cgst"]/100;
				$tsgst=$row["total_cost"]*$row["sgst"]/100;
				$tigst=$row["total_cost"]*$row["igst"]/100;
				$total_tax=$total_tax+$tcgst+$tsgst+$tigst;
				echo "CGST@".$row["cgst"]."% =".$tcgst."<br>"; 
				echo "SGST@".$row["sgst"]."% =".$tsgst."<br>";
				echo "IGST@".$row["igst"]."% =".$tigst;  	
				?></td>
            <td class="total"><?php echo $row["total_cost"]+$tcgst+$tsgst+$tigst; ?></td>
          </tr>
          <?php } ?>
		<?php
			$raw_material_query = "select rm.name, rhm.hsn_code, tm.tax_class_name, tm.cgst, tm.sgst, tm.igst, prd.quantity, prd.total_cost from po_master pom, po_raw_material_detail prd, raw_material rm, tax_master tm, raw_material_hsn_mapping rhm where rm.raw_mat_id = prd.fk_raw_material_id and pom.po_master_id =".$masterdata["po_number"] ." and rm.fk_tax_id=tm.tax_id and prd.fk_po_master_id = pom.po_master_id and rhm.fk_rm_id = rm.raw_mat_id";
//	echo $raw_material_query;
		$rm_result = $conn->query($raw_material_query);
		while($row = $rm_result->fetch_assoc())
		{ 
			$subtotal=$subtotal+$row["total_cost"];
			$i++; ?>
			<tr>
            <td class="no"><?php echo $i; ?></td>
            <td class="desc"><h3><?php echo $row["name"]; ?></h3></td>
            <td class="qty"><?php echo $row["hsn_code"]; ?></td>
	    <td class="unit"><?php echo $row["total_cost"]/$row["quantity"]; ?></td>
            <td class="qty"><?php echo $row["quantity"]; ?></td>
	    <td class="unit"><?php 
				$tcgst=$row["total_cost"]*$row["cgst"]/100;
				$tsgst=$row["total_cost"]*$row["sgst"]/100;
				$tigst=$row["total_cost"]*$row["igst"]/100;
				$total_tax=$total_tax+$tcgst+$tsgst+$tigst;
				echo "CGST@".$row["cgst"]."% =".$tcgst."<br>"; 
				echo "SGST@".$row["sgst"]."% =".$tsgst."<br>";
				echo "IGST@".$row["igst"]."% =".$tigst;  	
				?></td>
            <td class="total"><?php echo $row["total_cost"]+$tcgst+$tsgst+$tigst; ?></td>
          </tr>
		<?php }
	?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="3"></td>
            <td colspan="3">SUBTOTAL</td>
            <td><?php echo $subtotal; ?></td>
          </tr>
          <tr>
            <td colspan="3"></td>
            <td colspan="3">TAX</td>
            <td><?php echo $total_tax; ?></td>
          </tr>
          <tr>
            <td colspan="3"></td>
            <td colspan="3">GRAND TOTAL</td>
            <td><?php echo $subtotal+$total_tax; ?></td>
          </tr>
        </tfoot>
      </table>
      <div id="thanks">Thank you!</div>
      <div id="notices">
        <div>NOTICE:</div>
        <div class="notice">If you have any questions about this purchase order, please contact  [Pooja Singh, Phone -07527045123, pooja.singh@akinternational.net]</div>
      </div>
    </main>
    <footer>
      PO was created on a computer and is valid without the signature and seal.
    </footer>
  </body>
</html>
