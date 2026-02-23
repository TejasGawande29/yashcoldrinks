<?php
include_once("../dbconnection.php");
?>
<?php
$RESULT_TYPE = $_POST["RESULT_TYPE"];
switch ($RESULT_TYPE) {
    case "LOGIN":
        $result = login($_POST["USERNAME"], $_POST["PASSWORD"]);
        echo $result;
        break;
    case "GET_TOTAL_STOCK":
        $result = getTotalStock();
        echo $result;
        break;
    case "INSERT_STOCK":
        $result = insertStock($_POST["PRODUCTNAME"], $_POST["QUANTITY"], $_POST["BOTTLES"], $_POST["PRICEPERBOX"], $_POST["TOTALBILLAMOUNT"], $_POST["AGENCYNAME"], $_POST["PARTIALPAYMENT"], $_POST["PAYMENTMODE"]);
        echo $result;
        break;
    case "SHOW_INSERTED_STOCK":
        $result = getInsertedStock();
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
    case "GET_TOTAL_STOCK_DASHBOARD":
        $result = getTotalStockDashboard();
        echo $result;
        break;
    case "UPDATE_STOCK_PAYMENT":
        $result = updateStockPayment($_POST["stock_id"], $_POST["amount"], $_POST["method"]);
        echo $result;
        break;
    case 'GET_PAYMENT_DETAILS':
        $stock_id = $_POST['stock_id'];
        $stmt = $conn->prepare("SELECT * FROM stock WHERE id = ?");
        $stmt->bind_param("i", $stock_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo json_encode([
                'success' => true,
                'data' => $row
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Record not found'
            ]);
        }
        break;
}

function updateStockPayment($stock_id, $amount, $method)
{
    global $conn;

    $stmt = $conn->prepare("SELECT paid_amount, payment_mode, totalbillamount FROM stock WHERE id = ?");
    $stmt->bind_param("i", $stock_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        return json_encode(['success' => false, 'message' => 'Stock record not found']);
    }

    $row = $result->fetch_assoc();
    $current_paid = $row['paid_amount'];
    $current_method = $row['payment_mode'];
    $total_bill = $row['totalbillamount'];

    $new_paid = $current_paid + $amount;

    if ($current_method == 'Unpaid') {
        $new_method = $method;
    } else {
        $methods = explode(',', $current_method);
        if (!in_array($method, $methods)) {
            $methods[] = $method;
            $new_method = implode(',', $methods);
        } else {
            $new_method = $current_method;
        }
    }

    if ($new_paid == $total_bill) {
        $status = 'Paid';
    } else if ($new_paid > 0) {
        $status = 'Partial';
    } else {
        $status = 'Unpaid';
    }

    $updateStmt = $conn->prepare("UPDATE stock SET paid_amount = ?, payment_status = ?, payment_mode = ?, payment_date = CURRENT_TIMESTAMP() WHERE id = ?");
    $updateStmt->bind_param("dssi", $new_paid, $status, $new_method, $stock_id);

    if ($updateStmt->execute()) {
        return json_encode(['success' => true, 'message' => 'Payment updated successfully.']);
    } else {
        return json_encode(['success' => false, 'message' => 'Error updating payment: ' . $updateStmt->error]);
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

function getTotalStock()
{
    global $conn;
    $stmt = $conn->prepare("SELECT id, productname, quantity, totalbillamount, COALESCE(paid_amount, 0) as paid_amount, COALESCE(payment_status, 'Unpaid') as payment_status, payment_mode, agencyname, buydate FROM `stock` ORDER BY id DESC");
    if ($stmt) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $totalStock = array();
            while ($row = $result->fetch_assoc()) {
                $totalStock[] = $row;
            }
            return json_encode($totalStock);
        } else {
            return json_encode(["success" => false, "message" => "Execute error: " . $stmt->error]);
        }
    } else {
        return json_encode(["success" => false, "message" => "Prepare error: " . $conn->error]);
    }
}

function insertStock($productname, $quantity, $bottles, $priceperbox, $totalbillamount, $agencyname, $partialpayment, $paymentmode)
{
    global $conn;
    $totalbottles = $bottles * $quantity;

    $paidamount = 0;
    $paymentstatus = '';
    $use_current_timestamp = false;

    if ($paymentmode == 'Cash' || $paymentmode == 'PhonePe') {
        $paidamount = $totalbillamount;
        $paymentstatus = 'Paid';
        $use_current_timestamp = true;
    } else if ($paymentmode == 'PartialCash' || ($paymentmode == 'PartialPhonePe')) {
        $paidamount = $partialpayment;
        $paymentstatus = 'Partial';
        $use_current_timestamp = true;
    } else if ($paymentmode == 'Unpaid') {
        $paidamount = 0;
        $paymentstatus = 'Unpaid';
        $use_current_timestamp = false;
    }

    if ($use_current_timestamp) {
        $stmt1 = $conn->prepare("INSERT INTO `stock` (`productname`, `quantity`, `bottles`, `totalbottles`, `priceperbox`, `totalbillamount`, `paid_amount`, `payment_status`, `payment_mode`, `payment_date`, `agencyname`, `buydate`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP(), ?, CURRENT_TIMESTAMP())");
        $stmt1->bind_param("sidddddsss", $productname, $quantity, $bottles, $totalbottles, $priceperbox, $totalbillamount, $paidamount, $paymentstatus, $paymentmode, $agencyname);
    } else {
        $paymentdate = 0;
        $stmt1 = $conn->prepare("INSERT INTO `stock` (`productname`, `quantity`, `bottles`, `totalbottles`, `priceperbox`, `totalbillamount`, `paid_amount`, `payment_status`, `payment_mode`, `payment_date`, `agencyname`, `buydate`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP())");
        $stmt1->bind_param("sidddddssss", $productname, $quantity, $bottles, $totalbottles, $priceperbox, $totalbillamount, $paidamount, $paymentstatus, $paymentmode, $paymentdate, $agencyname);
    }

    if ($stmt1 && $stmt1->execute()) {
        if ($use_current_timestamp) {
            $stmt2 = $conn->prepare("INSERT INTO `totalstocksadded` (`productname`, `quantity`, `bottles`, `totalbottles`, `priceperbox`, `totalbillamount`, `paid_amount`, `payment_status`, `payment_mode`, `payment_date`, `agencyname`, `buydate`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP(), ?, CURRENT_TIMESTAMP())");
            $stmt2->bind_param("sidddddsss", $productname, $quantity, $bottles, $totalbottles, $priceperbox, $totalbillamount, $paidamount, $paymentstatus, $paymentmode, $agencyname);
        } else {
            $paymentdate = 0;
            $stmt2 = $conn->prepare("INSERT INTO `totalstocksadded` (`productname`, `quantity`, `bottles`, `totalbottles`, `priceperbox`, `totalbillamount`, `paid_amount`, `payment_status`, `payment_mode`, `payment_date`, `agencyname`, `buydate`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP())");
            $stmt2->bind_param("sidddddssss", $productname, $quantity, $bottles, $totalbottles, $priceperbox, $totalbillamount, $paidamount, $paymentstatus, $paymentmode, $paymentdate, $agencyname);
        }

        if ($stmt2 && $stmt2->execute()) {
            echo json_encode(array("message" => "Data inserted successfully...!"));
        } else {
            echo "Second query execution failed: " . $stmt2->error;
        }

        $stmt2->close();
    } else {
        echo "First query execution failed: " . $stmt1->error;
    }

    if ($stmt1) $stmt1->close();
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

function login($username, $password)
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    $hashedPassword = md5($password);
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM `admin` WHERE mobile=? AND password=?");
    if ($stmt) {
        $stmt->bind_param("ss", $username, $hashedPassword);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $rowcount = mysqli_num_rows($result);
            $finalresult = "";
            if ($rowcount == 1) {
                $row = $result->fetch_assoc();
                $_SESSION["LOGIN"] = true;
                $_SESSION["USERID"] = $row["id"];
                $_SESSION["USERNAME"] = $row["username"];
                $_SESSION["ROLE"] = $row["role"];

                $finalresult = array("result" => 1, "message" => "Login Success");
                $finalresult = json_encode($finalresult);
            } else {
                $finalresult = array("result" => 0, "message" => "Invalid mobile or password");
                $finalresult = json_encode($finalresult);
            }
            return $finalresult;
        } else {
            return json_encode(array("result" => 0, "message" => "Database error"));
        }
    } else {
        return json_encode(array("result" => 0, "message" => "Database error"));
    }
}
