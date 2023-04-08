<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anggaran_m extends CI_Model {

    public function anggaran_code()
    {
        $sql = "SELECT MAX(SUBSTRING(no_anggaran,7,4)) AS no_anggaran
        FROM m_anggaran_detail
        WHERE SUBSTRING(no_anggaran,1,6) = convert(varchar, getdate(), 12)";

        $query = $this->db->query($sql);
        // var_dump($query->row());
        // die;
        if($query->num_rows() > 0){
            $row = $query->row();
            $n = ((int)$row->no_anggaran) + 1;
            $no = sprintf("%'.04d", $n); 
        }else{
            $no = "0001";
        }
        $anggaran_no = date('ymd').$no;
        return $anggaran_no;
    }

    public function get($no_anggaran = null) 
    {
        $brand_user = getBrandUserHandled($this->fungsi->user_login()->id);
        $sql = "SELECT no_anggaran, tahun, brand_code, created_by, start_month, end_month, start_year, end_year, SUM(budget) AS subtotal
                FROM m_anggaran_detail";

        if($brand_user != null || $brand_user != ''){
            $sql .= " WHERE brand_code IN ($brand_user)";
        }

        $sql .= " GROUP BY no_anggaran, brand_code, created_by, start_month, tahun, end_month, start_year, end_year";
        $sql .= " ORDER BY no_anggaran DESC";
        // var_dump($sql);
        $query = $this->db->query($sql);
        return $query;
    }

    public function simpanAnggaran($post)
    {
       $this->simpanAnggaranDetailNew($post);
    }

    public function simpanAnggaranDetailNew($post){
        // var_dump($post);
        // die;
        for($i=0; $i< count($post['nilai_anggaran']); $i++){
            $params = [
                'no_anggaran' => $post['anggaran_code'],
                'brand_code' => $post['brand_code'],
                'bulan' => $post['bulan_anggaran'][$i],
                'tahun' => $post['tahun_anggaran'][$i],
                'budget' => str_replace(',','',$post['nilai_anggaran'][$i]),
                'start_month' => $post['bulan_anggaran'][0],
                'end_month' => end($post['bulan_anggaran']),
                'start_year' => $post['start_year'],
                'end_year' => $post['end_year'],
                'created_by' => $post['created_by'],
                'user_sign' => $post['user_sign'],
            ];
            // var_dump($params);
            $this->db->insert('m_anggaran_detail',$params);
        }
    }

    public function getAnggaranDetail($no_anggaran){
        $sql = "SELECT * FROM m_anggaran_detail WHERE no_anggaran = $no_anggaran";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getIdTableBudgetActivity(){
        $sql = "SELECT MAX(id) as id FROM t_budget_activity";
        $query = $this->db->query($sql);
        $id = $query->row()->id;
        if($id == null ){
            $id = 1;
        }else{
            $id = $id + 1;
        }
        return $id;
    }

    public function simpanAnggaranActivity($post){
        // var_dump($post);
        // die;
        $id = $this->getIdTableBudgetActivity();
        for($i=0 ;$i<count($post['isi_activity']); $i++){
            $params = [
                'id' => $id++,
                'no_anggaran' => $post['no_anggaran'],
                'code_budget' => preg_replace('/\s/', '',$post['brand_code'].$post['isi_tahun'][$i].$post['isi_activity'][$i].$post['isi_month'][$i]),
                'activity' =>$post['isi_activity'][$i],
                'month' =>$post['isi_month'][$i],
                'tahun' => $post['isi_tahun'][$i],
                'nominal_default' =>str_replace(',','',$post['isi_nominal'][$i]),
                'nominal' =>str_replace(',','',$post['isi_nominal'][$i]),
                'presentase' => $post['isi_presentase'][$i],
                'start_year' => $post['start_year'],
                'end_year' => $post['end_year'],
                'brand_code' => $post['brand_code'],
            ];
            // var_dump($params);
            $this->db->insert('t_budget_activity', $params);
            // var_dump($this->db->error());
        }
        // die;
    }

    public function getBrandCodeFromAnggaran($no_anggaran){
        $sql = "SELECT brand_code FROM m_anggaran WHERE anggaran_code = '$no_anggaran'";
        $query = $this->db->query($sql)->row()->brand_code;
        return $query;
    }
    
    public function getStartYearAnggaranDetail($no_anggaran){
        $sql = "SELECT DISTINCT start_year FROM m_anggaran_detail WHERE no_anggaran = '$no_anggaran'";
        $query = $this->db->query($sql)->row()->start_year;
        return $query;
    }

    public function getEndYearAnggaranDetail($no_anggaran){
        $sql = "SELECT DISTINCT end_year FROM m_anggaran_detail WHERE no_anggaran = '$no_anggaran'";
        $query = $this->db->query($sql)->row()->end_year;
        return $query;
    }

    public function getMonthAnggaranActivity($no_anggaran){
        $sql = "SELECT [bulan] AS [month], tahun FROM m_anggaran_detail WHERE no_anggaran = '$no_anggaran'  ORDER BY tahun";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getAnggaranActivity($no_anggaran){
        $sql = "SELECT * FROM t_budget_activity WHERE no_anggaran = '$no_anggaran'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getActivityFromAnggaranActivity($no_anggaran){
        $sql = "SELECT DISTINCT activity FROM t_budget_activity WHERE no_anggaran = $no_anggaran AND nominal != 0";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getPresentaseActivityFromAnggaranActivity($no_anggaran){
        // $sql = "SELECT DISTINCT activity FROM t_budget_activity WHERE no_anggaran = $no_anggaran AND nominal != 0";
        $sql = "SELECT activity, presentase FROM t_budget_activity WHERE no_anggaran = '$no_anggaran' AND nominal != 0 GROUP BY activity, presentase";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getAnggaranPerActivity($post){
        $code_budget = $post['code_budget'];
        $sql = "SELECT * FROM t_budget_activity
                WHERE code_budget LIKE '%$code_budget%' 
                AND nominal > 0";
        $query = $this->db->query($sql);
        return $query;
    }

    public function deleteAnggaran($no_anggaran){
        $this->db->where('no_anggaran', $no_anggaran);
        $this->db->delete('m_anggaran_detail');
        if($this->db->affected_rows() > 0){
            $this->db->where('no_anggaran', $no_anggaran);
            $this->db->delete('t_budget_activity');
            echo "<script>window.location='".site_url('anggaran')."';</script>";
        }
    }

    public function getAnggaranUsed($post)
    {
        $activity = $_POST['activityId'];
        $tahunAnggaran = $_POST['tahunAnggaran'];
        $brand = $_POST['brandId'];

        $sql = "SELECT * FROM t_budget_activity 
                WHERE activity = '$activity' 
                AND start_year = '$tahunAnggaran' 
                AND brand_code = '$brand' 
                AND nominal > 0";

        for($i = 0; $i < count($_POST['months']) ; $i++){
            $month = $_POST['months'][$i];
            $sql .= " AND [month] != '$month'";
        }

        $query = $this->db->query($sql);
        return $query;
    }

    public function budgetHasBeenSet(){
        $sql = "SELECT DISTINCT brand_code, tahun FROM m_anggaran_detail";
        $query = $this->db->query($sql);
        return $query;
    }

    public function budgetActivityHasBeenSet(){
        $sql = "SELECT DISTINCT no_anggaran FROM t_budget_activity";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getBrand($id_user = null ,$code_brand = null){
        $sql = "SELECT * FROM m_brand";
        $query = $this->db->query($sql);
        return $query;
    }

    public function get_purchase($code_brand, $start_periode, $end_periode){
        //from local
        // $sql = "SELECT CodeBrand, BRAND, [Year], month([month]) AS Month, SUM(Amount) AS Amount 
        // FROM tb_pembelian WHERE CodeBrand = '$code_brand' AND [month] BETWEEN '$start_periode' AND '$end_periode'
        // GROUP BY CodeBrand,BRAND,[Year],year([month]),month([month])
        // ORDER BY Year, Month";

        //from server
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
                WHERE TB.ItmsGrpCod = '$code_brand' AND T1.[DocDate] BETWEEN '$start_periode' AND '$end_periode'
                GROUP BY 
                TB.ItmsGrpNam,tb.ItmsGrpCod,T1.[DocDate],--T0.[ItemCode],T2.[ItemName],
                year(T1.[DocDate]))S
                group by s.CodeBrand,BRAND,[Year],[month]
                order by 
                BRAND, [Year]";
        $query = $this->db->query($sql);
        // var_dump($sql);
        return $query;
    }


    public function getActivity(){
        $sql = "SELECT * FROM m_promo";
        $query = $this->db->query($sql);
        return $query;
    }

    public function insertBudget($post){
        // var_dump($post);
        $code_anggaran = $this->getCodeAnggaran();
        for($i = 0 ; $i < count($post['activity']) ; $i++){
            for($x = 0 ; $x < count($post['monthValue'][$i]) ; $x++){
                $params = [
                    'codeAnggaran' => $code_anggaran,
                    'budgetCode' => $code_anggaran.'-'.$post['brandCode'].'-'.$post['activity'][$i].'-'.$post['budgetYearPeriode'].'-'.date('m',strtotime($post['monthValue'][$i][$x])).'-'.date('Y',strtotime($post['monthValue'][$i][$x])),
                    'brandCode' => $post['brandCode'],
                    'activity' => $post['activity'][$i],
                    'budgetYear' => $post['budgetYearPeriode'],
                    'month' => $post['monthValue'][$i][$x],
                    'year' => $post['year'][$i][$x],
                    'presentaseBudget' => $post['presentase'][$i],
                    'monthBudget' => str_replace(',', '', $post['monthBudget'][$i][$x]),
                    'budgetValue' => str_replace(',', '', $post['budgetValue'][$i][$x]), 
                    'budgetAlocated' => str_replace(',', '', $post['budgetValue'][$i][$x]), 
                    'actualBudgetValue' => str_replace(',', '', $post['budgetValue'][$i][$x]),
                    'actualPurchase' => str_replace(',', '', $post['amountPurchase'][$x]),
                    'presentasePurchase' => $post['purchasePresentase'],
                    'actualAnp' => str_replace(',', '', $post['monthBudget'][$i][$x]),
                    'createdBy' => $this->fungsi->user_login()->user_code,
                ];
                $this->db->insert('t_budgetActivity', $params);
                // var_dump($params);
                // var_dump($this->db->error());
            }
        }
    }

    public function getSummaryBudget($code_brand = null, $yearBudget = null){
        $sql = "SELECT ss.codeAnggaran ,ss.brandCode, ss.budgetYear, SUM(ss.monthBudget) as budgetYearValue, ss.pic, MIN(ss.[month]) as startDatePurchase,MAX(ss.[month]) as endDatePurchase
        FROM
        (SELECT DISTINCT codeAnggaran, brandCode, [budgetYear], [year], [month], monthBudget, createdBy as pic FROM t_budgetActivity)ss
         --WHERE ss.[brandCode] = '101'
        GROUP BY ss.codeAnggaran, [brandCode], budgetYear, pic";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getCodeAnggaran(){
        $sql = "SELECT MAX(SUBSTRING(codeAnggaran,7,4)) AS codeAnggaran
        FROM t_budgetActivity
        WHERE SUBSTRING(codeAnggaran,1,6) = convert(varchar, getdate(), 12)";

        $query = $this->db->query($sql);
        if($query->num_rows() > 0){
            $row = $query->row();
            $n = ((int)$row->codeAnggaran) + 1;
            $no = sprintf("%'.04d", $n); 
        }else{
            $no = "0001";
        }
        $anggaran_no = date('ymd').$no;
        return $anggaran_no;
    }

    public function getAnpActual($code_anggaran){
        $sql = "SELECT ss.actualAnp, [month], monthActual FROM
                (
                SELECT codeAnggaran, brandCode, activity, [month], month([month]) as monthActual, actualAnp 
                FROM t_budgetActivity 
                WHERE codeAnggaran = '$code_anggaran'
                )ss
                GROUP BY ss.actualAnp, [month], ss.monthActual
                ORDER BY ss.[month]";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getPurchaseActual($code_anggaran){
        $sql = "SELECT ss.actualPurchase --ss.actualAnp, [month], monthActual 
                FROM
                (
                SELECT codeAnggaran, brandCode, activity, [month], month([month]) as monthActual, actualAnp, actualPurchase, presentaseBudget, presentasePurchase 
                FROM t_budgetActivity 
                WHERE codeAnggaran = '$code_anggaran'
                )ss
                GROUP BY ss.actualAnp, actualPurchase, [month], ss.monthActual
                ORDER BY ss.[month]";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getSumAnpActual($code_anggaran){
        $sql = "SELECT SUM(tt.actualAnp) as totalAnp FROM
                (
                SELECT ss.actualAnp, [month], monthActual FROM
                (
                SELECT codeAnggaran, brandCode, activity, [month], month([month]) as monthActual, actualAnp 
                FROM t_budgetActivity 
                WHERE codeAnggaran = '$code_anggaran'
                )ss
                GROUP BY ss.actualAnp, [month], ss.monthActual
                --ORDER BY ss.[month]
                )tt";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getSumActualPurchase($code_anggaran){
        $sql = "SELECT SUM(tt.actualPurchase) AS sumActualPurchase FROM
                (
                SELECT ss.actualPurchase --ss.actualAnp, [month], monthActual 
                FROM
                (
                SELECT codeAnggaran, brandCode, activity, [month], month([month]) as monthActual, actualAnp, actualPurchase, presentaseBudget, presentasePurchase 
                FROM t_budgetActivity 
                WHERE codeAnggaran = '$code_anggaran'
                )ss
                GROUP BY ss.actualAnp, actualPurchase, [month], ss.monthActual
                --ORDER BY ss.[month]
                )tt";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getPresentasePurchase($code_anggaran){
        $sql = "SELECT DISTINCT presentasePurchase FROM t_budgetActivity
                WHERE codeAnggaran = '$code_anggaran'";
        $query = $this->db->query($sql);
        return $query;
    }

}