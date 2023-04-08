<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class pembelian_m extends CI_Model {

    public function get($brand_year = null)
    {
        // $sql = "EXEC [192.168.100.121].[PK-ANP].[dbo].[_PK_GRPO_byBrand]";
        $id_user = $this->fungsi->user_login()->id;
        // $brand_handled_user = getBrandUserHandled($id_user);
        // var_dump($brand_handled_user);
        // die;
        $sql = "SELECT * FROM 
                (SELECT cast(codeBRAND AS VARCHAR) + cast([YEAR] AS VARCHAR) AS brandyear, * FROM master_pembelian)
                AS aa";

        // $sql = "declare  @Today date = GETDATE()
        //         SELECT cast(codeBRAND AS VARCHAR) + cast([YEAR] AS VARCHAR) AS brandyear,
        //         CardName, CodeBrand, BRAND, [Year], isnull([1],0) as Jan, isnull([2],0) as Feb, isnull([3],0) as Mar, isnull([4],0) as Apr, isnull([5],0) as May, isnull([6],0) as Jun, isnull([7],0) as Jul, 
        //         isnull([8],0) as Aug, isnull([9],0) as Sep, isnull([10],0) as Oct, isnull([11],0) as Nov, isnull([12],0) as Dec
        //         FROM ( SELECT '-' AS CardName, TB.ItmsGrpCod AS CodeBrand,TB.ItmsGrpNam AS BRAND, year(T1.[DocDate]) AS Year, SUM(T0.[linetotal]) as Quantity, month(T1.[DocDate]) as Month FROM [pksrv-sap].PANDURASA_LIVE.dbo.PDN1 T0 
        //         INNER JOIN [pksrv-sap].PANDURASA_LIVE.dbo.OPDN T1 ON T0.DocEntry = T1.DocEntry 
        //         INNER JOIN [pksrv-sap].PANDURASA_LIVE.dbo.OITM T2 ON T0.ItemCode = T2.ItemCode
        //         INNER JOIN [pksrv-sap].PANDURASA_LIVE.dbo.oitb tb WITH (NOLOCK) on T2.itmsgrpcod=tb.itmsgrpcod
        //         AND (T1.[DocDate] between '20210101' and @Today)";

        if($brand_year != null){
            // $sql .= "WHERE CONCAT(TB.ItmsGrpCod,year(T1.[DocDate])) NOT IN('$brand_year')";
            $sql .= " WHERE brandyear NOT IN('$brand_year')";
        }

        // if($brand_handled_user != null || $brand_handled_user != ''){
        //     $sql .= " AND CodeBrand IN ($brand_handled_user)";
        // }

        // $sql .= " GROUP BY CardName, TB.ItmsGrpNam,tb.ItmsGrpCod, year(T1.[DocDate]), T1.DocDate)S
        //         Pivot (sum(Quantity) FOR Month IN ([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])) P order by BRAND";
        // var_dump($this->db->error());
        $query = $this->db->query($sql);
        // print_r($sql);
        // die;
        // var_dump($sql);
        // var_dump($query->result());
        // die;
        return $query;
    }

    public function simpanBudget_m($post){
        for($i = 0; $i < count($post['month']); $i++){
            $params = [
                'no_anggaran' => $post['no_anggaran'],
                'brand_code' => $post['brand_code'],
                'bulan' => $post['month'][$i],
                'tahun' => $post['tahun'],
                'purchase' => str_replace(',','',$post['purchase'][$i]),
                'presentase' => $post['presentase'],
                'budget' => str_replace(',','',$post['budget'][$i]),
            ];
            $this->db->insert('m_anggaran_detail', $params);
        }
    }
    
}