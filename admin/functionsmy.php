<?php
include_once("../dbconnection.php");
?>
<?php
$RESULT_TYPE = $_POST["RESULT_TYPE"];
switch ($RESULT_TYPE) {
    case "GET_TOTAL_STOCK":
        $result = getTotalStock();
        echo $result;
        break;
    case "LOGIN":
        $result = login($_POST["USERNAME"], $_POST["PASSWORD"]);
        echo $result;
        break;
    case "INSERT_STOCK":
        $result = insertStock($_POST["PRODUCTNAME"], $_POST["QUANTITY"], $_POST["BOTTLES"], $_POST["PRICEPERBOX"], $_POST["TOTALBILLAMOUNT"], $_POST["AGENCYNAME"], $_POST["BUYDATE"]);
        echo $result;
        break;
    case "SHOW_INSERTED_STOCK":
        $result = getInsertedStock();
        echo $result;
        break;
    case "ADD_PRODUCT_NAME":
        $result = addProductName($_POST["PRODUCTNAME"]);
        echo $result;
        break;
    case "SHOW_INSERTED_PRODUCTLIST":
        $result = showProductName();
        echo $result;
        break;
    case "ADD_AGENCY_NAME":
        $result = addAgencyName($_POST["AGENCYNAME"]);
        echo $result;
        break;
    case "SHOW_INSERTED_AGENCYNAME":
        $result = showInsertedAgencyName();
        echo $result;
        break;
    case "GET_PRODUCT_NAME":
        $result = getProductName();
        echo $result;
        break;
    case "GET_AGENCY_NAME":
        $result = getAgencyName();
        echo $result;
        break;
    case "SELL_RECEIPT":
        $result = getSellReceipt();
        echo $result;
        break;
    case "UPDATE_SELECT_PRODUCT":
        $result = updateSelectProduct();
        echo $result;
        break;
    case "ADD_COUNTER_NAME":
        $result = addCounterName($_POST["COUNTERNAME"]);
        echo $result;
        break;
    case "SHOW_INSERTED_COUNTERNAME":
        $result = showInsertedCounter();
        echo $result;
        break;
    case "GET_TOTAL_QUANITYT_STOCK":
        $result = getQuantityStock();
        echo $result;
        break;
    case "GET_PRODUCT_QUANTITY":
        $result = getProductQuanitity($_POST["PRODUCTNAME"]);
        echo $result;
        break;
    case "ADD_SELL_RECEIPT":
        $result = addSellReceipt($_POST["PRODUCTNAME"], $_POST["QUANTITY"], $_POST["SCHEME"], $_POST["PRICE"], $_POST["BILLAMOUNT"], $_POST["COUNTERNAME"]);
        echo $result;
        break;
    case "GET_TOTAL_STOCK_DASHBOARD":
        $result = getTotalStockDashboard();
        echo $result;
        break;
    case "GET_TODAY_SELL":
        $result = getTodaySell();
        echo $result;
        break;
    case "GET_TODAY_EARNING":
        $result = getTodayEarning();
        echo $result;
        break;
    case "GET_SUM_EARNING":
        $result = getSumEarning();
        echo $result;
        break;
    case "GET_DATA_FOR_CHART":
        $result = getDataForChart();
        echo $result;
        break;
    case "GET_COUNTERSLIST":
        $result = getCounterList();
        echo $result;
        break;
    case "INSERT_bill":
        $result = insertBill($_POST["PRODUCTS"], $_POST["COUNTERNAME"], $_POST["PAYMENTMETHOD"], $_POST["TOTALBILLAMOUNT"]);
        echo $result;
        break;
    case "GET_BILLS":
        $result = getBills();
        echo $result;
        break;

    case "GET_BILL_DETAILS":
        $result = getBillDetails($_POST["BILL_ID"]);
        echo $result;
        break;
}

function getBills()
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM bills ORDER BY bill_date DESC");
    $stmt->execute();
    $result = $stmt->get_result();

    $bills = [];
    while ($row = $result->fetch_assoc()) {
        $bills[] = $row;
    }
    return json_encode($bills);
}

function getBillDetails($billId)
{
    global $conn;

    // Get bill header
    $stmt = $conn->prepare("SELECT * FROM bills WHERE id = ?");
    $stmt->bind_param("i", $billId);
    $stmt->execute();
    $bill = $stmt->get_result()->fetch_assoc();

    // Get bill items
    $stmt = $conn->prepare("SELECT * FROM bill_items WHERE bill_id = ?");
    $stmt->bind_param("i", $billId);
    $stmt->execute();
    $items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    // Get payments
    $stmt = $conn->prepare("SELECT * FROM payments WHERE bill_id = ?");
    $stmt->bind_param("i", $billId);
    $stmt->execute();
    $payments = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    return json_encode([
        'id' => $bill['id'],
        'counter_name' => $bill['counter_name'],
        'total_bill_amount' => $bill['total_bill_amount'],
        'payment_status' => $bill['payment_status'],
        'paid_amount' => $bill['paid_amount'],
        'bill_date' => $bill['bill_date'],
        'items' => $items,
        'payments' => $payments
    ]);
}

function insertBill($products, $counterName, $paymentMethod, $totalBillAmount)
{
    global $conn;
    $conn->begin_transaction();

    try {
        // Insert into bills
        $paymentStatus = ($paymentMethod == 'Unpaid') ? 'Unpaid' : 'Paid';
        $paidAmount = ($paymentMethod == 'Unpaid') ? 0 : $totalBillAmount;

        $stmt = $conn->prepare("INSERT INTO bills (counter_name, total_bill_amount, payment_status, paid_amount, bill_date) VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP)");
        $stmt->bind_param("sdss", $counterName, $totalBillAmount, $paymentStatus, $paidAmount);
        $stmt->execute();
        $bill_id = $conn->insert_id;
        $stmt->close();

        // Insert bill items and sell records
        $productsArray = json_decode($products, true);
        $billItemsJson = json_encode($productsArray); // Encode products array
        foreach ($productsArray as $product) {
            $schemebottlesValue = ($product[3] == '-') ? null : (float)$product[3];

            // Insert into bill_items
            $stmt_item = $conn->prepare("INSERT INTO bill_items (bill_id, productname, quantity, scheme, schemebottles, priceperbox, totalamount) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt_item->bind_param("isissdd", $bill_id, $product[0], $product[1], $product[2], $schemebottlesValue, $product[4], $product[5]);
            $stmt_item->execute();
            $stmt_item->close();

            // Insert into sell
            $stmt_sell = $conn->prepare("INSERT INTO sell (bill_id, productname, quantity, scheme, schemebottles, priceperbox, totalbillamount, countername, paymentmethod, bill_items, sellDate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)");
            $stmt_sell->bind_param("isissddsss", $bill_id, $product[0], $product[1], $product[2], $schemebottlesValue, $product[4], $product[5], $counterName, $paymentMethod, $billItemsJson);
            $stmt_sell->execute();
            $stmt_sell->close();

            //Deduct Scheme and Stock
           if ($product[2] !== '-') {
               //Deduct Stock for main product
               deductstock($product[0], $product[1]);
               //Deduct Scheme Stock
                if ($schemebottlesValue !== null)
                deductSchemeStock($product[2], $schemebottlesValue);  
           }
           else {
                // If no scheme, just deduct stock.
                deductstock($product[0], $product[1]);
           }
        }

        // Insert payment if not unpaid
        if ($paymentMethod != 'Unpaid') {
            $stmt_payment = $conn->prepare("INSERT INTO payments (bill_id, amount_paid, payment_method, payment_date) VALUES (?, ?, ?, CURRENT_TIMESTAMP)");
            $stmt_payment->bind_param("ids", $bill_id, $totalBillAmount, $paymentMethod);
            $stmt_payment->execute();
            $stmt_payment->close();
        }


        $conn->commit();
        return json_encode(array("success" => true, "message" => "Bill generated successfully!"));
    } catch (Exception $e) {
        $conn->rollback();
        return json_encode(array("success" => false, "message" => "Error: " . $e->getMessage()));
    }
}
// Deduct main product stock using FIFO logic
function deductStock($productname, $quantity)
{
    global $conn;

    $remainingBoxes = $quantity;
    $stockQuery = $conn->prepare("SELECT id, quantity, bottles, totalbottles FROM stock WHERE productname = ? AND quantity > 0 ORDER BY buydate ASC");
    $stockQuery->bind_param("s", $productname);
    $stockQuery->execute();
    $stockResult = $stockQuery->get_result();

    while ($remainingBoxes > 0 && $row = $stockResult->fetch_assoc()) {
        $stockId = $row['id'];
        $stockQty = $row['quantity'];
        $bottlesPerBox = $row['bottles'];
        $currentTotalBottles = $row['totalbottles'];

        if ($stockQty >= $remainingBoxes) {
            // Deduct from this batch
            $bottlesSold = $remainingBoxes * $bottlesPerBox;
            $newTotalBottles = $currentTotalBottles - $bottlesSold;
            $newQty = $stockQty - $remainingBoxes;

            if ($newQty > 0) {
                // Update stock if some quantity remains
                $updateStock = $conn->prepare("UPDATE stock SET quantity = ?, totalbottles = ? WHERE id = ?");
                $updateStock->bind_param("ddi", $newQty, $newTotalBottles, $stockId);

                if (!$updateStock->execute()) {
                    throw new Exception("Error updating stock: " . $updateStock->error);
                }
            } else {
                // If quantity becomes 0, delete the row
                $deleteStock = $conn->prepare("DELETE FROM stock WHERE id = ?");
                $deleteStock->bind_param("i", $stockId);

                if (!$deleteStock->execute()) {
                    throw new Exception("Error deleting stock: " . $deleteStock->error);
                }
            }

            $remainingBoxes = 0;
        }
    }

    $stockQuery->close();

    if ($remainingBoxes > 0) {
        throw new Exception("Insufficient stock for $productname. Needed: $quantity boxes, Available: " . ($quantity - $remainingBoxes) . " boxes");
    }
}

// Deduct scheme product stock using FIFO logic with float values
function deductSchemeStock($schemeProduct, $schemeBottles)
{
    global $conn;

    $remainingBottles = $schemeBottles;
    $schemeQuery = $conn->prepare("SELECT id, quantity, bottles, totalbottles FROM stock WHERE productname = ? AND totalbottles > 0 ORDER BY buydate ASC");
    $schemeQuery->bind_param("s", $schemeProduct);
    $schemeQuery->execute();
    $schemeResult = $schemeQuery->get_result();

    while ($remainingBottles > 0 && $row = $schemeResult->fetch_assoc()) {
        $stockId = $row['id'];
        $bottlesPerBox = $row['bottles'];
        $currentTotalBottles = $row['totalbottles'];
        $currentQuantity = $row['quantity'];

        $deductBottles = min($remainingBottles, $currentTotalBottles);
        $newTotalBottles = $currentTotalBottles - $deductBottles;
        $newQuantity = $newTotalBottles / $bottlesPerBox;

        $updateStock = $conn->prepare("UPDATE stock SET quantity = ?, totalbottles = ? WHERE id = ?");
        $updateStock->bind_param("ddi", $newQuantity, $newTotalBottles, $stockId);

        if (!$updateStock->execute()) {
            throw new Exception("Error updating scheme stock: " . $updateStock->error);
        }

        // Delete if stock is exhausted
        if ($newTotalBottles <= 0) {
            $deleteStock = $conn->prepare("DELETE FROM stock WHERE id = ?");
            $deleteStock->bind_param("i", $stockId);
            if (!$deleteStock->execute()) {
                throw new Exception("Error deleting scheme stock: " . $deleteStock->error);
            }
        }

        $remainingBottles -= $deductBottles;
    }

    $schemeQuery->close();

    if ($remainingBottles > 0) {
        throw new Exception("Insufficient stock for scheme product $schemeProduct. Needed: $schemeBottles bottles, Available: " . ($schemeBottles - $remainingBottles) . " bottles");
    }
}


function getCounterList()
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM `counterlist`");
    if ($stmt) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $totalCounterName = array();
            while ($row = $result->fetch_assoc()) {
                $temparr = array($row["id"], $row["counterName"]);
                array_push($totalCounterName, $temparr);
            }
            return json_encode($totalCounterName);
        } else {
            echo "Prepare Error";
        }
    }
}

function getDataForChart()
{
    global $conn;
    $stmt = $conn->prepare("SELECT DATE_FORMAT(sellDate, '%b %Y') AS month_label, SUM(quantity) AS total_quantity, SUM(totalbillamount) AS total_earning FROM `sell` GROUP BY YEAR(sellDate), MONTH(sellDate) ORDER BY sellDate ASC;");
    if ($stmt) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $data = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = [$row['month_label'], (int)$row['total_quantity'], (float)$row['total_earning']];
            }
            return json_encode($data);
        } else {
            echo "Execute Error";
        }
    } else {
        echo "Prepare Error";
    }
}
function getSumEarning()
{
    global $conn;
    $today = date("Y-m-d");
    $stmt = $conn->prepare("SELECT SUM(totalbillamount) AS total_sum FROM sell WHERE DATE(sellDate) = ?");
    if ($stmt) {
        $stmt->bind_param("s", $today);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $todaySell = array();
            while ($row = $result->fetch_assoc()) {
                $temparr = array($row["total_sum"]);
                array_push($todaySell, $temparr);
            }
            return json_encode($todaySell);
        } else {
            echo "Execute Error";
        }
    } else {
        echo "Prepare Error";
    }
}

function getTodayEarning()
{
    global $conn;
    $today = date("Y-m-d");
    $stmt = $conn->prepare("SELECT productname, SUM(totalbillamount) AS total_amount FROM sell WHERE DATE(sellDate) = ? GROUP BY productname");
    if ($stmt) {
        $stmt->bind_param("s", $today);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $todaySell = array();
            while ($row = $result->fetch_assoc()) {
                $temparr = array($row["productname"], $row["total_amount"]);
                array_push($todaySell, $temparr);
            }
            return json_encode($todaySell);
        } else {
            echo "Execute Error";
        }
    } else {
        echo "Prepare Error";
    }
}

function getTodaySell()
{
    global $conn;
    $today = date("Y-m-d");
    $stmt = $conn->prepare("SELECT productname, SUM(quantity) AS total_quantity, SUM(totalbillamount) AS total_amount FROM sell WHERE DATE(sellDate) = ? GROUP BY productname");
    if ($stmt) {
        $stmt->bind_param("s", $today);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $todaySell = array();
            while ($row = $result->fetch_assoc()) {
                $temparr = array($row["productname"], $row["total_quantity"], $row["total_amount"]);
                array_push($todaySell, $temparr);
            }
            return json_encode($todaySell);
        } else {
            echo "Execute Error";
        }
    } else {
        echo "Prepare Error";
    }
}

function getTotalStockDashboard()
{

    global $conn;
    $stmt = $conn->prepare("SELECT productname, SUM(quantity) AS total_quantity FROM `stock` GROUP BY productname");
    if ($stmt) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $totalStock = array();
            while ($row = $result->fetch_assoc()) {
                $temparr = array($row["productname"], $row["total_quantity"]);
                array_push($totalStock, $temparr);
            }
            return json_encode($totalStock);
        } else {
            echo "Execute Error";
        }
    } else {
        echo "Prepare Error";
    }
}
// function for sell receipt logic
function addSellReceipt($productname, $quantity, $scheme, $price, $billamount, $countername)
{
    global $conn;

    $conn->begin_transaction(); // Start transaction for safety

    $remainingQuantity = $quantity;

    // Step 1: Get stock rows for this product ordered by buy date (FIFO)
    $stockResult = $conn->prepare("SELECT id, quantity FROM stock WHERE productname = ? ORDER BY buydate ASC");
    $stockResult->bind_param("s", $productname);
    $stockResult->execute();
    $result = $stockResult->get_result();

    // Loop through stock rows to deduct quantity
    while ($remainingQuantity > 0 && ($row = $result->fetch_assoc())) {

        $stockId = $row['id'];
        $stockQty = $row['quantity'];

        if ($stockQty >= $remainingQuantity) {
            // Enough quantity in this row
            $newQty = $stockQty - $remainingQuantity;

            if ($newQty == 0) {
                // Delete this stock row
                $deleteStmt = $conn->prepare("DELETE FROM stock WHERE id = ?");
                $deleteStmt->bind_param("i", $stockId);
                $deleteStmt->execute();
                $deleteStmt->close();
            } else {
                // Update this stock row
                $updateStmt = $conn->prepare("UPDATE stock SET quantity = ? WHERE id = ?");
                $updateStmt->bind_param("ii", $newQty, $stockId);
                $updateStmt->execute();
                $updateStmt->close();
            }

            $remainingQuantity = 0;
        } else {
            // Not enough, subtract all and delete this row
            $remainingQuantity -= $stockQty;

            $deleteStmt = $conn->prepare("DELETE FROM stock WHERE id = ?");
            $deleteStmt->bind_param("i", $stockId);
            $deleteStmt->execute();
            $deleteStmt->close();
        }
    }

    $stockResult->close();

    // Check if enough stock was found
    if ($remainingQuantity > 0) {
        $conn->rollback(); // Roll back everything
        echo json_encode(array("result" => 0, "message" => "Not enough stock for product '$productname'."));
        return;
    }

    // Insert into `sell`
    $stmt1 = $conn->prepare("INSERT INTO `sell` 
        (`id`, `productname`, `quantity`, `scheme`, `priceperbox`, `totalbillamount`, `countername`, `sellDate`) 
        VALUES (NULL, ?, ?, ?, ?, ?, ?, current_timestamp())");

    // Insert into `totalsell`
    $stmt2 = $conn->prepare("INSERT INTO `totalsell` 
        (`id`, `productname`, `quantity`, `scheme`, `priceperbox`, `totalbillamount`, `countername`, `sellDate`) 
        VALUES (NULL, ?, ?, ?, ?, ?, ?, current_timestamp())");

    if ($stmt1 && $stmt2) {
        $stmt1->bind_param("siiids", $productname, $quantity, $scheme, $price, $billamount, $countername);
        $stmt2->bind_param("siiids", $productname, $quantity, $scheme, $price, $billamount, $countername);

        $success1 = $stmt1->execute();
        $success2 = $stmt2->execute();

        $stmt1->close();
        $stmt2->close();

        if ($success1 && $success2) {
            $conn->commit();
            echo json_encode(array("result" => 1, "message" => "Sell Receipt Added Successfully!"));
        } else {
            $conn->rollback();
            echo json_encode(array("result" => 0, "message" => "Insert failed.", "error" => $conn->error));
        }
    } else {
        $conn->rollback();
        echo json_encode(array("result" => 0, "message" => "Prepare failed.", "error" => $conn->error));
    }
}

function getProductQuanitity($productname)
{
    global $conn;
    $stmt = $conn->prepare("SELECT SUM(quantity) AS total_quantity FROM `stock` WHERE productname = ?");
    $stmt->bind_param("s", $productname);
    if ($stmt) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            return json_encode($row);
        } else {
            echo "Prepare Error";
        }
    }
}

function getQuantityStock()
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM `counterlist`");
    if ($stmt) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $totalCounterName = array();
            while ($row = $result->fetch_assoc()) {
                $temparr = array($row["id"], $row["counterName"]);
                array_push($totalCounterName, $temparr);
            }
            return json_encode($totalCounterName);
        } else {
            echo "Prepare Error";
        }
    }
}
function showInsertedCounterList()
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM `counterlist`");
    if ($stmt) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $totalCounterName = array();
            while ($row = $result->fetch_assoc()) {
                $temparr = array($row["id"], $row["counterName"]);
                array_push($totalCounterName, $temparr);
            }
            return json_encode($totalCounterName);
        } else {
            echo "Prepare Error";
        }
    }
}
function showInsertedCounter()
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM `counterlist`");
    if ($stmt) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $totalCounterName = array();
            while ($row = $result->fetch_assoc()) {
                $temparr = array($row["id"], $row["counterName"]);
                array_push($totalCounterName, $temparr);
            }
            return json_encode($totalCounterName);
        } else {
            echo "Prepare Error";
        }
    }
}

function addCounterName($countername)
{
    global $conn;
    $stmt = $conn->prepare("INSERT INTO `counterlist` (`id`, `counterName`) VALUES (NULL,?)");
    if ($stmt) {
        $stmt->bind_param("s", $countername);
        if ($stmt->execute()) {
            $finalresult = array("result" => 1, "message" => "Counter Added Successfully...!");
            echo json_encode($finalresult);
        } else {
            echo "Prepare Error";
        }
    }
}

function updateSelectProduct()
{
    global $conn;
    $stmt = $conn->prepare("SELECT productname FROM `stock`");
    if ($stmt) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $totalProductNameFromStock = array();
            while ($row = $result->fetch_assoc()) {
                $temparr = array($row["productname"]);
                array_push($totalProductNameFromStock, $temparr);
            }
            return json_encode($totalProductNameFromStock);
        } else {
            echo "Prepare Error";
        }
    }
}

function getSellReceipt()
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM `sell`");
    if ($stmt) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $totalSell = array();
            while ($row = $result->fetch_assoc()) {
                $temparr = array($row["id"], $row["productname"], $row["quantity"], $row["scheme"], $row["priceperbox"], $row["totalbillamount"], $row["countername"], $row["sellDate"]);
                array_push($totalSell, $temparr);
            }
            return json_encode($totalSell);
        } else {
            echo "Prepare Error";
        }
    }
}

function getAgencyName()
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM `agencylist`");
    if ($stmt) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $totalagencyname = array();
            while ($row = $result->fetch_assoc()) {
                $temparr = array($row["id"], $row["agencyName"]);
                array_push($totalagencyname, $temparr);
            }
            return json_encode($totalagencyname);
        } else {
            echo "Prepare Error";
        }
    }
}

function getProductName()
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM `productlist`");
    if ($stmt) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $totalname = array();
            while ($row = $result->fetch_assoc()) {
                $temparr = array($row["id"], $row["productname"]);
                array_push($totalname, $temparr);
            }
            return json_encode($totalname);
        } else {
            echo "Prepare Error";
        }
    }
}

function showInsertedAgencyName()
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM `agencylist`");
    if ($stmt) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $totalagency = array();
            while ($row = $result->fetch_assoc()) {
                $temparr = array($row["id"], $row["agencyName"]);
                array_push($totalagency, $temparr);
            }
            return json_encode($totalagency);
        } else {
            echo "Prepare Error";
        }
    }
}

function addAgencyName($agencyname)
{
    global $conn;
    $stmt = $conn->prepare("INSERT INTO `agencylist` (`id`, `agencyName`) VALUES (NULL,?);");
    if ($stmt) {
        $stmt->bind_param("s", $agencyname);
        if ($stmt->execute()) {
            $finalresult = array("result" => 1, "message" => "Added Successfully...!");
            echo json_encode($finalresult);
        } else {
            echo "Prepare Error";
        }
    }
}

function showProductName()
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM `productlist`");
    if ($stmt) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $totalname = array();
            while ($row = $result->fetch_assoc()) {
                $temparr = array($row["id"], $row["productname"]);
                array_push($totalname, $temparr);
            }
            return json_encode($totalname);
        } else {
            echo "Prepare Error";
        }
    }
}

function addProductName($productname)
{
    global $conn;
    $stmt = $conn->prepare("INSERT INTO `productlist` (`id`, `productname`) VALUES (NULL,?)");
    if ($stmt) {
        $stmt->bind_param("s", $productname);
        if ($stmt->execute()) {
            $finalresult = array("result" => 1, "message" => "Added Successfully...!");
            echo json_encode($finalresult);
        } else {
            echo "Prepare Error";
        }
    }
}

function getInsertedStock()
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM `totalstocksadded` ORDER BY buydate DESC");
    if ($stmt) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $totalStock = array();
            while ($row = $result->fetch_assoc()) {
                $temparr = array($row["id"], $row["productname"], $row["quantity"], $row["bottles"], $row["priceperbox"], $row["totalbillamount"], $row["agencyname"], $row["buydate"]);
                array_push($totalStock, $temparr);
            }
            return json_encode($totalStock);
        } else {
            echo "Execute Error";
        }
    } else {
        echo "Prepare Error";
    }
}

function insertStock($productname, $quantity, $bottles, $priceperbox, $totalbillamount, $agencyname, $buydate)
{
    global $conn;
    $totalbottles = $bottles * $quantity; // Calculate total bottles based on quantity and bottles per box
    // First SQL query: Insert into 'stock' table
    $stmt1 = $conn->prepare("INSERT INTO `stock` (`productname`, `quantity`,`bottles`, `totalbottles`, `priceperbox`, `totalbillamount`, `agencyname`, `buydate`) VALUES (?, ?, ?, ?, ?, ?, ?, current_timestamp())");
    if ($stmt1) {
        $stmt1->bind_param("sidddds", $productname, $quantity, $bottles, $totalbottles, $priceperbox, $totalbillamount, $agencyname);
        if ($stmt1->execute()) {
            // Second SQL query: For example, insert into 'inventory_log' table
            $stmt2 = $conn->prepare("INSERT INTO `totalstocksadded` (`productname`, `quantity`,`bottles`, `totalbottles`, `priceperbox`, `totalbillamount`, `agencyname`, `buydate`) VALUES (?, ?, ?, ?, ?, ?, ?, current_timestamp())");
            if ($stmt2) {
                $action = "Inserted into stock";
                $stmt2->bind_param("sidddds",  $productname, $quantity, $bottles, $totalbottles, $priceperbox, $totalbillamount, $agencyname);
                if ($stmt2->execute()) {
                    $result = array("message" => "Data inserted successfully...!");
                    echo json_encode($result);
                } else {
                    echo "Second query execution failed: " . $stmt2->error;
                }
                $stmt2->close();
            } else {
                echo "Second query preparation failed: " . $conn->error;
            }
        } else {
            echo "First query execution failed: " . $stmt1->error;
        }
        $stmt1->close();
    } else {
        echo "First query preparation failed: " . $conn->error;
    }
}


function getTotalStock()
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM `stock`");
    if ($stmt) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $totalStock = array();
            while ($row = $result->fetch_assoc()) {
                $temparr = array($row["id"], $row["productname"], $row["quantity"], $row["priceperbox"], $row["totalbillamount"], $row["agencyname"], $row["buydate"]);
                array_push($totalStock, $temparr);
            }
            return json_encode($totalStock);
        } else {
            echo "Execute Error";
        }
    } else {
        echo "Prepare Error";
    }
}

function login($username, $password)
{
    $password = md5($password);
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM `admin` WHERE mobile=? AND password=?");
    if ($stmt) {
        $stmt->bind_param("ss", $username, $password);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $rowcount = mysqli_num_rows($result);
            $finalresult = "";
            if ($rowcount == 1) {
                $row = $result->fetch_assoc();
                session_start();
                $_SESSION["LOGIN"] = true;
                $_SESSION["USERID"] = $row["id"];
                $_SESSION["USERNAME"] = $row["username"];
                $_SESSION["PASSWORD"] = $row["password"];
                $_SESSION["ROLE"] = $row["role"];

                $finalresult = array("result" => 1, "message" => "Login Success");
                $finalresult = json_encode($finalresult);
            } else {
                $finalresult = array("result" => 0, "message" => "Login Failed");
                $finalresult = json_encode($finalresult);
            }
            return $finalresult;
        } else {
            echo "Execute Error";
        }
    } else {
        echo "Prepare Error";
    }
}
