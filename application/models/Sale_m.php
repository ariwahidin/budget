<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sale_m extends CI_Model {

    // public function invoice_no()
    // {
    //     // Query MySQL
    //     $sql = "SELECT MAX(MID(invoice,9,4)) AS invoice_no 
    //     FROM t_sale 
    //     WHERE MID(invoice,3,6) = DATE_FORMAT(CURDATE(), '%y%m%d')";

    //     // Query SQL Server
    //     $sql2 = "SELECT MAX(SUBSTRING(invoice,9,4)) AS invoice_no 
    //     FROM t_sale 
    //     WHERE SUBSTRING(invoice,3,6) = convert(varchar, getdate(), 12)";

    //     $query = $this->db->query($sql2);
    //     if($query->num_rows() > 0){
    //         $row = $query->row();
    //         $n = ((int)$row->invoice_no) + 1;
    //         $no = sprintf("%'.04d", $n); 
    //     }else{
    //         $no = "0001";
    //     }
    //     $invoice = "PK".date('ymd').$no;
    //     return $invoice;
    // }

    

    // public function get_cart($params =  null)
    // {
    //     $this->db->select('*, p_item.name as item_name, t_cart.price as cart_price');
    //     $this->db->from('t_cart');
    //     $this->db->join('p_item','t_cart.item_id = p_item.item_id');
    //     if($params != null){
    //         $this->db->where($params);
    //     }
    //     $this->db->where('user_id', $this->session->userdata('user_id'));
    //     $query = $this->db->get();
    //     return $query;
    // }

    public function get_cart($params =  null)
    {
        $this->db->select('*, 
                        master_product.barcode as product_barcode, 
                        master_product.product_name as product_name,  
                        master_brand.abbr as brand_inisial,  
                        t_cart.price as cart_price');
        $this->db->from('t_cart');
        $this->db->join('master_product','t_cart.item_id = master_product.id_product');
        $this->db->join('master_brand','master_product.id_brand = master_brand.sid');
        if($params != null){
            $this->db->where($params);
        }
        $this->db->where('user_id', $this->session->userdata('user_id'));
        $query = $this->db->get();
        return $query;
    }

    public function add_cart($post){

        $params = array(
            'item_id' => $post['product_id'],
            'price' => $post['price'],
            'user_id' => $this->session->userdata('user_id'),
        );

        $this->db->insert('t_cart',$params);
        
        // $query = $this->db->query("SELECT MAX(cart_id) AS cart_no FROM t_cart");
        // if($query->num_rows() > 0){
        //     $row = $query->row();
        //     $cart_no = ((int)$row->cart_no + 1);
        // } else {
        //     $cart_no = "1";
        // }
        
        // foreach($post['isi_product'] as $product){





        //     // $params = array(
        //     //     'item_id' => (int)$product,
        //     // );
        //     // var_dump($product);
            
        //     // $this->db->insert('t_cart',$params);
        // }

        // die;
        
        // $pengkali = (float)$post['qty_estimation'];

        // $params = array(
        //     'cart_id' => $cart_no,
        //     'item_id' => $post['item_id'],
        //     'price' => $post['price'],
        //     'price_after_promo' => $post['price'],
        //     'qty_last_year' => $post['qty_last_year'],
        //     'qty_last_3_month' => $post['qty_last_3_month'],
        //     'multiple_estimation' => $pengkali,
        //     'qty_sales_estimation' => ($pengkali * (float)$post['qty_last_3_month']),
        //     'show_sales_estimation' => ceil(($pengkali * (float)$post['qty_last_3_month'])),
        //     'actual_value_estimation' => ($post['price'] * ($pengkali * (float)$post['qty_last_3_month'])),
        //     'total' => ($post['price']*$post['qty_estimation']),
        //     'user_id' => $this->session->userdata('user_id')
        // );

        // var_dump($post);
        // die;

        // return $query;
        // die;
        // $params = array(
        //     'cart_id' => $cart_no,
        //     'item_id' => $post['product_id'],
        //     'user_id' => $this->session->userdata('user_id'),
        // );

        // var_dump($params);
        // $this->db->insert('t_cart',$params);
        // $err = $this->db->error();
        // var_dump($err);
    }
    

    function update_cart_qty($post){
        $sql = "UPDATE t_cart 
                SET price = '$post[price]',
                    total = '$post[price]'
                WHERE item_id = '$post[item_id]'";
        $this->db->query($sql);
    }

    public function del_cart($params = null)
    {
        if($params != null){
            $this->db->where($params);
        }
        $this->db->delete('t_cart');
    }

    public function edit_cart($post)
    {

        $timezone = new DateTimeZone('Asia/Jakarta');
        $date = new DateTime();
        $date->setTimeZone($timezone);

        $params = array(
            'price' => $post['price'],
            'qty_last_year' => $post['input_qty_last_year'],
            'qty_last_3_month' => $post['input_qty_last_3_month'],
            'multiple_estimation' => $post['input_qty_sales_estimation'],
            'qty_sales_estimation' => ($post['input_qty_last_3_month'] * $post['input_qty_sales_estimation']),
            'show_sales_estimation' => ceil(((float)$post['input_qty_sales_estimation'] * (float)$post['input_qty_last_3_month'])),
            'actual_value_estimation' => (($post['input_qty_last_3_month'] * $post['input_qty_sales_estimation']) * $post['price']),
            'updated' => $date->format('Y-m-d H:i:s')
        );
        $this->db->where('cart_id', $post['cart_id']);
        $this->db->update('t_cart', $params);
    }

    public function edit_promo($post)
    {
        
        $params = array(
            'discount_promo' => $post['discount'],
            'value_discount' => ($post['discount']/100) * $post['price'],
            'total_costing' => (($post['discount']/100) * $post['price']) * $post['sales_target']
        );
        // var_dump($params);
        // var_dump($post['cart_id']);
        $this->db->where('cart_id',$post['cart_id']);
        $this->db->update('t_cart',$params);
    }






    public function add_sale($post){
        $params = array(
            'invoice' => $this->invoice_no(),
            'periode_start' => date ('Y-m-d', strtotime($post['startDate'])),
            'periode_end' => date ('Y-m-d', strtotime($post['endDate'])),
            'total_target' => $post['totalTarget'],
            'total_costing' => $post['totalCosting'],
            'created_by' => $this->session->userdata('user_id'),
            'id_brand' => $post['idBrand'],
            'id_claim' => $post['claim']
        );
        // var_dump($params);
        $this->db->insert('t_sale',$params);
        return $this->db->insert_id();
    }

    // function add_sale_detail($params){
    //     $this->db->insert_batch('t_sale_detail', $params);
    // }















    






    function pilih_outlet($post){
        $params = array(
            'id_outlet' => $post['outlet_id'],
            'user_id' => $this->session->userdata('user_id'),
        );
        $this->db->insert('t_outlet_selected',$params);
    }

    function get_outlet_selected($params = null){
        $this->db->select('master_customer.customer_name as outlet_name,
                            t_outlet_selected.id_outlet as id_outlet');
        $this->db->from('master_customer');
        $this->db->join('t_outlet_selected','master_customer.sid = t_outlet_selected.id_outlet');
        if($params != null){
            $this->db->where($params);
        }
        $query = $this->db->get();

        // var_dump($this->db->error());
        return $query;
    }

    public function del_outlet($params = null)
    {
        if($params != null){
            $this->db->where($params);
        }
        $this->db->delete('t_outlet_selected');
    }





    
    public function get_sale($id = null)
    {
        $this->db->select('*,users.nama as pic, master_brand.name as brand_name, master_claim.claim_to as claim_name');
        $this->db->from('t_sale');
        $this->db->join('users','t_sale.created_by = users.id','left');
        $this->db->join('master_brand','t_sale.id_brand = master_brand.sid');
        $this->db->join('master_claim','t_sale.id_claim = master_claim.id');
        if($id != null){
            $this->db->where('sale_id',$id);
        }
        $this->db->order_by('sale_id','desc');
        $query = $this->db->get();
        return $query;
    }

    public function get_proposal_detail_outlet($doc){
        $this->db->select('*,master_customer.customer_name as outlet_name');
        $this->db->from('t_outlet_end');
        $this->db->join('master_customer','t_outlet_end.id_outlet = master_customer.sid','left');
        $this->db->where('no_doc',$doc);
        $query = $this->db->get();
        return $query;
    }

    public function get_proposal_detail_promo($doc){
        $this->db->select('*,type_promotion.name as promo_name');
        $this->db->from('t_promo_end');
        $this->db->join('type_promotion','t_promo_end.id_promo = type_promotion.sid','left');
        $this->db->where('no_doc',$doc);
        $query = $this->db->get();
        return $query;
    }

    public function get_proposal_detail_item($doc){
        $this->db->select('*,master_product.product_name as product_name, master_product.barcode as product_barcode');
        $this->db->from('t_transaction_detail_end');
        $this->db->join('master_product','t_transaction_detail_end.product_id = master_product.id_product','left');
        $this->db->where('no_doc',$doc);
        $query = $this->db->get();
        return $query;
    }



    public function get_sale_pagination($limit = null, $start = null)
    {
        $post = $this->session->userdata('search');
        $this->db->select('*');
        // $this->db->select('*, 
        // master_customer.customer_name as customer_name,
        // users.nama as user_name,
        // t_sale.created as sale_created');
        $this->db->from('t_sale');
        // $this->db->join('master_customer',
        // 't_sale.customer_id = master_customer.sid',
        // 'left');
        // $this->db->join('users',
        // 't_sale.user_id = users.id');

        // var_dump($post['date1']);
        // var_dump($post['date2']);

        // if(!empty($post['date1']) && !empty($post['date2'])){
        //     $this->db->where("t_sale.date BETWEEN '".$post['date1']."' AND '".$post['date2']."'");
        // }

        // if(!empty($post['customer'])){
        //     if($post['customer'] == "null"){
        //         $this->db->where("t_sale.customer_id IS NULL");
        //     }else{
        //         $this->db->where("t_sale.customer_id", $post['customer']);
        //     }
        // }

        // if(!empty($post['invoice'])){
        //     $this->db->like("invoice", $post['invoice']);
        // }

        $this->db->order_by('sale_id','desc');
        $this->db->limit($limit,$start);
        $query = $this->db->get();
        return $query;
    }

    // public function get_sale_detail($sale_id = null)
    // {
    //     $this->db->from('t_sale_detail');
    //     $this->db->join('p_item',
    //                     't_sale_detail.item_id = p_item.item_id');
    //     if($sale_id != null){
    //         $this->db->where('t_sale_detail.sale_id',$sale_id);
    //     }
    //     $query = $this->db->get();
    //     return $query;
    // }

    public function del_sale($id)
    {
        $this->db->where('sale_id',$id);
        $this->db->delete('t_sale');
    }



    public function get_claim($id = null){
        $this->db->select('*');
        $this->db->from('master_claim');
        $query = $this->db->get();
        return $query;
    }

    public function add_mechanism($post, $no_doc){

        foreach($post as $m){
            $params = array(
                'no_doc' => $no_doc,
                'mechanism' => $m,
                'created_by' => $this->session->userdata('user_id')
            );
            $this->db->insert('t_mechanism_end',$params);
            // var_dump($this->db->error());
        }
    }

    public function get_mechanism($no_doc){
        $this->db->select('*');
        $this->db->from('t_mechanism_end');
        $this->db->where('no_doc',$no_doc);
        $query = $this->db->get();
        return $query;
    }

    public function add_objective($post, $no_doc){

        foreach($post as $o){
            $params = array(
                'no_doc' => $no_doc,
                'objective' => $o,
                'created_by' => $this->session->userdata('user_id')
            );
            $this->db->insert('t_objective_end',$params);
            // var_dump($this->db->error());
        }
    }

    public function add_comment($post, $no_doc){
        $params = array(
            'no_doc' => $no_doc,
            'comment' =>$post['comment']
        );
        $this->db->insert('t_comment_end',$params);
    }

    public function get_comment($no_doc){
        $this->db->select('*');
        $this->db->from('t_comment_end');
        $this->db->where('no_doc', $no_doc);
        $query = $this->db->get();
        return $query;
    }

    public function get_objective($no_doc){
        $this->db->select('*');
        $this->db->from('t_objective_end');
        $this->db->where('no_doc',$no_doc);
        $query = $this->db->get();
        return $query;
    }

}
