<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Administrator_model extends CI_Model
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

    public function getBrand()
    {
        $sql = "SELECT BrandCode, BrandName FROM m_brand";
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
            $sql = "SELECT BudgetCode, ss.BrandCode,MIN([month]) AS StartPeriode,MAX([month]) AS EndPeriode, t2.BrandName, SUM(OperatingBudget) AS OperatingBudget FROM
            (SELECT * FROM tb_operating)ss
            INNER JOIN m_brand t2 ON ss.BrandCode = t2.BrandCode
            GROUP BY BudgetCode, ss.BrandCode, t2.BrandName";
        }
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

    public function getProposal($number = null)
    {
        $sql = "SELECT t1.*, t2.BrandName FROM tb_proposal t1 inner join m_brand t2 on t1.BrandCode = t2.BrandCode";
        if ($number != null) {
            $sql .= " WHERE t1.[Number] = '$number'";
        }
        $sql .= " ORDER BY t1.id DESC";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getProposalItem($number)
    {
        $sql = "SELECT t1.ItemCode, FrgnName AS Barcode, t3.ItemName, t1.Price, t1.Qty, t1.[Target], t1.Promo, t1.Costing FROM tb_proposal_item t1
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
            DELETE tb_proposal_item_other WHERE [ProposalNumber] = '$number'
            DELETE tb_proposal_customer WHERE [ProposalNumber] = '$number'
            DELETE tb_operating_proposal WHERE [ProposalNumber] = '$number'
            DELETE tb_proposal_approved WHERE [proposalNumber] = '$number'
            DELETE tb_proposal_objective WHERE [ProposalNumber] = '$number'
            DELETE tb_proposal_mechanism WHERE [ProposalNumber] = '$number'
            DELETE tb_proposal_customer_item WHERE [no_proposal] = '$number'
            DELETE tb_proposal_group WHERE [ProposalNumber] = '$number'
            DELETE tb_proposal_group_item WHERE [ProposalNumber] = '$number'
            DELETE tb_proposal_comment WHERE [Proposalnumber] = '$number'";
        $this->db->query($sql);
    }

    public function approveProposal($number)
    {
        $username = $_SESSION['username'];
        $date = $this->getDate();
        $allocated = $this->db->query("SELECT AllocatedBudget FROM tb_operating_proposal WHERE ProposalNumber = '$number'")->row()->AllocatedBudget;
        $updateOperating = $this->db->query("UPDATE tb_operating_proposal SET UsedBudget = '$allocated', ApprovedBy = '$username', ApprovedDate = '$date' WHERE ProposalNumber = '$number'");
        $updateStatusProposal = $this->db->query("UPDATE tb_proposal SET [Status] = 'approved', ApprovedBy = '$username', ApprovedDate = '$date' WHERE Number = '$number'");
    }

    public function cancelProposal($number)
    {
        $username = $_SESSION['username'];
        $date = $this->getDate();
        $allocated = $this->db->query("SELECT AllocatedBudget FROM tb_operating_proposal WHERE ProposalNumber = '$number'")->row()->AllocatedBudget;
        $updateOperating = $this->db->query("UPDATE tb_operating_proposal SET AllocatedBudget = 0, DeallocatedBudget = '$allocated', CancelBy = '$username', CancelDate = '$date' WHERE ProposalNumber = '$number'");
        $updateStatusProposal = $this->db->query("UPDATE tb_proposal SET [Status] = 'cancelled', CancelBy = '$username', CancelDate = '$date' WHERE Number = '$number'");
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

    public function getPicBrand()
    {
        $sql = "select * from tb_pic_brand where UserCode != '-'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getPic()
    {
        $sql = "select * from master_user where access_role = 'pic'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function addPicBrand($post)
    {
        $user_code = $post['pic'];
        $brand_code = $post['brand'];

        $condition = array(
            'UserCode' => $user_code,
            'BrandCode' => $brand_code
        );

        $this->db->select('*');
        $this->db->from('tb_pic_brand');
        $this->db->where($condition);
        $query = $this->db->get();

        if ($query->num_rows() < 1) {
            $user = $this->db->query("select distinct user_code, fullname from master_user where user_code = '$user_code'");
            $brand = $this->db->query("select distinct BrandCode, BrandName from m_brand where BrandCode = '$brand_code'");
            $params = array(
                'UserCode' => $user->row()->user_code,
                'Pic' => $user->row()->fullname,
                'BrandCode' => $brand->row()->BrandCode,
                'BrandName' => $brand->row()->BrandName,
                'CreatedBy' => $this->session->userdata('user_code')
            );
            $this->db->insert('tb_pic_brand', $params);
        }
    }

    public function getAllUsers()
    {
        $sql = "select * from master_user";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getDepartment()
    {
        $sql = "select * from m_department";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getUsername($username)
    {
        $sql = "select * from master_user where username = '$username'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function generateUserCode($page)
    {

        $prefix = $this->db->query("select code from m_department where page = '$page'")->row()->code;

        $sqlNumber = "SELECT FORMAT(MAX(SUBSTRING(user_code,3,5))+1, 'd3') as code from master_user
        WHERE SUBSTRING(user_code,1,2) = '$prefix'";

        $queryNumber = $this->db->query($sqlNumber);

        if (is_null($queryNumber->row()->code)) {
            $number = "001";
        } else {
            $number = $queryNumber->row()->code;
        }

        return $prefix . $number;
    }

    public function addUser($post)
    {
        $user_code = $this->generateUserCode($post['page']);
        $data = array(
            'user_code' => $user_code,
            'username' => $post['username'],
            'fullname' => $post['fullname'],
            'password' => $post['password'],
            'page' => $post['page'],
            'access_role' => $post['page'],
            'created_by' => $this->session->userdata('user_code'),
            'created_date' => $this->getDate(),
        );

        $this->db->insert('master_user', $data);
    }
}
