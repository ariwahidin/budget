<?php

function check_already_login()
{
    $ci = &get_instance();
    $user_session = $ci->session->userdata('user_code');
    if ($user_session) {
        redirect('dashboard');
    }
}

function check_not_login()
{
    $ci = &get_instance();
    $user_session = $ci->session->userdata('user_code');
    if (!$user_session) {
        redirect('auth/login');
    }
}

function check_admin()
{
    $ci = &get_instance();
    $ci->load->library('fungsi');
    if ($ci->fungsi->user_login()->level != 1) {
        redirect('dashboard');
    }
}

function rupiah($angka){
	$angkaarr = str_replace(".",",",$angka);
	$aex = explode(",",$angkaarr);
	$angka = $aex[0];
	$ades = (count($aex) >= 2) ? $aex[1] : 0;
	$rupiah="";
	$rp=strlen($angka);
	while ($rp>3){
		$rupiah = ".". substr($angka,-3). $rupiah;
		$s=strlen($angka) - 3;
		$angka=substr($angka,0,$s);
		$rp=strlen($angka);
	}
	$rupiah = $angka . $rupiah . ",".$ades;
	return $rupiah;
}

function angkrupiah($string) {
    $string = str_replace('.', '', $string); // Mengganti titik dengan kosong
    $string = str_replace(',', '.', $string); // Mengganti koma dengan titik
    return $string;
}

function indo_currency($nominal)
{
    $result = "Rp " . number_format($nominal, 2, ',', '.');
    return $result;
}

function indo_date($date)
{
    $d = substr($date, 8, 2);
    $m = substr($date, 5, 2);
    $y = substr($date, 0, 4);
    return $d . '-' . $m . '-' . $y;
}

function getMonth($value)
{
    if ($value == 1 || $value == '01') {
        $month = 'Januari';
    } else if ($value == 2 || $value == '02') {
        $month = 'Februari';
    } else if ($value == 3 || $value == '03') {
        $month = 'Maret';
    } else if ($value == 4 || $value == '04') {
        $month = 'April';
    } else if ($value == 5 || $value == '05') {
        $month = 'Mei';
    } else if ($value == 6 || $value == '06') {
        $month = 'Juni';
    } else if ($value == 7 || $value == '07') {
        $month = 'Juli';
    } else if ($value == 8 || $value == '08') {
        $month = 'Agustus';
    } else if ($value == 9 || $value == '09') {
        $month = 'September';
    } else if ($value == 10) {
        $month = 'Oktober';
    } else if ($value == 11) {
        $month = 'November';
    } else if ($value == 12) {
        $month = 'Desember';
    }
    return $month;
}

function getActualMonth($value)
{
    if ($value == '01') {
        $month = 1;
    } else if ($value == '02') {
        $month = 2;
    } else if ($value == '03') {
        $month = 3;
    } else if ($value == '04') {
        $month = 4;
    } else if ($value == '05') {
        $month = 5;
    } else if ($value == '06') {
        $month = 6;
    } else if ($value == '07') {
        $month = 7;
    } else if ($value == '08') {
        $month = 8;
    } else if ($value == '09') {
        $month = 9;
    } else if ($value == '10') {
        $month = 10;
    } else if ($value == '11') {
        $month = 11;
    } else if ($value == '12') {
        $month = 12;
    }
    return $month;
}

function getApproval($budget_code)
{
    $CI = &get_instance();
    $sql = "SELECT * FROM m_budget WHERE budget_code = '$budget_code'";
    $query = $CI->db->query($sql);
    return $query->row()->budget_name;
}

function getPic($pic_code)
{
    $CI = &get_instance();
    $sql = "SELECT * FROM m_employee WHERE nik = '$pic_code'";
    $query = $CI->db->query($sql);
    return $query->row()->namakaryawan;
}

function getBrandName($brand_code)
{
    $CI = &get_instance();
    $sql = "SELECT * FROM m_brand WHERE BrandCode = '$brand_code'";
    $query = $CI->db->query($sql);
    return $query->row()->BrandName;
}

function getGrandTotalActivity($no_anggaran, $month)
{
    $CI = &get_instance();
    $sql = "SELECT SUM(nominal) as grandTotalActivity FROM t_budget_activity WHERE no_anggaran = $no_anggaran  AND [month] = $month";
    $query = $CI->db->query($sql);
    return $query->row()->grandTotalActivity;
}

function TotalBudgetPerPeriode($no_anggaran)
{
    $CI = &get_instance();
    $sql = "SELECT SUM(budget) AS total_budget FROM m_anggaran_detail WHERE no_anggaran = '$no_anggaran'";
    $query = $CI->db->query($sql);
    return $query->row()->total_budget;
}
function subtotalAnggaranPerBrand($no_anggaran)
{
    $CI = &get_instance();
    $sql = "SELECT SUM(nominal) as subtotal FROM t_budget_activity WHERE no_anggaran = '$no_anggaran'";
    $query = $CI->db->query($sql);
    return $query->row()->subtotal;
}

function getActivityName($id_promo)
{
    $CI = &get_instance();
    $sql = "SELECT promo_name FROM m_promo WHERE id = $id_promo";
    $query = $CI->db->query($sql);
    return $query->row()->promo_name;
}

function getUserName($user_code)
{
    $CI = &get_instance();
    $sql = "SELECT username FROM master_user WHERE user_code = '$user_code'";
    $query = $CI->db->query($sql);
    return $query->row()->username;
}

function getNominalActivity($no_anggaran, $month, $id_promo)
{
    $CI = &get_instance();
    $sql = "SELECT* FROM t_budget_activity WHERE no_anggaran = $no_anggaran AND [month] = $month  AND activity = $id_promo";
    $query = $CI->db->query($sql);
    return $query->row()->nominal;
}

function getDefaultNominalActivity($no_anggaran, $month, $id_promo)
{
    $CI = &get_instance();
    $sql = "SELECT* FROM t_budget_activity WHERE no_anggaran = $no_anggaran AND [month] = $month  AND activity = $id_promo";
    $query = $CI->db->query($sql);
    return $query->row()->nominal_default;
}

function getPeriodeBudgetActivityPerBrand($no_anggaran)
{
    $CI = &get_instance();
    $sql = "SELECT MIN([month]) as start_month,
    MAX([month]) as end_month,
    MIN(start_year) as start_year,
    MAX(end_year) as end_year 
    FROM t_budget_activity WHERE no_anggaran = '$no_anggaran'";
    $query = $CI->db->query($sql);
    $start_month = getMonth($query->row()->start_month);
    $end_month = getMonth($query->row()->end_month);
    $start_year = $query->row()->start_year;
    $end_year = $query->row()->end_year;
    $periode = $start_month . ' ' . $start_year . ' s/d ' . $end_month . ' ' . $end_year;
    return $periode;
}

function getBrandFromBudgetActivity($no_anggaran)
{
    $CI = &get_instance();
    $sql = "SELECT DISTINCT brand_code FROM t_budget_activity WHERE no_anggaran = '$no_anggaran'";
    $query = $CI->db->query($sql);
    $brand = getBrandName($query->row()->brand_code);
    // $brand = getActivityName($brand);
    return $brand;
}

function getAnggaranDipakai($brand, $activity, $bulan, $tahun)
{
    $CI = &get_instance();
    $sql = "SELECT * FROM t_budget_activity WHERE brand_code = '$brand' AND activity = $activity AND [month] = '$bulan' AND start_year = '$tahun'";
    $query = $CI->db->query($sql);

    if ($query->num_rows() > 0) {
        $nominal = number_format($query->row()->nominal);
    } else {
        $nominal = "Tidak ada data";
    }
    return $nominal;
}

function getNoAnggaranFromBudgetActivity($brand_code, $activity_id, $month_used, $start_year)
{
    $CI = &get_instance();
    $sql = "SELECT * FROM t_budget_activity WHERE brand_code = '$brand_code' AND activity = '$activity_id' AND [month] = '$month_used' AND start_year = '$start_year'";
    $query = $CI->db->query($sql)->row()->no_anggaran;
    return $query;
}

function getPemakaianAnggaranPerProposal($no_proposal)
{
    $CI = &get_instance();
    $sql = "SELECT * FROM t_budgeting WHERE no_proposal = '$no_proposal'";
    $query = $CI->db->query($sql);
    return $query;
}

function getSubtotalAnggaranPerActivity($no_anggaran, $activity)
{
    $CI = &get_instance();
    $sql = "SELECT SUM(nominal) AS subtotal FROM t_budget_activity 
            WHERE no_anggaran = '$no_anggaran' 
            AND nominal > 0
            AND activity = $activity";
    $query = $CI->db->query($sql);
    return $query->row()->subtotal;
}

function getCustomerName($code)
{
    $CI = &get_instance();
    $sql = "SELECT CustomerName FROM m_customer WHERE CardCode = '$code'";
    $query = $CI->db->query($sql);
    return $query->row()->CustomerName;
}

function getGroupName($code)
{
    $CI = &get_instance();
    $sql = "SELECT GroupName FROM m_group WHERE GroupCode = '$code'";
    $query = $CI->db->query($sql);
    return $query->row()->GroupName;
}

function getBarcodeItem($item_code)
{
    $CI = &get_instance();
    $sql = "SELECT FrgnName as Barcode FROM m_item WHERE ItemCode = '$item_code'";
    $query = $CI->db->query($sql);
    return $query->row()->Barcode;
}

function getNameItem($item_code)
{
    $CI = &get_instance();
    $sql = "SELECT ItemName FROM m_item WHERE ItemCode = '$item_code'";
    $query = $CI->db->query($sql);
    return $query->row()->ItemName;
}

function getBrandNameItem($item_code)
{
    $CI = &get_instance();
    $sql = "SELECT T1.BrandName as BrandName FROM m_brand T1
            INNER JOIN m_item T2 ON T1.BrandCode = T2.BrandCode
            WHERE T2.ItemCode = '$item_code'";
    $query = $CI->db->query($sql);
    return $query->row()->BrandName;
}

function getPriceItem($item_code)
{
    $CI = &get_instance();
    $sql = "SELECT CONVERT(int, Price) as Price FROM t_price WHERE ItemCode = '$item_code'";
    $query = $CI->db->query($sql);
    return $query->row()->Price;
}

function getBudgdetActivityHasBeenSet($no_anggaran)
{
    $CI = &get_instance();
    $sql = "SELECT DISTINCT no_anggaran FROM t_budget_activity WHERE no_anggaran = '$no_anggaran'";
    $query = $CI->db->query($sql);
    return $query->num_rows();
}

function getBrandNameForUser($brand_code)
{
    $CI = &get_instance();
    if ($brand_code != null || $brand_code = '') {
        $sql = "SELECT BrandName FROM m_brand WHERE BrandCode IN($brand_code)";
        $query = $CI->db->query($sql);
        $result = $query->result();
        $brand = [];
        foreach ($result as $data) {
            array_push($brand, $data->BrandName);
        }
        $result = implode(', ', $brand);
    } else {
        $result = $brand_code;
    }
    return $result;
}

function getMonthValueBudget($brand, $year, $activity, $month, $code_anggaran)
{
    $CI = &get_instance();
    $sql = "SELECT budgetValue FROM t_budgetActivity 
            WHERE brandCode = '$brand' 
            AND budgetYear = '$year' 
            AND activity = '$activity' 
            AND month([month]) = month('$month')
            AND codeAnggaran = '$code_anggaran'";
    $query = $CI->db->query($sql);
    if ($query->num_rows() > 0) {
        $result = $query->row()->budgetValue;
    } else {
        $result = 0;
    }
    return $result;
}

function getPurchase($brandCode, $date)
{
    $CI = &get_instance();
    $sql = "SELECT ss.CodeBrand, SUM(ss.Amount) as Amount FROM
            (SELECT * FROM tb_pembelian 
            WHERE CodeBrand = '$brandCode' 
            AND month([month]) = month('$date') 
            AND year([month]) = year ('$date'))ss
            GROUP BY ss.CodeBrand, month(ss.[month])";
    $query = $CI->db->query($sql);
    if ($query->num_rows() > 0) {
        $result = $query->row()->Amount;
    } else {
        $result = 0;
    }
    return $result;
}

function getSumBudgetActivity($codeAnggaran, $activity)
{
    $CI = &get_instance();
    $sql = "SELECT SUM(budgetValue) AS sumBudgetActivity FROM t_budgetActivity  
    WHERE activity = '$activity' 
    AND codeAnggaran = '$codeAnggaran'";
    $query = $CI->db->query($sql);
    return $query->row()->sumBudgetActivity;
}
// NEW SCRIPT ANP HMVC

function check_login()
{
    // var_dump($_SESSION);
    // die;
    $ci = &get_instance();
    $username = $ci->session->userdata('username');
    $fullname = $ci->session->userdata('fullname');
    $page = $ci->session->userdata('page');
    if ($username && $fullname && $page) {
        $sql = "SELECT * FROM master_user WHERE username = '$username' AND [page] = '$page'";
        $query = $ci->db->query($sql);
        if ($query->row()->page != $ci->uri->segment(1)) {
            redirect('auth/login');
        }
    } else {
        redirect('auth/login');
    }
}

function is_delete()
{
    $ci = &get_instance();
    $level = $ci->session->userdata('level');
    $sql = "SELECT is_delete FROM master_level WHERE [level] = '$level'";
    $query = $ci->db->query($sql);
    if ($query->row()->is_delete == 'y') {
        return TRUE;
    } else {
        return FALSE;
    }
}

function statusOperatingActivity($budget_code)
{
    $ci = &get_instance();
    $sql = "SELECT * FROM tb_operating_activity WHERE BudgetCode = '$budget_code'";
    $query = $ci->db->query($sql);
    $status = "";
    if ($query->num_rows() > 0) {
        $status = "complete";
    } else {
        $status = "not complete";
    }
    return $status;
}

function get_ytd_operating($budget_code)
{
    $ci = &get_instance();
    $sql = "SELECT tt.BudgetCode, tt.BrandCode, tt.BrandName, SUM(OperatingBudget) AS YTD_Operating FROM
    (SELECT BudgetCode, BrandCode, BrandName, [Month], OperatingBudget FROM tb_operating)tt
    WHERE tt.BudgetCode = '$budget_code' AND tt.[Month] BETWEEN (SELECT MIN([month]) FROM tb_operating WHERE BudgetCode = '$budget_code') AND getdate()
    GROUP BY tt.BudgetCode, tt.BrandCode, tt.BrandName";
    $query = $ci->db->query($sql);
    return $query->row()->YTD_Operating;
}

function get_ytd_operating_activity($budget_code_activity)
{
    $ci = &get_instance();
    $sql = "SELECT BudgetCodeActivity, BrandCode, ActivityCode, Precentage, SUM(OperatingBudget) AS YTD_OperatingBudgetActivity FROM
    (SELECT * FROM tb_operating_activity)ss
    WHERE ss.BudgetCodeActivity = '$budget_code_activity' AND [Month] BETWEEN (SELECT MIN([month]) FROM tb_operating_activity WHERE BudgetCodeActivity = '$budget_code_activity') AND getdate()
    GROUP BY precentage, ActivityCode, BudgetCodeActivity, BrandCode
    ";
    $query = $ci->db->query($sql);
    return $query->row()->YTD_OperatingBudgetActivity;
}

// function get_ytd_purchase($brand_code, $start_periode, $precentage_activity = null)
// {
//     $ci = &get_instance();
//     $sql = "SELECT CodeBrand, SUM(Amount) AS YTD_Purchase FROM
//     (SELECT * FROM tb_purchase 
//     WHERE CodeBrand = '$brand_code' 
//     AND [Year] BETWEEN Year('$start_periode') AND Year(getdate()) 
//     AND [month] BETWEEN Month('$start_periode') AND Month(getdate()))ss
//     GROUP BY CodeBrand
//     ";
//     $query = $ci->db->query($sql);
//     return $query->row()->YTD_Purchase * (10 / 100);
// }

function get_periode_operating($budget_code)
{
    $ci = &get_instance();
    $sql = "SELECT MIN([Month]) AS StartPeriode, MAX([Month]) AS EndPeriode FROM tb_operating WHERE BudgetCode = '$budget_code'";
    $query = $ci->db->query($sql);
    return date('M-Y', strtotime($query->row()->StartPeriode)) . ' s/d ' . date('M-Y', strtotime($query->row()->EndPeriode));
}

function get_allocated_budget($budgetCodeActivity)
{
    $ci = &get_instance();
    $sql = "SELECT SUM(AllocatedBudget) AS AllocatedBudget FROM tb_operating_proposal WHERE BudgetCodeActivity = '$budgetCodeActivity'";
    $query = $ci->db->query($sql);
    return $query->row()->AllocatedBudget;
}

function getBookedBudgetActivity($budget_code_activity)
{
    $ci = &get_instance();
    $sql = "SELECT SUM(Budget_booked) AS Budget_booked FROM tb_operating_proposal WHERE BudgetCodeActivity = '$budget_code_activity'";
    $query = $ci->db->query($sql);
    return $query->row()->Budget_booked;
}

function getTotalProposal()
{
    $ci = &get_instance();
    $sql = "SELECT * FROM tb_proposal";
    $query = $ci->db->query($sql);
    return $query->num_rows();
}

function getProposalApproved()
{
    $ci = &get_instance();
    $sql = "SELECT * FROM tb_proposal WHERE [Status] = 'approved'";
    $query = $ci->db->query($sql);
    return $query->num_rows();
}

function getProposalOpen()
{
    $ci = &get_instance();
    $sql = "SELECT * FROM tb_proposal WHERE [Status] = 'open'";
    $query = $ci->db->query($sql);
    return $query->num_rows();
}

function do_i_agree($proposalNumber, $userCode)
{
    $ci = &get_instance();
    $sql = "SELECT * FROM tb_proposal_approved WHERE proposalNumber = '$proposalNumber' AND approvedBy = '$userCode'";
    $query = $ci->db->query($sql);
    if ($query->num_rows() > 0) {
        return true;
    } else {
        return false;
    }
}

// function getActualPurchase($brand, $month){
//     $ci = &get_instance();
//     $sql = "SELECT * FROM tb_purchase WHERE CodeBrand = '$brand' AND [Year] = year('$month') AND [month] = month('$month')";
//     $query = $ci->db->query($sql);
//     if($query->num_rows() > 0){
//         return $query->row()->Amount;
//     }else{
//         return 0;
//     }
// }

function getActualPurchase($brand_code, $start_date, $end_date)
{
    $ci = &get_instance();

    // $sql = "SELECT SUM(Amount) AS ActualPurchase FROM tb_purchase 
    // WHERE CodeBrand = '$brand_code' 
    // AND [Year] BETWEEN Year('$start_date') AND Year('$end_date') 
    // AND [month] BETWEEN Month('$start_date') AND Month('$end_date')";

    $sql = "SELECT
    SUM(Amount) AS ActualPurchase 
    FROM tb_purchase_with_date 
    WHERE 
    CodeBrand = '$brand_code'
    AND
    DATEADD(month, DATEDIFF(month, 0, [date]), 0) BETWEEN 
    DATEADD(month, DATEDIFF(month, 0, '$start_date'), 0) AND
    DATEADD(month, DATEDIFF(month, 0, '$end_date'), 0)";

    $query = $ci->db->query($sql);
    return $query->row()->ActualPurchase;
}

function getActualPurchasePerMonth($brand_code, $date)
{
    $ci = &get_instance();
    // $sql = "SELECT Amount FROM tb_purchase 
    // WHERE Codebrand = '$brand_code'
    // AND [Year] = Year('$date')
    // AND [month] = Month('$date')";

    $sql = "SELECT --*
    SUM(Amount) AS Amount 
    FROM tb_purchase_with_date 
    WHERE 
    CodeBrand = '$brand_code'
    AND
    DATEADD(month, DATEDIFF(month, 0, [date]), 0)  = DATEADD(month, DATEDIFF(month, 0, '$date'), 0)";

    $query = $ci->db->query($sql);
    if ($query->num_rows() > 0) {
        return $query->row()->Amount;
    } else {
        return 0;
    }
}

function getGroupCode($customer_code)
{
    $ci = &get_instance();
    $sql = "SELECT GroupCode FROM m_customer WHERE CardCode = '$customer_code'";
    $query = $ci->db->query($sql);
    return $query->row()->GroupCode;
}

function getOperatingActivity($brand, $activity, $month)
{
    $ci = &get_instance();
    $sql = "SELECT BudgetActivity FROM tb_operating_activity 
    WHERE BrandCode = '$brand' AND ActivityCode = '$activity' AND [Month] = '$month'";
    $query = $ci->db->query($sql);
    return $query->row()->BudgetActivity;
}

function getTotalOperatingActivity($budgetCodeActivity)
{
    $ci = &get_instance();
    $sql = "SELECT SUM(BudgetActivity) AS TotalOperatingActivity FROM tb_operating_activity 
    WHERE BudgetCodeActivity = '$budgetCodeActivity'";
    $query = $ci->db->query($sql);
    return $query->row()->TotalOperatingActivity;
}

function getAnpBookedPermonth($budget_code, $year_month)
{
    $ci = &get_instance();
    $sql = "SELECT SUM(Budget_booked) AS BudgetBooked 
    FROM tb_operating_proposal 
    WHERE BudgetCode = '$budget_code' AND Budget_type = 'operating' AND
    DATEADD(month, DATEDIFF(month, 0, [StartPeriodeProposal]), 0)  = DATEADD(month, DATEDIFF(month, 0, '$year_month'), 0)";
    $query = $ci->db->query($sql);
    $result = 0;
    if ($query->num_rows() > 0) {
        $result = $query->row()->BudgetBooked;
    }
    return $result;
}

function getAnpUnbookedPermonth($budget_code, $year_month)
{
    $ci = &get_instance();
    $sql = "SELECT SUM(Budget_unbooked) AS BudgetUnbooked 
    FROM tb_operating_proposal 
    WHERE BudgetCode = '$budget_code' AND Budget_type = 'operating' AND
    DATEADD(month, DATEDIFF(month, 0, [StartPeriodeProposal]), 0)  = DATEADD(month, DATEDIFF(month, 0, '$year_month'), 0)";
    $query = $ci->db->query($sql);
    $result = 0;
    if ($query->num_rows() > 0) {
        $result = $query->row()->BudgetUnbooked;
    }
    return $result;
}

function getTotalOperating($budget_code)
{
    $ci = &get_instance();
    $sql = "SELECT SUM(OperatingBudget) AS TotalOperating FROM tb_operating WHERE BudgetCode = '$budget_code'";
    $query = $ci->db->query($sql);
    return $query->row()->TotalOperating;
}

function getTotalBudgetBooked($budget_code)
{
    $ci = &get_instance();
    $sql = "SELECT SUM(Budget_booked) AS TotalBudgetBooked FROM tb_operating_proposal WHERE BudgetCode ='$budget_code' AND Budget_type = 'operating'";
    $query = $ci->db->query($sql);
    $result = 0;
    if ($query->num_rows() > 0) {
        $result = $query->row()->TotalBudgetBooked;
    }
    return $result;
}

function getTotalBudgetUnbooked($budget_code)
{
    $ci = &get_instance();
    $sql = "SELECT SUM(Budget_unbooked) AS TotalUnbooked FROM tb_operating_proposal WHERE BudgetCode ='$budget_code' AND Budget_type = 'operating'";
    $query = $ci->db->query($sql);
    $result = 0;
    if ($query->num_rows() > 0) {
        $result = $query->row()->TotalUnbooked;
    }
    return $result;
}

function getBudgetBookedActivityPermonth($budget_code_activity, $start_date_proposal)
{
    $ci = &get_instance();
    $sql = "SELECT SUM(Budget_booked) AS BudgetBooked FROM tb_operating_proposal 
    WHERE BudgetCodeActivity = '$budget_code_activity' AND Budget_type = 'operating' AND
    DATEADD(month, DATEDIFF(month, 0, [StartPeriodeProposal]), 0)  = DATEADD(month, DATEDIFF(month, 0, '$start_date_proposal'), 0)";
    $query = $ci->db->query($sql);
    $result = 0;
    if ($query->num_rows() > 0) {
        $result = $query->row()->BudgetBooked;
    }
    return $result;
}

function getTotalBudgetBookedActivity($budget_code_activity)
{
    $ci = &get_instance();
    $sql = "SELECT SUM(Budget_booked) AS TotalBooked FROM tb_operating_proposal WHERE BudgetCodeActivity = '$budget_code_activity' AND Budget_type = 'operating'";
    $query = $ci->db->query($sql);
    $result = 0;
    if ($query->num_rows() > 0) {
        $result = $query->row()->TotalBooked;
    }
    return $result;
}

function getGroupCustomer()
{
    $ci = &get_instance();
    $sql = "SELECT GroupCode, GroupName FROM m_group";
    $query = $ci->db->query($sql);
    return $query;
}

function getActualIMSPermonth($brand, $month, $percent, $is_ims)
{
    $ims_value = 0;
    if ($is_ims == 'Yes') {
        $ci = &get_instance();
        $sql = "SELECT SUM(Omset) * (CONVERT(float,'$percent') / CONVERT(float,100)) AS ims_value FROM tb_sales WHERE CodeBrand = '$brand' AND FORMAT([Month],'yyyy-MM') = FORMAT(CONVERT(date,'$month'),'yyyy-MM')";
        $query = $ci->db->query($sql);
        $ims_value = $query->row()->ims_value;
    }
    return $ims_value;
}

function getActualSalesPerMonth($brand, $month)
{
    $sales = 0;
    $ci = &get_instance();
    $sql = "SELECT SUM(Omset) AS sales FROM tb_sales WHERE CodeBrand = '$brand' AND FORMAT([Month],'yyyy-MM') = FORMAT(CONVERT(date,'$month'),'yyyy-MM')";
    $query = $ci->db->query($sql);
    if ($query->row()->sales != NULL) {
        $sales = $query->row()->sales;
    }
    return $sales;
}

function getTotalActualSales($brand, $startMonth, $endMonth)
{
    $total_sales = 0;
    $ci = &get_instance();
    $sql = "SELECT SUM(Omset) as total_sales FROM tb_sales WHERE CodeBrand = '$brand' AND FORMAT([Month],'yyyy-MM') BETWEEN FORMAT(CONVERT(date,'$startMonth'),'yyyy-MM') AND FORMAT(CONVERT(date,'$endMonth'),'yyyy-MM')";
    $query = $ci->db->query($sql);
    if ($query->row()->total_sales != NULL) {
        $total_sales = $query->row()->total_sales;
    }
    return $total_sales;
}

function getPercentBudgetActivity($budgetCodeActivity)
{
    $ci = &get_instance();
    $sql = "SELECT AVG(OperatingBudget) as TotalOperating, SUM(BudgetActivity) as TotalBudgetActivity, (SUM(BudgetActivity)/AVG(OperatingBudget)) AS PercentBudgetActivity
    FROM tb_operating_activity WHERE BudgetCodeActivity = '$budgetCodeActivity'";
    $query = $ci->db->query($sql);
    return $query->row()->PercentBudgetActivity;
}

function getMonthBudget($budget_code)
{
    $ci = &get_instance();
    $sql = "SELECT [month] FROM tb_operating WHERE BudgetCode = '$budget_code'";
    $query = $ci->db->query($sql);
    return $query;
}

function get_budget_on_top_permonth($brand_code, $month)
{
    $ci = &get_instance();
    $sql = "SELECT budget_on_top FROM tb_budget_on_top WHERE brand_code = '$brand_code' AND [month] = '$month'";
    $query = $ci->db->query($sql);
    $budget_on_top = 0;
    if ($query->num_rows() > 0) {
        $budget_on_top = $query->row()->budget_on_top;
    }
    return $budget_on_top;
}

function get_operating_permonth($brand_code, $month)
{
    $ci = &get_instance();
    $sql = "SELECT OperatingBudget FROM tb_operating WHERE BrandCode = '$brand_code' AND [month] = '$month'";
    $query = $ci->db->query($sql);
    $budget_operating = 0;
    if ($query->num_rows() > 0) {
        $budget_operating = $query->row()->OperatingBudget;
    }
    return $budget_operating;
}

function get_anp_booked_permonth($budget_code, $month)
{
    $ci = &get_instance();
    $sql = "SELECT Budget_booked FROM tb_operating_proposal WHERE BudgetCode = '$budget_code' AND FORMAT([StartPeriodeProposal],'yyyy-MM') = FORMAT(CONVERT(date,'$month'),'yyyy-MM')";
    $query = $ci->db->query($sql);
    $anp_booked = 0;
    if ($query->num_rows() > 0) {
        $anp_booked = $query->row()->Budget_booked;
    }
    return $anp_booked;
}

function get_on_top_is_exists($budget_code)
{
    $ci = &get_instance();
    $sql = "SELECT * FROM tb_budget_on_top WHERE budget_code = '$budget_code'";
    $query = $ci->db->query($sql);
    return $query;
}

function budget_on_top($budget_code)
{
    $ci = &get_instance();
    $sql = "SELECT * FROM tb_budget_on_top WHERE budget_code = '$budget_code'";
    $query = $ci->db->query($sql);
    return $query;
}

function budget_on_top_activity($budget_code)
{
    $ci = &get_instance();
    $sql = "SELECT *, (budget_on_top_percent / 100) * (SELECT SUM(budget_on_top) as budget_on_top FROM tb_budget_on_top WHERE budget_code = '$budget_code') AS on_top_activity
    FROM tb_budget_on_top_activity WHERE budget_code = '$budget_code'";
    $query = $ci->db->query($sql);
    return $query;
}

function get_total_on_top($budget_code)
{
    $total_budget_on_top = 0;
    $ci = &get_instance();
    $sql = "SELECT SUM(budget_on_top) AS total_budget_on_top FROM tb_budget_on_top WHERE budget_code = '$budget_code'";
    $query = $ci->db->query($sql);
    if ($query->num_rows() > 0) {
        $total_budget_on_top = $query->row()->total_budget_on_top;
    }
    return $total_budget_on_top;
}

function get_on_top_per_month($budget_code, $month)
{
    $ci = &get_instance();
    $sql = "SELECT budget_on_top FROM tb_budget_on_top WHERE budget_code = '$budget_code' AND FORMAT([month],'yyyy-MM') = FORMAT(CONVERT(date,'$month'),'yyyy-MM')";
    $query = $ci->db->query($sql);
    $on_top = 0;
    if ($query->num_rows() > 0) {
        $on_top = $query->row()->budget_on_top;
    }
    return $on_top;
}

function get_on_top_booked_per_activity_permonth($budget_code, $code_activity, $month)
{
    $ci = &get_instance();
    $sql = "SELECT SUM(Budget_booked) as Budget_booked FROM tb_operating_proposal WHERE BudgetCode = '$budget_code' AND ActivityCode = '$code_activity' AND FORMAT([StartPeriodeProposal],'yyyy-MM') = FORMAT(CONVERT(date,'$month'),'yyyy-MM') AND Budget_type = 'on_top'";
    $query = $ci->db->query($sql);
    $booked = 0;
    if ($query->num_rows() > 0) {
        $booked = $query->row()->Budget_booked;
    }
    return $booked;
}

function booked_on_top_per_activity($budget_code_activty)
{
    $ci = &get_instance();
    $sql = "SELECT SUM(Budget_booked) as budget_booked FROM tb_operating_proposal WHERE BudgetCodeActivity = '$budget_code_activty' AND Budget_type = 'on_top'";
    $query = $ci->db->query($sql);
    $booked = 0;
    if ($query->num_rows() > 0 && !is_null($query->row()->budget_booked)) {
        $booked = $query->row()->budget_booked;
    }
    return $booked;
}

function get_on_top_per_activity_permonth($budget_code_activity)
{
    $ci = &get_instance();
    $sql = "SELECT (t1.budget_on_top_percent/100) * budget_on_top as on_top_activity FROM tb_budget_on_top_activity t1 
    INNER JOIN tb_budget_on_top t2 ON t1.budget_code = t2.budget_code
    WHERE t1.budget_code_activity = '$budget_code_activity'";
    $query = $ci->db->query($sql);
    return $query;
}

function get_on_top_activity_is_exists($budget_code)
{
    $ci = &get_instance();
    $sql = "SELECT * FROM tb_budget_on_top_activity WHERE budget_code = '$budget_code'";
    $query = $ci->db->query($sql);
    return $query;
}

function proposal_approved($number)
{
    $ci = &get_instance();
    $sql = "SELECT * FROM tb_operating_proposal WHERE ProposalNumber = '$number'";
    $query = $ci->db->query($sql);
    return $query;
}

function proposal_maked($number)
{
    $ci = &get_instance();
    $sql = "SELECT * FROM tb_operating_proposal WHERE ProposalNumber = '$number'";
    $query = $ci->db->query($sql);
    return $query;
}

function get_proposal_objective($number)
{
    $ci = &get_instance();
    $sql = "SELECT * FROM tb_proposal_objective WHERE [ProposalNumber] = '$number'";
    $query = $ci->db->query($sql);
    return $query;
}

function get_proposal_mechanism($number)
{
    $ci = &get_instance();
    $sql = "SELECT * FROM tb_proposal_mechanism WHERE [ProposalNumber] = '$number'";
    $query = $ci->db->query($sql);
    return $query;
}

function get_proposal_comment($number)
{
    $ci = &get_instance();
    $sql = "SELECT * FROM tb_proposal_comment WHERE [ProposalNumber] = '$number'";
    $query = $ci->db->query($sql);
    return $query;
}

function get_target_activity_percent($budget_code)
{
    $percent = 0;
    $ci = &get_instance();
    $sql = "SELECT AVG(OperatingBudget)/SUM(BudgetActivity) as [percent]
    FROM tb_operating_activity WHERE BudgetCode = '$budget_code'";
    $query = $ci->db->query($sql);
    if ($query->num_rows() > 0 && !is_null($query->row()->percent)) {
        $percent = round($query->row()->percent * 100) . '%';
    }
    return $percent;
}

function get_on_top_target_activity_percent($budget_code)
{
    $percent = 0;
    $ci = &get_instance();
    $sql = "SELECT SUM(budget_on_top_percent) as [percent] FROM tb_budget_on_top_activity WHERE budget_code = '$budget_code'";
    $query = $ci->db->query($sql);
    if ($query->num_rows() > 0 && !is_null($query->row()->percent)) {
        $percent = round($query->row()->percent) . '%';
    }
    return $percent;
}

function get_proposal($number_proposal)
{
    $ci = &get_instance();
    $sql = "SELECT * FROM tb_proposal WHERE Number ='$number_proposal'";
    $query = $ci->db->query($sql);
    return $query;
}

function get_proposal_item($number_proposal)
{
    $ci = &get_instance();
    $sql = "SELECT * FROM tb_proposal_item WHERE ProposalNumber = '$number_proposal'";
    $query = $ci->db->query($sql);
    return $query;
}

function get_proposal_customer($number_proposal)
{
    $ci = &get_instance();
    $sql = "SELECT * FROM tb_proposal_customer WHERE ProposalNumber= '$number_proposal'";
    $query = $ci->db->query($sql);
    return $query;
}

function get_item($item_code)
{
    $ci = &get_instance();
    $sql = "SELECT * FROM tb_item WHERE ItemCode= '$item_code'";
    $query = $ci->db->query($sql);
    return $query;
}

function get_budget_booked($budget_code_activity, $budget_type)
{
    $ci = &get_instance();
    $sql = "SELECT SUM(Budget_booked) as budget_booked FROM tb_operating_proposal WHERE BudgetCodeActivity = '$budget_code_activity' AND Budget_type = '$budget_type'";
    $query = $ci->db->query($sql);
    return $query;
}

function get_budget_allocated($budget_code_activity, $budget_type)
{
    $ci = &get_instance();
    $sql = "SELECT SUM(Budget_allocated) as budget_allocated FROM tb_operating_proposal WHERE BudgetCodeActivity = '$budget_code_activity' AND Budget_type = '$budget_type'";
    $query = $ci->db->query($sql);
    return $query;
}

function get_operating_activity($budget_code_activity, $end_date_proposal)
{
    $ci = &get_instance();
    $sql = "SELECT SUM(BudgetActivity) as budget_activity FROM tb_operating_activity WHERE BudgetCodeActivity = '$budget_code_activity'
    AND format([month], 'yyyy-MM') 
    BETWEEN format((SELECT MIN([month]) FROM tb_operating_activity WHERE BudgetCodeActivity = '$budget_code_activity'),'yyyy-MM') 
    AND format(cast('$end_date_proposal' as datetime), 'yyyy-MM')";
    $query = $ci->db->query($sql);
    return $query->row()->budget_activity;
}

function get_total_purchase($brand, $budget_code_activity, $end_date_proposal)
{
    $ci = &get_instance();
    $sql = "SELECT sum(amount) as total_purchase FROM tb_purchase_with_date WHERE CodeBrand = '$brand'
    AND format([date],'yyyy-MM') BETWEEN format((SELECT min([Month]) FROM tb_operating_activity WHERE BudgetCodeActivity = '$budget_code_activity'),'yyyy-MM')
    AND format(cast('$end_date_proposal' as datetime),'yyyy-MM')";
    $query = $ci->db->query($sql);
    return $query->row()->total_purchase;
}

function get_anp_percent($budget_code_activity)
{
    $ci = &get_instance();
    $sql = "SELECT AVG(PrincipalAnpIDR)/AVG(PrincipalTargetIDR) as percent_anp 
    FROM tb_operating_activity WHERE BudgetCodeActivity = '$budget_code_activity'";
    $query = $ci->db->query($sql);
    return $query->row()->percent_anp;
}

function get_percent_activity($budget_code_activity)
{
    $ci = &get_instance();
    $sql = "SELECT SUM(BudgetActivity)/AVG(OperatingBudget) as percent_activity 
    FROM tb_operating_activity WHERE BudgetCodeActivity = '$budget_code_activity'";
    $query = $ci->db->query($sql);
    return $query->row()->percent_activity;
}

function get_budget_allocated_proposal($nomor_proposal)
{
    $ci = &get_instance();
    $sql = "SELECT Budget_allocated FROM tb_operating_proposal WHERE ProposalNumber = '$nomor_proposal'";
    $query = $ci->db->query($sql);
    return $query->row()->Budget_allocated;
}

function get_on_top_activity($budget_code_activity)
{
    $ci = &get_instance();
    $budget_code = $ci->db->query("SELECT budget_code FROM tb_budget_on_top_activity WHERE budget_code_activity = '$budget_code_activity'")->row()->budget_code;
    $total_on_top = $ci->db->query("SELECT SUM(budget_on_top) as total_on_top FROM tb_budget_on_top WHERE budget_code = '$budget_code'")->row()->total_on_top;
    $percent_on_top_activity = $ci->db->query("SELECT budget_on_top_percent FROM tb_budget_on_top_activity WHERE budget_code_activity = '$budget_code_activity'")->row()->budget_on_top_percent / 100;
    $on_top_activity = 0;
    $on_top_activity = $total_on_top * $percent_on_top_activity;
    return $on_top_activity;
}

function get_balance($brand, $budget_code_activity, $end_date_proposal, $budget_type, $nomor_proposal)
{
    $on_top = $budget_type == 'on_top' ? get_on_top_activity($budget_code_activity) : 0;
    $operating = get_operating_activity($budget_code_activity, $end_date_proposal);
    $actual = (get_total_purchase($brand, $budget_code_activity, $end_date_proposal) * get_anp_percent($budget_code_activity)) * get_percent_activity($budget_code_activity);
    $budget_allocated = get_budget_allocated($budget_code_activity, $budget_type)->row()->budget_allocated;
    $budget_allocated_this_proposal = 0;
    $balance = 0;
    $exists_costing = get_budget_allocated_proposal($nomor_proposal);

    if ($actual < $operating) {
        $balance = ($actual - $budget_allocated) + $exists_costing;
    } else {
        $balance = ($operating - $budget_allocated) + $exists_costing;
    }

    if ($budget_type == 'on_top') {
        $balance = $on_top - $budget_allocated + $exists_costing;
    }

    return round($balance);
}

function get_customer_only($number_proposal)
{
    $ci = &get_instance();
    $sql = "SELECT CustomerCode FROM tb_proposal_customer WHERE ProposalNumber = '$number_proposal'";
    $query = $ci->db->query($sql);
    $customer = $query->result();
    $cust = [];
    foreach ($customer as $data) {
        array_push($cust, $data->CustomerCode);
    }
    $cust = "'" . implode("','", $cust) . "'";
    return $cust;
}

function activity_is_sales($id_activity)
{
    $ci = &get_instance();
    $sql = "SELECT sales FROM m_promo WHERE id='$id_activity'";
    $query = $ci->db->query($sql);
    return $query->row()->sales;
}

function total_costing($no_proposal)
{
    $ci = &get_instance();
    $sql = "SELECT SUM(Costing) AS total_costing FROM tb_proposal_item WHERE ProposalNumber = '$no_proposal'";
    $query = $ci->db->query($sql);
    return $query->row()->total_costing;
}

function total_target($no_proposal)
{
    $ci = &get_instance();
    $sql = "SELECT SUM([Target]) AS total_target FROM tb_proposal_item WHERE ProposalNumber = '$no_proposal'";
    $query = $ci->db->query($sql);
    return $query->row()->total_target;
}

function cost_ratio($no_proposal)
{
    $cost_ratio = round((total_costing($no_proposal) / total_target($no_proposal)) * 100);
    return $cost_ratio . '%';
}

function get_avg_sales_qty_per_customer($no_proposal, $customer_code, $item_code)
{
    $ci = &get_instance();
    $sql = "select * from tb_item_cart where no_proposal = '$no_proposal' and customer_code = '$customer_code' and item_code = '$item_code'";
    $query = $ci->db->query($sql);
    return $query->row()->qty_avg_sales;
}

function getItemProposal($number)
{
    $ci = &get_instance();
    $sql = "SELECT t1.ItemCode, FrgnName AS Barcode, t3.ItemName, t1.Price,t1.AvgSales, t1.Qty, t1.[Target], t1.Promo, t1.Costing, t1.ListingCost, t1.PromoValue FROM tb_proposal_item t1
        INNER JOIN m_brand t2 ON t1.BrandCode = t2.BrandCode
        INNER JOIN m_item t3 ON t1.ItemCode = t3.ItemCode
        WHERE t1.ProposalNumber = '$number'";
    $query = $ci->db->query($sql);
    return $query;
}

function getProposalCostingOther($number)
{
    $ci = &get_instance();
    $sql = "select * from tb_proposal_item_other where ProposalNumber = '$number'";
    $query = $ci->db->query($sql);
    return $query;
}

function getItemGroup($number)
{
    $ci = &get_instance();
    $sql = "select * from ProposalItemGroupDetailView where ProposalNumber = '$number'";
    $query = $ci->db->query($sql);
    return $query;
}

function getApprovedBy($proposalNumber)
{
    $ci = &get_instance();
    $sql = "select t1.*, t2.fullname from tb_proposal_approved t1
    inner join master_user t2 on t1.approvedBy = t2.user_code
    where t1.ProposalNumber = '$proposalNumber'";
    $query = $ci->db->query($sql);
    return $query;
}

function encrypt($s)
{
    $qEncoded    = base64_encode($s);
    return ($qEncoded);
}

function decrypt($s)
{
    $qDecoded    = base64_decode($s);
    return ($qDecoded);
}
