<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart_m extends CI_Model {

    public function addCartTransaction($post){
        $CI =& get_instance();
        $CI->load->model('product_m');

        // var_dump($post);
        // die;

        for($i = 0; $i < count($post['item_id']) ; $i++){
            // $price = $CI->product_m->get($item_id)->row()->item_price;
            $check = $this->getCartTransaction($post['item_id'][$i])->num_rows();
            if($check == 0 ){
                $params = [
                    'item_id' => $post['item_id'][$i],
                    'item_price' => $post['price'][$i],
                    'item_avg_sales_qty' => (int)$post['sales'][$i],
                    'created_by' => $this->fungsi->user_login()->id,
                ];
                // var_dump($params);
                $query = $this->db->insert('t_transaction_cart',$params);
            }
        }
    }

    public function getCartTransaction($item_id = null){
        $id_user = $this->fungsi->user_login()->id;
        $sql = "SELECT *,m_item.ItemName as item_name, t_transaction_cart.id as cart_id
                FROM t_transaction_cart
                INNER JOIN m_item ON t_transaction_cart.item_id = m_item.ItemCode
                WHERE t_transaction_cart.created_by = $id_user";
        if($item_id != null){
            $sql .= " AND t_transaction_cart.item_id = '$item_id' ";
        }
        $query = $this->db->query($sql);
        return $query;
    }

    public function getSumTotalTarget(){
        $id_user = $this->fungsi->user_login()->id;
        $query = $this->db->query("SELECT SUM(item_target_total) as sum_total_target FROM t_transaction_cart WHERE created_by = $id_user ");
        $result = $query->result_array();
        $result = number_format($result[0]['sum_total_target']);
        // var_dump($result);
        return $result;
	}

    public function getSumTotalCosting(){
        $id_user = $this->fungsi->user_login()->id;
        $query = $this->db->query("SELECT SUM(item_costing_total) as sum_total_costing FROM t_transaction_cart WHERE created_by = $id_user ");
        $result = $query->result_array();
        $result = number_format($result[0]['sum_total_costing']);
        return $result;
	}

    public function delCart($post){
        $cart_id = $post['cart_id'];
        $this->db->where('t_transaction_cart.id', $cart_id);
        $this->db->delete('t_transaction_cart');
    }

    public function edit_cart($post){
        $cart_id = $post['cart_id'];
        
        $timezone = new DateTimeZone('Asia/Jakarta');
        $date = new DateTime();
        $date->setTimeZone($timezone);

        $params = [
            'item_price' => (float)$post['item_price'],
            'item_avg_sales_qty' => (float) $post['item_sales'],
            'item_target_multiple' => (float)$post['multiple_target'],
            'item_target_qty' =>((float)$post['item_sales']*(float)$post['multiple_target']),
            'item_target_qty_display' =>ceil(((float)$post['item_sales']*(float)$post['multiple_target'])),
            'item_target_total' => (((float)$post['item_sales']*(float)$post['multiple_target'])*(float)$post['item_price']),
            'item_costing_discount' => (float)$post['item_promo'],
            'item_costing_value' => ((float)$post['item_promo']/100)*(float)$post['item_price'],
            'item_costing_total' => ((float)$post['item_sales']*(float)$post['multiple_target'])*(((float)$post['item_promo']/100)*(float)$post['item_price']),
            'updated_by'=>$this->fungsi->user_login()->id,
            'updated_date' => $date->format('Y-m-d H:i:s')
        ];

        $this->db->where('id',$cart_id);
        $this->db->update('t_transaction_cart',$params);
    }

    public function UpdateCartWhenMultipleChanged($multiple){
        $timezone = new DateTimeZone('Asia/Jakarta');
        $date = new DateTime();
        $date->setTimeZone($timezone);
        $cart = $this->getCartTransaction();
        $multiple = (float)$multiple;
        $user_id = $this->fungsi->user_login()->id;
        $date = $date->format('Y-m-d H:i:s');

        $sql=   "UPDATE t_transaction_cart
                SET item_target_multiple = $multiple,
                    item_target_qty = item_avg_sales_qty * $multiple,
                    item_target_qty_display = CEILING(item_avg_sales_qty * $multiple),
                    item_target_total = item_price * (item_avg_sales_qty * $multiple),
                    item_costing_value = (item_costing_discount/100) * item_price,
                    item_costing_total = ((item_costing_discount/100) * item_price) * (item_avg_sales_qty * $multiple),
                    updated_date = '$date'
                WHERE created_by = $user_id";
        $query = $this->db->query($sql);
        return $query;
    }
}