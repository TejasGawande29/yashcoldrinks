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
        $result = insertStock($_POST["PRODUCTNAME"], $_POST["QUANTITY"], $_POST["BOTTLES"], $_POST["PRICEPERBOX"], $_POST["TOTALBILLAMOUNT"], $_POST["AGENCYNAME"], $_POST["PARTIALPAYMENT"], $_POST["PAYMENTMODE"]);
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
    case "MAKE_PAYMENT":
        $result = recordPayment($_POST["BILL_ID"], $_POST["AMOUNT"], $_POST["METHOD"]);
        echo $result;
        break;
    case "GET_TODAY_CASH_FLOW_SELL":
        $result = getTodayCashFlow();
        echo $result;
        break;
    case "GET_UNPAID_LIST":
        $result = getUnpaidList();
        echo $result;
        break;
    case "GET_PHONEPE_LIST":
        $result = getPhonepeList();
        echo $result;
        break;
    case "GET_PREVIOUS_PAYMENT_LIST":
        $result = getPreviousPaymentList();
        echo $result;
        break;
    case "ADD_EXPENSE":
        $result = addExpense($_POST["expense_date"], $_POST["expense_type"], $_POST["amount"], $_POST["description"]);
        echo $result;
        break;

    case "GET_EXPENSES":
        $filter = isset($_POST["TIMEFRAME"]) ? $_POST["TIMEFRAME"] : 'today';
        $result = getExpenses($filter);
        echo $result;
        break;

    case "DELETE_EXPENSE":
        $result = deleteExpense($_POST["id"]);
        echo $result;
        break;
    case "GET_TOTAL_EXPENSES":
        $result = getTotalExpense();
        echo $result;
        break;
    case "GET_TODAYS_NETPROFIT":
        $result = getTodaysNetProfit();
        echo $result;
        break;

    case "GET_ADMIN_ACCOUNTS":
        $result = getAdminAccounts();
        echo json_encode($result);
        break;

    case "ADD_ADMIN_ACCOUNT":
        $result = addAdminAccount($_POST["username"], $_POST["password"], $_POST["mobile"], $_POST["role"]);
        echo json_encode($result);
        break;

    case "UPDATE_ADMIN_ACCOUNT":
        $result = updateAdminAccount($_POST["id"], $_POST["username"], $_POST["password"], $_POST["mobile"], $_POST["role"]);
        echo json_encode($result);
        break;

    case "DELETE_ADMIN_ACCOUNT":
        $result = deleteAdminAccount($_POST["id"]);
        echo json_encode($result);
        break;
    case "UPDATE_STOCK_PAYMENT":
        $result = updateStockPayment($_POST["stock_id"], $_POST["amount"], $_POST["method"]);
        echo $result;
        break;
        // Add this case to your switch statement
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

    case "GET_STOCK_PAYMENT_LIST":
        $result = getStockPaymentList();
        echo $result;
        case 'GET_ORDERS':
            $filter = isset($_POST['FILTER']) ? $_POST['FILTER'] : 'all';
            $orders = getOrders($conn, $filter);
            echo json_encode($orders);
            break;
            
        case 'GET_ORDER_DETAILS':
            if (isset($_POST['ORDER_ID'])) {
                $orderId = (int)$_POST['ORDER_ID'];
                $orderData = getOrderDetails($conn, $orderId);
                echo json_encode($orderData);
            }
            break;
            
        case 'UPDATE_ORDER_STATUS':
            if (isset($_POST['ORDER_ID'], $_POST['STATUS'])) {
                $orderId = (int)$_POST['ORDER_ID'];
                $status = $conn->real_escape_string($_POST['STATUS']);
                $result = updateOrderStatus($conn, $orderId, $status);
                echo json_encode($result);
            }
            break;
            
        case 'DELETE_ORDER':
            if (isset($_POST['ORDER_ID'])) {
                $orderId = (int)$_POST['ORDER_ID'];
                $result = deleteOrder($conn, $orderId);
                echo json_encode($result);
            }
        break;
}
function getOrders($conn, $filter) {
    $sql = "SELECT * FROM orders";
    
    if ($filter !== 'all') {
        $filter = $conn->real_escape_string($filter);
        $sql .= " WHERE status = '$filter'";
    }
    
    $sql .= " ORDER BY order_date DESC";
    
    $result = $conn->query($sql);
    $orders = [];
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
    }
    
    return $orders;
}

function getOrderDetails($conn, $orderId) {
    // Get order info
    $orderSql = "SELECT * FROM orders WHERE id = $orderId";
    $orderResult = $conn->query($orderSql);
    
    if ($orderResult->num_rows === 0) {
        return ['error' => 'Order not found'];
    }
    
    $order = $orderResult->fetch_assoc();
    
    // Get order items
    $itemsSql = "SELECT oi.*, p.name 
                 FROM order_items oi
                 JOIN products p ON oi.product_id = p.id
                 WHERE oi.order_id = $orderId";
    $itemsResult = $conn->query($itemsSql);
    $items = [];
    
    if ($itemsResult->num_rows > 0) {
        while ($row = $itemsResult->fetch_assoc()) {
            $items[] = $row;
        }
    }
    
    return [
        'id' => $order['id'],
        'customer_name' => $order['customer_name'],
        'phone' => $order['phone'],
        'address' => $order['address'],
        'total_amount' => $order['total_amount'],
        'order_date' => $order['order_date'],
        'status' => $order['status'],
        'items' => $items
    ];
}

function updateOrderStatus($conn, $orderId, $status) {
    $sql = "UPDATE orders SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $orderId);
    
    if ($stmt->execute()) {
        return ['success' => true, 'message' => 'Order status updated successfully'];
    } else {
        return ['success' => false, 'message' => 'Failed to update order status'];
    }
}

function deleteOrder($conn, $orderId) {
    // First delete order items
    $deleteItemsSql = "DELETE FROM order_items WHERE order_id = $orderId";
    $conn->query($deleteItemsSql);
    
    // Then delete the order
    $deleteOrderSql = "DELETE FROM orders WHERE id = $orderId";
    
    if ($conn->query($deleteOrderSql)) {
        return ['success' => true, 'message' => 'Order deleted successfully'];
    } else {
        return ['success' => false, 'message' => 'Failed to delete order'];
    }
}

function getStockPaymentList(){
    global $conn;
    $stmt = $conn->prepare("SELECT productname, quantity, totalbillamount, paid_amount, payment_mode, payment_date, agencyname FROM `stock` WHERE DATE(payment_date) = CURRENT_DATE");
    if ($stmt) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $stockpayment = array();
            while ($row = $result->fetch_assoc()) {
                $temparr = array($row['productname'], $row['quantity'], $row['totalbillamount'], $row['paid_amount'], $row['payment_mode'], $row['payment_date'], $row['agencyname']);
                array_push($stockpayment, $temparr);
            }

            return json_encode($stockpayment);
        } else {
            echo "Execute Error";
        }
    } else {
        echo "Prepare Error";
    }
}

function updateStockPayment($stock_id, $amount, $method)
{
    global $conn;

    // Get current payment details
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

    // Update payment mode
    if ($current_method == 'Unpaid') {
        $new_method = $method;
    } else {
        // Append new method if different
        $methods = explode(',', $current_method);
        if (!in_array($method, $methods)) {
            $methods[] = $method;
            $new_method = implode(',', $methods);
        } else {
            $new_method = $current_method;
        }
    }

    // Determine new status
    if ($new_paid == $total_bill) {
        $status = 'Paid';
    } else if ($new_paid > 0) {
        $status = 'Partial';
    } else {
        $status = 'Unpaid';
    }

    // Update the stock row
    $updateStmt = $conn->prepare("UPDATE stock SET paid_amount = ?, payment_status = ?, payment_mode = ?, payment_date = CURRENT_TIMESTAMP() WHERE id = ?");
    $updateStmt->bind_param("dssi", $new_paid, $status, $new_method, $stock_id);

    if ($updateStmt->execute()) {
        return json_encode(['success' => true, 'message' => 'Payment updated successfully.']);
    } else {
        return json_encode(['success' => false, 'message' => 'Error updating payment: ' . $updateStmt->error]);
    }
}
function getAdminAccounts()
{
    global $conn;
    $stmt = $conn->prepare("SELECT id, username, mobile, role FROM admin");
    if ($stmt) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $accounts = [];
            while ($row = $result->fetch_assoc()) {
                $accounts[] = $row;
            }
            return $accounts;
        } else {
            return ["success" => false, "message" => "Database error: " . $stmt->error];
        }
    } else {
        return ["success" => false, "message" => "Prepare failed: " . $conn->error];
    }
}

function addAdminAccount($username, $password, $mobile, $role)
{
    global $conn;

    // Check if username already exists
    $checkStmt = $conn->prepare("SELECT id FROM admin WHERE username = ?");
    $checkStmt->bind_param("s", $username);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        return ["success" => false, "message" => "Username already exists"];
    }

    // Hash password with MD5
    $hashedPassword = md5($password);

    $stmt = $conn->prepare("INSERT INTO admin (username, password, mobile, role) VALUES (?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("ssss", $username, $hashedPassword, $mobile, $role);
        if ($stmt->execute()) {
            return ["success" => true, "message" => "Account created successfully"];
        } else {
            return ["success" => false, "message" => "Database error: " . $stmt->error];
        }
    } else {
        return ["success" => false, "message" => "Prepare failed: " . $conn->error];
    }
}

function updateAdminAccount($id, $username, $password, $mobile, $role)
{
    global $conn;

    // Check if username exists for other accounts
    $checkStmt = $conn->prepare("SELECT id FROM admin WHERE username = ? AND id != ?");
    $checkStmt->bind_param("si", $username, $id);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        return ["success" => false, "message" => "Username already exists for another account"];
    }

    // Prepare SQL based on whether password is provided
    if (!empty($password)) {
        $hashedPassword = md5($password);
        $stmt = $conn->prepare("UPDATE admin SET username = ?, password = ?, mobile = ?, role = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $username, $hashedPassword, $mobile, $role, $id);
    } else {
        $stmt = $conn->prepare("UPDATE admin SET username = ?, mobile = ?, role = ? WHERE id = ?");
        $stmt->bind_param("sssi", $username, $mobile, $role, $id);
    }

    if ($stmt) {
        if ($stmt->execute()) {
            return ["success" => true, "message" => "Account updated successfully"];
        } else {
            return ["success" => false, "message" => "Database error: " . $stmt->error];
        }
    } else {
        return ["success" => false, "message" => "Prepare failed: " . $conn->error];
    }
}

function deleteAdminAccount($id)
{
    global $conn;

    // Prevent deletion of the current logged-in admin
    if ($id == $_SESSION["USERID"]) {
        return ["success" => false, "message" => "You cannot delete your own account while logged in"];
    }

    // Prevent deletion of the last admin account
    $adminCountStmt = $conn->prepare("SELECT COUNT(*) AS admin_count FROM admin WHERE role = 'admin'");
    $adminCountStmt->execute();
    $adminCountResult = $adminCountStmt->get_result();
    $adminCountRow = $adminCountResult->fetch_assoc();

    // Check if this account is an admin
    $isAdminStmt = $conn->prepare("SELECT role FROM admin WHERE id = ?");
    $isAdminStmt->bind_param("i", $id);
    $isAdminStmt->execute();
    $isAdminResult = $isAdminStmt->get_result();
    $isAdminRow = $isAdminResult->fetch_assoc();

    if ($isAdminRow['role'] === 'admin' && $adminCountRow['admin_count'] <= 1) {
        return ["success" => false, "message" => "Cannot delete the last admin account"];
    }

    $stmt = $conn->prepare("DELETE FROM admin WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            return ["success" => true, "message" => "Account deleted successfully"];
        } else {
            return ["success" => false, "message" => "Database error: " . $stmt->error];
        }
    } else {
        return ["success" => false, "message" => "Prepare failed: " . $conn->error];
    }
}
function getTodaysNetProfit()
{
    global $conn;
    $stmt = $conn->prepare("SELECT SUM(amount_paid) totalincome FROM `payments`WHERE DATE(payment_date) = CURRENT_DATE");
    if ($stmt) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $totalincome = array($row['totalincome']);

            // Get todays Expense
            $stmt1 = $conn->prepare("SELECT SUM(amount) AS expense FROM `expenses` WHERE expense_date = CURRENT_DATE");
            $stmt1->execute();
            $result1 = $stmt1->get_result();
            $row1 = $result1->fetch_assoc();
            $todaysexpense = array($row1['expense']);

            // Get todays Stock Payment
            $stmt2 = $conn->prepare("SELECT SUM(paid_amount) AS stockpayment FROM `stock` WHERE payment_status IN ('paid', 'partial') AND DATE(payment_date)=CURRENT_DATE");
            $stmt2->execute();
            $result2 = $stmt2->get_result();
            $row2 = $result2->fetch_assoc();
            $todaysstockpayment = array($row2['stockpayment']);

            // Calculate Net Profit
            $netProfit = $totalincome[0] - $todaysexpense[0] - $todaysstockpayment[0];

            //Final Result
            $finalResult = array("totalincome" => $totalincome[0], "todaysexpense" => $todaysexpense[0], "netprofit" => $netProfit);
            return json_encode($finalResult);
        } else {
            return json_encode(["success" => false, "message" => "Database error: " . $stmt->error]);
        }
    } else {
        return json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
    }
}

function getTotalExpense()
{
    global $conn;
    $stmt = $conn->prepare("SELECT SUM(amount) AS Expense FROM `expenses` WHERE DATE(expense_date) = CURRENT_DATE");
    if ($stmt) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $expense = array();
            while ($row = $result->fetch_assoc()) {
                $temparr = array($row['Expense']);
                array_push($expense, $temparr);
            }
            return json_encode($expense);
        } else {
            return json_encode(["success" => false, "message" => "Database error: " . $stmt->error]);
        }
    } else {
        return json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
    }
}

function addExpense($date, $type, $amount, $description)
{
    global $conn;
    $stmt = $conn->prepare("INSERT INTO expenses (expense_date, expense_type, amount, description) VALUES (?, ?, ?, ?)");

    if ($stmt) {
        $stmt->bind_param("ssds", $date, $type, $amount, $description);
        if ($stmt->execute()) {
            return json_encode(["success" => true, "message" => "Expense added successfully"]);
        } else {
            return json_encode(["success" => false, "message" => "Database error: " . $stmt->error]);
        }
    } else {
        return json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
    }
}

function getExpenses($filter)
{
    global $conn;
    $sql = "SELECT * FROM expenses";

    // Add filters based on timeframe
    switch ($filter) {
        case 'today':
            $sql .= " WHERE expense_date = CURDATE()";
            break;
        case 'week':
            $sql .= " WHERE YEARWEEK(expense_date, 1) = YEARWEEK(CURDATE(), 1)";
            break;
        case 'month':
            $sql .= " WHERE MONTH(expense_date) = MONTH(CURDATE()) AND YEAR(expense_date) = YEAR(CURDATE())";
            break;
        default:
            // All expenses - no filter
            break;
    }

    $sql .= " ORDER BY expense_date DESC";
    $result = $conn->query($sql);

    $expenses = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $expenses[] = $row;
        }
    }
    return json_encode($expenses);
}

function deleteExpense($id)
{
    global $conn;
    $stmt = $conn->prepare("DELETE FROM expenses WHERE id = ?");

    if ($stmt) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            return json_encode(["success" => true, "message" => "Expense deleted successfully"]);
        } else {
            return json_encode(["success" => false, "message" => "Database error: " . $stmt->error]);
        }
    } else {
        return json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
    }
}


function getPreviousPaymentList()
{
    global $conn;
    $stmt = $conn->prepare("SELECT counter_name AS countername, DATE(bill_date) AS billdate, DATE(payment_date) AS paymentdate, payment_method AS paymentmode, payments.amount_paid AS amountpaid FROM `bills` RIGHT JOIN `payments` ON bills.id = payments.bill_id WHERE DATE(bills.bill_date) != DATE(payments.payment_date) AND DATE(payments.payment_date) = CURRENT_DATE");
    if ($stmt) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $getPreviousPayment = array();
            while ($row = $result->fetch_assoc()) {
                $temparr = array($row['countername'], $row['billdate'], $row['paymentdate'], $row['paymentmode'], $row['amountpaid']);
                array_push($getPreviousPayment, $temparr);
            }

            return json_encode($getPreviousPayment);
        } else {
            echo "Execute Error";
        }
    } else {
        echo "Prepare Error";
    }
}
function getPhonepeList()
{
    global $conn;
    $stmt = $conn->prepare("SELECT counter_name AS counter, amount_paid AS amountpaid FROM `bills` RIGHT JOIN `payments` ON bills.id = payments.bill_id WHERE payments.payment_method = 'Phonepe' AND DATE(payments.payment_date) = CURRENT_DATE ORDER BY `payments`.`amount_paid` DESC");
    if ($stmt) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $getPhonepelist = array();
            while ($row = $result->fetch_assoc()) {
                $temparr = array($row['counter'], $row['amountpaid']);
                array_push($getPhonepelist, $temparr);
            }

            return json_encode($getPhonepelist);
        } else {
            echo "Execute Error";
        }
    } else {
        echo "Prepare Error";
    }
}
function getUnpaidList()
{
    global $conn;
    $stmt = $conn->prepare("SELECT counter_name AS countername, total_bill_amount AS billamount, paid_amount AS paidamount FROM `bills` WHERE payment_status != 'Paid'");
    if ($stmt) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $getUnpaid = array();
            while ($row = $result->fetch_assoc()) {
                $temparr = array($row['countername'], $row['billamount'], $row['paidamount']);
                array_push($getUnpaid, $temparr);
            }

            return json_encode($getUnpaid);
        } else {
            echo "Execute Error";
        }
    } else {
        echo "Prepare Error";
    }
}

function getTodayCashFlow()
{
    global $conn;
    // Cash From Payments
    $stmt = $conn->prepare("SELECT SUM(amount_paid) AS Cash FROM `bills` RIGHT JOIN payments ON bills.id = payments.bill_id WHERE payments.payment_method = 'Cash' AND date(payments.payment_date)=CURRENT_DATE");
    if ($stmt) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $getCashFlow = array();
            while ($row = $result->fetch_assoc()) {
                $temparr = array($row);
                array_push($getCashFlow, $temparr);
            }
            // Phonepe From Payments
            $stmt1 = $conn->prepare("SELECT SUM(amount_paid) AS Phonepe FROM `bills` RIGHT JOIN payments ON bills.id = payments.bill_id WHERE payments.payment_method = 'Phonepe' AND date(payments.payment_date)=CURRENT_DATE");
            $stmt1->execute();
            $result1 = $stmt1->get_result();
            while ($row1 = $result1->fetch_assoc()) {
                $temparr1 = array($row1);
                array_push($getCashFlow, $temparr1);
            }
            // Unpaid From Bills
            $stmt2 = $conn->prepare("SELECT SUM(total_bill_amount) AS Unpaid FROM `bills` WHERE payment_status= 'Unpaid' AND DATE(bill_date) = CURRENT_DATE");
            $stmt2->execute();
            $result2 = $stmt2->get_result();
            while ($row2 = $result2->fetch_assoc()) {
                $temparr2 = array($row2);
                array_push($getCashFlow, $temparr2);
            }
            // Todays Sell from Bills
            $stmt3 = $conn->prepare("SELECT SUM(total_bill_amount) AS sell FROM bills WHERE DATE(bill_date) = CURRENT_DATE");
            $stmt3->execute();
            $result3 = $stmt3->get_result();
            while ($row3 = $result3->fetch_assoc()) {
                $temparr3 = array($row3);
                array_push($getCashFlow, $temparr3);
            }


            return json_encode($getCashFlow);
        } else {
            echo "Execute Error";
        }
    } else {
        echo "Prepare Error";
    }
}

function recordPayment($billId, $amount, $method)
{
    global $conn;
    $conn->begin_transaction();

    try {
        // Get bill details
        $stmt = $conn->prepare("SELECT total_bill_amount, paid_amount FROM bills WHERE id = ?");
        $stmt->bind_param("i", $billId);
        $stmt->execute();
        $bill = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        $total = $bill['total_bill_amount'];
        $paid = $bill['paid_amount'];
        $newPaid = $paid + $amount;
        $remaining = $total - $paid;

        // Validate payment amount
        if ($amount > $remaining) {
            throw new Exception("Payment amount exceeds remaining balance");
        }

        // Update bill status
        $status = ($newPaid == $total) ? 'Paid' : 'Partially Paid';
        $updateBill = $conn->prepare("UPDATE bills SET paid_amount = ?, payment_status = ? WHERE id = ?");
        $updateBill->bind_param("dsi", $newPaid, $status, $billId);
        $updateBill->execute();
        $updateBill->close();

        // Record payment
        $paymentType = ($amount == $remaining) ? 'full' : 'partial';
        $insertPayment = $conn->prepare("INSERT INTO payments (bill_id, amount_paid, payment_method, payment_type, payment_date) VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP)");
        $insertPayment->bind_param("idss", $billId, $amount, $method, $paymentType);
        $insertPayment->execute();
        $insertPayment->close();

        $conn->commit();
        return json_encode(["success" => true, "message" => "Payment recorded successfully"]);
    } catch (Exception $e) {
        $conn->rollback();
        return json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
    }
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
            } else {
                // If no scheme, just deduct stock.
                deductstock($product[0], $product[1]);
            }
        }

        // Insert payment if not unpaid
        if ($paymentMethod !== 'Unpaid') {
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
    $stmt = $conn->prepare("SELECT SUM(totalbillamount) AS total_sum FROM sell WHERE DATE(sellDate) = CURRENT_DATE");
    if ($stmt) {
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
    $stmt = $conn->prepare("SELECT productname, SUM(quantity) AS totalquantity FROM `sell` WHERE DATE(sellDate) = CURRENT_DATE GROUP BY productname");
    if ($stmt) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $todaySell = array();
            while ($row = $result->fetch_assoc()) {
                $temparr = array($row["productname"], $row['totalquantity']);
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
        // Insert into totalstocksadded
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


function getTotalStock()
{
    global $conn;
    $stmt = $conn->prepare("SELECT id, productname, quantity, totalbillamount, paid_amount, payment_status, payment_mode, agencyname, buydate FROM `stock` ORDER BY id DESC");
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
