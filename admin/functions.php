<?php
include_once("../dbconnection.php");
session_start();
?>
<?php
$RESULT_TYPE = isset($_POST["RESULT_TYPE"]) ? $_POST["RESULT_TYPE"] : '';
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
        $batchNumber = isset($_POST["BATCHNUMBER"]) ? $_POST["BATCHNUMBER"] : null;
        $expiryDate = isset($_POST["EXPIRYDATE"]) ? $_POST["EXPIRYDATE"] : null;
        $lowStockThreshold = isset($_POST["LOWSTOCKTHRESHOLD"]) ? $_POST["LOWSTOCKTHRESHOLD"] : 5;
        $result = insertStock($_POST["PRODUCTNAME"], $_POST["QUANTITY"], $_POST["BOTTLES"], $_POST["PRICEPERBOX"], $_POST["TOTALBILLAMOUNT"], $_POST["AGENCYNAME"], $_POST["PARTIALPAYMENT"], $_POST["PAYMENTMODE"], $batchNumber, $expiryDate, $lowStockThreshold);
        echo $result;
        break;
    case "SHOW_INSERTED_STOCK":
        $result = getInsertedStock();
        echo $result;
        break;
    case "GET_LOW_STOCK_ALERTS":
        $result = getLowStockAlerts();
        echo $result;
        break;
    case "GET_STOCK_BY_ID":
        $result = getStockById($_POST["STOCK_ID"]);
        echo $result;
        break;
    case "UPDATE_STOCK":
        $result = updateStock($_POST["STOCK_ID"], $_POST["QUANTITY"], $_POST["ML"], $_POST["PRICEPERBOX"], $_POST["BATCHNUMBER"], $_POST["EXPIRYDATE"], $_POST["LOWSTOCKTHRESHOLD"]);
        echo $result;
        break;
    case "DELETE_STOCK":
        $result = deleteStock($_POST["STOCK_ID"]);
        echo $result;
        break;
    case "GET_STOCK_HISTORY":
        $productName = isset($_POST["PRODUCTNAME"]) ? $_POST["PRODUCTNAME"] : null;
        $fromDate = isset($_POST["FROM_DATE"]) ? $_POST["FROM_DATE"] : null;
        $toDate = isset($_POST["TO_DATE"]) ? $_POST["TO_DATE"] : null;
        $result = getStockHistory($productName, $fromDate, $toDate);
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
    case "GET_PRODUCT_NAMES":
        $result = getProductNames();
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
    case "GET_COUNTERS":
        $result = getCounterList();
        echo $result;
        break;
    case "INSERT_bill":
        $customerName = isset($_POST["CUSTOMERNAME"]) ? $_POST["CUSTOMERNAME"] : null;
        $customerPhone = isset($_POST["CUSTOMERPHONE"]) ? $_POST["CUSTOMERPHONE"] : null;
        $result = insertBill($_POST["PRODUCTS"], $_POST["COUNTERNAME"], $_POST["PAYMENTMETHOD"], $_POST["TOTALBILLAMOUNT"], $customerName, $customerPhone);
        echo $result;
        break;
    case "SEARCH_BILLS":
        $dateFrom = isset($_POST["FROM_DATE"]) ? $_POST["FROM_DATE"] : null;
        $dateTo = isset($_POST["TO_DATE"]) ? $_POST["TO_DATE"] : null;
        $counter = isset($_POST["COUNTER"]) ? $_POST["COUNTER"] : null;
        $customerPhone = isset($_POST["CUSTOMER_PHONE"]) ? $_POST["CUSTOMER_PHONE"] : null;
        $result = searchBills($dateFrom, $dateTo, $counter, $customerPhone);
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
    
    // ===================== FILTERED AUDIT CASES =====================
    case "GET_FILTERED_AUDIT_STATS":
        $startDate = isset($_POST["START_DATE"]) ? $_POST["START_DATE"] : date('Y-m-d');
        $endDate = isset($_POST["END_DATE"]) ? $_POST["END_DATE"] : date('Y-m-d');
        echo json_encode(getFilteredAuditStats($startDate, $endDate));
        break;
    case "GET_FILTERED_CASH_FLOW":
        $startDate = isset($_POST["START_DATE"]) ? $_POST["START_DATE"] : date('Y-m-d');
        $endDate = isset($_POST["END_DATE"]) ? $_POST["END_DATE"] : date('Y-m-d');
        echo json_encode(getFilteredCashFlow($startDate, $endDate));
        break;
    case "GET_FILTERED_PHONEPE_LIST":
        $startDate = isset($_POST["START_DATE"]) ? $_POST["START_DATE"] : date('Y-m-d');
        $endDate = isset($_POST["END_DATE"]) ? $_POST["END_DATE"] : date('Y-m-d');
        echo json_encode(getFilteredPhonePeList($startDate, $endDate));
        break;
    case "GET_FILTERED_PAYMENT_LIST":
        $startDate = isset($_POST["START_DATE"]) ? $_POST["START_DATE"] : date('Y-m-d');
        $endDate = isset($_POST["END_DATE"]) ? $_POST["END_DATE"] : date('Y-m-d');
        echo json_encode(getFilteredPaymentList($startDate, $endDate));
        break;
    case "GET_FILTERED_STOCK_PAYMENTS":
        $startDate = isset($_POST["START_DATE"]) ? $_POST["START_DATE"] : date('Y-m-d');
        $endDate = isset($_POST["END_DATE"]) ? $_POST["END_DATE"] : date('Y-m-d');
        echo json_encode(getFilteredStockPayments($startDate, $endDate));
        break;
    // ===================== END FILTERED AUDIT =====================

    // ===================== SALARY MANAGEMENT CASES =====================
    case "GET_SALARY_STATS":
        echo json_encode(getSalaryStats());
        break;
    case "GET_EMPLOYEES":
        echo json_encode(getEmployees());
        break;
    case "GET_ACTIVE_EMPLOYEES":
        echo json_encode(getActiveEmployees());
        break;
    case "GET_EMPLOYEE":
        echo json_encode(getEmployee($_POST["ID"]));
        break;
    case "ADD_EMPLOYEE":
        echo json_encode(addEmployee($_POST["NAME"], $_POST["PHONE"], $_POST["ROLE"], $_POST["SALARY"], $_POST["JOIN_DATE"]));
        break;
    case "UPDATE_EMPLOYEE":
        echo json_encode(updateEmployee($_POST["ID"], $_POST["NAME"], $_POST["PHONE"], $_POST["ROLE"], $_POST["SALARY"]));
        break;
    case "TOGGLE_EMPLOYEE_STATUS":
        echo json_encode(toggleEmployeeStatus($_POST["ID"], $_POST["STATUS"]));
        break;
    case "DELETE_EMPLOYEE":
        echo json_encode(deleteEmployee($_POST["ID"]));
        break;
    case "GET_PENDING_SALARIES":
        echo json_encode(getPendingSalaries());
        break;
    case "GET_SALARY_PAYMENTS":
        $month = isset($_POST["MONTH"]) ? $_POST["MONTH"] : null;
        $empId = isset($_POST["EMPLOYEE_ID"]) ? $_POST["EMPLOYEE_ID"] : null;
        echo json_encode(getSalaryPayments($month, $empId));
        break;
    case "ADD_SALARY_PAYMENT":
        echo json_encode(addSalaryPayment($_POST["EMPLOYEE_ID"], $_POST["AMOUNT"], $_POST["PAYMENT_DATE"], $_POST["PAYMENT_MONTH"], $_POST["PAYMENT_METHOD"], $_POST["NOTES"]));
        break;
    case "DELETE_SALARY_PAYMENT":
        echo json_encode(deleteSalaryPayment($_POST["ID"]));
        break;
    // ===================== END SALARY MANAGEMENT =====================

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

    // ===================== FORGOT PASSWORD =====================
    case "FORGOT_VERIFY_IDENTITY":
        $result = forgotVerifyIdentity($_POST["mobile"], $_POST["username"]);
        echo json_encode($result);
        break;

    case "FORGOT_RESET_PASSWORD":
        $result = forgotResetPassword($_POST["userId"], $_POST["mobile"], $_POST["newPassword"]);
        echo json_encode($result);
        break;

    // ===================== REGISTER NEW ADMIN =====================
    case "REGISTER_NEW_ADMIN":
        $result = registerNewAdmin($_POST["username"], $_POST["mobile"], $_POST["password"], $_POST["role"], $_POST["approvalCode"]);
        echo json_encode($result);
        break;

    // ===================== ADMIN APPROVAL CODE MANAGEMENT =====================
    case "GET_APPROVAL_CODE":
        $result = getApprovalCode();
        echo json_encode($result);
        break;

    case "REGENERATE_APPROVAL_CODE":
        $result = regenerateApprovalCode();
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
        break;
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
    // Get order info using prepared statement to prevent SQL injection
    $orderStmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
    $orderStmt->bind_param("i", $orderId);
    $orderStmt->execute();
    $orderResult = $orderStmt->get_result();
    
    if ($orderResult->num_rows === 0) {
        return ['error' => 'Order not found'];
    }
    
    $order = $orderResult->fetch_assoc();
    
    // Get order items using prepared statement
    $itemsStmt = $conn->prepare("SELECT oi.*, p.name 
                 FROM order_items oi
                 JOIN products p ON oi.product_id = p.id
                 WHERE oi.order_id = ?");
    $itemsStmt->bind_param("i", $orderId);
    $itemsStmt->execute();
    $itemsResult = $itemsStmt->get_result();
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
    // First delete order items using prepared statement
    $deleteItemsStmt = $conn->prepare("DELETE FROM order_items WHERE order_id = ?");
    $deleteItemsStmt->bind_param("i", $orderId);
    $deleteItemsStmt->execute();
    
    // Then delete the order using prepared statement
    $deleteOrderStmt = $conn->prepare("DELETE FROM orders WHERE id = ?");
    $deleteOrderStmt->bind_param("i", $orderId);
    
    if ($deleteOrderStmt->execute()) {
        return ['success' => true, 'message' => 'Order deleted successfully'];
    } else {
        return ['success' => false, 'message' => 'Failed to delete order'];
    }
}

function getStockPaymentList(){
    global $conn;
    $stmt = $conn->prepare("SELECT productname, quantity, totalbillamount, COALESCE(paid_amount, 0) as paid_amount, COALESCE(payment_mode, 'N/A') as payment_mode, payment_date, agencyname FROM `stock` WHERE DATE(payment_date) = CURRENT_DATE AND paid_amount > 0");
    if ($stmt) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $stockpayment = array();
            while ($row = $result->fetch_assoc()) {
                $temparr = array(
                    $row['productname'], 
                    $row['quantity'], 
                    number_format(floatval($row['totalbillamount']), 2, '.', ''),
                    number_format(floatval($row['paid_amount']), 2, '.', ''),
                    $row['payment_mode'], 
                    $row['payment_date'], 
                    $row['agencyname']
                );
                array_push($stockpayment, $temparr);
            }
            return json_encode($stockpayment);
        } else {
            return json_encode([]);
        }
    } else {
        return json_encode([]);
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
    
    // Get today's total income from payments (includes both current day sales and previous bill payments received today)
    $stmt = $conn->prepare("SELECT COALESCE(SUM(amount_paid), 0) AS totalincome FROM `payments` WHERE DATE(payment_date) = CURRENT_DATE");
    if (!$stmt) {
        return json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
    }
    
    if (!$stmt->execute()) {
        return json_encode(["success" => false, "message" => "Database error: " . $stmt->error]);
    }
    
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $totalincome = floatval($row['totalincome']);
    $stmt->close();

    // Get today's expenses
    $stmt1 = $conn->prepare("SELECT COALESCE(SUM(amount), 0) AS expense FROM `expenses` WHERE expense_date = CURRENT_DATE");
    if (!$stmt1) {
        return json_encode(["success" => false, "message" => "Prepare failed for expenses: " . $conn->error]);
    }
    $stmt1->execute();
    $result1 = $stmt1->get_result();
    $row1 = $result1->fetch_assoc();
    $todaysexpense = floatval($row1['expense']);
    $stmt1->close();

    // Get today's Stock Payment (payments made to suppliers for stock)
    $stmt2 = $conn->prepare("SELECT COALESCE(SUM(paid_amount), 0) AS stockpayment FROM `stock` WHERE payment_status IN ('Paid', 'Partial') AND DATE(payment_date) = CURRENT_DATE");
    if (!$stmt2) {
        return json_encode(["success" => false, "message" => "Prepare failed for stock payments: " . $conn->error]);
    }
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    $row2 = $result2->fetch_assoc();
    $todaysstockpayment = floatval($row2['stockpayment']);
    $stmt2->close();

    // Get previous payment income (payments received today for bills created on previous days)
    $stmt3 = $conn->prepare("SELECT COALESCE(SUM(p.amount_paid), 0) AS previous_income 
                              FROM payments p 
                              JOIN bills b ON p.bill_id = b.id 
                              WHERE DATE(p.payment_date) = CURRENT_DATE 
                              AND DATE(b.bill_date) < CURRENT_DATE");
    if (!$stmt3) {
        return json_encode(["success" => false, "message" => "Prepare failed for previous payments: " . $conn->error]);
    }
    $stmt3->execute();
    $result3 = $stmt3->get_result();
    $row3 = $result3->fetch_assoc();
    $previousPaymentIncome = floatval($row3['previous_income']);
    $stmt3->close();

    // Get today's salary payments
    $stmt4 = $conn->prepare("SELECT COALESCE(SUM(amount), 0) AS salarypayment FROM `salary_payments` WHERE payment_date = CURRENT_DATE");
    if (!$stmt4) {
        return json_encode(["success" => false, "message" => "Prepare failed for salary payments: " . $conn->error]);
    }
    $stmt4->execute();
    $result4 = $stmt4->get_result();
    $row4 = $result4->fetch_assoc();
    $todayssalarypayment = floatval($row4['salarypayment']);
    $stmt4->close();

    // Calculate Net Profit: Total Income - Expenses - Stock Payments - Salary Payments
    $netProfit = $totalincome - $todaysexpense - $todaysstockpayment - $todayssalarypayment;

    // Final Result with detailed breakdown
    $finalResult = array(
        "totalincome" => number_format($totalincome, 2, '.', ''),
        "todaysexpense" => number_format($todaysexpense, 2, '.', ''),
        "stockpayment" => number_format($todaysstockpayment, 2, '.', ''),
        "salarypayment" => number_format($todayssalarypayment, 2, '.', ''),
        "previouspaymentincome" => number_format($previousPaymentIncome, 2, '.', ''),
        "netprofit" => number_format($netProfit, 2, '.', '')
    );
    
    return json_encode($finalResult);
}

function getTotalExpense()
{
    global $conn;
    $stmt = $conn->prepare("SELECT COALESCE(SUM(amount), 0) AS Expense FROM `expenses` WHERE DATE(expense_date) = CURRENT_DATE");
    if ($stmt) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $expense = array(array(number_format(floatval($row['Expense']), 2, '.', '')));
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
    $stmt = $conn->prepare("SELECT counter_name AS countername, DATE(bill_date) AS billdate, DATE(payment_date) AS paymentdate, payment_method AS paymentmode, payments.amount_paid AS amountpaid FROM `bills` RIGHT JOIN `payments` ON bills.id = payments.bill_id WHERE DATE(bills.bill_date) != DATE(payments.payment_date) AND DATE(payments.payment_date) = CURRENT_DATE ORDER BY payments.payment_date DESC");
    if ($stmt) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $getPreviousPayment = array();
            while ($row = $result->fetch_assoc()) {
                $temparr = array(
                    $row['countername'] ?? 'N/A', 
                    $row['billdate'], 
                    $row['paymentdate'], 
                    $row['paymentmode'], 
                    number_format(floatval($row['amountpaid']), 2, '.', '')
                );
                array_push($getPreviousPayment, $temparr);
            }
            return json_encode($getPreviousPayment);
        } else {
            return json_encode([]);
        }
    } else {
        return json_encode([]);
    }
}

function getPhonepeList()
{
    global $conn;
    // Match both 'Phonepe' and 'PhonePe' spellings
    $stmt = $conn->prepare("SELECT counter_name AS counter, amount_paid AS amountpaid FROM `bills` RIGHT JOIN `payments` ON bills.id = payments.bill_id WHERE (payments.payment_method = 'Phonepe' OR payments.payment_method = 'PhonePe') AND DATE(payments.payment_date) = CURRENT_DATE ORDER BY `payments`.`amount_paid` DESC");
    if ($stmt) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $getPhonepelist = array();
            while ($row = $result->fetch_assoc()) {
                $temparr = array(
                    $row['counter'] ?? 'N/A', 
                    number_format(floatval($row['amountpaid']), 2, '.', '')
                );
                array_push($getPhonepelist, $temparr);
            }
            return json_encode($getPhonepelist);
        } else {
            return json_encode([]);
        }
    } else {
        return json_encode([]);
    }
}

function getUnpaidList()
{
    global $conn;
    $stmt = $conn->prepare("SELECT counter_name AS countername, total_bill_amount AS billamount, paid_amount AS paidamount FROM `bills` WHERE payment_status != 'Paid' ORDER BY bill_date DESC");
    if ($stmt) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $getUnpaid = array();
            while ($row = $result->fetch_assoc()) {
                $remaining = floatval($row['billamount']) - floatval($row['paidamount']);
                $temparr = array(
                    $row['countername'], 
                    number_format(floatval($row['billamount']), 2, '.', ''),
                    number_format(floatval($row['paidamount']), 2, '.', '')
                );
                array_push($getUnpaid, $temparr);
            }
            return json_encode($getUnpaid);
        } else {
            return json_encode([]);
        }
    } else {
        return json_encode([]);
    }
}

function getTodayCashFlow()
{
    global $conn;
    $getCashFlow = array();
    
    // Cash From Payments (today)
    $stmt = $conn->prepare("SELECT COALESCE(SUM(amount_paid), 0) AS Cash FROM payments WHERE payment_method = 'Cash' AND DATE(payment_date) = CURRENT_DATE");
    if ($stmt) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $getCashFlow[] = array(array('Cash' => number_format(floatval($row['Cash']), 2, '.', '')));
            $stmt->close();
        }
    }
    
    // PhonePe From Payments (today) - check both 'Phonepe' and 'PhonePe' cases
    $stmt1 = $conn->prepare("SELECT COALESCE(SUM(amount_paid), 0) AS Phonepe FROM payments WHERE (payment_method = 'Phonepe' OR payment_method = 'PhonePe') AND DATE(payment_date) = CURRENT_DATE");
    if ($stmt1) {
        if ($stmt1->execute()) {
            $result1 = $stmt1->get_result();
            $row1 = $result1->fetch_assoc();
            $getCashFlow[] = array(array('Phonepe' => number_format(floatval($row1['Phonepe']), 2, '.', '')));
            $stmt1->close();
        }
    }
    
    // Unpaid From Bills (all unpaid + partially paid remaining)
    $stmt2 = $conn->prepare("SELECT COALESCE(SUM(total_bill_amount - paid_amount), 0) AS Unpaid FROM bills WHERE payment_status IN ('Unpaid', 'Partially Paid')");
    if ($stmt2) {
        if ($stmt2->execute()) {
            $result2 = $stmt2->get_result();
            $row2 = $result2->fetch_assoc();
            $getCashFlow[] = array(array('Unpaid' => number_format(floatval($row2['Unpaid']), 2, '.', '')));
            $stmt2->close();
        }
    }
    
    // Today's Total Sales from Bills
    $stmt3 = $conn->prepare("SELECT COALESCE(SUM(total_bill_amount), 0) AS sell FROM bills WHERE DATE(bill_date) = CURRENT_DATE");
    if ($stmt3) {
        if ($stmt3->execute()) {
            $result3 = $stmt3->get_result();
            $row3 = $result3->fetch_assoc();
            $getCashFlow[] = array(array('sell' => number_format(floatval($row3['sell']), 2, '.', '')));
            $stmt3->close();
        }
    }

    return json_encode($getCashFlow);
}

// ===================== FILTERED AUDIT FUNCTIONS =====================

/**
 * Get filtered audit statistics for a date range
 */
function getFilteredAuditStats($startDate, $endDate) {
    global $conn;
    
    // Income from payments in date range
    $incomeStmt = $conn->prepare("SELECT COALESCE(SUM(amount_paid), 0) AS income FROM payments WHERE DATE(payment_date) BETWEEN ? AND ?");
    $incomeStmt->bind_param("ss", $startDate, $endDate);
    $incomeStmt->execute();
    $income = $incomeStmt->get_result()->fetch_assoc()['income'];
    $incomeStmt->close();
    
    // Operating expenses in date range
    $expenseStmt = $conn->prepare("SELECT COALESCE(SUM(amount), 0) AS expense FROM expenses WHERE DATE(expense_date) BETWEEN ? AND ?");
    $expenseStmt->bind_param("ss", $startDate, $endDate);
    $expenseStmt->execute();
    $operatingExpense = $expenseStmt->get_result()->fetch_assoc()['expense'];
    $expenseStmt->close();
    
    // Stock payments in date range
    $stockStmt = $conn->prepare("SELECT COALESCE(SUM(paid_amount), 0) AS stockpayment FROM stock WHERE payment_status IN ('Paid', 'Partial') AND DATE(payment_date) BETWEEN ? AND ?");
    $stockStmt->bind_param("ss", $startDate, $endDate);
    $stockStmt->execute();
    $stockPayment = $stockStmt->get_result()->fetch_assoc()['stockpayment'];
    $stockStmt->close();
    
    // Salary payments in date range
    $salaryStmt = $conn->prepare("SELECT COALESCE(SUM(amount), 0) AS salarypayment FROM salary_payments WHERE DATE(payment_date) BETWEEN ? AND ?");
    $salaryStmt->bind_param("ss", $startDate, $endDate);
    $salaryStmt->execute();
    $salaryPayment = $salaryStmt->get_result()->fetch_assoc()['salarypayment'];
    $salaryStmt->close();
    
    // Calculate totals
    $totalExpenses = floatval($operatingExpense) + floatval($stockPayment) + floatval($salaryPayment);
    $netProfit = floatval($income) - $totalExpenses;
    
    return array(
        "success" => true,
        "income" => number_format($income, 2, '.', ''),
        "operatingexpense" => number_format($operatingExpense, 2, '.', ''),
        "stockpayment" => number_format($stockPayment, 2, '.', ''),
        "salarypayment" => number_format($salaryPayment, 2, '.', ''),
        "totalexpenses" => number_format($totalExpenses, 2, '.', ''),
        "netprofit" => number_format($netProfit, 2, '.', '')
    );
}

/**
 * Get filtered cash flow for a date range
 */
function getFilteredCashFlow($startDate, $endDate) {
    global $conn;
    
    // Cash from payments in date range
    $cashStmt = $conn->prepare("SELECT COALESCE(SUM(amount_paid), 0) AS cash FROM payments WHERE payment_method = 'Cash' AND DATE(payment_date) BETWEEN ? AND ?");
    $cashStmt->bind_param("ss", $startDate, $endDate);
    $cashStmt->execute();
    $cash = $cashStmt->get_result()->fetch_assoc()['cash'];
    $cashStmt->close();
    
    // PhonePe from payments in date range
    $phonepeStmt = $conn->prepare("SELECT COALESCE(SUM(amount_paid), 0) AS phonepe FROM payments WHERE (payment_method = 'Phonepe' OR payment_method = 'PhonePe') AND DATE(payment_date) BETWEEN ? AND ?");
    $phonepeStmt->bind_param("ss", $startDate, $endDate);
    $phonepeStmt->execute();
    $phonepe = $phonepeStmt->get_result()->fetch_assoc()['phonepe'];
    $phonepeStmt->close();
    
    // Total unpaid (all time - not filtered by date)
    $unpaidStmt = $conn->prepare("SELECT COALESCE(SUM(total_bill_amount - paid_amount), 0) AS unpaid FROM bills WHERE payment_status IN ('Unpaid', 'Partially Paid')");
    $unpaidStmt->execute();
    $unpaid = $unpaidStmt->get_result()->fetch_assoc()['unpaid'];
    $unpaidStmt->close();
    
    // Total sales in date range
    $salesStmt = $conn->prepare("SELECT COALESCE(SUM(total_bill_amount), 0) AS sales FROM bills WHERE DATE(bill_date) BETWEEN ? AND ?");
    $salesStmt->bind_param("ss", $startDate, $endDate);
    $salesStmt->execute();
    $sales = $salesStmt->get_result()->fetch_assoc()['sales'];
    $salesStmt->close();
    
    return array(
        "success" => true,
        "cash" => number_format($cash, 2, '.', ''),
        "phonepe" => number_format($phonepe, 2, '.', ''),
        "unpaid" => number_format($unpaid, 2, '.', ''),
        "totalsales" => number_format($sales, 2, '.', '')
    );
}

/**
 * Get PhonePe transactions list for a date range
 */
function getFilteredPhonePeList($startDate, $endDate) {
    global $conn;
    $stmt = $conn->prepare("
        SELECT 
            b.counter_name AS counter, 
            p.amount_paid AS amountpaid,
            DATE(p.payment_date) AS paymentdate
        FROM payments p 
        LEFT JOIN bills b ON b.id = p.bill_id 
        WHERE (p.payment_method = 'Phonepe' OR p.payment_method = 'PhonePe') 
        AND DATE(p.payment_date) BETWEEN ? AND ?
        ORDER BY p.payment_date DESC
    ");
    $stmt->bind_param("ss", $startDate, $endDate);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $list = array();
    while ($row = $result->fetch_assoc()) {
        $list[] = array(
            $row['counter'] ?? 'N/A',
            number_format(floatval($row['amountpaid']), 2, '.', ''),
            $row['paymentdate']
        );
    }
    $stmt->close();
    
    return $list;
}

/**
 * Get payment list for a date range
 */
function getFilteredPaymentList($startDate, $endDate) {
    global $conn;
    $stmt = $conn->prepare("
        SELECT 
            b.counter_name AS countername, 
            DATE(b.bill_date) AS billdate, 
            DATE(p.payment_date) AS paymentdate, 
            p.payment_method AS paymentmode, 
            p.amount_paid AS amountpaid 
        FROM payments p 
        LEFT JOIN bills b ON b.id = p.bill_id 
        WHERE DATE(p.payment_date) BETWEEN ? AND ?
        ORDER BY p.payment_date DESC
    ");
    $stmt->bind_param("ss", $startDate, $endDate);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $list = array();
    while ($row = $result->fetch_assoc()) {
        $list[] = array(
            $row['countername'] ?? 'N/A',
            $row['billdate'],
            $row['paymentdate'],
            $row['paymentmode'],
            number_format(floatval($row['amountpaid']), 2, '.', '')
        );
    }
    $stmt->close();
    
    return $list;
}

/**
 * Get stock payments for a date range
 */
function getFilteredStockPayments($startDate, $endDate) {
    global $conn;
    $stmt = $conn->prepare("
        SELECT 
            s.productname,
            s.quantity,
            s.totalbillamount,
            s.paid_amount,
            s.payment_mode,
            DATE(s.buydate) AS stockdate,
            s.agencyname
        FROM stock s
        WHERE payment_status IN ('Paid', 'Partial') AND DATE(s.payment_date) BETWEEN ? AND ?
        ORDER BY s.payment_date DESC
    ");
    $stmt->bind_param("ss", $startDate, $endDate);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $list = array();
    while ($row = $result->fetch_assoc()) {
        $list[] = array(
            $row['productname'],
            $row['quantity'],
            number_format(floatval($row['totalbillamount']), 2, '.', ''),
            number_format(floatval($row['paid_amount']), 2, '.', ''),
            $row['payment_mode'] ?? 'N/A',
            $row['stockdate'],
            $row['agencyname']
        );
    }
    $stmt->close();
    
    return $list;
}

// ===================== END FILTERED AUDIT FUNCTIONS =====================

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

function insertBill($products, $counterName, $paymentMethod, $totalBillAmount, $customerName = null, $customerPhone = null)
{

    global $conn;
    $conn->begin_transaction();

    try {
        // Insert into bills with customer info
        $paymentStatus = ($paymentMethod == 'Unpaid') ? 'Unpaid' : 'Paid';
        $paidAmount = ($paymentMethod == 'Unpaid') ? 0 : $totalBillAmount;

        $stmt = $conn->prepare("INSERT INTO bills (counter_name, total_bill_amount, payment_status, paid_amount, customer_name, customer_phone, bill_date) VALUES (?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)");
        $stmt->bind_param("sdsdss", $counterName, $totalBillAmount, $paymentStatus, $paidAmount, $customerName, $customerPhone);
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

    $remainingQty = $quantity;
    $stockQuery = $conn->prepare("SELECT id, quantity FROM stock WHERE productname = ? AND quantity > 0 ORDER BY buydate ASC");
    $stockQuery->bind_param("s", $productname);
    $stockQuery->execute();
    $stockResult = $stockQuery->get_result();

    while ($remainingQty > 0 && $row = $stockResult->fetch_assoc()) {
        $stockId = $row['id'];
        $stockQty = $row['quantity'];

        if ($stockQty >= $remainingQty) {
            // Deduct from this batch
            $newQty = $stockQty - $remainingQty;

            if ($newQty > 0) {
                // Update stock if some quantity remains
                $updateStock = $conn->prepare("UPDATE stock SET quantity = ? WHERE id = ?");
                $updateStock->bind_param("di", $newQty, $stockId);

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

            $remainingQty = 0;
        } else {
            // Use all from this batch and continue to next
            $remainingQty -= $stockQty;
            $deleteStock = $conn->prepare("DELETE FROM stock WHERE id = ?");
            $deleteStock->bind_param("i", $stockId);

            if (!$deleteStock->execute()) {
                throw new Exception("Error deleting stock: " . $deleteStock->error);
            }
        }
    }

    $stockQuery->close();

    if ($remainingQty > 0) {
        throw new Exception("Insufficient stock for $productname. Needed: $quantity, Available: " . ($quantity - $remainingQty));
    }
}

// Deduct scheme product stock using FIFO logic
function deductSchemeStock($schemeProduct, $schemeQty)
{
    global $conn;

    $remainingQty = $schemeQty;
    $schemeQuery = $conn->prepare("SELECT id, quantity FROM stock WHERE productname = ? AND quantity > 0 ORDER BY buydate ASC");
    $schemeQuery->bind_param("s", $schemeProduct);
    $schemeQuery->execute();
    $schemeResult = $schemeQuery->get_result();

    while ($remainingQty > 0 && $row = $schemeResult->fetch_assoc()) {
        $stockId = $row['id'];
        $currentQty = $row['quantity'];

        $deductQty = min($remainingQty, $currentQty);
        $newQty = $currentQty - $deductQty;

        if ($newQty > 0) {
            $updateStock = $conn->prepare("UPDATE stock SET quantity = ? WHERE id = ?");
            $updateStock->bind_param("di", $newQty, $stockId);

            if (!$updateStock->execute()) {
                throw new Exception("Error updating scheme stock: " . $updateStock->error);
            }
        } else {
            // Delete if stock is exhausted
            $deleteStock = $conn->prepare("DELETE FROM stock WHERE id = ?");
            $deleteStock->bind_param("i", $stockId);
            if (!$deleteStock->execute()) {
                throw new Exception("Error deleting scheme stock: " . $deleteStock->error);
            }
        }

        $remainingQty -= $deductQty;
    }

    $schemeQuery->close();

    if ($remainingQty > 0) {
        throw new Exception("Insufficient stock for scheme product $schemeProduct. Needed: $schemeQty, Available: " . ($schemeQty - $remainingQty));
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
    $stmt = $conn->prepare("SELECT COALESCE(SUM(totalbillamount), 0) AS total_sum FROM sell WHERE DATE(sellDate) = CURRENT_DATE");
    if ($stmt) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $totalSum = number_format(floatval($row["total_sum"]), 2, '.', '');
            return json_encode(array(array($totalSum)));
        } else {
            return json_encode(array(array("0.00")));
        }
    } else {
        return json_encode(array(array("0.00")));
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
    if ($stmt) {
        $stmt->bind_param("s", $productname);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            return json_encode($row);
        } else {
            return json_encode(["total_quantity" => 0]);
        }
    }
    return json_encode(["total_quantity" => 0]);
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
            return json_encode(["success" => true, "message" => "Counter added successfully!"]);
        } else {
            return json_encode(["success" => false, "message" => "Failed to add counter."]);
        }
    }
    return json_encode(["success" => false, "message" => "Database error."]);
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
            $finalresult = array("result" => 1, "success" => true, "message" => "Added Successfully...!");
            return json_encode($finalresult);
        } else {
            return json_encode(array("result" => 0, "success" => false, "message" => "Database error"));
        }
    }
    return json_encode(array("result" => 0, "success" => false, "message" => "Prepare error"));
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
            $finalresult = array("result" => 1, "success" => true, "message" => "Added Successfully...!");
            return json_encode($finalresult);
        } else {
            return json_encode(array("result" => 0, "success" => false, "message" => "Database error"));
        }
    }
    return json_encode(array("result" => 0, "success" => false, "message" => "Prepare error"));
}

function getInsertedStock()
{
    global $conn;
    $stmt = $conn->prepare("SELECT id, productname, ml, quantity, priceperbox, totalbillamount, agencyname, batch_number, expiry_date, buydate FROM `stock` ORDER BY buydate DESC");
    if ($stmt) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $totalStock = array();
            while ($row = $result->fetch_assoc()) {
                $expiryFormatted = $row["expiry_date"] ? date('Y-m-d', strtotime($row["expiry_date"])) : '-';
                $temparr = array(
                    $row["id"], 
                    $row["productname"], 
                    $row["quantity"], 
                    $row["ml"], 
                    '₹' . number_format($row["priceperbox"]), 
                    '₹' . number_format($row["totalbillamount"]), 
                    $row["agencyname"], 
                    $row["batch_number"] ?? '-',
                    $expiryFormatted,
                    date('d M Y', strtotime($row["buydate"]))
                );
                array_push($totalStock, $temparr);
            }
            return json_encode($totalStock);
        } else {
            return json_encode(array("error" => "Execute Error"));
        }
    } else {
        return json_encode(array("error" => "Prepare Error"));
    }
}

function insertStock($productname, $quantity, $bottles, $priceperbox, $totalbillamount, $agencyname, $partialpayment, $paymentmode, $batchNumber = null, $expiryDate = null, $lowStockThreshold = 5)
{
    global $conn;
    
    // Insert with new fields: batch_number, expiry_date, low_stock_threshold
    $ml = (int)$bottles; // Using bottles as ml value
    $quantity = (int)$quantity;
    $priceperbox = (float)$priceperbox;
    $totalbillamount = (float)$totalbillamount;
    $lowStockThreshold = (int)$lowStockThreshold;
    $expiryDate = !empty($expiryDate) ? $expiryDate : null;
    $batchNumber = !empty($batchNumber) ? $batchNumber : null;
    
    // Calculate payment data
    $paidAmount = 0;
    $paymentStatus = 'Unpaid';
    $paymentDateVal = null;
    if (!empty($paymentmode) && $paymentmode !== 'SelectPayment' && $paymentmode !== 'Unpaid') {
        if (stripos($paymentmode, 'Partial') !== false || (!empty($partialpayment) && $partialpayment > 0 && $partialpayment < $totalbillamount)) {
            $paidAmount = (float)$partialpayment;
            $paymentStatus = 'Partial';
            $paymentDateVal = date('Y-m-d H:i:s');
        } else {
            $paidAmount = $totalbillamount;
            $paymentStatus = 'Paid';
            $paymentDateVal = date('Y-m-d H:i:s');
        }
    }
    
    $stmt = $conn->prepare("INSERT INTO `stock` (`productname`, `ml`, `quantity`, `priceperbox`, `totalbillamount`, `agencyname`, `paid_amount`, `payment_status`, `payment_mode`, `payment_date`, `batch_number`, `expiry_date`, `low_stock_threshold`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("siiddsdsssssi", $productname, $ml, $quantity, $priceperbox, $totalbillamount, $agencyname, $paidAmount, $paymentStatus, $paymentmode, $paymentDateVal, $batchNumber, $expiryDate, $lowStockThreshold);
        if ($stmt->execute()) {
            return json_encode(array("result" => 1, "message" => "Stock added successfully!"));
        } else {
            return json_encode(array("result" => 0, "message" => "Error: " . $stmt->error));
        }
        $stmt->close();
    } else {
        return json_encode(array("result" => 0, "message" => "Prepare error: " . $conn->error));
    }
}

// Get Low Stock Alerts
function getLowStockAlerts()
{
    global $conn;
    $stmt = $conn->prepare("SELECT id, productname, ml, quantity, low_stock_threshold, expiry_date, 
        DATEDIFF(expiry_date, CURDATE()) as days_until_expiry 
        FROM stock 
        WHERE quantity <= low_stock_threshold OR (expiry_date IS NOT NULL AND DATEDIFF(expiry_date, CURDATE()) <= 30)
        ORDER BY quantity ASC");
    if ($stmt) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $alerts = array();
            while ($row = $result->fetch_assoc()) {
                $alerts[] = $row;
            }
            return json_encode($alerts);
        }
    }
    return json_encode([]);
}

// Get Stock by ID
function getStockById($stockId)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM stock WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $stockId);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                return json_encode(["success" => true, "data" => $row]);
            }
        }
    }
    return json_encode(["success" => false, "message" => "Stock not found"]);
}

// Update Stock
function updateStock($stockId, $quantity, $ml, $priceperbox, $batchNumber, $expiryDate, $lowStockThreshold)
{
    global $conn;
    $expiryDate = !empty($expiryDate) ? $expiryDate : null;
    
    $stmt = $conn->prepare("UPDATE stock SET quantity = ?, ml = ?, priceperbox = ?, batch_number = ?, expiry_date = ?, low_stock_threshold = ? WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("iidssii", $quantity, $ml, $priceperbox, $batchNumber, $expiryDate, $lowStockThreshold, $stockId);
        if ($stmt->execute()) {
            return json_encode(["success" => true, "message" => "Stock updated successfully"]);
        } else {
            return json_encode(["success" => false, "message" => "Error: " . $stmt->error]);
        }
    }
    return json_encode(["success" => false, "message" => "Database error"]);
}

// Delete Stock
function deleteStock($stockId)
{
    global $conn;
    $stmt = $conn->prepare("DELETE FROM stock WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $stockId);
        if ($stmt->execute()) {
            return json_encode(["success" => true, "message" => "Stock deleted successfully"]);
        } else {
            return json_encode(["success" => false, "message" => "Error: " . $stmt->error]);
        }
    }
    return json_encode(["success" => false, "message" => "Database error"]);
}

// Get Stock History (Timeline view)
function getStockHistory($productName = null, $fromDate = null, $toDate = null)
{
    global $conn;
    
    $sql = "SELECT id, productname, ml, quantity, priceperbox, totalbillamount, agencyname, batch_number, expiry_date, buydate as created_at, 'ADDED' as action_type 
        FROM stock WHERE 1=1";
    $params = [];
    $types = "";
    
    if (!empty($productName)) {
        $sql .= " AND productname = ?";
        $params[] = $productName;
        $types .= "s";
    }
    if (!empty($fromDate)) {
        $sql .= " AND DATE(buydate) >= ?";
        $params[] = $fromDate;
        $types .= "s";
    }
    if (!empty($toDate)) {
        $sql .= " AND DATE(buydate) <= ?";
        $params[] = $toDate;
        $types .= "s";
    }
    
    $sql .= " ORDER BY buydate DESC LIMIT 100";
    
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $history = array();
            while ($row = $result->fetch_assoc()) {
                $history[] = $row;
            }
            return json_encode(["success" => true, "data" => $history]);
        }
    }
    return json_encode(["success" => false, "message" => "Database error"]);
}

// Get distinct product names for dropdown
function getProductNames()
{
    global $conn;
    $stmt = $conn->prepare("SELECT DISTINCT productname FROM stock ORDER BY productname ASC");
    if ($stmt) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $products = array();
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
            return json_encode(["success" => true, "data" => $products]);
        }
    }
    return json_encode(["success" => false, "message" => "Database error"]);
}

// Search Bills
function searchBills($dateFrom, $dateTo, $counter, $customerPhone)
{
    global $conn;
    $sql = "SELECT b.id as bill_id, b.counter_name, b.total_bill_amount as total_amount, b.payment_status as payment_method, b.bill_date as created_at, b.customer_name, b.customer_phone 
            FROM bills b WHERE 1=1";
    $params = [];
    $types = "";
    
    if (!empty($dateFrom)) {
        $sql .= " AND DATE(b.bill_date) >= ?";
        $params[] = $dateFrom;
        $types .= "s";
    }
    if (!empty($dateTo)) {
        $sql .= " AND DATE(b.bill_date) <= ?";
        $params[] = $dateTo;
        $types .= "s";
    }
    if (!empty($counter)) {
        $sql .= " AND b.counter_name = ?";
        $params[] = $counter;
        $types .= "s";
    }
    if (!empty($customerPhone)) {
        $sql .= " AND b.customer_phone LIKE ?";
        $params[] = "%$customerPhone%";
        $types .= "s";
    }
    
    $sql .= " ORDER BY b.bill_date DESC LIMIT 200";
    
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $bills = array();
            while ($row = $result->fetch_assoc()) {
                $bills[] = $row;
            }
            return json_encode(["success" => true, "data" => $bills]);
        }
    }
    return json_encode(["success" => false, "message" => "Database error"]);
}

function getTotalStock()
{
    global $conn;
    $stmt = $conn->prepare("SELECT id, productname, quantity, priceperbox, totalbillamount, COALESCE(paid_amount, 0) as paid_amount, COALESCE(payment_status, 'Unpaid') as payment_status, agencyname, buydate FROM `stock` ORDER BY id DESC");
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

// ===================== SALARY MANAGEMENT FUNCTIONS =====================

// Get Salary Statistics
function getSalaryStats() {
    global $conn;
    
    // Total employees
    $stmt = $conn->query("SELECT COUNT(*) as total FROM employees");
    $totalEmployees = $stmt->fetch_assoc()['total'];
    
    // Active employees
    $stmt = $conn->query("SELECT COUNT(*) as active FROM employees WHERE status = 'Active'");
    $activeEmployees = $stmt->fetch_assoc()['active'];
    
    // Monthly payroll (sum of active employees' salaries)
    $stmt = $conn->query("SELECT COALESCE(SUM(monthly_salary), 0) as payroll FROM employees WHERE status = 'Active'");
    $monthlyPayroll = $stmt->fetch_assoc()['payroll'];
    
    // Paid this month
    $currentMonth = date('Y-m');
    $stmt = $conn->prepare("SELECT COALESCE(SUM(amount), 0) as paid FROM salary_payments WHERE payment_month = ?");
    $stmt->bind_param("s", $currentMonth);
    $stmt->execute();
    $paidThisMonth = $stmt->get_result()->fetch_assoc()['paid'];
    
    return [
        "success" => true,
        "total_employees" => $totalEmployees,
        "active_employees" => $activeEmployees,
        "monthly_payroll" => $monthlyPayroll,
        "paid_this_month" => $paidThisMonth
    ];
}

// Get All Employees
function getEmployees() {
    global $conn;
    $stmt = $conn->query("SELECT * FROM employees ORDER BY status DESC, name ASC");
    $employees = [];
    while ($row = $stmt->fetch_assoc()) {
        $employees[] = $row;
    }
    return ["success" => true, "data" => $employees];
}

// Get Active Employees (for dropdowns)
function getActiveEmployees() {
    global $conn;
    $stmt = $conn->query("SELECT id, name, monthly_salary FROM employees WHERE status = 'Active' ORDER BY name ASC");
    $employees = [];
    while ($row = $stmt->fetch_assoc()) {
        $employees[] = $row;
    }
    return ["success" => true, "data" => $employees];
}

// Get Single Employee
function getEmployee($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM employees WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        return ["success" => true, "data" => $row];
    }
    return ["success" => false, "message" => "Employee not found"];
}

// Add Employee
function addEmployee($name, $phone, $role, $salary, $joinDate) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO employees (name, phone, role, monthly_salary, join_date) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssds", $name, $phone, $role, $salary, $joinDate);
    if ($stmt->execute()) {
        return ["success" => true, "message" => "Employee added successfully!"];
    }
    return ["success" => false, "message" => "Failed to add employee: " . $conn->error];
}

// Update Employee
function updateEmployee($id, $name, $phone, $role, $salary) {
    global $conn;
    $stmt = $conn->prepare("UPDATE employees SET name = ?, phone = ?, role = ?, monthly_salary = ? WHERE id = ?");
    $stmt->bind_param("sssdi", $name, $phone, $role, $salary, $id);
    if ($stmt->execute()) {
        return ["success" => true, "message" => "Employee updated successfully!"];
    }
    return ["success" => false, "message" => "Failed to update employee"];
}

// Toggle Employee Status
function toggleEmployeeStatus($id, $status) {
    global $conn;
    $stmt = $conn->prepare("UPDATE employees SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    if ($stmt->execute()) {
        return ["success" => true, "message" => "Status changed to $status"];
    }
    return ["success" => false, "message" => "Failed to update status"];
}

// Delete Employee
function deleteEmployee($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM employees WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        return ["success" => true, "message" => "Employee deleted successfully!"];
    }
    return ["success" => false, "message" => "Failed to delete employee"];
}

// Get Pending Salaries for Current Month
function getPendingSalaries() {
    global $conn;
    $currentMonth = date('Y-m');
    
    $sql = "SELECT e.id, e.name, e.role, e.monthly_salary, 
            COALESCE((SELECT SUM(amount) FROM salary_payments WHERE employee_id = e.id AND payment_month = ?), 0) as paid
            FROM employees e 
            WHERE e.status = 'Active'
            ORDER BY e.name ASC";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $currentMonth);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $employees = [];
    while ($row = $result->fetch_assoc()) {
        $employees[] = $row;
    }
    return ["success" => true, "data" => $employees];
}

// Get Salary Payments History
function getSalaryPayments($month = null, $employeeId = null) {
    global $conn;
    
    $sql = "SELECT sp.*, e.name as employee_name 
            FROM salary_payments sp 
            JOIN employees e ON sp.employee_id = e.id 
            WHERE 1=1";
    $params = [];
    $types = "";
    
    if ($month) {
        $sql .= " AND sp.payment_month = ?";
        $params[] = $month;
        $types .= "s";
    }
    
    if ($employeeId) {
        $sql .= " AND sp.employee_id = ?";
        $params[] = $employeeId;
        $types .= "i";
    }
    
    $sql .= " ORDER BY sp.payment_date DESC, sp.id DESC";
    
    $stmt = $conn->prepare($sql);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    
    $payments = [];
    while ($row = $result->fetch_assoc()) {
        $payments[] = $row;
    }
    return ["success" => true, "data" => $payments];
}

// Add Salary Payment
function addSalaryPayment($employeeId, $amount, $paymentDate, $paymentMonth, $paymentMethod, $notes) {
    global $conn;
    
    $stmt = $conn->prepare("INSERT INTO salary_payments (employee_id, amount, payment_date, payment_month, payment_method, notes) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("idssss", $employeeId, $amount, $paymentDate, $paymentMonth, $paymentMethod, $notes);
    
    if ($stmt->execute()) {
        return ["success" => true, "message" => "Payment recorded successfully!"];
    }
    return ["success" => false, "message" => "Failed to record payment: " . $conn->error];
}

// Delete Salary Payment
function deleteSalaryPayment($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM salary_payments WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        return ["success" => true, "message" => "Payment deleted successfully!"];
    }
    return ["success" => false, "message" => "Failed to delete payment"];
}

// Get Today's Salary Payments (for audit)
function getTodaysSalaryPayments() {
    global $conn;
    $stmt = $conn->query("SELECT COALESCE(SUM(amount), 0) as total FROM salary_payments WHERE payment_date = CURRENT_DATE");
    return floatval($stmt->fetch_assoc()['total']);
}

// ===================== END SALARY MANAGEMENT FUNCTIONS =====================

// ===================== FORGOT PASSWORD FUNCTIONS =====================

function forgotVerifyIdentity($mobile, $username)
{
    global $conn;

    $mobile = trim($mobile);
    $username = trim($username);

    if (empty($mobile) || empty($username)) {
        return ["success" => false, "message" => "Mobile and username are required"];
    }

    $stmt = $conn->prepare("SELECT id, username FROM `admin` WHERE mobile = ? AND username = ?");
    if ($stmt) {
        $stmt->bind_param("ss", $mobile, $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            return [
                "success"  => true,
                "userId"   => $row["id"],
                "username" => $row["username"],
                "message"  => "Identity verified"
            ];
        } else {
            return ["success" => false, "message" => "No account found with this mobile number and username combination"];
        }
    }
    return ["success" => false, "message" => "Database error"];
}

function forgotResetPassword($userId, $mobile, $newPassword)
{
    global $conn;

    $userId = intval($userId);
    $mobile = trim($mobile);

    if ($userId <= 0 || empty($mobile) || empty($newPassword)) {
        return ["success" => false, "message" => "Invalid data"];
    }

    if (strlen($newPassword) < 4) {
        return ["success" => false, "message" => "Password must be at least 4 characters"];
    }

    // Double-check the user exists with matching mobile
    $checkStmt = $conn->prepare("SELECT id FROM `admin` WHERE id = ? AND mobile = ?");
    $checkStmt->bind_param("is", $userId, $mobile);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows !== 1) {
        return ["success" => false, "message" => "User verification failed"];
    }

    $hashedPassword = md5($newPassword);

    $stmt = $conn->prepare("UPDATE `admin` SET password = ? WHERE id = ? AND mobile = ?");
    if ($stmt) {
        $stmt->bind_param("sis", $hashedPassword, $userId, $mobile);
        if ($stmt->execute() && $stmt->affected_rows > 0) {
            return ["success" => true, "message" => "Password reset successfully"];
        } else {
            return ["success" => false, "message" => "Failed to update password"];
        }
    }
    return ["success" => false, "message" => "Database error"];
}

// ===================== REGISTER NEW ADMIN FUNCTIONS =====================

function ensureApprovalCodeTable()
{
    global $conn;
    $conn->query("CREATE TABLE IF NOT EXISTS `admin_settings` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `setting_key` varchar(100) NOT NULL UNIQUE,
        `setting_value` text NOT NULL,
        `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");

    // Insert default approval code if not exists
    $check = $conn->query("SELECT id FROM `admin_settings` WHERE setting_key = 'approval_code'");
    if ($check->num_rows === 0) {
        $defaultCode = md5('YASH' . date('Y')); // Default: md5 of 'YASH2026'
        $conn->query("INSERT INTO `admin_settings` (setting_key, setting_value) VALUES ('approval_code', '$defaultCode')");
    }
}

function registerNewAdmin($username, $mobile, $password, $role, $approvalCode)
{
    global $conn;

    $username = trim($username);
    $mobile = trim($mobile);
    $role = trim($role);
    $approvalCode = trim($approvalCode);

    // Validation
    if (empty($username) || empty($mobile) || empty($password) || empty($approvalCode)) {
        return ["success" => false, "message" => "All fields are required"];
    }

    if (strlen($username) < 2) {
        return ["success" => false, "message" => "Name must be at least 2 characters"];
    }

    if (strlen($mobile) < 10) {
        return ["success" => false, "message" => "Please enter a valid mobile number"];
    }

    if (strlen($password) < 4) {
        return ["success" => false, "message" => "Password must be at least 4 characters"];
    }

    // Only allow staff and manager roles through self-registration
    if (!in_array($role, ['staff', 'manager'])) {
        $role = 'staff';
    }

    // Verify approval code
    ensureApprovalCodeTable();
    $codeResult = $conn->query("SELECT setting_value FROM `admin_settings` WHERE setting_key = 'approval_code'");
    if ($codeResult->num_rows === 0) {
        return ["success" => false, "message" => "Approval system not configured"];
    }
    $storedCode = $codeResult->fetch_assoc()['setting_value'];

    // Check: code matches the stored hash OR code matches the raw hash
    if (md5($approvalCode) !== $storedCode && $approvalCode !== $storedCode) {
        return ["success" => false, "message" => "Invalid approval code. Please contact your administrator."];
    }

    // Check if mobile already exists
    $checkMobile = $conn->prepare("SELECT id FROM `admin` WHERE mobile = ?");
    $checkMobile->bind_param("s", $mobile);
    $checkMobile->execute();
    if ($checkMobile->get_result()->num_rows > 0) {
        return ["success" => false, "message" => "An account with this mobile number already exists"];
    }

    // Check if username already exists
    $checkUser = $conn->prepare("SELECT id FROM `admin` WHERE username = ?");
    $checkUser->bind_param("s", $username);
    $checkUser->execute();
    if ($checkUser->get_result()->num_rows > 0) {
        return ["success" => false, "message" => "This username is already taken"];
    }

    // Create account
    $hashedPassword = md5($password);
    $stmt = $conn->prepare("INSERT INTO `admin` (username, password, mobile, role) VALUES (?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("ssss", $username, $hashedPassword, $mobile, $role);
        if ($stmt->execute()) {
            return ["success" => true, "message" => "Account created successfully! You can now login."];
        } else {
            return ["success" => false, "message" => "Database error: " . $stmt->error];
        }
    }
    return ["success" => false, "message" => "Database error"];
}

function getApprovalCode()
{
    if (!isset($_SESSION['ROLE']) || $_SESSION['ROLE'] !== 'admin') {
        return ["success" => false, "message" => "Only admins can view the approval code"];
    }

    global $conn;
    ensureApprovalCodeTable();

    $result = $conn->query("SELECT setting_value, updated_at FROM `admin_settings` WHERE setting_key = 'approval_code'");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return ["success" => true, "code" => $row['setting_value'], "updatedAt" => $row['updated_at']];
    }
    return ["success" => false, "message" => "Code not found"];
}

function regenerateApprovalCode()
{
    if (!isset($_SESSION['ROLE']) || $_SESSION['ROLE'] !== 'admin') {
        return ["success" => false, "message" => "Only admins can regenerate the code"];
    }

    global $conn;
    ensureApprovalCodeTable();

    // Generate a random 8-char code and store its md5 hash
    $newCode = strtoupper(substr(md5(random_bytes(16)), 0, 8));
    $hashedCode = md5($newCode);

    $stmt = $conn->prepare("UPDATE `admin_settings` SET setting_value = ? WHERE setting_key = 'approval_code'");
    $stmt->bind_param("s", $hashedCode);
    if ($stmt->execute()) {
        return ["success" => true, "code" => $newCode, "message" => "New code generated. Share this with new users: " . $newCode];
    }
    return ["success" => false, "message" => "Failed to generate new code"];
}

// ===================== END AUTH FUNCTIONS =====================

function login($username, $password)
{
    // Start session if not already started
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    $hashedPassword = md5($password); // Note: Consider migrating to password_hash() in future
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
                // Note: Removed storing password in session for security

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
