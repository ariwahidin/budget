<?php 


Class Fungsi {

    protected $ci;

    public function __construct(){
        $this->ci =& get_instance();
    }

    function user_login(){
        $this->ci->load->model('user_m');
        $user_code = $this->ci->session->userdata('user_code');
        $user_data = $this->ci->user_m->get($user_code)->row();
        return $user_data;
    }

    function PdfGenerator($html, $filename, $paper, $orientation){

        $dompdf = new Dompdf\Dompdf();
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper($paper,$orientation);

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream($filename, array('Attachment' => 0));

    }

    public function count_item(){
        $this->ci->load->model('product_m');
        return $this->ci->product_m->get()->num_rows();
    }

    // public function count_proposal(){
    //     $this->ci->load->model('laporan_m');
    //     return $this->ci->laporan_m->getTransaksi()->num_rows();
    // }

    public function count_customer(){
        $this->ci->load->model('customer_m');
        return $this->ci->customer_m->get()->num_rows();
    }

    public function count_user(){
        $this->ci->load->model('user_m');
        return $this->ci->user_m->get()->num_rows();
    }

    
}