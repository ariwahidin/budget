<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Finance_model extends CI_Model
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

    public function getProposalApproved($number = null)
    {
        $sql = "select t1.id, t1.Number, t3.BrandName, t1.StartDatePeriode, 
        t1.EndDatePeriode, t2.promo_name as ActivityName, 
        t1.Status,t1.CreatedBy, t1.CreatedDate, t4.TotalCosting, t6.GroupName,
        (select count(id) from tb_proposal_skp where ProposalNumber = t1.Number and NoSKP != '') as jml_skp
        from tb_proposal t1
        inner join m_promo t2 on t1.Activity = t2.id 
        inner join m_brand t3 on t1.BrandCode = t3.BrandCode
        inner join tb_operating_proposal t4 on t1.Number = t4.ProposalNumber
        inner join tb_proposal_group t5 on t1.Number = t5.ProposalNumber 
        inner join m_group t6 on t6.GroupCode = t5.GroupCustomer 
        where [Status] = 'approved'";
        if (!is_null($number)) {
            $sql .= " and t1.Number = '$number'";
        }
        $sql .= " order by t1.CreatedDate desc";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getItemProposal($number)
    {
        $sql = "select t1.id, t1.ProposalNumber,t2.ItemCode, t2.FrgnName, t2.ItemName,
        t1.Price, t1.Qty, t1.Target, t1.PromoValue, t1.Costing
        from tb_proposal_item t1
        inner join m_item t2 on t1.ItemCode = t2.ItemCode
        where t1.ProposalNumber = '$number'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getObjectiveProposal($number)
    {
        $sql = "select * from tb_proposal_objective where ProposalNumber = '$number'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getMechanismProposal($number)
    {
        $sql = "select * from tb_proposal_mechanism where ProposalNumber = '$number'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getCommentProposal($number)
    {
        $sql = "select * from tb_proposal_comment where ProposalNumber = '$number'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getCostingOther($number)
    {
        $sql = "select * from tb_proposal_item_other where ProposalNumber = '$number'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getProposalGroup($number)
    {
        $sql = "select distinct t1.ProposalNumber, t2.GroupCode, t2.GroupName
        from tb_proposal_group t1
        inner join m_group t2 on t1.GroupCustomer = t2.GroupCode
        where ProposalNumber = '$number'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getProposalSKP($number)
    {
        /*
        $sql = "select distinct t3.id, t1.ProposalNumber, t2.GroupCode, t2.GroupName, t3.NoSKP, t3.Ket, t3.Valueskp
        from tb_proposal_group t1
        inner join m_group t2 on t1.GroupCustomer = t2.GroupCode
        left join tb_proposal_skp t3 on t1.ProposalNumber = t3.ProposalNumber and t2.GroupCode = t3.GroupCode
        where t1.ProposalNumber = '$number'";
        $query = $this->db->query($sql);
        return $query;
        */

        $sql = "select distinct t5.id, t1.ProposalNumber, t1.GroupCustomer as GroupCode, 
        t2.GroupName, 
        --t1.CustomerCode, t3.CustomerName, 
        t4.SubGroupCode, 
        t4.SubGroupName,
        t5.NoSKP, t5.Ket
        from tb_proposal_customer t1
        inner join m_group t2 on t1.GroupCustomer = t2.GroupCode
        inner join m_customer t3 on t1.CustomerCode = t3.CardCode
        inner join m_customer_anp t4 on t3.CardCode = t4.CardCode
        left join tb_proposal_skp t5 on t1.ProposalNumber = t5.ProposalNumber and t4.SubGroupCode = t5.SubGroupCode
        where t1.ProposalNumber = '$number'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getCustomerProposal($number)
    {
        $sql = "select t1.id, t1.ProposalNumber, t1.CustomerCode, t2.CustomerName
        from tb_proposal_customer t1
        inner join m_customer t2 on t1.CustomerCode = t2.CardCode
        where ProposalNumber = '$number'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function insert_skp($array)
    {
        $params = array();
        $i = 0;
        foreach ($array['group'] as $key => $value) {

            //simpan gambar 
            $fileName = $array['number'] . $array['sub_group'][$i] . ".jpg";
            if ($array['img'][$i] != "") {
                $gambarKompres = $array['img'][$i];
                $gambarKompres = str_replace('data:image/jpeg;base64,', '', $gambarKompres);
                $gambarKompres = str_replace(' ', '+', $gambarKompres);
                $decodedData = base64_decode($gambarKompres);
                $fileDestination = 'uploads/img/skp/' . $fileName;
                file_put_contents($fileDestination, $decodedData);
            } else {
                $fileName = "noimage.jpg";
            }

            //params inputan
            array_push($params, array(
                'ProposalNumber' => $array['number'],
                'GroupCode' => $value,
                'SubGroupCode' => $array['sub_group'][$i],
                'NoSKP' => $array['skp'][$i],
                'Valueskp' => angkrupiah($array['valuskp'][$i]),
                'Ket' => $array['ket'][$i],
                'Img' => $fileName,
                'CreatedBy' => $this->session->userdata('user_code'),
                'CreatedAt' => $this->getDate(),
            ));
            $i++;
        }

        $this->db->insert_batch('tb_proposal_skp', $params);
    }

    public function update_skp($array)
    {
        $i = 0;
        foreach ($array['id'] as $key => $value) {

            //hapus gambar lalu insert gambar baru
            $fileName = $array['number'] . $array['sub_group'][$i] . ".jpg";
            $gambarPath = FCPATH . 'uploads/img/skp/' . $fileName;
            if (file_exists($gambarPath) && $array['img'][$i] != "") {
                if (unlink($gambarPath)) {
                    if ($array['img'][$i] != "") {
                        $gambarKompres = $array['img'][$i];
                        $gambarKompres = str_replace('data:image/jpeg;base64,', '', $gambarKompres);
                        $gambarKompres = str_replace(' ', '+', $gambarKompres);
                        $decodedData = base64_decode($gambarKompres);
                        $fileDestination = 'uploads/img/skp/' . $fileName;
                        file_put_contents($fileDestination, $decodedData);
                    }
                }
            } else {
                if ($array['img'][$i] != "") {
                    $gambarKompres = $array['img'][$i];
                    $gambarKompres = str_replace('data:image/jpeg;base64,', '', $gambarKompres);
                    $gambarKompres = str_replace(' ', '+', $gambarKompres);
                    $decodedData = base64_decode($gambarKompres);
                    $fileDestination = 'uploads/img/skp/' . $fileName;
                    file_put_contents($fileDestination, $decodedData);
                }
            }


            $data = array(
                'NoSKP' => $array['skp'][$i],
                'Ket' => $array['ket'][$i],
                'GroupCode' => $array['group'][$i],
                'SubGroupCode' => $array['sub_group'][$i],
                'Valueskp' => angkrupiah($array['valuskp'][$i]),
                'Img' => $fileName,
                'UpdatedBy' => $this->session->userdata('user_code'),
                'UpdatedAt' => $this->getDate(),
            );

            $this->db->where('id', $value);
            $this->db->update('tb_proposal_skp', $data);
            $i++;
        }
    }

    public function getSKP($number)
    {
        $sql = "select id from tb_proposal_skp where ProposalNumber = '$number'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getTotalCostingByNumberProposal($number)
    {
        $sql = "select
        (select case when sum(Costing) is null then 0 else sum(Costing) end from tb_proposal_item where ProposalNumber = '$number')
        +
        (select case when sum(Costing) is null then 0 else sum(Costing) end from tb_proposal_item_other where ProposalNumber = '$number')
        as TotalCosting";
        $query = $this->db->query($sql);
        return $query->row()->TotalCosting;
    }

    public function getDataSkp()
    {
        $sql = "select distinct t1.id, t1.ProposalNumber, t1.GroupCode, 
        t1.SubGroupCode, t1.NoSKP, t1.Ket, 
        t2.GroupName as GroupCustomer, 
        --t3.CardCode, t3.CardName as CustomerName, 
        t4.GroupCode, t4.GroupName as ServiceBy
        from [dbo].[tb_proposal_skp] t1
        left join m_group_anp t2 on t1.SubGroupCode = t2.GroupId
        left join m_customer_anp t3 on t1.SubGroupCode = t3.SubGroupCode
        left join m_group t4 on t1.GroupCode = t4.GroupCode
        where t1.NoSKP != ''";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getCustomerBySkp($skp){
        $sql = "select distinct 
        t1.id, t1.ProposalNumber,
        t2.GroupName as GroupCustomer, 
        t5.CardCode, t5.CardName, 
        t4.GroupCode, t4.GroupName as ServiceBy
        from [dbo].[tb_proposal_skp] t1
        left join m_group_anp t2 on t1.SubGroupCode = t2.GroupId
        left join tb_proposal_customer t3 on t1.ProposalNumber = t3.ProposalNumber
        left join m_group t4 on t1.GroupCode = t4.GroupCode
        left join m_customer_anp t5 on t1.SubGroupCode = t5.SubGroupCode 
        where t1.NoSKP = '$skp'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getBrandProposal(){
        $sql = "select distinct t1.BrandCode, t2.BrandName from tb_proposal t1
        inner join m_brand t2 on t1.BrandCode = t2.BrandCode";
        $query = $this->db->query($sql);
        return $query;
    }
}
