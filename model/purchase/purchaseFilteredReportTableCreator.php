<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	$uPrice = 0;
	$qty = 0;
	$totalPrice = 0;
	
	if(isset($_POST['startDate'])){
		$startDate = htmlentities($_POST['startDate']);
		$endDate = htmlentities($_POST['endDate']);
		
		$purchaseFilteredReportSql = 'SELECT * FROM purchase WHERE purchaseDate BETWEEN :startDate AND :endDate';
		$purchaseFilteredReportStatement = $conn->prepare($purchaseFilteredReportSql);
		$purchaseFilteredReportStatement->execute(['startDate' => $startDate, 'endDate' => $endDate]);

		$output = '<table id="purchaseFilteredReportsTable" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
					<thead>
						<tr>
							<th>Purchase ID</th>
							<th>itemName</th>
							<th>Quantity</th>
							<th>Unit</th>
							<th>P.O.No. & Date</th>
							<th>Invoice No.</th>
							<th>Invoice Date.</th>
							<th>Invoice Value</th>
							<th>Other Chgr</th>
							<th>Total Amount</th>
							<th>Rate</th>
							<th>Total Depreciation</th>
							<th>W.D.V</th>
							<th>Value of Insurance</th>
						</tr>
					</thead>
					<tbody>';
		
		// Create table rows from the selected data
		while($row = $purchaseFilteredReportStatement->fetch(PDO::FETCH_ASSOC)){
			
		
			$output .= '<tr>' .
							'<td>' . $row['purchaseID'] . '</td>' .
							'<td>' . $row['itemName'] . '</td>' .
							'<td>' . $row['Quantity'] . '</td>' .
							'<td>' . $row['Unit'] . '</td>' .
							'<td>' . $row['P.O.No. & Date'] . '</td>' .
							'<td>' . $row['Invoice No.'] . '</td>' .
							'<td>' . $row['Invoice Date.'] . '</td>' .
							'<td>' . $row['Invoice Value'] . '</td>' .
							'<td>' . $row['Other Chgr'] . '</td>' .
							'<td>' . $row['Total Amount'] . '</td>' .
							'<td>' . $row['Rate'] . '</td>' .
							'<td>' . $row['Total Depreciation'] . '</td>' .
							'<td>' . $row['W.D.V'] . '</td>' .
							'<td>' . $row['Value of Insurance'] . '</td>' .
						'</tr>';
		}
		
		$purchaseFilteredReportStatement->closeCursor();
		
		$output .= '</tbody>
						<tfoot>
							<tr>
								<th>Purchase ID</th>
								<th>itemName</th>
								<th>Quantity</th>
								<th>Unit</th>
								<th>P.O.No. & Date</th>
								<th>Invoice No.</th>
								<th>Invoice Date.</th>
								<th>Invoice Value</th>
								<th>Other Chgr</th>
								<th>Total Amount</th>
								<th>Rate</th>
								<th>Total Depreciation</th>
								<th>W.D.V</th>
								<th>Value of Insurance</th>
							</tr>
						</tfoot>
					</table>';
		echo $output;
	}
?>


