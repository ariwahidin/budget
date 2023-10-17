<?php
defined('BASEPATH') or exit('No direct script access allowed');



class Direksi_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function getDate()
    {
        $timezone = new DateTimeZone('Asia/Jakarta');
        $date = new DateTime();
        $date->setTimeZone($timezone);
        return $date->format('Y-m-d H:i:s');
    }

    public function getBrand($a = null)
    {
        $sql = "SELECT BrandCode, BrandName FROM m_brand";
        if($a){
            $sql .= " where BrandCode = '".$a."'";
        }

        $query = $this->db->query($sql);
        return $query;
    }

    public function getActivity()
    {
        $sql = "SELECT id, promo_name AS ActivityName FROM m_promo";
        $query = $this->db->query($sql);
        return $query;
    }
    

    public function getGroup()
    {
        $sql = "SELECT GroupCode, GroupName FROM m_group";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getCustomer($group = null)
    {
        $sql = "SELECT CardCode, t2.GroupName, CustomerName, t1.GroupCode FROM m_customer t1
        INNER JOIN m_group t2 ON t1.GroupCode = t2.GroupCode";

        if ($group != null) {
            $sql .= " WHERE t1.GroupCode = '$group'";
        }

        $query = $this->db->query($sql);
        return $query;
    }

    public function getItem($brand = null)
    {
        $sql = "SELECT BrandName, ItemCode, ItemName, FrgnName as Barcode, t1.BrandCode, Price 
        FROM m_item t1
        INNER JOIN m_brand t2 ON t1.BrandCode = t2.BrandCode";
        if ($brand != null) {
            $sql .= " WHERE t1.BrandCode = '$brand'";
        }
        $query = $this->db->query($sql);
        return $query;
    }

    public function getBudget()
    {
        $sql = "SELECT ob.*, --ss.CodeBrand, ss.Brand, ss.[Month] AS Month_Purchase, 
        ISNULL(ss.Amount, 0) AS Actual_Purchase, ISNULL((0.1 * ss.Amount),0) as Actual_ANP  FROM [PK-ANP].[dbo].[operatingbudget] ob
        LEFT JOIN
        (
        SELECT
        s.CodeBrand,BRAND,[Year],[Month],sum(Amount)  as Amount
        from
        ( select --T0.[ItemCode],T2.[ItemName],
        TB.ItmsGrpCod AS CodeBrand,TB.ItmsGrpNam AS BRAND,
        year(T1.[DocDate])  as Year,
        sum(T0.[linetotal]) as Amount,
        month(T1.[DocDate]) as Month 
        FROM [pksrv-sap].PANDURASA_LIVE.dbo.PDN1 T0 
        --T1.[DocDate] as Month FROM [pksrv-sap].PANDURASA_LIVE.dbo.PDN1 T0 
        INNER JOIN [pksrv-sap].PANDURASA_LIVE.dbo.OPDN T1 ON T0.DocEntry = T1.DocEntry 
        INNER JOIN [pksrv-sap].PANDURASA_LIVE.dbo.OITM T2 ON T0.ItemCode = T2.ItemCode
        INNER JOIN [pksrv-sap].PANDURASA_LIVE.dbo.oitb tb WITH (NOLOCK) on T2.itmsgrpcod=tb.itmsgrpcod
        --WHERE TB.ItmsGrpCod = '148' AND T1.[DocDate] BETWEEN '2022-08-01 00:00:00.000' AND '2023-06-01 00:00:00.000'
        GROUP BY 
        TB.ItmsGrpNam,tb.ItmsGrpCod,T1.[DocDate],--T0.[ItemCode],T2.[ItemName],
        year(T1.[DocDate]))S
        group by s.CodeBrand,BRAND,[Year],[month]
        --order by BRAND, [Year]
        )
        ss ON month(ob.[month]) = ss.[Month] AND ob.[year] = ss.[Year] AND ob.codebrand = ss.CodeBrand";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getPurchase()
    {
        $sql = "SELECT
        s.CodeBrand,BRAND,[Year],[month],sum(Amount)  as Amount
        from
        ( select --T0.[ItemCode],T2.[ItemName],
        TB.ItmsGrpCod AS CodeBrand,TB.ItmsGrpNam AS BRAND,
        year(T1.[DocDate])  as Year,
        sum(T0.[linetotal]) as Amount,
        month(T1.[DocDate]) as Month 
        FROM [pksrv-sap].PANDURASA_LIVE.dbo.PDN1 T0 
        --T1.[DocDate] as Month FROM [pksrv-sap].PANDURASA_LIVE.dbo.PDN1 T0 
        INNER JOIN [pksrv-sap].PANDURASA_LIVE.dbo.OPDN T1 ON T0.DocEntry = T1.DocEntry 
        INNER JOIN [pksrv-sap].PANDURASA_LIVE.dbo.OITM T2 ON T0.ItemCode = T2.ItemCode
        INNER JOIN [pksrv-sap].PANDURASA_LIVE.dbo.oitb tb WITH (NOLOCK) on T2.itmsgrpcod=tb.itmsgrpcod
        --WHERE TB.ItmsGrpCod = '' AND T1.[DocDate] BETWEEN '' AND ''
        GROUP BY 
        TB.ItmsGrpNam,tb.ItmsGrpCod,T1.[DocDate],--T0.[ItemCode],T2.[ItemName],
        year(T1.[DocDate]))S
        group by s.CodeBrand,BRAND,[Year],[month]
        order by 
        BRAND, [Year]";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getOperating($budget_code = null)
    {
        if ($budget_code != null) {
            $sql = "SELECT * FROM tb_operating WHERE BudgetCode = '$budget_code'";
        } else {
            $sql = "SELECT BudgetCode, ss.BrandCode, ss.ExchangeRate, ss.Valas,
            MIN([month]) AS StartPeriode,
            MAX([month]) AS EndPeriode, t2.BrandName,
            SUM([PrincipalTargetIDR]) AS PrincipalTarget,
            SUM([PrincipalAnpIDR]) AS TargetAnp,
            SUM([PKTargetIDR]) AS PKTarget,
            SUM([PKAnpIDR]) AS PKAnp,
            SUM(OperatingBudget) AS OperatingBudget FROM
            (SELECT * FROM tb_operating)ss
            INNER JOIN m_brand t2 ON ss.BrandCode = t2.BrandCode
            GROUP BY BudgetCode, ss.BrandCode, t2.BrandName, ss.ExchangeRate, ss.Valas";
        }
        $query = $this->db->query($sql);
        return $query;
    }

    public function getHeaderOperatingbybrand($brand,$year = null, $periode = null)
    {
        $sql = "SELECT MIN([Month]) AS StartPeriode, 
        MAX([Month]) AS EndPeriode, 
        AVG(ExchangeRate) AS ExchangeRate,
        SUM(PKTargetIDR) AS TotalPKTargetIDR, 
        SUM(PKAnpIDR) AS TotalPKAnpIDR,
        SUM(PrincipalTargetValas) AS TotalPrincipalTargetValas,
        SUM(PrincipalTargetIDR) AS TotalPrincipalTargetIDR,
        SUM([PrincipalAnpIDR]) AS TotalTargetAnp, 
        SUM(OperatingBudget) AS TotalOperating 
        FROM tb_operating WHERE BrandCode = '$brand'";

        
        if(($year)&&($periode)){
            $range0 = 3 * ($periode - 1);
            $range1 = 3 * $periode;
            $range0 = ($range0 >= 1) ? $range0 : 1;
            $range1 = ($range1 < 12) ? $range1 : 12;
            $periode0 = $year."-".$range0."-01";
            $periode1 = $year."-".$range1."-01";

            $sql0 = $sql." and Month between '$periode0' and '$periode1'";  
    
            $query0 = $this->db->query($sql0);
            if($query0->num_rows() >= 1){
                return $query0;
            }else{

                $sql = "SELECT MIN([Month]) AS StartPeriode, 
                startp = '$periode0',
                endp = '$periode1',
                nullkah=1,
                MAX([Month]) AS EndPeriode, 
                AVG(ExchangeRate) AS ExchangeRate,
                SUM([PKAnpIDR]) AS TotalPKAnpIDR,
                SUM(PrincipalTargetValas) AS TotalPrincipalTargetValas,
                SUM(PrincipalTargetIDR) AS TotalPrincipalTargetIDR,
                SUM([PrincipalAnpIDR]) AS TotalTargetAnp, 
                SUM(OperatingBudget) AS TotalOperating 
                FROM tb_operating WHERE BrandCode = '$brand'";
            }
        }


        $query = $this->db->query($sql);
        return $query;
    }

    public function getHeaderOperating($budget_code)
    {
        $sql = "SELECT MIN([Month]) AS StartPeriode, 
        MAX([Month]) AS EndPeriode, 
        AVG(ExchangeRate) AS ExchangeRate,
        SUM([PKAnpIDR]) AS TotalPKAnpIDR,
        SUM(PrincipalTargetValas) AS TotalPrincipalTargetValas,
        SUM(PrincipalTargetIDR) AS TotalPrincipalTargetIDR,
        SUM([PrincipalAnpIDR]) AS TotalTargetAnp, 
        SUM(OperatingBudget) AS TotalOperating 
        FROM tb_operating WHERE BudgetCode = '$budget_code'";

        $query = $this->db->query($sql);
        return $query;
    }

    public function getActivityFromTbOperatingActivity($budget_code)
    {
        $sql = "SELECT DISTINCT BudgetCode, BudgetCodeActivity, BrandCode, ActivityCode, ActivityName
        FROM tb_operating_activity WHERE BudgetCode = '$budget_code'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getActualIMS($brand, $budget_code)
    {
        $sql = "declare @brand as varchar(50) = '$brand'
        declare @budget_code as varchar(50) = '$budget_code'
        declare @imsStartDate as date = (SELECT MIN([Month]) FROM tb_operating WHERE BudgetCode = @budget_code)
        declare @imsEndDate as date = (SELECT MAX([Month]) FROM tb_operating WHERE BudgetCode = @budget_code)
        declare @is_ims as varchar(10) = (SELECT DISTINCT is_ims FROM tb_operating WHERE BudgetCode = @budget_code)
        declare @percent_ims as float = (SELECT DISTINCT ims_percent FROM tb_operating WHERE BudgetCode = @budget_code)/100
        declare @ims_value as float = (SELECT SUM(Omset)*@percent_ims FROM tb_sales WHERE CodeBrand = @brand AND FORMAT([Month],'yyyy-MM') BETWEEN FORMAT(@imsStartDate,'yyyy-MM') AND FORMAT(@imsEndDate,'yyyy-MM'))
        select @is_ims as ims, @percent_ims as ims_percent, @ims_value as ims_value";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getBudgetCode($post)
    {
        $brand_code = $post['brand'];
        $end_date = $post['end_date'];
        $activity = $post['activity'];
        $sql = "SELECT * FROM tb_operating_activity WHERE BrandCode = '$brand_code' AND year([month]) = year('$end_date') AND month([Month]) = month('$end_date') AND ActivityCode = '$activity'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getYTDOperatingBudget($budget_code, $end_date)
    {
        $sql = "SELECT SUM(ss.OperatingBudget) AS OperatingBudget FROM
                (SELECT * FROM tb_operating_activity 
                WHERE [Month] Between (SELECT MIN([month]) FROM tb_operating WHERE BudgetCodeActivity = '$budget_code') AND '$end_date')ss";
        $YtdOperating = $this->db->query($sql)->row()->OperatingBudget;

        $YtdAllocated = $this->db->query("SELECT SUM(AllocatedBudget) AS YtdAllocatedBudget FROM tb_operating_proposal WHERE BudgetCodeActivity = '$budget_code'");
        if ($YtdAllocated->num_rows() > 0) {
            $YtdAllocated = $YtdAllocated->row()->YtdAllocatedBudget;
        } else {
            $YtdAllocated = 0;
        }
        $YtdOperating = (float)$YtdOperating - (float)$YtdAllocated;

        return $YtdOperating;
    }

    public function getNumber()
    {
        $sql = "SELECT FORMAT(MAX(SUBSTRING(number,5,8))+1, 'd4') as number from tb_proposal";
        $query = $this->db->query($sql);
        $number = $query->row()->number;
        if ($number == null) {
            $number = '0001';
        }
        $sql2 = "SELECT concat(cast(year(getdate()) AS varchar),'$number') as num";
        $query2 = $this->db->query($sql2);
        $number = $query2->row()->num;
        return $number;
    }

    public function insertProposal($post)
    {
        // var_dump($post);
        // die;
        $number = $this->getNumber();
        $username = $_SESSION['username'];
        $date = $this->getDate();
        //insert proposal
        $params = array(
            'Number' => $number,
            'StartDatePeriode' => $post['start_date'],
            'EndDatePeriode' => $post['end_date'],
            'BudgetCode' => $post['budget_code'],
            'Activity' => $post['activity'],
            'BrandCode' => $post['brand'],
            'Status' => 'open',
            'CreatedBy' => $_SESSION['username'],
        );
        $this->db->insert('tb_proposal', $params);
        $id = $this->db->insert_id();

        //insert item
        for ($i = 0; $i < count($post['item_code']); $i++) {
            $items = array(
                'ProposalNumber' => $this->db->query("SELECT [Number] FROM tb_proposal WHERE id = '$id'")->row()->Number,
                'BrandCode' => $post['brand'],
                'ItemCode' => $post['item_code'][$i],
                'Price' => (float)$post['item_price'][$i],
                'Qty' => (float)$post['item_qty'][$i],
                'Target' => (float)$post['item_target'][$i],
                'Promo' => (float)$post['item_promo'][$i],
                'Costing' => (float)$post['item_costing'][$i]
            );
            $this->db->insert('tb_proposal_item', $items);
        }

        //insert customer
        for ($c = 0; $c < count($post['customer_code']); $c++) {
            $customer = array(
                'ProposalNumber' => $this->db->query("SELECT [Number] FROM tb_proposal WHERE id = '$id'")->row()->Number,
                'GroupCustomer' => $post['group_code'],
                'CustomerCode' => $post['customer_code'][$c]
            );
            $this->db->insert('tb_proposal_customer', $customer);
        }

        //insert operating proposal
        $operating = array(
            'BudgetCodeActivity' => $post['budget_code'],
            'ProposalNumber' => $this->db->query("SELECT [Number] FROM tb_proposal WHERE id = '$id'")->row()->Number,
            'TotalCosting' => (float)$post['total_costing'],
            'OperatingBudget' => (float)$post['operating'],
            'AllocatedBudget' => (float)$post['total_costing'],
            'BalanceBudget' => (float)$post['operating'],
            'UsedBudget' => 0,
            'CreatedBy' => $username,
            'CreatedDate' => $date,
        );
        $this->db->insert('tb_operating_proposal', $operating);
    }


    public function getProposalbybrand($kode_brand = null,$actx=null)
    {
        $sql = "SELECT t1.*, t2.TotalCosting FROM tb_proposal t1
		LEFT JOIN tb_operating_proposal t2 on t1.Number = t2.ProposalNumber
        WHERE t1.Status != 'canceled'";
        if ($kode_brand != null) {
            $sql .= " and t1.BrandCode = '".$kode_brand."'";
        }

        if ($actx != null) {
            $sql .= " and t1.Activity = '".$actx."'";
        }
        
        $sql .= " ORDER BY t1.id DESC";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getProposal($number = null)
    {
        $sql = "SELECT t1.*, t2.TotalCosting FROM tb_proposal t1
		LEFT JOIN tb_operating_proposal t2 on t1.Number = t2.ProposalNumber
        WHERE t1.Status != 'canceled'";
        if ($number != null) {
            $sql .= " AND t1.[Number] = '$number'";
        }
        $sql .= " ORDER BY t1.id DESC";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getProposalApproved($status)
    {
        $sql = "SELECT * FROM tb_proposal WHERE [Status] = '$status'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getProposalItem($number)
    {
        $sql = "SELECT t1.ItemCode, FrgnName AS Barcode, t3.ItemName, t1.Price,t1.AvgSales, t1.Qty, t1.[Target], t1.Promo, t1.Costing, t1.ListingCost, t1.PromoValue FROM tb_proposal_item t1
        INNER JOIN m_brand t2 ON t1.BrandCode = t2.BrandCode
        INNER JOIN m_item t3 ON t1.ItemCode = t3.ItemCode
        WHERE t1.ProposalNumber = '$number'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getProposalCustomer($number)
    {
        $sql = "SELECT GroupCustomer, t3.GroupName, t2.CustomerName FROM tb_proposal_customer t1
        INNER JOIN m_customer t2 ON t1.CustomerCode = t2.CardCode
        INNER JOIN m_group t3 ON t1.GroupCustomer = t3.GroupCode
        WHERE t1.ProposalNumber = '$number'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function deleteProposal($number)
    {
        $sql = "DELETE tb_proposal WHERE [Number] = '$number'
            DELETE tb_proposal_item WHERE [ProposalNumber] = '$number'
            DELETE tb_proposal_customer WHERE [ProposalNumber] = '$number'
            DELETE tb_operating_proposal WHERE [ProposalNumber] = '$number'";
        $this->db->query($sql);
    }

    public function approveProposal($post)
    {
        $number = $post['number'];
        $comment = $post['comment'];
        $username = $_SESSION['username'];
        $date = $this->getDate();

        if ($this->session->userdata('level') == 'D1') {
            $allocated = $this->db->query("SELECT Budget_allocated FROM tb_operating_proposal WHERE ProposalNumber = '$number'")->row()->Budget_allocated;
            $updateOperating = $this->db->query("UPDATE tb_operating_proposal SET Budget_unbooked = 0, Budget_booked = '$allocated', ApprovedBy = '$username', ApprovedDate = '$date' WHERE ProposalNumber = '$number'");
            $updateStatusProposal = $this->db->query("UPDATE tb_proposal SET [Status] = 'approved', ApprovedBy = '$username', ApprovedDate = '$date', reason ='$comment', reason_by = '$username' WHERE Number = '$number'");
        }

        $params = array(
            'proposalNumber' => $number,
            'approvedBy' => $_SESSION['user_code'],
            'username' => $_SESSION['username'],
            'approvedDate' => $this->getDate(),
            'reason' => $comment,
            'is_approve' => 'y',
            'created_by' => $_SESSION['user_code']
        );
        $this->db->insert('tb_proposal_approved', $params);
    }

    public function rejectProposal($post)
    {

        // var_dump($post);
        // die;

        $number = $post['number'];
        $comment = $post['comment'];
        $username = $_SESSION['username'];
        $date = $this->getDate();

        // if ($this->session->userdata('level') == 'D1') {
        //     $allocated = $this->db->query("SELECT Budget_allocated FROM tb_operating_proposal WHERE ProposalNumber = '$number'")->row()->Budget_allocated;
        //     $updateOperating = $this->db->query("UPDATE tb_operating_proposal SET Budget_unbooked = 0, Budget_booked = '$allocated', ApprovedBy = '$username', ApprovedDate = '$date' WHERE ProposalNumber = '$number'");
        // }

        $updateStatusProposal = $this->db->query("UPDATE tb_proposal SET [Status] = 'rejected', RejectBy = '$username', RejectDate = '$date', reason ='$comment', reason_by = '$username' WHERE Number = '$number'");

        $params = array(
            'proposalNumber' => $number,
            'approvedBy' => $_SESSION['user_code'],
            'username' => $_SESSION['username'],
            'approvedDate' => $this->getDate(),
            'reason' => $comment,
            'is_approve' => 'n',
            'created_by' => $_SESSION['user_code']
        );
        $this->db->insert('tb_proposal_approved', $params);
    }

    public function cancelProposal($post)
    {
        $number = $post['number'];
        $comment = $post['comment'];
        $username = $_SESSION['username'];
        $date = $this->getDate();
        $unbooked = $this->db->query("SELECT Budget_unbooked FROM tb_operating_proposal WHERE ProposalNumber = '$number'")->row()->Budget_unbooked;
        $update_budget = $this->db->query("UPDATE tb_operating_proposal SET Budget_allocated = 0, Budget_unbooked = 0, DeallocatedBudget = '$unbooked', CancelBy = '$username', CancelDate = '$date' WHERE ProposalNumber = '$number'");
        $update_status_proposal = $this->db->query("UPDATE tb_proposal SET [Status] = 'cancelled', CancelBy = '$username', CancelDate = '$date', reason ='$comment', reason_by = '$username' WHERE Number = '$number'");
    }

    public function getNumberBudget($brand_code)
    {
        $sql = "SELECT FORMAT(MAX(right(BudgetCode, charindex('/', BudgetCode) - 1))+1, 'd3') AS Number FROM tb_operating
        WHERE BrandCode = '$brand_code'";
        $number = $this->db->query($sql)->row()->Number;
        if ($number == null) {
            $number = '001';
        }
        return $brand_code . '/' . $number;
    }

    public function simpanOperating($post)
    {
        $number = $this->getNumberBudget($post['brand']);
        for ($i = 0; $i < count($post['month']); $i++) {
            $params = array(
                'BudgetCode' => $number,
                'BrandCode' => $post['brand'],
                'BrandName' => getBrandName($post['brand']),
                'Year' => date('Y', strtotime($post['month'][$i])),
                'Month' => $post['month'][$i],
                'OperatingBudget' => (float)str_replace(',', '', $post['operating'][$i]),
                'CreatedBy' => $_SESSION['username'],
                'CreatedDate' => $this->getDate(),
            );
            $this->db->insert('tb_operating', $params);
        }
    }

    public function getOperatingActivity($budget_code, $activity = null)
    {
        $sql = "SELECT BudgetCode, BudgetCodeActivity,BrandCode, MIN([Month]) AS StartPeriode, ActivityCode,Precentage, SUM(OperatingBudget) AS OperatingBudget FROM
        (SELECT * FROM tb_operating_activity)ss";

        if ($activity != null) {
            $sql .= " WHERE ss.BudgetCode = '$budget_code' AND ss.ActivityCode = '$activity'";
        } else {
            $sql .= " WHERE ss.BudgetCode = '$budget_code'";
        }

        $sql .= " GROUP BY BudgetCode, precentage, ActivityCode, BudgetCodeActivity, BrandCode";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getOperatingActivityDetail($budget_code)
    {
        $sql = "SELECT * FROM tb_operating_activity
        WHERE BudgetCodeActivity = '$budget_code'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function simpanOperatingActivity($post)
    {
        for ($i = 0; $i < count($post['activity']); $i++) {
            $params = array(
                'BudgetCode' => $post['budget_code'],
                'BudgetCodeActivity' => $post['budget_code_activity'][$i],
                'BrandCode' => $post['brand_code'],
                'BrandName' => getBrandName($post['brand_code']),
                'ActivityCode' => $post['activity'][$i],
                'ActivityName' => getActivityName($post['activity'][$i]),
                'Month' => $post['month'][$i],
                'Precentage' => $post['precentage'][$i],
                'OperatingBudget' => $post['operating_activity'][$i],
                'CreatedBy' => $_SESSION['username'],
                'CreatedDate' => $this->getDate()
            );
            $this->db->insert('tb_operating_activity', $params);
        }
    }

    public function checkOperatingAlreadyExist($brand, $start_month, $end_month)
    {
        $sql = "SELECT * FROM tb_operating WHERE BrandCode = '$brand' AND [Month] Between  '$start_month' and  '$end_month'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getOperatingPurchase()
    {
        $sql = "SELECT ss.BudgetCode, ss.BrandCode, ss.BrandName, 
        MIN(ss.[Month]) AS StartPeriode, 
        MAX(ss.[Month]) AS EndPeriode, 
        SUM(OperatingBudget) AS Total_operating FROM 
        (SELECT BudgetCode, BrandCode, BrandName, [Month], OperatingBudget FROM tb_operating)ss
        GROUP BY ss.BudgetCode, ss.BrandCode, ss.BrandName";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getBrandFromBudgetSetted()
    {
        $sql = "SELECT DISTINCT t1.BrandCode, t2.BrandName FROM tb_operating_activity t1
        INNER JOIN m_brand t2 ON t1.BrandCode = t2.BrandCode";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getActivityFromBudgetSetted()
    {
        $sql = "SELECT DISTINCT t1.ActivityCode as id, t2.promo_name as ActivityName FROM tb_operating_activity t1
        INNER JOIN m_promo t2 ON t1.ActivityCode = t2.id";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getBudgetAllocatedActivity($budget_code_activity)
    {
        $sql = "SELECT SUM(AllocatedBudget) as SUMAllocatedBudget FROM tb_operating_proposal WHERE BudgetCodeActivity = '$budget_code_activity'";
        $query = $this->db->query($sql);
        $allocated_budget = $query->row()->SUMAllocatedBudget;
        if (is_null($allocated_budget)) {
            $allocated_budget = 0;
        }
        return $allocated_budget;
    }

    public function getOperatingProposal($number)
    {
        $sql = "SELECT * FROM tb_operating_proposal WHERE ProposalNumber = '$number'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getApprovedBy($proposalNumber)
    {
        $sql = "SELECT * FROM tb_proposal_approved WHERE proposalNumber = '$proposalNumber'";
        $query = $this->db->query($sql);
        return $query;
    }

    

    public function get_detail_budget($budget_code)
    {
        $sql = "SELECT *, [PrincipalAnpIDR] AS TargetAnp FROM tb_operating WHERE BudgetCode = '$budget_code'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function costkot($brand_code){
        $arr0 = [];
        $sql ="SELECT  t1.Number, sum(t2.TotalCosting) as totalang
        FROM tb_proposal t1
        LEFT JOIN tb_operating_proposal t2 ON t1.Number = t2.ProposalNumber ";

        
        if($brand_code){
            $sql .= " where t1.BrandCode = '".$brand_code."' and t1.Status != 'canceled'";
        } else{
            $sql .= " where t1.Status != 'canceled'";
        }

        $sql .=" GROUP BY t1.Number";
        $query = $this->db->query($sql);
        foreach ($query->result() as $key => $value) {
            
            $sql1 ="select mc.City from tb_proposal_customer t3 left join m_customer mc on mc.CardCode = t3.CustomerCode ";
            $sql1 .= " where t3.ProposalNumber = '".$value->Number."' ";
            $query1 = $this->db->query($sql1);
            foreach ($query1->result() as $key1 => $value1) {
                $arrk['city'] = $value1->City;
                $arrk['totalang'] = $value->totalang;
                array_push($arr0,$arrk);
            }
        }

                
        // Array untuk menyimpan totalang berdasarkan city
        $totalangByCity = [];

        // Loop melalui data
        foreach ($arr0 as $item) {
            $city = $item["city"];
            $totalang = $item["totalang"];
            
            // Jika city belum ada dalam $totalangByCity, inisialisasi dengan nilai totalang
            if (!isset($totalangByCity[$city])) {
                $totalangByCity[$city] = $totalang;
            } else {
                // Jika city sudah ada, tambahkan nilai totalang ke total yang ada
                $totalangByCity[$city] += $totalang;
            }
        }

        return $totalangByCity;

    }


    public function filterkota($brand_code){
        $sql = "select mc.City,sum(t2.TotalCosting) as totalang FROM tb_proposal t1
        INNER JOIN tb_operating_proposal t2 ON t1.Number = t2.ProposalNumber
        INNER join tb_proposal_customer tc on t1.Number = tc.ProposalNumber
        INNER join m_customer mc on mc.CardCode = tc.CustomerCode
        INNER JOIN m_brand t3 ON t1.BrandCode = t3.BrandCode";
        
        if($brand_code){
            $sql .= " where t1.BrandCode = ".$brand_code." and t1.Status != 'canceled'";
        } else{
            $sql .= "where t1.Status != 'canceled'";
        }

        $sql .=" and mc.city is not null GROUP BY mc.City";
        
        $query = $this->db->query($sql);
        return $query;
        
    }

    
    public function filteract2($budget_code)
    {
        $sql = "
        SELECT
    ROW_NUMBER() OVER (ORDER BY ss.BudgetActivity DESC) AS ID,
    ss.ActivityName,
    ss.[Percent],
    ss.BudgetActivity,
    tt.TotalCosting AS Used,
    (ss.BudgetActivity - tt.TotalCosting) AS Saldo
FROM
    (
        SELECT DISTINCT
            BudgetCode,
            BudgetCodeActivity,
            BrandCode,
            BrandName,
            ActivityCode,
            ActivityName,
            BudgetActivity,
            [BudgetActivity%] AS [Percent]
        FROM
            tb_operating_activity
        WHERE
            BrandCode = '$budget_code'
    ) ss
LEFT JOIN
    (
        SELECT
            a1.BudgetCode,
            a1.BudgetCodeActivity,
            a1.ActivityCode,
            SUM(a1.TotalCosting) AS TotalCosting
        FROM
            tb_operating_proposal a1
        INNER JOIN
            tb_proposal a2 ON a1.ProposalNumber = a2.Number
            AND a2.Status IN ('open', 'approved')
        WHERE
            a1.BrandCode = '$budget_code'
            AND a1.Budget_type = 'operating'
        GROUP BY
            a1.BudgetCode,
            a1.BudgetCodeActivity,
            a1.ActivityCode
    ) tt ON ss.BudgetCodeActivity = tt.BudgetCodeActivity
ORDER BY
    ss.BudgetActivity DESC;

        ";
        
        $query = $this->db->query($sql);
        return $query;
    }


    public function filteract($brand_code){
        $sql ="SELECT 
        t5.BudgetActivity,
        t2.ActivityCode, t4.promo_name,
        t1.BudgetCode, t3.BrandName, t1.BrandCode,
        sum(t2.TotalCosting) as totalang
        FROM tb_proposal t1
        LEFT JOIN tb_operating_proposal t2 ON t1.Number = t2.ProposalNumber
        LEFT JOIN tb_operating_activity t5 ON t2.BudgetCodeActivity = t5.BudgetCodeActivity 
        INNER JOIN m_brand t3 ON t1.BrandCode = t3.BrandCode
        INNER JOIN m_promo t4 ON t2.ActivityCode = t4.id";

        
        if($brand_code){
            $sql .= " where t1.BrandCode = '".$brand_code."' and t1.Status != 'canceled'";
        } else{
            $sql .= "where t1.Status != 'canceled'";
        }

        $sql .="
        GROUP BY t2.ActivityCode, t5.BudgetActivity, t4.promo_name,
            t1.BudgetCode, t3.BrandName, t1.BrandCode
        ORDER BY t2.ActivityCode";
        
        $query = $this->db->query($sql);
        return $query;

    }

    public function anpdir1($kode_brand = null){
        $sql = "SELECT t1.*, t1.BudgetCode, t3.BrandCode, t1.BrandName, t3.Code,
        FORMAT(StartPeriode, 'MMM yyyy') as StartPeriode, 
        FORMAT(EndPeriode, 'MMM yyyy') AS EndPeriode,
        Year(EndPeriode) as EndYearPeriode,
        (
            SELECT sum(totaldn) as Totdn
            FROM tb_dn_amount 
            WHERE kdbrand  = Code 
            AND (
                (tahun = FORMAT(StartPeriode, 'yyyy') 
                AND bulan >= FORMAT(StartPeriode, 'MM')) OR 
                (tahun  = FORMAT(EndPeriode, 'yyyy') 
                AND bulan <= FORMAT(EndPeriode, 'MM'))
            )
        ) as Totaldn,
        (
            SELECT sum(IncomingAmount) as tot
            FROM tb_incoming_amount
            WHERE Code = t3.Code 
            AND (
                (Year = FORMAT(StartPeriode, 'yyyy') 
                AND Month >= FORMAT(StartPeriode, 'MM')) OR 
                (Year = FORMAT(EndPeriode, 'yyyy') 
                AND Month <= FORMAT(EndPeriode, 'MM'))
            )
        ) as TotalIncomingAmount,
        TotalOperatingBudget, t2.TotalCosting
    FROM AnpView t1
    LEFT JOIN CostingByBudgetCodeView t2 ON t1.BudgetCode = t2.BudgetCode
    LEFT JOIN m_brand_anp t3 ON t3.BrandCode = t1.BrandCode 
    ";
        if($kode_brand){
            $sql .= " where t3.BrandCode ='".$kode_brand."'";
        }
        $sql .= "ORDER BY TotalIncomingAmount DESC";

        $query = $this->db->query($sql);
        return $query;
    }
    public function getAnpForManagement()
    {
        $sql = "EXEC getAnpForManagement";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getResumeAnp()
    {
        $sql = "select sum(Operating) AS TotalOperating, sum(ProposalCosting) AS TotalProposalCosting, 
        sum(Operating) - sum(ProposalCosting) AS TotalOperatingBalance 
        from view_resumeAnp";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getCostingOther($ProposalNumber)
    {
        $sql = "SELECT * FROM tb_proposal_item_other where ProposalNumber = '$ProposalNumber'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getProposalItemGroupDetail($ProposalNumber)
    {
        $sql = "select * from ProposalItemGroupDetailView
        where ProposalNumber = '$ProposalNumber'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getProposalView()
    {
        $sql = "SELECT * FROM ProposalView";
        $query = $this->db->query($sql);
        return $query;
    }

    public function plan_list_brand($a=null){ 
        $sql = "SELECT BrandCode, BrandName FROM tb_operating group by BrandCode, BrandName";
        return $this->db->query($sql);
    }
    
    public function plan_list_year($a=null){ 
        $where = "";
        if (count($a) > 0) {
            $ax = implode(",", $a);
            $where .= ($ax) ? " where BrandCode IN (SELECT * FROM STRING_SPLIT('$ax', ','))" : " ";
        }
        $sql = "SELECT Year FROM tb_operating $where group by Year";
        return $this->db->query($sql);
    }

    public function plan_list_periode($a=null,$b=null){ 
        $where = "";
        if (count($a) > 0) {
            $ax = implode(",", $a);
            $where .= ($ax) ? " where BrandCode IN (SELECT * FROM STRING_SPLIT('$ax', ','))" : " ";
            if (count($b) > 0) {
                $bx = implode(",", $b);
                $where .= ($bx) ? " and Year IN (SELECT * FROM STRING_SPLIT('$bx', ','))" : " ";
            }
        }

        $sql = "SELECT distinct CASE when (MONTH(Month) % 3) != 0 then (MONTH(Month)/3) +1 else (MONTH(Month)/3) END AS periode FROM tb_operating $where";
        return $this->db->query($sql);
    }
    

    public function getProposalpic($params = null)
    {
        $sql = "SELECT DISTINCT t1.*, t2.Budget_type FROM tb_proposal t1 
        inner join tb_operating_proposal t2 on t1.[Number] = t2.ProposalNumber";

            if (isset($params['brand'])) {
                $brand = $params['brand'];
                $sql .= " AND t1.BrandCode IN (SELECT * FROM STRING_SPLIT('$brand', ','))";
            }

            if (isset($params['activity'])) {
                $activity = $params['activity'];
                $sql .= " AND t1.Activity IN (SELECT * FROM STRING_SPLIT('$activity', ','))";
            }

            if (isset($params['status'])) {
                $status = $params['status'];
                $sql .= " AND t1.Status IN (SELECT * FROM STRING_SPLIT('$status', ','))";
            }
        

        if (!empty($params['number'])) {
            $number = $params['number'];
            $sql .= " WHERE t1.[Number] = '$number'";
        }

        $sql .= " ORDER BY t1.id DESC";

        
        // echo $sql;
        $query = $this->db->query($sql);
        return $query;
    }

    public function getProposalx($params = null){
        $anu = $this->getProposalpic($params);
        return $anu;
    }
    
    public function getBrandProposalByPic()
    {
        $sql = "SELECT DISTINCT t1.BrandCode, t1.BrandName FROM ProposalTarikanExcelView t1 
        LEFT JOIN tb_pic_brand t2 on t1.BrandCode = t2.BrandCode ";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getBudgetOperatingbybrand($brand,$year = null, $periode = null)
    {
        $sql = "select
        BrandName,BrandCode, Valas,ExchangeRate, ActualAnp,
        [Month] as Periode,
        PrincipalTargetIDR as PrincipalTarget,
        PrincipalAnpIDR as AnpPrincipal,
        PKTargetIDR,
        PKAnpIDR,
        OperatingBudget
        from tb_operating where BrandCode = '$brand'";

        if(($year)&&($periode)){
            $range0 = 3 * ($periode - 1);
            $range1 = 3 * $periode;
            $range0 = ($range0 >= 1) ? $range0 : 1;
            $range1 = ($range1 < 12) ? $range1 : 12;
            $periode0 = $year."-".$range0."-01";
            $periode1 = $year."-".$range1."-01";

            $sql0 = $sql." and Month between '$periode0' and '$periode1'";  
            
            $query0 = $this->db->query($sql0);
            if($query0->num_rows() >= 1){
                return $query0;
            }else{
                        
                $sql = "select
                BrandName,BrandCode, Valas,ExchangeRate, ActualAnp,
                [Month] as Periode,
                startp = '$periode0',
                endp = '$periode1',
                nullkah=1,
                PrincipalTargetIDR as PrincipalTarget,
                PrincipalAnpIDR as AnpPrincipal,
                PKTargetIDR,
                PKAnpIDR,
                OperatingBudget
                from tb_operating where BrandCode = '$brand'";
            }
        }

        $query = $this->db->query($sql);
        return $query;
    }


    public function getBudgetOperating($budget_code)
    {
        $sql = "select
        BrandName,BrandCode, Valas,ExchangeRate, ActualAnp,
        [Month] as Periode,
        PrincipalTargetIDR as PrincipalTarget,
        PrincipalAnpIDR as AnpPrincipal,
        PKTargetIDR,
        PKAnpIDR,
        OperatingBudget
        from tb_operating where BudgetCode = '$budget_code'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getIncomingFund($budget_code)
    {
        $sql = "select * from tb_incoming_fund where budget_code = '$budget_code'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function simpanFund($post)
    {
        $params = array(
            'budget_code' => $post['budget_code'],
            'value' => $post['value'],
            'note' => $post['note'],
            'created_at' => $this->session->userdata('user_code')
        );
        // var_dump($params);
        $this->db->insert('tb_incoming_fund', $params);
    }

    public function getBudgetOnTopById($id)
    {
        $sql = "select * from tb_budget_on_top where id = '$id'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getBudgetOnTop($budgetCode)
    {
        $sql = "select * from tb_budget_on_top where budget_code = '$budgetCode'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function totalOnTop($budgetCode)
    {
        $sql = "select case when sum(budget_on_top) is null then 0 else sum(budget_on_top) end as TotalOnTop from [dbo].[tb_budget_on_top] 
        where budget_code = '$budgetCode'";
        $query = $this->db->query($sql);
        return $query->row()->TotalOnTop;
    }

    public function totalCostingOnTop($budgetCode)
    {
        $sql = "select case when sum(TotalCosting) is null then 0 else sum(TotalCosting) end as TotalCostingOnTop 
        from tb_operating_proposal where BudgetCode = '$budgetCode' and Budget_type = 'on_top'";
        $query = $this->db->query($sql);
        return $query->row()->TotalCostingOnTop;
    }

    public function editOnTop($post)
    {
        $data = array(
            'budget_on_top' => $post['newOnTop'],
            'update_by' => $this->session->userdata('user_code'),
            'update_date' => $this->getDate(),
        );
        $this->db->where('id', $post['id']);
        $this->db->update('tb_budget_on_top', $data);
    }

    public function functionGetMonthBudget($budget_code)
    {
        $sql = "select [Month] from tb_operating where BudgetCode = '$budget_code'
        order by [Month] asc";
        $query = $this->db->query($sql);
        return $query;
    }


    public function createBudgetOnTop($post)
    {
        // var_dump($post);
        $budget_code = $post['budget_code'];
        $brand_code = $this->db->query("select distinct BrandCode from tb_operating where BudgetCode = '$budget_code'")->row()->BrandCode;
        $data = array();
        for ($i = 0; $i < count($post['month']); $i++) {
            array_push(
                $data,
                array(
                    'brand_code' => $brand_code,
                    'budget_code' => $budget_code,
                    'month' => $post['month'][$i],
                    'budget_on_top' => $post['budget'][$i],
                    'created_by' => $this->session->userdata('user_code'),
                    'created_date' => $this->getDate()
                )
            );
        }
        $this->db->insert_batch('tb_budget_on_top', $data);
    }

    public function getTarikanProposalExcel($post)
    {
        $sql = "select * from ProposalTarikanExcelView
        order by Number DESC";
        $query = $this->db->query($sql);
        return $query;
    }

    public function changePassword($post)
    {
        $params = array(
            'password' => $post['newPassword'],
            'updated_date' => $this->getDate(),
            'updated_by' => $this->session->userdata('user_code'),
        );
        $this->db->where('user_code', $this->session->userdata('user_code'));
        $this->db->update('master_user', $params);
    }
}
