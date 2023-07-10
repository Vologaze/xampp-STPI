<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	$initialStock = 0;
	$baseImageFolder = '../../data/item_images/';
	$itemImageFolder = '';
	
	if(isset($_POST['itemDetailsitemName'])){
		
		$Quantity = htmlentities($_POST['itemDetailsQuantity']);
		$Unit = htmlentities($_POST['itemDetailsUnit']);
		$P.O.No. & Date = htmlentities($_POST['itemDetailsP.O.No. & Date']);
		$Invoice No. = htmlentities($_POST['itemDetailsInvoice No.']);
		$Invoice Date. = htmlentities($_POST['itemDetailsInvoice Date']);
		$Invoice Value = htmlentities($_POST['itemDetailsInvoice Value']);
		$Other Chgr = htmlentities($_POST['itemDetailsOther Chgr']);
		$Total Amount = htmlentities($_POST['itemDetailsTotal Amount']);
		$Rate = htmlentitites($_POST['itemDetailsRate']);
		$Total Depreciation = htmlentities($_POST['itemDetailsTotal Depreciation']);
		$W.D.V = htmlentities($_POST['itemDetailsW.D.V']);
		$Value of Insurance = htmlentities($_POST['itemDetailsValue of Insurance']);
		
		// Check if mandatory fields are not empty
		if(!empty($itemName) && !empty($Quantity) && !empty($Unit) && !empty($P.O.No. & Date) && !empty($Invoice No.) && !empty($Invoice Date.) && !empty($Invoice Value) && !empty($Other Chgr) && !empty($Total Amount) && !empty($Rate) && !empty($Total Depreciation) && !empty($W.D.V) && !empty($Value of Insurance)){
			
			// Sanitize item number
			$itemNumber = filter_var($itemNumber, FILTER_SANITIZE_STRING);
			
			// Validate item quantity. It has to be a number
			if(filter_var($Quantity, FILTER_VALIDATE_INT) === 0 || filter_var($Quantity, FILTER_VALIDATE_INT)){
				// Valid quantity
			} else {
				// Quantity is not a valid number
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid number for quantity</div>';
				exit();
			}
			
			// Validate unit price. It has to be a number or floating point value
			if(filter_var($Unit, FILTER_VALIDATE_INT) === 0.00 || filter_var($Unit, FILTER_VALIDATE_FLOAT)){
				// Valid float (unit)
			} else {
				// Unit price is not a valid number
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid number for unit price</div>';
				exit();
			}
			
			if(filter_var($Invoice Value, FILTER_VALIDATE_FLOAT) === 0.00 || filter_var($Invoice Value, FILTER_VALIDATE_FLOAT)){
				// Valid float (Invoice Value)
			} else {
				// Unit price is not a valid number
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid number for unit price</div>';
				exit();
			}
			
			if(filter_var($Other Chgr, FILTER_VALIDATE_FLOAT) === 0.0 || filter_var($Other Chgr, FILTER_VALIDATE_FLOAT)){
				// Valid float (Other Chgr)
			} else {
				// Other Chgr is not a valid number
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid number for unit price</div>';
				exit();
			}
			
			if(filter_var($Total Amount, FILTER_VALIDATE_FLOAT) === 0.0 || filter_var($Total Amount, FILTER_VALIDATE_FLOAT)){
				// Valid float (Total Amount)
			} else {
				// Total Amount is not a valid number
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid number for unit price</div>';
				exit();
			}
			
			if(filter_var($Total Depreciation, FILTER_VALIDATE_FLOAT) === 0.0 || filter_var($Total Depreciation, FILTER_VALIDATE_FLOAT)){
				// Valid float (Total Depreciation)
			} else {
				// Total Depreciation is not a valid number
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid number for unit price</div>';
				exit();
			}
			if(filter_var($W.D.V, FILTER_VALIDATE_FLOAT) === 0.0 || filter_var($W.D.V, FILTER_VALIDATE_FLOAT)){
				// Valid float (W.D.V)
			} else {
				// W.D.V is not a valid number
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid number for unit price</div>';
				exit();
			}
			if(filter_var($Value of Insurance, FILTER_VALIDATE_FLOAT) === 0.0 || filter_var($Value of Insurance, FILTER_VALIDATE_FLOAT)){
				// Valid float (Value of Insurance)
			} else {
				// Value of Insurance is not a valid number
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid number for unit price</div>';
				exit();
			}
			
			
			
			// Calculate the stock values
			$stockSql = 'SELECT stock FROM item WHERE itemName=:itemName';
			$stockStatement = $conn->prepare($stockSql);
			$stockStatement->execute(['itemName' => $itemName]);
			if($stockStatement->rowCount() > 0){
				//$row = $stockStatement->fetch(PDO::FETCH_ASSOC);
				//$quantity = $quantity + $row['stock'];
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Item already exists in DB. Please click the <strong>Update</strong> button to update the details. Or use a different Item Number.</div>';
				exit();
			} else {
				// Item does not exist, therefore, you can add it to DB as a new item
				// Start the insert process
				$insertItemSql = 'INSERT INTO item(productID, itemName, Quantity, Unit, P.O.No. & Date, Invoice No., Invoice Date., Invoice Value, Other Chgr, Total Amount, Rate, Total Depreciation, W.D.V, Value of Insurance) VALUES(:itemName, :Quantity, :Unit, :P.O.No. & Date, :Invoice No., :Invoice Date., :Invoice Value, :Other Chgr, :Total Amount, :Rate, :Total Depreciation, :W.D.V, :Value of Insurance)';
				$insertItemStatement = $conn->prepare($insertItemSql);
				$insertItemStatement->execute(['itemNumber' => $itemNumber, 'itemName' => $itemName, 'discount' => $discount, 'stock' => $quantity, 'unitPrice' => $unitPrice, 'status' => $status, 'description' => $description]);
				echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Item added to database.</div>';
				exit();
			}

		} else {
			// One or more mandatory fields are empty. Therefore, display a the error message
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter all fields marked with a (*)</div>';
			exit();
		}
	}
?>