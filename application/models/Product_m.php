<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_m extends CI_Model {

    public function get($id = null, $brand_code = null)
    {
        $this->db->select('*,m_item.Sales as Sales, m_item.ItemCode as ItemCode, m_item.id as item_id, m_item.FrgnName as Barcode, m_brand.BrandName as BrandName, t_price.Price as item_price');
        $this->db->from('m_item');
        $this->db->join('m_brand',' m_item.BrandCode =  m_brand.BrandCode','left');
        $this->db->join('t_price','m_item.ItemCode = t_price.itemCode','left');
        if($id != null)
        {
            $this->db->where('m_item.ItemCode',$id);
        }
        if($brand_code != null){
            $this->db->where('m_item.BrandCode', $brand_code);
        }
        $this->db->order_by('m_item.id','desc');
        $query = $this->db->get();
        return $query;
    }

    public function add($data)
    {
        $params = [
            'BrandCode' => $data['code_brand'],
            'FrgnName' => $data['product_bracode'],
            'ItemName' => ucwords($data['product_name']),
            'created' => $this->fungsi->user_login()->id
        ];
        $this->db->insert('m_item',$params);
    }

    public function edit($post)
    {
        $timezone = new DateTimeZone('Asia/Jakarta');
        $date = new DateTime();
        $date->setTimeZone($timezone);
        $params = [
            'BrandCode' => $post['code_brand'],
            'ItemName' => ucwords($post['product_name']),
            'Updated' => $this->fungsi->user_login()->id,
            'UpdatedDate' => $date->format('Y-m-d H:i:s')
        ];
        $this->db->where('id',$post['item_id']);
        $this->db->update('m_item',$params);
    }

    public function del($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('m_item');
    }

    public function refreshItem_m(){
        $sql = "DELETE m_item
                insert into m_item (ItemCode,itemname,FrgnName,BrandCode,Price,created,CreatedDate,updated,updateddate)
                select t0.ItemCode,itemname,FrgnName,ItmsGrpCod,Price,UserSign,CreateDate,UserSign2,updatedate from [pksrv-sap].[pandurasa_live].[dbo].[oitm] t0
                inner join [pksrv-sap].[pandurasa_live].[dbo].ITM1 T1 on t0.ItemCode=t1.ItemCode and t1.PriceList=1
                where FrgnName is not null";
        $query = $this->db->query($sql);
        // var_dump($this->db->error());
        // var_dump($query);
        // die;
        return $query;
    }
    
}