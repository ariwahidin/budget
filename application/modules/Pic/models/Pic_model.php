<?php

use BaconQrCode\Renderer\Color\Rgb;

defined('BASEPATH') or exit('No direct script access allowed');

class Pic_model extends CI_Model
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

    // Start Datatable Server Side

    public function getRows($post)
    {

        $this->_get_datatables_query($post);
        if ($post['length'] != -1) {
            $this->db->limit($post['length'], $post['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function getRowsCustomer($post)
    {
        $this->_get_datatables_customer($post);
        if ($post['length'] != -1) {
            $this->db->limit($post['length'], $post['start']);
        }
        $query = $this->db->get();
        // var_dump($this->db->last_query());
        // var_dump($this->db->error());
        return $query->result();
    }

    public function countAll()
    {
        $table = 'm_brand';
        $this->db->from($table);
        return $this->db->count_all_results();
    }

    public function countAllCustomer()
    {
        $table = "(SELECT CardCode, t2.GroupName, CustomerName, t1.GroupCode FROM m_customer t1 
        INNER JOIN m_group t2 ON t1.GroupCode = t2.GroupCode)ss";
        $this->db->from($table);
        return $this->db->count_all_results();
    }

    public function countFiltered($post)
    {
        $this->_get_datatables_query($post);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function countFilteredCustomer($post)
    {
        $this->_get_datatables_customer($post);
        $query = $this->db->get();
        return $query->num_rows();
    }

    private function _get_datatables_query($post)
    {
        $this->db->from('m_brand');
        $i = 0;

        $column_order = array(
            null,
            'BrandCode',
            'BrandName',
        );

        $column_search = array(
            'BrandCode',
            'BrandName',
        );

        $order = array(
            'BrandName' => 'asc',
        );

        foreach ($column_search as $brand) {
            if ($post['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($brand, $post['search']['value']);
                } else {
                    $this->db->or_like($brand, $post['search']['value']);
                }

                if (count($column_search) - 1 == $i) {
                    $this->db->group_end();
                }
            }
            $i++;
        }

        if (isset($post['order'])) {
            $this->db->order_by($column_order[$post['order']['0']['column']], $post['order']['0']['dir']);;
        } else if ($order) {
            $order = $order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    private function _get_datatables_customer($post)
    {
        $this->db->from('(SELECT CardCode, t2.GroupName, CustomerName, t1.GroupCode FROM m_customer t1 
        INNER JOIN m_group t2 ON t1.GroupCode = t2.GroupCode)ss');
        $i = 0;

        $column_order = array(
            null,
            'CardCode',
            'GroupName',
            'CustomerName',
            'GroupCode',
        );

        $column_search = array(
            'CardCode',
            'GroupName',
            'CustomerName',
            'GroupCode',
        );

        $order = array(
            'CustomerName' => 'asc',
        );

        foreach ($column_search as $member) {
            if ($post['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($member, $post['search']['value']);
                } else {
                    $this->db->or_like($member, $post['search']['value']);
                }

                if (count($column_search) - 1 == $i) {
                    $this->db->group_end();
                }
            }
            $i++;
        }

        if (isset($post['order'])) {
            $this->db->order_by($column_order[$post['order']['0']['column']], $post['order']['0']['dir']);;
        } else if ($order) {
            $order = $order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    // End Datatable Server Side

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

    public function getGroupCustomer($group_customer)
    {
        $sql = "select GroupCode, GroupName from m_group where GroupCode in(select value FROM  STRING_SPLIT('$group_customer', ','))";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getCustomer($group = null, $customer = null)
    {
        $sql = "SELECT CardCode, t2.GroupName, CustomerName, t1.GroupCode FROM m_customer t1
        INNER JOIN m_group t2 ON t1.GroupCode = t2.GroupCode";

        if ($group != null) {
            $sql .= " WHERE t1.GroupCode = '$group'";
        }

        // var_dump($sql);
        // die;

        $query = $this->db->query($sql);
        return $query;
    }

    public function getCustomerByCardCode($array_customer)
    {
        $customer = implode(",", $array_customer);
        $sql = "select * from CustomerView where CardCode in(select value from STRING_SPLIT('$customer',','))";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getCustomerFromSales($group = null, $customer = null)
    {

        // var_dump($group);
        // var_dump($customer);

        $sql = "select * from CustomerView";

        if ($group != null) {
            $group = implode(",", $group);
            $sql .= " WHERE GroupCode IN (select value FROM  STRING_SPLIT('$group', ','))";
        }

        if ($customer != null) {
            $customer = implode(",", $customer);
            $sql .= " AND CardCode NOT IN(select value FROM  STRING_SPLIT('$customer', ','))";
        }


        $query = $this->db->query($sql);
        return $query;
    }

    public function getBarcodeFromTBSales($item_code)
    {
        $sql = "select distinct barcode from tb_sales where itemcode = '$item_code'";
        $query = $this->db->query($sql);
        return $query->row()->barcode;
    }

    public function getCustomerFromTBSales($customer_code = null)
    {
        // var_dump($group);
        // var_dump($customer);
        $sql = "SELECT DISTINCT CardCode, GroupName, CardName AS CustomerName, GroupCode FROM tb_sales";

        if ($customer_code != null) {
            // $customer = implode(",", $customer);
            $sql .= " WHERE CardCode IN(select value FROM  STRING_SPLIT('$customer_code', ','))";
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

    public function getItemFromPenjualan($brand, $customer, $start, $end, $item = null, $barcode)
    {

        // if ($item != null) {
        //     $sql = "IF OBJECT_ID('tempdb..#tempItemFromSales') IS NOT NULL
        //     DROP TABLE #tempItemFromSales;
        //     CREATE TABLE #tempItemFromSales
        //     (
        //     ItemCode VARCHAR(255),
        //     ItemName VARCHAR(255),
        //     Barcode VARCHAR(255),
        //     CodeBrand VARCHAR(255),
        //     BrandName VARCHAR(255),
        //     Quantity VARCHAR(255),
        //     Price VARCHAR(255)
        //     )
        //     INSERT INTO #tempItemFromSales
        //     EXEC select_item_from_sales @BrandCode = '$brand', @StartDate = '$start', 
        //     @EndDate = '$end', @StringListCustomerCode ='$customer'";
        //     $this->db->query($sql);

        //     $query = "select * from #tempItemFromSales where ItemCode IN (select value FROM  STRING_SPLIT('$item', ','))";
        //     $result = $this->db->query($query);
        // } else {
        //     $sql = "EXEC select_item_from_sales @BrandCode = '$brand', @StartDate = '$start',@EndDate = '$end', @StringListCustomerCode ='$customer'";
        //     // $sql = "select * from tb_sales where ";
        //     $result = $this->db->query($sql);
        // }

        // $sql = "select * from 
        // (
        // select ItemCode collate SQL_Latin1_General_CP850_CI_AS as ItemCode,
        // ItemName collate SQL_Latin1_General_CP850_CI_AS as ItemName, 
        // Barcode collate SQL_Latin1_General_CP850_CI_AS as Barcode,
        // CodeBrand as CodeBrand,
        // BRAND collate SQL_Latin1_General_CP850_CI_AS as BrandName, 
        // SUM(Quantity) as Quantity, 
        // AVG(Price) as Price 
        // from tb_sales 
        // WHERE CardCode collate SQL_Latin1_General_CP850_CI_AS IN (select value FROM  STRING_SPLIT('$customer', ','))
        // AND [Month] between '$start' and '$end'
        // AND CodeBrand = '$brand' 
        // group by ItemCode, ItemName, Barcode, CodeBrand, BRAND 
        // union
        // select ItemCode collate SQL_Latin1_General_CP850_CI_AS as ItemCode,
        // ItemName collate SQL_Latin1_General_CP850_CI_AS as ItemName, 
        // FRGNNAME collate SQL_Latin1_General_CP850_CI_AS as Barcode,
        // BrandCode as CodeBrand,
        // BrandName collate SQL_Latin1_General_CP850_CI_AS as BrandName, 
        // '0' as Quantity,
        // Price 
        // from tb_item 
        // WHERE ItemCode collate SQL_Latin1_General_CP850_CI_AS NOT IN(
        // select distinct ItemCode from tb_sales 
        // WHERE CardCode  IN (select value FROM  STRING_SPLIT('$customer', ',')) 
        // AND [Month] between '$start' and '$end'
        // AND CodeBrand = '$brand'
        // )
        // AND tb_item.BrandCode = '$brand'
        // )ss";

        $sql = "select * from
        (
        select t2.ItemCode, t2.ItemName, t2.FrgnName as Barcode, t2.BrandCode, t3.BrandName,
        case when ss.Quantity IS NULL then 0 else ss.Quantity end AS Quantity, t2.Price  
        from ( select ItemCode collate SQL_Latin1_General_CP850_CI_AS as ItemCode, 
        ItemName collate SQL_Latin1_General_CP850_CI_AS as ItemName, 
        Barcode collate SQL_Latin1_General_CP850_CI_AS as Barcode, CodeBrand as CodeBrand, 
        BRAND collate SQL_Latin1_General_CP850_CI_AS as BrandName, SUM(Quantity) as Quantity, 
        AVG(Price) as Price from tb_sales 
        WHERE CardCode collate SQL_Latin1_General_CP850_CI_AS IN (select value FROM STRING_SPLIT('$customer', ',')) 
        AND [Month] between '$start' and '$end' AND CodeBrand = '$brand' group by ItemCode, ItemName, Barcode, 
        CodeBrand, BRAND union select ItemCode collate SQL_Latin1_General_CP850_CI_AS as ItemCode, 
        ItemName collate SQL_Latin1_General_CP850_CI_AS as ItemName, FRGNNAME collate SQL_Latin1_General_CP850_CI_AS as Barcode, 
        BrandCode as CodeBrand, BrandName collate SQL_Latin1_General_CP850_CI_AS as BrandName, '0' as Quantity, Price 
        from tb_item WHERE ItemCode collate SQL_Latin1_General_CP850_CI_AS NOT IN( select distinct ItemCode from tb_sales 
        WHERE CardCode IN (select value FROM STRING_SPLIT('$customer', ',')) AND [Month] between '$start' and '$end' 
        AND CodeBrand = '$brand' ) 
        AND tb_item.BrandCode = '$brand' )ss 
        --order by ss.Quantity DESC
        RIGHT JOIN m_item t2 ON ss.ItemCode = t2.ItemCode 
        INNER JOIN m_brand t3 ON t2.BrandCode = t3.BrandCode
        where t2.BrandCode = '$brand'
        )xx";

        if ($item != null) {
            $sql .= " WHERE xx.ItemCode IN (select value FROM  STRING_SPLIT('$item', ','))";
        }

        if (count($barcode) > 0 || $barcode != null) {
            $barcode = implode(",", $barcode);
            // var_dump($barcode);
            $sql .= " WHERE xx.Barcode NOT IN (select value FROM  STRING_SPLIT('$barcode', ','))";
        }

        $sql .= " order by xx.Quantity DESC";
        $result = $this->db->query($sql);
        // print_r($sql);
        // die;

        return $result;
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

    public function getBrandProposalByPic()
    {
        $user_code = $this->session->userdata('user_code');
        $sql = "SELECT DISTINCT t1.BrandCode, t1.BrandName FROM ProposalTarikanExcelView t1 
        LEFT JOIN tb_pic_brand t2 on t1.BrandCode = t2.BrandCode
        WHERE t2.UserCode = '$user_code'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getTarikanProposalExcel($post)
    {
        $user_code = $this->session->userdata('user_code');
        $sql = "select * from ProposalTarikanExcelView
        where UserCode = '$user_code' order by Number DESC";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getOperatingBudget($budgetCode)
    {
        // var_dump($budgetCode);
        $sql = "select sum(OperatingBudget) as BudgetOperating from tb_operating where BudgetCode = '$budgetCode'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getOperating($params)
    {
        if (!empty($params['user_code'])) {
            $user_code = $params['user_code'];
            $sql = "SELECT BudgetCode, ss.BrandCode,
            MIN([month]) AS StartPeriode,
            MAX([month]) AS EndPeriode, t2.BrandName,
            SUM([PrincipalTargetIDR]) AS PrincipalTarget,
            SUM([PrincipalAnpIDR]) AS TargetAnp,
            SUM([PKTargetIDR]) AS TotalPKTargetIDR,
            SUM([PKAnpIDR]) AS TotalPKAnpIDR,
            SUM(OperatingBudget) AS OperatingBudget FROM
            (SELECT * FROM tb_operating)ss
            INNER JOIN m_brand t2 ON ss.BrandCode = t2.BrandCode";
            $sql .= " WHERE ss.BrandCode IN(SELECT BrandCode FROM tb_pic_brand WHERE UserCode = '$user_code')";
            $sql .= " GROUP BY BudgetCode, ss.BrandCode, t2.BrandName";
        }

        if (!empty($params['budget_code'])) {
            $budget_code = $params['budget_code'];
            $sql = "SELECT *, [PrincipalAnpIDR] AS Target FROM tb_operating";
            $sql .= " WHERE BudgetCode = '$budget_code'";
        }

        $query = $this->db->query($sql);
        return $query;
    }

    public function getBudgetActivity($budget_code_activity, $end_date)
    {
        // $sql = "SELECT SUM(BudgetActivity) AS BudgetActivity FROM tb_operating_activity 
        // WHERE BudgetCodeActivity = '$budget_code_activity'
        // AND [month] BETWEEN (SELECT MIN([month]) FROM tb_operating_activity WHERE BudgetCodeActivity = '$budget_code_activity') AND '$end_date'";
        // $query = $this->db->query($sql);
        $sql = "SELECT SUM(BudgetActivity)/12 AS BudgetActivity FROM tb_operating_activity 
        WHERE BudgetCodeActivity = '$budget_code_activity'";
        $query = $this->db->query($sql);
        return $query->row()->BudgetActivity;
    }

    public function getBudgetActivityReport($budget_code)
    {
        // $sql = "select distinct t1.BudgetCode, t1.BudgetCodeActivity, t1.ActivityName, t1.BudgetActivity,
        // (select sum(Budget_unbooked) from tb_operating_proposal 
        // where BudgetCodeActivity = t1.BudgetCodeActivity) as Used,
        // t1.BudgetActivity - (select sum(Budget_unbooked) from tb_operating_proposal 
        // where BudgetCodeActivity = t1.BudgetCodeActivity) as Saldo
        // from tb_operating_activity t1
        // where BudgetCode = '$budget_code'";
        $sql = "exec getBudgetActivityUsedReport '$budget_code'";
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

    public function functionGetMonthBudget($budget_code)
    {
        $sql = "select [Month] from tb_operating where BudgetCode = '$budget_code'
        order by [Month] asc";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getBudgetOnTopById($id)
    {
        $sql = "select * from tb_budget_on_top where id = '$id'";
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

    public function getBudgetOnTop($budgetCode)
    {
        // $brand_code = $post['brand'];
        // $end_date = $post['end_date'];
        // $activity = $post['activity'];
        // var_dump($post);

        $sql = "select * from tb_budget_on_top where budget_code = '$budgetCode'";
        $query = $this->db->query($sql);
        return $query;





        // $sql = "SELECT t1.brand_code, t1.budget_code AS BudgetCode, t1.[month], t2.id_activity as ActivityCode FROM tb_budget_on_top t1
        // INNER JOIN tb_budget_on_top_activity t2 on t1.budget_code = t2.budget_code 
        // WHERE t1.brand_code = '$brand_code' AND year([month]) = year('$end_date') 
        // AND month([Month]) = month('$end_date') AND t2.id_activity = '$activity '";
        // $query = $this->db->query($sql);
        // return $query;
    }

    public function getTotalOnTop($budgetCode)
    {
        $sql = "SELECT SUM(budget_on_top) as totalOnTop FROM tb_budget_on_top WHERE budget_code = '$budgetCode'";
        $query = $this->db->query($sql);
        return $query->row()->totalOnTop;
    }

    public function getTotalUsedOnTop($budetCode)
    {
        $sql = "select CASE WHEN sum(t1.TotalCosting) is null THEN 0 ELSE sum(t1.TotalCosting) END as TotalCostingOnTop
        from tb_operating_proposal t1
        inner join tb_proposal t2 on t1.ProposalNumber = t2.Number and t2.[Status] in ('open','approved') 
        where t1.BudgetCode = '$budetCode' and t1.Budget_type = 'on_top'";
        $query = $this->db->query($sql);
        return $query->row()->TotalCostingOnTop;
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

    public function getYTDBudgetActivity($budget_code, $end_date_proposal)
    {
        $sql = "SELECT SUM(ss.BudgetActivity) AS BudgetActivity FROM
                (SELECT * FROM tb_operating_activity 
                WHERE [Month] Between (SELECT MIN([month]) FROM tb_operating WHERE BudgetCode = '$budget_code') AND '$end_date_proposal')ss";
        $YtdBudgetActivity = $this->db->query($sql)->row()->BudgetActivity;
        return $YtdBudgetActivity;
    }

    public function getYTDOperatingBudget($budget_code, $end_date)
    {
        $sql = "SELECT SUM(ss.OperatingBudget) AS OperatingBudget FROM
                (SELECT * FROM tb_operating_activity 
                WHERE [Month] Between (SELECT MIN([month]) FROM tb_operating WHERE BudgetCodeActivity = '$budget_code') AND '$end_date')ss";
        $YtdOperating = $this->db->query($sql)->row()->OperatingBudget;
        return $YtdOperating;
    }

    public function getYTDAllocatedBudget($budget_code_activity)
    {
        $sql = "SELECT SUM(AllocatedBudget) AS YtdAllocatedBudget FROM tb_operating_proposal WHERE BudgetCodeActivity = '$budget_code_activity' and Budget_type = 'operating'";
        $query = $this->db->query($sql)->row()->YtdAllocatedBudget;
        if ($query == NULL) {
            return 0;
        } else {
            return $query;
        }
    }

    public function getPrefix($brand_code)
    {
        $sql = "select UPPER(LEFT(REPLACE(BrandName,' ',''), 3)) as prefix, REPLACE(BrandName,' ','') as BrandName from m_brand
        where BrandCode = '$brand_code'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getNumber()
    {
        $user_code = $_SESSION['user_code'];
        $sql = "SELECT FORMAT(MAX(SUBSTRING(number,10,13))+1, 'd4') as number from tb_proposal where UserCode = '$user_code'";
        $query = $this->db->query($sql);
        $number = $query->row()->number;
        if ($number == null) {
            $number = '0001';
        }
        $sql2 = "SELECT concat(cast(year(getdate()) AS varchar),'$number') as num";
        $query2 = $this->db->query($sql2);
        $number = $user_code . $query2->row()->num;
        return $number;
    }

    public function getYtdBudgetActualActivity($brand, $budget_code, $budget_code_activity, $endDateProposal)
    {
        $budget_actual_activity = 0;

        // $sql = "
        // declare @brand as varchar(100) = '$brand'
        // declare @budgetCode as varchar(100) = '$budget_code'
        // declare @budgetCodeActivity as varchar(100) = '$budget_code_activity'
        // declare @startDateBudget as date = (SELECT MIN([month]) FROM tb_operating WHERE BudgetCode = @budgetCode)
        // declare @endDateProposal as date = '$endDateProposal'
        // declare @ytdPurchase as float = (SELECT SUM(Amount) FROM tb_purchase_with_date WHERE CodeBrand = @brand AND format([Date], 'yyyy-MM') Between format(@startDateBudget, 'yyyy-MM') AND format(@endDateProposal, 'yyyy-MM'))
        // declare @percentageAnp as Float = (SELECT SUM(PrincipalAnpIDR)/SUM(PrincipalTargetIDR) FROM tb_operating WHERE BudgetCode = @budgetCode)
        // declare @percentageOperating as float = (SELECT SUM(OperatingBudget)/SUM(PrincipalAnpIDR) FROM tb_operating WHERE BudgetCode = @budgetCode)
        // declare @budgetActivity as float = (SELECT SUM(BudgetActivity) as float FROM tb_operating_activity WHERE BudgetCodeActivity = @budgetCodeActivity)
        // declare @percentageBudgetActivity as float = (SELECT @budgetActivity/SUM(OperatingBudget) FROM tb_operating WHERE BudgetCode = @budgetCode)
        // SELECT ((@ytdPurchase * @percentageAnp)) * @percentageBudgetActivity AS ytd_budget_actual_activity";

        $sql = "exec getYtdBudgetActualActivity '$brand', '$budget_code', '$budget_code_activity', '$endDateProposal'";
        $query = $this->db->query($sql);
        if ($query->row()->ytd_budget_actual_activity != NULL) {
            $budget_actual_activity = $query->row()->ytd_budget_actual_activity;
        }
        return $budget_actual_activity;
    }

    public function getNoDoc($noDoc)
    {
        $sql = "select NoRef from tb_proposal where NoRef = '$noDoc'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function insertProposal($post)
    {
        // var_dump(count($post['customer_code']));
        $post['customer_code'] = json_decode($post['customer_code'], true);
        // die;

        $customer_group = array_values(array_unique($post['t_group']));
        $number = $this->getNumber();
        $username = $_SESSION['username'];
        $user_code = $_SESSION['user_code'];
        $date = $this->getDate();
        $budget_code = $post['budget_code'];
        $budget_code_activity = $post['budget_code_activity'];

        //insert proposal
        $params = array(
            'Number' => $number,
            'NoRef' => $post['no_doc'],
            'StartDatePeriode' => $post['start_date'],
            'EndDatePeriode' => $post['end_date'],
            'BudgetCode' => $budget_code,
            'BudgetCodeActivity' => $budget_code_activity,
            'Activity' => $post['activity'],
            'BrandCode' => $post['brand'],
            'AvgSales' => $post['activity'] == '20' ? 'Non Sales' : $post['avg_sales_type'], // Jika activity 'Listing' => Avg Sales = Non Sales
            'Status' => 'open',
            'ClaimTo' => $post['claim_to'],
            'CreatedBy' => $_SESSION['username'],
            'UserCode' => $user_code,
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
                'AvgSales' => (float)$post['item_avg_sales'][$i],
                'Qty' => (float)$post['item_qty'][$i],
                'Target' => (float)$post['item_target'][$i],
                'Promo' => (float)$post['item_promo'][$i],
                'PromoValue' => !empty($post['item_promo_value']) ? (float)$post['item_promo_value'][$i] : 0,
                'Costing' => (float)$post['item_costing'][$i],
                'ListingCost' => !empty($post['listing_cost']) ? (float)$post['listing_cost'][$i] : 0,
            );
            $this->db->insert('tb_proposal_item', $items);
        }

        //insert item other
        if (isset($post['other_cost'])) {
            for ($i = 0; $i < count($post['other_cost']); $i++) {
                $items_other = array(
                    'ProposalNumber' => $this->db->query("SELECT [Number] FROM tb_proposal WHERE id = '$id'")->row()->Number,
                    'Desc' => $post['other_desc'][$i],
                    'Costing' => $post['other_cost'][$i],
                );
                $this->db->insert('tb_proposal_item_other', $items_other);
            }
        }

        //insert customer
        $ProposalNumber = $this->db->query("SELECT [Number] FROM tb_proposal WHERE id = '$id'")->row()->Number;
        $CustomerCode = implode(",", $post['customer_code']);
        $sql_insert_customer = "exec insertCustomerProposal '$ProposalNumber','$CustomerCode'";
        $insert_customer_proposal = $this->db->query($sql_insert_customer);


        //Insert CustomerGroup
        $ProposalNumber = $this->db->query("SELECT [Number] FROM tb_proposal WHERE id = '$id'")->row()->Number;
        $sql_insert_customer_group = "insert into tb_proposal_group(ProposalNumber, GroupCustomer)
        select ProposalNumber, GroupCustomer from tb_proposal_customer
        where ProposalNumber = '$ProposalNumber'
        group by ProposalNumber, GroupCustomer";
        $insert_customer_group = $this->db->query($sql_insert_customer_group);


        //insert operating proposal
        $operating = array(
            'BudgetCode' => $budget_code,
            'BudgetCodeActivity' => $budget_code_activity,
            'BrandCode' => $post['brand'],
            'ActivityCode' => $post['activity'],
            'ProposalNumber' => $this->db->query("SELECT [Number] FROM tb_proposal WHERE id = '$id'")->row()->Number,
            'StartPeriodeProposal' => $post['start_date'],
            'EndPeriodeProposal' => $post['end_date'],
            'TotalCosting' => (float)$post['total_costing'],
            'Budget_type' => $post['budget_type'],
            'Budget_saldo' => (float)str_replace(',', '', $post['budget_saldo']),
            'Budget_allocated' => (float)str_replace(',', '', $post['total_costing']),
            'Budget_unbooked' => (float)str_replace(',', '', $post['total_costing']),
            'Budget_booked' => 0,
            'Budget_used' => 0,
            'Budget_balance' => (float)str_replace(',', '', $post['budget_saldo']) - (float)str_replace(',', '', $post['total_costing']),
            'CreatedBy' => $username,
            'CreatedDate' => $date,
        );
        $this->db->insert('tb_operating_proposal', $operating);

        if (!empty($post['objective'])) {
            for ($i = 0; $i < count($post['objective']); $i++) {
                $objective = [
                    'ProposalNumber' => $this->db->query("SELECT [Number] FROM tb_proposal WHERE id = '$id'")->row()->Number,
                    'Objective' => $post['objective'][$i],
                ];
                $this->db->insert('tb_proposal_objective', $objective);
            }
        }

        if (!empty($post['mechanism'])) {
            for ($i = 0; $i < count($post['mechanism']); $i++) {
                $mechanism = [
                    'ProposalNumber' => $this->db->query("SELECT [Number] FROM tb_proposal WHERE id = '$id'")->row()->Number,
                    'Mechanism' => $post['mechanism'][$i],
                ];
                $this->db->insert('tb_proposal_mechanism', $mechanism);
            }
        }

        if (!empty($post['comment'])) {
            for ($i = 0; $i < count($post['comment']); $i++) {
                $comment = [
                    'ProposalNumber' => $this->db->query("SELECT [Number] FROM tb_proposal WHERE id = '$id'")->row()->Number,
                    'Comment' => $post['comment'][$i],
                ];
                $this->db->insert('tb_proposal_comment', $comment);
            }
        }

        //insert item sales detail by group
        for ($i = 0; $i < count($post['t_qty_item']); $i++) {
            $customer_group_item = [
                'ProposalNumber' => $this->db->query("SELECT [Number] FROM tb_proposal WHERE id = '$id'")->row()->Number,
                'GroupCustomer' => $post['t_group'][$i],
                'ItemCode' => $post['t_item_code'][$i],
                'Sales' => $post['t_sales'][$i],
                'Target' => $post['t_qty_item'][$i],
            ];
            $this->db->insert('tb_proposal_group_item', $customer_group_item);
        }
    }

    public function getTotalBudgetActivity($BudgetCodeActivity)
    {
        $sql = "SELECT SUM(BudgetActivity) AS TotalBudgetActivity FROM tb_operating_activity WHERE BudgetCodeActivity = '$BudgetCodeActivity'";
        $query = $this->db->query($sql);
        return $query->row()->TotalBudgetActivity;
    }

    public function getCustomerProposal($number)
    {
        $sql = "select * from tb_proposal_customer t1
        inner join m_customer t2 on t1.CustomerCode = t2.CardCode
        where t1.ProposalNumber = '$number'";
        $query = $this->db->query($sql);
        return $query;
    }


    public function getProposal($params = null)
    {
        $sql = "SELECT DISTINCT t1.*, t2.Budget_type FROM tb_proposal t1 
        inner join tb_operating_proposal t2 on t1.[Number] = t2.ProposalNumber";
        if (!empty($params['user_code'])) {
            $user_code = $params['user_code'];
            $sql .= " WHERE t1.BrandCode IN(SELECT BrandCode FROM tb_pic_brand WHERE UserCode = '$user_code')";
        }

        if (!empty($params['number'])) {
            $number = $params['number'];
            $sql .= " WHERE t1.[Number] = '$number'";
        }

        $sql .= " ORDER BY t1.id DESC";

        $query = $this->db->query($sql);
        return $query;
    }

    public function getProposalItem($number)
    {
        $sql = "SELECT t1.ItemCode, FrgnName AS Barcode, t3.ItemName, t1.Price, t1.AvgSales, t1.Qty, t1.[Target], t1.Promo, t1.Costing,t1.PromoValue, t1.ListingCost FROM tb_proposal_item t1
        INNER JOIN m_brand t2 ON t1.BrandCode = t2.BrandCode
        INNER JOIN m_item t3 ON t1.ItemCode = t3.ItemCode
        WHERE t1.ProposalNumber = '$number'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getProposalItemOther($number)
    {
        $sql = "SELECT * FROM tb_proposal_item_other WHERE ProposalNumber = '$number'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getTotalCosting($number)
    {
        // $sql = "select sum(ss.costing) as total_costing from
        // (
        // select costing from tb_proposal_item where ProposalNumber = '$number'
        // union
        // select costing from tb_proposal_item_other where ProposalNumber = '$number'
        // )ss";

        $sql = "select (select case when sum(Costing) is null then 0 else sum(Costing) end from tb_proposal_item where ProposalNumber = '$number')
        + (select case when sum(costing) is null then 0 else sum(costing) end from tb_proposal_item_other where ProposalNumber = '$number') as total_costing";

        $query = $this->db->query($sql);
        return $query;
    }

    public function getProposalCustomer($number)
    {
        $sql = "SELECT t1.id, GroupCustomer, t2.GroupName,t1.CustomerCode, t2.CustomerName, t1.no_sk FROM tb_proposal_customer t1
        INNER JOIN CustomerView t2 ON t1.CustomerCode = t2.CardCode
        WHERE t1.ProposalNumber = '$number'";
        $query = $this->db->query($sql);
        // var_dump($sql);
        // die;
        return $query;
    }

    public function editNoSK($post)
    {
        // var_dump($post);
        // die;
        for ($i = 0; $i < count($post['id']); $i++) {
            $data = array(
                'no_sk' => $post['no_sk'][$i],
                'sk_created_by' => $_SESSION['username'],
                'sk_created_at' => $this->getDate(),
            );

            $this->db->where('id', $post['id'][$i]);
            $this->db->update('tb_proposal_customer', $data);
        }

        // var_dump($this->db->last_query());
        // var_dump($this->db->error());
        // die;
    }

    public function deleteProposal($number)
    {
        $sql = "DELETE tb_proposal WHERE [Number] = '$number'
            DELETE tb_proposal_item WHERE [ProposalNumber] = '$number'
            DELETE tb_proposal_customer WHERE [ProposalNumber] = '$number'
            DELETE tb_operating_proposal WHERE [ProposalNumber] = '$number'
            DELETE tb_proposal_objective WHERE [ProposalNumber] = '$number'
            DELETE tb_proposal_mechanism WHERE [ProposalNumber] = '$number'
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
        $unbooked = $this->db->query("SELECT Budget_unbooked FROM tb_operating_proposal WHERE ProposalNumber = '$number'")->row()->Budget_unbooked;
        // var_dump($unbooked);
        // die;
        $update_budget = $this->db->query("UPDATE tb_operating_proposal SET Budget_unbooked = 0, DeallocatedBudget = '$unbooked', CancelBy = '$username', CancelDate = '$date' WHERE ProposalNumber = '$number'");
        $update_status_proposal = $this->db->query("UPDATE tb_proposal SET [Status] = 'cancelled', CancelBy = '$username', CancelDate = '$date' WHERE Number = '$number'");
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
        // var_dump($post);
        // die;
        $number = $this->getNumberBudget($post['brand_code']);
        for ($i = 0; $i < count($post['month']); $i++) {
            $params = array(
                'BudgetCode' => $number,
                'BrandCode' => $post['brand_code'],
                'BrandName' => getBrandName($post['brand_code']),
                'BudgetType' => $post['budget_type'],
                'Year' => date('Y', strtotime($post['month'][$i])),
                'Month' => $post['month'][$i],
                'Valas' => $post['valas'],
                'ExchangeRate' => (float)$post['exchange_rate'],
                'PrincipalTargetValas' => (float)str_replace(',', '', $post['principal_target_valas'][$i]),
                'PrincipalTargetIDR' => (float)str_replace(',', '', $post['principal_target_idr'][$i]),
                'PrincipalAnpValas' => (float)str_replace(',', '', $post['anp_principal_valas'][$i]),
                'PrincipalAnpIDR' => (float)str_replace(',', '', $post['anp_principal_idr'][$i]),
                'PKTargetIDR' => (float)str_replace(',', '', $post['pk_target_idr'][$i]),
                'PKAnpIDR' => (float)str_replace(',', '', $post['pk_anp_idr'][$i]),
                'OperatingBudget' => (float)str_replace(',', '', $post['anp_operating'][$i]),
                'IMS_Target' => (float)str_replace(',', '', $post['ims_target'][$i]),
                'IMS_Budget' => (float)str_replace(',', '', $post['ims_budget'][$i]),
                'is_ims' => $post['set_ims'],
                'ims_percent' => $post['ims_percent'],
                'CreatedBy' => $_SESSION['username'],
                'PicCode' => $_SESSION['user_code'],
                'CreatedDate' => $this->getDate(),
            );
            // var_dump($params);
            $this->db->insert('tb_operating', $params);
        }
        // die;
    }

    // public function get_budget($post)
    // {
    //     // var_dump($post);
    //     $budget_code = $this->getBudgetCode($post)->row()->BudgetCode;
    //     // var_dump($budget_code);
    //     die;
    // }

    public function getBudgetBooked($budget_code_activity)
    {
        $sql = "SELECT SUM(Budget_booked) AS total_budget_booked FROM tb_operating_proposal WHERE BudgetCodeActivity = '$budget_code_activity' AND Budget_type = 'operating'";
        $query = $this->db->query($sql);
        $budget_booked = 0;
        if ($query->row()->total_budget_booked != NULL) {
            $budget_booked = $query->row()->total_budget_booked;
        }
        return $budget_booked;
    }

    public function getOperatingActivity($budget_code, $activity = null)
    {
        $sql = "SELECT BudgetCode, BudgetCodeActivity, BrandCode, ActivityCode, SUM(BudgetActivity) AS BudgetActivity 
        FROM tb_operating_activity";

        if ($activity != null) {
            $sql .= " WHERE BudgetCode = '$budget_code' AND ActivityCode = '$activity'";
        } else {
            $sql .= " WHERE BudgetCode = '$budget_code'";
        }

        $sql .= " Group By BudgetCode, BudgetCodeActivity, BrandCode, ActivityCode";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getStartPeriodeBudget($code)
    {
        $sql = "SELECT MIN([month]) AS StartPeriode FROM tb_operating_activity WHERE BudgetCodeActivity = '$code'";
        $query = $this->db->query($sql);
        $start_periode = $query->row()->StartPeriode;
        return date('Y-m-d', strtotime($start_periode));
    }

    public function getBudgetActivityVsOperating($budget_code_activity)
    {
        $sql = "SELECT AVG(OperatingBudget) as OperatingBudget, SUM(BudgetActivity) as TotalBudgetActivity, (SUM(BudgetActivity)/AVG(OperatingBudget)) AS activity_vs_operating
        FROM tb_operating_activity WHERE BudgetCodeActivity = '$budget_code_activity'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getAnpVsTarget($budget_code)
    {
        $sql = "SELECT SUM(PrincipalTargetIDR) as Target, SUM(PrincipalAnpIDR) as Anp, 
        SUM(PrincipalAnpIDR)/SUM(PrincipalTargetIDR) as [Anp_Vs_Target] FROM tb_operating WHERE BudgetCode = '$budget_code'";
        $query = $this->db->query($sql);
        // var_dump($this->db->error());
        return $query;
    }

    public function getOperatingVsAnp($budget_code)
    {
        $sql = "SELECT SUM(OperatingBudget) / SUM(PrincipalAnpIDR) as [Operating_Vs_Anp]FROM tb_operating WHERE BudgetCode = '$budget_code'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getYtdActualPurchase($brand, $budget_code_activity, $end_date)
    {
        $sql = "declare @startdate AS datetime = (SELECT MIN([month]) FROM tb_operating_activity WHERE BudgetCodeActivity = '$budget_code_activity')
        declare @StartYearMonth AS varchar(50) = format(DATEADD(MONTH, DATEDIFF(MONTH, 0, @startdate), 0), 'yyyy-MM')
        declare @EndYearMonth AS varchar(50) = format(DATEADD(MONTH, DATEDIFF(MONTH, 0, '$end_date'), 0), 'yyyy-MM')
        SELECT SUM(Amount) AS YtdActualPurchase FROM
        (SELECT *,format(DATEADD(MONTH, DATEDIFF(MONTH, 0, [Date]), 0), 'yyyy-MM') AS YearMonth 
        FROM tb_purchase_with_date WHERE CodeBrand = '$brand')ss
        WHERE ss.YearMonth between @StartYearMonth and @EndYearMonth";
        $query = $this->db->query($sql);
        return $query->row()->YtdActualPurchase;
    }


    public function getYTDActualBudget($brand, $start_date, $end_date)
    {
        // $sql = "SELECT SUM(Amount) AS YtdPurchase FROM tb_purchase WHERE CodeBrand = '$brand' AND [Year] BETWEEN Year('$start_date') AND Year('$end_date') AND [month] BETWEEN Month('$start_date') AND Month('$end_date')";
        $sql = "SELECT --*
        SUM(Amount) AS YtdPurchase 
        FROM tb_purchase_with_date 
        WHERE 
        CodeBrand = '$brand'
        AND
        DATEADD(month, DATEDIFF(month, 0, [date]), 0) BETWEEN 
        DATEADD(month, DATEDIFF(month, 0, '$start_date'), 0) AND
        DATEADD(month, DATEDIFF(month, 0, '$end_date'), 0)";
        $query = $this->db->query($sql);
        $actual_budget = $query->row()->YtdPurchase;
        $actual_budget = $actual_budget;
        return $actual_budget;
    }

    public function getOperatingActivityDetail($budget_code)
    {
        $sql = "SELECT * FROM tb_operating_activity
        WHERE BudgetCodeActivity = '$budget_code'";
        $query = $this->db->query($sql);
        return $query;
    }

    // public function simpanOperatingActivity($post) // script old
    // {
    //     // var_dump($post);
    //     // die;
    //     for ($i = 0; $i < count($post['activity']); $i++) {
    //         $params = array(
    //             'BudgetCode' => $post['budget_code'],
    //             'BudgetCodeActivity' => $post['budget_code_activity'][$i],
    //             'BrandCode' => $post['brand_code'],
    //             'BrandName' => getBrandName($post['brand_code']),
    //             'ActivityCode' => $post['activity'][$i],
    //             'ActivityName' => getActivityName($post['activity'][$i]),
    //             'Month' => $post['month'][$i],
    //             'PrincipalTargetIDR' => $this->getPrincipalTarget($post['budget_code']),
    //             'PrincipalAnpIDR' => $this->getTargetAnp($post['budget_code']),
    //             'OperatingBudget' => $this->getTotalOperatingBudget($post['budget_code']),
    //             'BudgetActivity' => (float)$post['budget_activity'][$i],
    //             'BudgetActivity%' => ((float)$post['budget_activity'][$i] / (float)$this->getTotalOperatingBudget($post['budget_code'])) * 100,
    //             'CreatedBy' => $_SESSION['username'],
    //             'CreatedDate' => $this->getDate()
    //         );
    //         // var_dump($params);
    //         $this->db->insert('tb_operating_activity', $params);
    //     }
    // }

    public function simpanOperatingActivity($post) // script revisi
    {
        // var_dump($post);
        // var_dump($post['activity']);
        // var_dump($post['budget_code_activity']);
        // var_dump($post['budget_activity']);


        //perbaikan insert, activity yang tidak dipilih, agar di set 0
        $act = implode(",", $post['activity']);
        $other_activity = $this->db->query("select id from m_promo where id not in(select value FROM  STRING_SPLIT('$act', ','))");
        foreach ($other_activity->result() as $a) {
            //activity
            array_push($post['activity'], (string)$a->id);
            //budget code activity
            array_push($post['budget_code_activity'], $post['budget_code'] . "/" . (string)$a->id);
            //budget activity yang tidak diset user, di set 0
            array_push($post['budget_activity'], '0');
        }

        // var_dump($post['activity']);
        // var_dump($post['budget_code_activity']);
        // var_dump($post['budget_activity']);
        // die;
        for ($i = 0; $i < count($post['activity']); $i++) {

            for ($m = 0; $m < count($post['month']); $m++) {
                $params = array(
                    'BudgetCode' => $post['budget_code'],
                    'BudgetCodeActivity' => $post['budget_code_activity'][$i],
                    'BrandCode' => $post['brand_code'],
                    'BrandName' => getBrandName($post['brand_code']),
                    'ActivityCode' => $post['activity'][$i],
                    'ActivityName' => getActivityName($post['activity'][$i]),
                    'Month' => $post['month'][$m],
                    'PrincipalTargetIDR' => $this->getPrincipalTarget($post['budget_code']),
                    'PrincipalAnpIDR' => $this->getTargetAnp($post['budget_code']),
                    'OperatingBudget' => $this->getTotalOperatingBudget($post['budget_code']),
                    'BudgetActivity' => (float)$post['budget_activity'][$i],
                    'BudgetActivity%' => ((float)$post['budget_activity'][$i] / (float)$this->getTotalOperatingBudget($post['budget_code'])) * 100,
                    'CreatedBy' => $_SESSION['username'],
                    'CreatedDate' => $this->getDate()
                );
                // var_dump($params);
                $this->db->insert('tb_operating_activity', $params);
            }
        }
    }

    public function getPrincipalTarget($budget_code)
    {
        $sql = "SELECT PrincipalTargetIDR FROM tb_operating WHERE BudgetCode = '$budget_code'";
        $query = $this->db->query($sql);
        return $query->row()->PrincipalTargetIDR;
    }

    public function getTargetAnp($budget_code)
    {
        $sql = "SELECT [PrincipalAnpIDR] AS TargetAnp FROM tb_operating WHERE BudgetCode = '$budget_code'";
        $query = $this->db->query($sql);
        return $query->row()->TargetAnp;
    }



    public function getTotalOperatingBudget($budget_code)
    {
        $sql = "SELECT SUM(OperatingBudget) AS OperatingBudget FROM tb_operating WHERE BudgetCode = '$budget_code'";
        $query = $this->db->query($sql);
        return $query->row()->OperatingBudget;
    }

    public function checkOperatingAlreadyExist($brand, $start_month, $end_month)
    {
        $sql = "SELECT * FROM tb_operating WHERE BrandCode = '$brand' AND [Month] Between  '$start_month' and  '$end_month'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getOperatingPurchase($user_code = null)
    {
        $sql = "SELECT ss.BudgetCode, ss.BrandCode, ss.BrandName, 
        MIN(ss.[Month]) AS StartPeriode, 
        MAX(ss.[Month]) AS EndPeriode,
        SUM([Target]) AS Total_target, 
        SUM(OperatingBudget) AS Total_operating FROM 
        (SELECT BudgetCode, BrandCode, BrandName, [Month], [Target], OperatingBudget FROM tb_operating)ss";

        if ($user_code != null) {
            $sql .= " WHERE ss.BrandCode IN(SELECT BrandCode FROM tb_pic_brand WHERE UserCode = '$user_code')";
        }

        $sql .= " GROUP BY ss.BudgetCode, ss.BrandCode, ss.BrandName";
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
        INNER JOIN m_promo t2 ON t1.ActivityCode = t2.id AND sales != 'Y'";
        $query = $this->db->query($sql);
        return $query;
    }
    public function getActivityFromBudgetSeteed()
    {
        $sql = "SELECT DISTINCT 
        t1.ActivityCode as id, 
        t2.promo_name as ActivityName, sales 
        FROM tb_operating_activity t1
        INNER JOIN m_promo t2 ON t1.ActivityCode = t2.id
        UNION
        SELECT DISTINCT t2.id, 
        t2.promo_name as ActivityName, sales 
        FROM tb_budget_on_top_activity t1
        INNER JOIN m_promo t2 ON t1.id_activity = t2.id";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getBudgetAllocatedActivity($budget_code_activity)
    {
        $sql = "SELECT SUM(Budget_allocated) as SUMAllocatedBudget FROM tb_operating_proposal WHERE BudgetCodeActivity = '$budget_code_activity' AND Budget_type = 'operating'";
        $query = $this->db->query($sql);
        $allocated_budget = $query->row()->SUMAllocatedBudget;
        // var_dump($sql);
        // var_dump($allocated_budget);
        // die;
        if (is_null($allocated_budget)) {
            $allocated_budget = 0;
        }
        // var_dump($this->db->error());
        return $allocated_budget;
    }

    public function getBudgetUsed($budget_code)
    {
        $sql = "select sum(t1.TotalCosting) as TotalCosting from 
        tb_operating_proposal t1
        inner join tb_proposal t2 on t1.ProposalNumber = t2.Number and t2.[Status] in ('open','approved') 
        where 
        t1.BudgetCode = '$budget_code' 
        and 
        t1.Budget_type = 'operating'";
        $query = $this->db->query($sql);
        $totalCosting = $query->row()->TotalCosting;
        if (is_null($totalCosting)) {
            $totalCosting = 0;
        }
        return $totalCosting;
    }

    public function getBudgetAllocated($budgetCode)
    {
        $sql = "select SUM(Budget_allocated) as budget_total_allocated from tb_operating_proposal where BudgetCode = '$budgetCode'and Budget_type = 'operating'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getBrandPic($pic_code)
    {
        $sql = "SELECT * FROM tb_pic_brand WHERE UserCode = '$pic_code'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getBrandPicJoinPenjualan($pic_code)
    {
        $sql = "SELECT DISTINCT t1.BrandCode, t1.BrandName FROM tb_pic_brand T1
        INNER JOIN tb_sales T2 ON T1.BrandCode = T2.CodeBrand 
        WHERE T1.UserCode = '$pic_code'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getApprovedBy($proposalNumber)
    {
        $sql = "SELECT * FROM tb_proposal_approved WHERE proposalNumber = '$proposalNumber'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getHeaderOperating($budget_code)
    {
        $sql = "SELECT MIN([Month]) AS StartPeriode, 
        MAX([Month]) AS EndPeriode, 
        AVG(ExchangeRate) AS ExchangeRate,
        SUM(PrincipalTargetValas) AS TotalPrincipalTargetValas,
        SUM(PrincipalTargetIDR) AS TotalPrincipalTargetIDR,
        SUM([PKTargetIDR]) AS TotalPKTargetIDR,
        SUM([PKAnpIDR]) AS TotalPKAnpIDR,
        SUM([PrincipalAnpIDR]) AS TotalTargetAnp, 
        SUM(OperatingBudget) AS TotalOperating,
        SUM(IMS_Target) AS TotalImsTarget, 
        SUM(IMS_Budget) AS TotalImsBudget
        FROM tb_operating WHERE BudgetCode = '$budget_code'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function get_detail_budget($budget_code)
    {
        $sql = "SELECT *, [PrincipalAnpIDR] AS TargetAnp FROM tb_operating WHERE BudgetCode = '$budget_code' ORDER BY [Month] ASC";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getTotalAnp($budget_code)
    {
        $sql = "SELECT SUM(PrincipalAnpIDR) AS TotalAnp FROM tb_operating WHERE BudgetCode = '$budget_code'";
        $query = $this->db->query($sql);
        return $query->row()->TotalAnp;
    }



    public function getTotalTarget($budget_code)
    {
        $sql = "SELECT SUM(PrincipalTargetIDR) AS TotalTarget FROM tb_operating WHERE BudgetCode = '$budget_code'";
        $query = $this->db->query($sql);
        return $query->row()->TotalTarget;
    }

    public function getCustomerFromPenjualan($group = null)
    {
        $sql = "SELECT DISTINCT CardCode, CardName FROM tb_sales";
        if ($group != null) {
            $sql .= " WHERE GroupCode='$group'";
        }
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

    public function getGroupFromSales()
    {
        $sql = "SELECT DISTINCT GroupCode, GroupName FROM tb_sales";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getGroupMaster()
    {
        $sql = "SELECT DISTINCT GroupCode, GroupName FROM m_group";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getObjective($number)
    {
        $sql = "SELECT * FROM tb_proposal_objective WHERE [ProposalNumber] = '$number'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getMechanism($number)
    {
        $sql = "SELECT * FROM tb_proposal_mechanism WHERE [ProposalNumber] = '$number'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getComment($number)
    {
        $sql = "SELECT * FROM tb_proposal_comment WHERE [ProposalNumber] = '$number'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function get_ytd_ims($brand, $budget_code, $end_date_proposal)
    {
        $ims = 0;
        $percent_ims = $this->db->query("SELECT DISTINCT (ims_percent / 100) AS ims_percent FROM tb_operating WHERE BudgetCode = '$budget_code'")->row()->ims_percent;
        $start_periode_budget = $this->db->query("SELECT MIN([month]) as start_periode FROM tb_operating WHERE BudgetCode = '$budget_code'")->row()->start_periode;
        $sql = "declare @startDate as datetime = '$start_periode_budget'
        declare @endDate as datetime = '$end_date_proposal'
        SELECT SUM(Omset) AS Omset FROM tb_sales 
        WHERE CodeBrand = '$brand' AND format([month], 'yyyy-MM') Between format(@startDate, 'yyyy-MM') AND format(@endDate, 'yyyy-MM')";
        $get_omset = $this->db->query($sql);
        if ($get_omset->row()->Omset != NULL) {
            $ims = (float)$get_omset->row()->Omset * (float)$percent_ims;
        }
        return $ims;
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

    public function getImsUsed($budget_code)
    {
        $sql = "SELECT SUM(Budget_allocated) AS ims_allocated FROM tb_operating_proposal WHERE BudgetCode = '$budget_code' AND Budget_type = 'ims'";
        $query = $this->db->query($sql);
        $ims_used = 0;
        if ($query->row()->ims_allocated != NULL) {
            $ims_used = $query->row()->ims_allocated;
        }
        return $ims_used;
    }

    public function getMonthBudget($budget_code)
    {
        $sql = "SELECT [month] FROM tb_operating WHERE BudgetCode = '$budget_code'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getBrandBudget($budget_code)
    {
        $sql = "SELECT DISTINCT BrandCode, BrandName FROM tb_operating WHERE BudgetCode = '$budget_code'";
        $query = $this->db->query($sql);
        return $query;
    }

    // public function simpanBudgetOnTop($post)
    // {
    //     $budget_code = $_POST['budget_code'];
    //     // $cek_ontop_exist = $this->db->query("SELECT * FROM tb_budget_on_top WHERE budget_code = '$budget_code'")->num_rows();
    //     for ($i = 0; $i < count($post['month']); $i++) {
    //         $params = array(
    //             'brand_code' => $this->getBrandBudget($budget_code)->row()->BrandCode,
    //             'brand_name' => $this->getBrandBudget($budget_code)->row()->BrandName,
    //             'budget_code' => $budget_code,
    //             'month' => $post['month'][$i],
    //             'budget_on_top' => (float)str_replace(',', '', $post['on_top'][$i]),
    //             'created_by' => $_SESSION['username'],
    //             'created_date' => $this->getDate(),
    //         );
    //         $this->db->insert('tb_budget_on_top', $params);
    //     }
    // }

    public function get_total_budget_on_top($budget_code)
    {
        $sql = "SELECT SUM(budget_on_top) AS total_budget_on_top FROM tb_budget_on_top WHERE budget_code = '$budget_code'";
        $query = $this->db->query($sql);
        $total_budget_on_top = 0;
        if ($query->num_rows() > 0) {
            $total_budget_on_top = $query->row()->total_budget_on_top;
        }
        return $total_budget_on_top;
    }

    public function get_total_budget_on_top_allocated($budget_code_activity)
    {
        $sql = "SELECT SUM(Budget_allocated) AS total_budget_on_top_allocated FROM tb_operating_proposal WHERE BudgetCodeActivity = '$budget_code_activity' AND Budget_type = 'on_top'";
        $query = $this->db->query($sql);
        $total_budget_on_top_allocated = 0;
        if ($query->num_rows() > 0 && !is_null($query->row()->total_budget_on_top_allocated)) {
            $total_budget_on_top_allocated = $query->row()->total_budget_on_top_allocated;
        }
        return $total_budget_on_top_allocated;
    }

    public function get_total_budget_on_top_booked($budget_code_activity)
    {
        $sql = "SELECT SUM(Budget_booked) AS total_budget_on_top_booked FROM tb_operating_proposal WHERE BudgetCodeActivity = '$budget_code_activity' AND Budget_type = 'on_top'";
        $query = $this->db->query($sql);
        $total_budget_on_top_booked = 0;
        if ($query->num_rows() > 0 && !is_null($query->row()->total_budget_on_top_booked)) {
            $total_budget_on_top_booked = $query->row()->total_budget_on_top_booked;
        }
        return $total_budget_on_top_booked;
    }

    public function simpan_on_top_activity($post)
    {
        for ($i = 0; $i < count($post['input_percent_activity']); $i++) {
            if ($post['input_percent_activity'][$i] != '0') {
                $params = array(
                    'budget_code' => $post['budget_code'],
                    'budget_code_activity' => $post['budget_code_activity'][$i],
                    'id_activity' => $post['activity_id'][$i],
                    'budget_on_top_percent' => (float)($post['input_percent_activity'][$i]),
                    'create_by' => $_SESSION['username'],
                    'create_date' => $this->getDate()
                );
                $this->db->insert('tb_budget_on_top_activity', $params);
            }
        }
    }

    public function update_on_top($post)
    {
        // var_dump($post);
        for ($i = 0; $i < count($post['month']); $i++) {
            $budget_code = $post['budget_code'][$i];
            $month = $post['month'][$i];
            $budget_on_top = str_replace(',', '', $post['budget_on_top'][$i]);
            $username = $_SESSION['username'];
            $date = $this->getDate();
            $sql = "UPDATE tb_budget_on_top SET budget_on_top = '$budget_on_top', update_by = '$username', update_date = '$date'
            WHERE budget_code = '$budget_code' AND [month] = '$month'";
            $this->db->query($sql);
        }
    }

    public function update_proposal_item($post)
    {
        $proposal_number = $post['proposal_number'];
        $delete_data_exists = $this->db->query("DELETE tb_proposal_item WHERE ProposalNumber = '$proposal_number'");
        $cek_data = $this->db->query("SELECT * FROM tb_proposal_item WHERE ProposalNumber = '$proposal_number'");
        if ($cek_data->num_rows() < 1) {
            for ($i = 0; $i < count($post['item_code']); $i++) {
                $params = [
                    'ProposalNumber' => $post['proposal_number'],
                    'BrandCode' => $post['brand'],
                    'ItemCode' => $post['item_code'][$i],
                    'Price' => $post['item_price'][$i],
                    'AvgSales' => $post['item_avg_sales'][$i],
                    'Qty' => $post['item_qty'][$i],
                    'Target' => $post['item_target'][$i],
                    'Promo' => $post['budget_type'] == 'on_top' ? 0 : $post['item_promo'][$i],
                    'PromoValue' => $post['budget_type'] == 'on_top' ? 0 : $post['item_promo_value'][$i],
                    'Costing' => $post['item_costing'][$i],
                    'ListingCost' => $post['budget_type'] == 'on_top' ? $post['listing_cost'][$i] : 0,
                ];
                $this->db->insert('tb_proposal_item', $params);
            }
        }
    }

    public function update_proposal_customer($post)
    {
        $proposal_number = $post['proposal_number'];
        $delete_data_exists = $this->db->query("DELETE tb_proposal_customer WHERE ProposalNumber = '$proposal_number'");
        $cek_data = $this->db->query("SELECT * FROM tb_proposal_customer WHERE ProposalNumber = '$proposal_number'");
        if ($cek_data->num_rows() < 1) {
            for ($i = 0; $i < count($post['customer_code']); $i++) {
                $params = [
                    'ProposalNumber' => $post['proposal_number'],
                    'GroupCustomer' => $post['group_code'][$i],
                    'CustomerCode' => $post['customer_code'][$i],
                ];
                $this->db->insert('tb_proposal_customer', $params);
            }
        }
    }

    public function update_proposal_objective($post)
    {
        $proposal_number = $post['proposal_number'];
        $delete_data_exists = $this->db->query("DELETE tb_proposal_objective WHERE ProposalNumber = '$proposal_number'");
        $cek_data = $this->db->query("SELECT * FROM tb_proposal_objective WHERE ProposalNumber = '$proposal_number'");
        if ($cek_data->num_rows() < 1) {
            if (!empty($post['objective'])) {
                for ($i = 0; $i < count($post['objective']); $i++) {
                    $params  = [
                        'ProposalNumber' => $proposal_number,
                        'Objective' => $post['objective'][$i]
                    ];
                    $this->db->insert('tb_proposal_objective', $params);
                }
            }
        }
    }

    public function update_proposal_mechanism($post)
    {
        $proposal_number = $post['proposal_number'];
        $delete_data_exists = $this->db->query("DELETE tb_proposal_mechanism WHERE ProposalNumber = '$proposal_number'");
        $cek_data = $this->db->query("SELECT * FROM tb_proposal_mechanism WHERE ProposalNumber = '$proposal_number'");
        if ($cek_data->num_rows() < 1) {
            if (!empty($post['mechanism'])) {
                for ($i = 0; $i < count($post['mechanism']); $i++) {
                    $params  = [
                        'ProposalNumber' => $proposal_number,
                        'Mechanism' => $post['mechanism'][$i]
                    ];
                    $this->db->insert('tb_proposal_mechanism', $params);
                }
            }
        }
    }

    public function update_proposal_comment($post)
    {
        $proposal_number = $post['proposal_number'];
        $delete_data_exists = $this->db->query("DELETE tb_proposal_comment WHERE ProposalNumber = '$proposal_number'");
        $cek_data = $this->db->query("SELECT * FROM tb_proposal_comment WHERE ProposalNumber = '$proposal_number'");
        if ($cek_data->num_rows() < 1) {
            if (!empty($post['comment'])) {
                for ($i = 0; $i < count($post['comment']); $i++) {
                    $params  = [
                        'ProposalNumber' => $proposal_number,
                        'Comment' => $post['comment'][$i]
                    ];
                    $this->db->insert('tb_proposal_comment', $params);
                }
            }
        }
    }

    public function update_tb_proposal($post)
    {
        // var_dump($post);
        $proposal_number = $post['proposal_number'];
        $username = $_SESSION['username'];
        $date = $this->getDate();
        $sql = "UPDATE tb_proposal SET [Status] = 'open', UpdateBy = '$username', UpdateDate = '$date' WHERE [Number] = '$proposal_number'";
        $this->db->query($sql);
    }

    public function update_tb_operating_proposal($post)
    {
        $username = $_SESSION['username'];
        $proposal_number = $post['proposal_number'];
        $date = $this->getDate();
        $budget_saldo = $post['budget_saldo'];
        $total_costing = $post['total_costing'];
        $budget_balance = (float)$budget_saldo - (float)$total_costing;
        $sql = "UPDATE tb_operating_proposal SET
        TotalCosting = '$total_costing', 
        Budget_saldo = '$budget_saldo', 
        Budget_allocated = '$total_costing', 
        Budget_unbooked = '$total_costing', 
        Budget_balance = '$budget_balance', 
        DeallocatedBudget = 0,
        UpdateBy = '$username', UpdateDate = '$date' 
        WHERE ProposalNumber = '$proposal_number'";
        $this->db->query($sql);
    }

    public function delete_cart_item()
    {
        $user_id = $_SESSION['user_code'];
        $sql = "delete from tb_item_cart where user_id = '$user_id'";
        $this->db->query($sql);
    }

    public function insert_batch_customer_item($data)
    {
        $this->db->insert_batch('tb_proposal_customer_item', $data);
    }

    public function set_cart_item($post)
    {

        $end = date('Y-m-d', strtotime($post['start_date']));
        $start = '';
        if ($post['avg_sales'] == 'Last 3 Month') {
            $start = date("Y-m-d", strtotime("-3 Months", strtotime($end)));
        } else if ($post['avg_sales'] == 'Last Year') {
            $start = date("Y-m-d", strtotime("-12 Months", strtotime($end)));
        }

        $brand = $post['brand'];
        $group_customer = implode(",", $post['group_customer']);
        $item_code = implode(",", $post['item_code']);
        $customer_code = $post['customer'];
        // var_dump($group_customer);
        // var_dump($item_code);
        // var_dump($customer_code);
        // var_dump($start);
        // var_dump($end);

        $sql = "getSalesByCustomerGroup @GroupCode='$group_customer', @ItemCode = '$item_code', @CustomerCode = '$customer_code', @StartDate = '$start', @EndDate = '$end'";
        $salesByGroup = $this->db->query($sql);
        return $salesByGroup;

        // $data = array();
        // for ($i = 0; $i < count($post['item_code']); $i++) {
        //     for ($x = 0; $x < count($post['customer']); $x++) {

        //         $param = array(
        //             'no_proposal' => $post['no_proposal'],
        //             'customer_code' => $post['customer'][$x],
        //             'customer_name' => $this->getCustomerFromTBSales($post['customer'][$x])->row()->CustomerName,
        //             'item_code' => $post['item_code'][$i],
        //             'barcode' => $this->getBarcodeFromTBSales($post['item_code'][$i]),
        //             'item_name' => getNameItem($post['item_code'][$i]),
        //             // 'qty_avg_sales' => (int)$this->getItemFromPenjualan($brand, $post['customer'][$x], $start, $end, $post['item_code'][$i], null)->row()->Quantity,
        //             'qty_avg_sales' => 0,
        //             'sales_estimation' => $post['item_qty'][$i],
        //             'user_id' => $_SESSION['user_code'],
        //         );

        //         $cek = $this->db->query("select * from tb_item_cart where no_proposal = '" . $post['no_proposal'] . "' and item_code = '" . $post['item_code'][$i] . "'");

        //         if ($cek->num_rows() > 0) {
        //             //nothing
        //         } else {
        //             array_push($data, $param);
        //         }
        //     }
        // }

        // var_dump($data);
        // die;

        // $this->db->insert_batch('tb_item_cart', $data);
    }

    public function get_item_cart()
    {
        $user_id = $_SESSION['user_code'];
        $sql = "select distinct no_proposal, item_code, barcode, item_name, sales_estimation from tb_item_cart where user_id = '$user_id'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function get_proposal_customer_item($number)
    {
        // $sql = "select t1.no_proposal, t1.customer_code, t2.CustomerName as customer_name, t1.item_code, 
        // t3.FrgnName as barcode, t3.ItemName as item_name, t1.sales_estimation, t1.avg_sales,
        // CASE WHEN CAST(t1.avg_sales as varchar) = '0' THEN '0' ELSE
        // CAST(ROUND(((t1.sales_estimation-t1.avg_sales)/t1.avg_sales)*100,0) as varchar)
        // END as growth
        // from tb_proposal_customer_item t1
        // inner join m_customer t2 on t1.customer_code = t2.CardCode
        // inner join m_item t3 on t1.item_code = t3.ItemCode
        // where t1.no_proposal = '$number' and t1.sales_estimation > 0";

        $sql = "select t1.ProposalNumber, t1.GroupCustomer, t2.GroupName, t3.FrgnName as Barcode, t3.ItemName,
        t1.Sales, t1.[Target]
        from tb_proposal_group_item t1
        inner join m_group t2 on t1.GroupCustomer = t2.GroupCode
        inner join m_item t3 on t1.ItemCode = t3.ItemCode
        WHERE t1.ProposalNumber = '$number' order by t2.GroupName asc";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getApproved($number)
    {
        $sql = "select * from tb_proposal_approved where proposalNumber = '$number'";
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

    public function getProposalItemGroupDetailById($id)
    {
        $sql = "select * from ProposalItemGroupDetailView
        where id = '$id'";
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

    // public function getCurrentSaldoForEdit($number){
    //     $current_saldo = 0;
    //     $sql_1= "select BudgetCode, Budget_type, TotalCosting 
    //     from tb_operating_proposal where ProposalNumber = '$number'";
    //     $proposal = $this->db->query($sql_1);
    //     $budget_code = $proposal->row()->BudgetCode;
    //     $budget_type = $proposal->row()->Budget_type;
    //     $total_costing = $proposal->row()->TotalCosting;
    //     if($budget_type == 'operating'){
    //         $sql_saldoe

    //     }else if($budget_type == 'on_top'){

    //     }
    // }
}
