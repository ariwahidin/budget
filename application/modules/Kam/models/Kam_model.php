<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kam_model extends CI_Model
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
        t1.EndDatePeriode, t2.promo_name as ActivityName, t1.Status,t1.CreatedBy, t1.CreatedDate
        from tb_proposal t1
        inner join m_promo t2 on t1.Activity = t2.id 
        inner join m_brand t3 on t1.BrandCode = t3.BrandCode
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
        $sql = "select distinct t1.ProposalNumber, t2.GroupCode, t2.GroupName, t3.NoSKP, t3.Ket
        from tb_proposal_group t1
        inner join m_group t2 on t1.GroupCustomer = t2.GroupCode
        left join tb_proposal_skp t3 on t1.ProposalNumber = t3.ProposalNumber and t2.GroupCode = t3.GroupCode
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
            array_push($params, array(
                'ProposalNumber' => $array['number'],
                'GroupCode' => $value,
                'NoSKP' => $array['skp'][$i],
                'Ket' => $array['ket'][$i],
                'CreatedBy' => $this->session->userdata('user_code'),
                'CreatedAt' => $this->getDate(),
            ));
            $i++;
        }

        $this->db->insert_batch('tb_proposal_skp', $params);
    }

    public function update_skp($array)
    {
        var_dump($array);
    }

    public function getSKP($number)
    {
        $sql = "select id from tb_proposal_skp where ProposalNumber = '$number'";
        $query = $this->db->query($sql);
        return $query;
    }
}
