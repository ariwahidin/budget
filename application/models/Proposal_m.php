<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proposal_m extends CI_Model {

    public function transaction_no()
    {
        $sql2 = "SELECT MAX(SUBSTRING(no_transaction,10,4)) AS no_transaction 
        FROM t_transaction 
        WHERE SUBSTRING(no_transaction,4,6) = convert(varchar, getdate(), 12)";

        $query = $this->db->query($sql2);
        // var_dump($query->row());
        // die;
        if($query->num_rows() > 0){
            $row = $query->row();
            $n = ((int)$row->no_transaction) + 1;
            $no = sprintf("%'.04d", $n); 
        }else{
            $no = "0001";
        }
        $transaction = date('ymd').$no;
        return $transaction;
    }

    public function add_customer_selected($post){
        $user_id = $this->fungsi->user_login()->id;
        $customer_id = $_POST['customer_id'];
        foreach($customer_id as $customer){
            $check = $this->get_customer_selected($user_id, $customer)->num_rows();
            if($check == 0){
                $params = array(
                    'customer_id' => $customer,
                    'user_id' => $user_id,
                );
                $this->db->insert('t_customer_selected',$params);
            }
        }
    }

    public function get_customer_selected($user_id = null, $customer_id = null){
        $sql = "SELECT *,m_customer.CustomerName as customer_name 
                FROM t_customer_selected
                INNER JOIN m_customer ON t_customer_selected.customer_id = m_customer.id";
        if($user_id != null){
            $sql .= " WHERE user_id = $user_id";
        }
        if($customer_id != null){
            $sql .= " AND customer_id = $customer_id";
        }
        $query = $this->db->query($sql);
        return $query;
    }

    public function customer_selected_del($post){
        $this->db->where('customer_id',$post['customer_id']);
        $this->db->delete('t_customer_selected');
    }

    public function getCustomerSales($brand, $tahun){
        // $sql = "SELECT CardCode, CardName, BRAND, [Year] FROM t_sales_item GROUP BY CardCode, CardName, BRAND, [Year]";
        $sql = "SELECT CardCode, CardName, [CodeBrand], BRAND, [Year] 
                FROM t_sales_item 
                WHERE [Year] = '$tahun' AND CodeBrand = '$brand'
                GROUP BY CardCode, CardName, [CodeBrand], BRAND, [Year]";

        $query = $this->db->query($sql);
        return $query;
    }

    public function setTableSales($post){
        $code_brand = $post['code_brand'];
        $tahun = $post['tahun'];
        $bulan = $post['bulan'];
        $sales_avg = $post['sales_avg'];
        $code_budget = $post['code_budget'];
        $customer_code = $post['customer_code'];
        $from_sales = $post['from_sales'];

        // $sql ="SELECT *, CardCode as customer_code, ItemCode as item_code, CodeBrand as brand_code, [Year] as tahun
        //         FROM t_sales_item 
        //         WHERE [Year] = 2022 
        //         AND [CodeBrand] = 135 
        //         AND [CardCode] = 'RTS01SSI34'";

        $sql ="SELECT *, CardCode as customer_code, ItemCode as item_code, CodeBrand as brand_code, [Year] as tahun
                FROM t_sales_item 
                WHERE [Year] = '$tahun' 
                AND [CodeBrand] = '$code_brand' 
                AND [CardCode] = '$customer_code'";
        $query = $this->db->query($sql)->result();
        $this->setTableSalesTemp($query);
    }

    public function max_id_tb_sales_temp(){
        $sql = "SELECT MAX(id) as id FROM t_sales_temp";
        $query = $this->db->query($sql);
        $id = $query->row()->id;
        if(is_null($id)){
            $id = 1;
        }
        return $id;
    }

    public function check_table_sales_m($post){
        // var_dump($post);
        $customer_code = $post['customer_code'];
        $brand_code = $post['code_brand'];
        $tahun = $post['tahun'];
        $sql = "SELECT * FROM t_sales_item 
                WHERE [Year] = '$tahun' AND [CodeBrand] = '$brand_code' AND [CardCode] = '$customer_code'";

        // $sql = "declare  @Today date = GETDATE()
        //         SELECT CardCode,CardName,[ItemCode],[ItemName], Barcode,
        //         CodeBrand,BRAND,[Year],
        //         isnull([1],0) as Jan, isnull([2],0) as Feb, isnull([3],0) as Mar, isnull([4],0) as Apr, isnull([5],0) as May, isnull([6],0) as Jun, isnull([7],0) as Jul, 
        //         isnull([8],0) as Aug, isnull([9],0) as Sep, isnull([10],0) as Oct, isnull([11],0) as Nov, isnull([12],0) as Dec
        //         from
        //         ( select t1.CardCode,t1.CardName,T0.[ItemCode],T2.[ItemName],T2.FrgnName AS Barcode,
        //         TB.ItmsGrpCod AS CodeBrand,TB.ItmsGrpNam AS BRAND,
        //         year(T1.[DocDate])  as Year,
        //         sum(T0.[Quantity]) as Quantity, month(T1.[DocDate]) as Month FROM [pksrv-sap].PANDURASA_LIVE.dbo.INV1 T0 
        //         INNER JOIN [pksrv-sap].PANDURASA_LIVE.dbo.OINV T1 ON T0.DocEntry = T1.DocEntry AND T1.CANCELED='N'
        //         INNER JOIN [pksrv-sap].PANDURASA_LIVE.dbo.OITM T2 ON T0.ItemCode = T2.ItemCode
        //         INNER JOIN [pksrv-sap].PANDURASA_LIVE.dbo.oitb tb WITH (NOLOCK) on T2.itmsgrpcod=tb.itmsgrpcod
        //         and (T1.[DocDate] between '20210101' and @Today --DATEADD(DAY, -1, GETDATE()) AND GETDATE()
        //         ) --WHERE (T0.ItemCode LIKE '%%[%0]%%' OR '[%0]' = ' ')
        //         WHERE (year(T1.[DocDate]) = '$tahun' AND TB.ItmsGrpCod = '$brand_code' AND T1.CardCode = '$customer_code')
        //         GROUP BY t1.CardCode,t1.CardName,T2.FrgnName,
        //         TB.ItmsGrpNam,tb.ItmsGrpCod,T0.[ItemCode],T2.[ItemName],
        //         year(T1.[DocDate]),
        //         T1.DocDate)S
        //         Pivot
        //         (sum(Quantity) FOR Month IN ([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])) P
        //         order by CardName,
        //         BRAND,ItemCode";

        $query = $this->db->query($sql);
        return $query;
    }

    public function setTableSalestemp($data){
        $total_data = count($data);
        $id = $this->max_id_tb_sales_temp();
        $user_id = $this->fungsi->user_login()->id;
        for($a = 0; $a < $total_data; $a++){

            $bulan = [
                $data[$a]->Jan,
                $data[$a]->Feb,
                $data[$a]->Apr,
                $data[$a]->Mar,
                $data[$a]->May,
                $data[$a]->Jun,
                $data[$a]->Jul,
                $data[$a]->Aug,
                $data[$a]->Sep,
                $data[$a]->Oct,
                $data[$a]->Nov,
                $data[$a]->Dec,
            ];

            $bulan_num = 1;
            for($i = 0; $i < count($bulan); $i++){
                $params = [
                    'id' => $id++,
                    'customer_code' => $data[$a]->CardCode,
                    'item_code' => $data[$a]->ItemCode,
                    'brand_code'=> $data[$a]->CodeBrand,
                    'tahun' => $data[$a]->Year,
                    'bulan' => $bulan_num++,
                    'sales' => $bulan[$i],
                    'user_id' => $user_id,
                ];
                // var_dump($params);
                $this->db->insert('t_sales_temp', $params);
                // var_dump($this->db->error());
            }
        }

        // die;
    }

    public function getItemFromSalesTemp(){
        // $sql = "SELECT DISTINCT T1.Sales as Sales, T2.ItemName as ItemName, T2.ItemCode as ItemCode, T2.FrgnName as Barcode, T3.BrandCode as BrandCode, T3.BrandName as BrandName 
        //         FROM t_sales_temp T1 
        //         INNER JOIN m_item T2 ON T1.item_code = T2.ItemCode 
        //         INNER JOIN m_brand T3 ON T1.brand_code = T3.BrandCode";
        $sales_avg = (int)$_POST['sales_avg'];
        $bulan = (int)$_POST['bulan'];
        $last3month = [];
        
        $x = $bulan - 1;
        while($x > ($sales_avg + 1)) {
            array_push($last3month,$x);
        $x--;
        }
        $bulan = implode(',',$last3month);

        $sql = "SELECT item_code as ItemCode, (SUM(Sales)/$sales_avg) as Sales FROM t_sales_temp T1
                WHERE bulan IN($bulan) GROUP BY item_code";

        $query = $this->db->query($sql);
        return $query;
    }

    public function getCustomerFromSales($code_customer = null){
        $sql = "SELECT DISTINCT CustomerName, CardCode, T1.id as CustomerId, T2.GroupName as GroupName FROM m_customer T1
                INNER JOIN m_group T2 ON T1.GroupCode = T2.GroupCode
                INNER JOIN t_sales_temp T3 ON T1.CardCode = T3.customer_code";

        if($code_customer != null){
            $code_customer = implode(',', $code_customer);
            $code_customer = str_replace(",","','", $code_customer);
            $sql .= " WHERE T1.CardCode NOT IN('$code_customer')"; 
        }
        $query = $this->db->query($sql);
        return $query;
    }

    public function dellSalesTemp(){
        $user_id = $this->fungsi->user_login()->id;
        $query = $this->db->where('user_id',$user_id);
        $query = $this->db->delete('t_sales_temp');
        return $query; 
    }

}