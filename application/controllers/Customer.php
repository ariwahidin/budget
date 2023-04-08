<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {


	function __construct()
	{
		parent::__construct();
		check_not_login();
		// check_admin();
		$this->load->model(['customer_m','group_m']);
	}


	function get_ajax() {

		// var_dump(@$_POST['length']);
		// die;

        $list = $this->customer_m->get_datatables();
        $data = array();
        $no = @$_POST['start'];
        foreach ($list as $item) {
            $no++;
            $row = array();
         	$row[] = $no.".";
            $row[] = $item->GroupName;
            $row[] = $item->CustomerName;
            // add html for action
            $row[] = '<a href="'.site_url('customer/edit/'.$item->CustomerId.'/'.$item->GroupCode).'" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i> Update</a>';
            // $row[] = '<a href="'.site_url('customer/edit/'.$item->CustomerId.'/'.$item->GroupCode).'" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i> Update</a>
            //          <a href="'.site_url('customer/del/'.$item->CustomerId).'" onclick="return confirm(\'Yakin hapus data?\')"  class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete</a>';
            $data[] = $row;
        }

        $output = array(
                    "draw" => @$_POST['draw'],
                    "recordsTotal" => $this->customer_m->count_all(),
                    "recordsFiltered" => $this->customer_m->count_filtered(),
                    "data" => $data,
                );

        // output to json format
        echo json_encode($output);
    }

	public function index()
	{
		$data['row'] = $this->customer_m->get();
		$this->template->load('template','customer/customer_data',$data);
	}

	public function add()
	{
		$group = $this->group_m->get()->result();
		$customer = new stdClass();
		$customer->GroupCode = null;
		$customer->GroupName = null;
		$customer->CustomerId = null;
		$customer->CustomerName = null;
		$code = null;
		$data = array(
			'page' => 'add',
			'row' => $customer,
			'group' =>$group,
			'code' => $code,
		);
		$this->template->load('template','customer/customer_form',$data);
	}

	public function edit($CustomerId, $GroupCodeSelected)
	{
		$group = $this->group_m->get()->result();
		$query = $this->customer_m->get($CustomerId);

		if($query->num_rows() > 0)
		{
			$customer = $query->row();
			$data = array(
				'page' => 'edit',
				'row' => $customer,
				'group' => $group,
				'code' => $GroupCodeSelected,
			);

			// var_dump($data);
			// die;
			$this->template->load('template','customer/customer_form',$data);
		}else
		{
			echo "<script>
				alert('Data tidak ditemukan');
				window.location='".site_url('customer')."';
			</script>";
		}
	}

	public function process()
	{
		$post = $this->input->post(null, TRUE);

		if(isset($_POST['add']))
		{
			$this->customer_m->add($post);
		}
		else if(isset($_POST['edit']))
		{
			$this->customer_m->edit($post);
		}
		
		if($this->db->affected_rows() > 0)
		{
			echo "<script>alert('Data berhasil disimpan');</script>";
		}
		 echo "<script>window.location='".site_url('customer')."';</script>";
	}

	public function del($id)
	{
		$this->customer_m->del($id);
		if($this->db->affected_rows() > 0)
		{
			echo "<script>alert('Data berhasil dihapus');</script>";
		}
		echo "<script>window.location='".site_url('customer')."'</script>";

	}

	function getCustomerName(){
		$code = $_POST['code'];
		$sql = "SELECT CustomerName FROM m_customer WHERE CardCode = '$code'";
		$query = $this->db->query($sql);
		$result = $query->row()->CustomerName;
		echo json_encode($result);
	}
}
