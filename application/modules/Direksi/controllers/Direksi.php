<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Direksi extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        check_login();
        $this->load->model(['direksi_model']);
        
    }

    public function render($view, array $data = NULL)
    {
        $this->load->view('header');
        $this->load->view($view, $data);
        $this->load->view('footer');
    }

    public function index()
    {
        $anp = $this->direksi_model->anpdir1();
        $resumeAnp = $this->direksi_model->getResumeAnp();
        // var_dump($resumeAnp->result());
        $data = array(
            'anp' => $anp,
            'resumeAnp' => $resumeAnp
        );

        // var_dump($this->session->userdata());
        $this->load->view('direksi_v', $data);
    }

    public function cekdir(){
        $kode_brand = $_POST['code'];
        $costkot = $this->direksi_model->costkot($kode_brand);
        $data['costkot'] = $costkot;
        $data['hmaster']  = $this->direksi_model->anpdir1($kode_brand);
        $data['filteract']  = $this->direksi_model->filteract($kode_brand);
        $data['filterkota']  = $this->direksi_model->filterkota($kode_brand);
        $data['brand'] =  $this->direksi_model->getBrand($kode_brand)->row();
        $data['operating'] = $this->direksi_model->getBudgetOperatingbybrand($kode_brand);
        $data['header']  = $this->direksi_model->getHeaderOperatingbybrand($kode_brand);
        $data['proposal']  = $this->direksi_model->getProposalbybrand($kode_brand);

        
        // var_dump($this->session->userdata());
        $this->load->view('cekdir', $data);
    }


    public function propd(){
        $kode_brand = $_POST['code'];
        $actx = $_POST['actx'];
        $data['proposal']  = $this->direksi_model->getProposalbybrand($kode_brand,$actx);
        $this->load->view('propd', $data);
    }

    public function downloadExcel()
    {
        $anp = $this->direksi_model->getAnpForManagement();
        $data = array(
            'anp' => $anp,
        );
        $this->load->view('report/report_excel', $data);
    }

    public function showActivity()
    {
        $activity = $this->direksi_model->getActivity();
        $data = array(
            'activity' => $activity,
        );
        $this->load->view('activity/activity_v', $data);
    }

    public function showBrand()
    {
        $brand = $this->direksi_model->getBrand();
        $data = array(
            'brand' => $brand,
        );
        $this->load->view('brand/brand_v', $data);
    }

    public function showGroup()
    {
        $group = $this->direksi_model->getGroup();
        $data = array(
            'group' => $group,
        );
        $this->load->view('group/group_v', $data);
    }

    public function showItem()
    {
        $item = $this->direksi_model->getItem();
        $data = array(
            'item' => $item,
        );
        $this->load->view('item/item_v', $data);
    }

    public function showBudget()
    {
        $budget = $this->direksi_model->getBudget();
        $data = array(
            'budget' => $budget,
        );
        $this->load->view('budget/budget_v', $data);
    }

    public function showCustomer()
    {
        $customer = $this->direksi_model->getCustomer();
        $data = array(
            'customer' => $customer,
        );
        $this->load->view('customer/customer_v', $data);
    }

    public function showPurchase()
    {
        $purchase = $this->direksi_model->getPurchase();
        $data = array(
            'purchase' => $purchase,
        );
        $this->load->view('purchase/purchase_v', $data);
    }

    public function showOperating()
    {
        $operating = $this->direksi_model->getOperating();
        $data = array(
            'operating' => $operating,
        );
        $this->load->view('operating/operating_v', $data);
    }

    public function createProposal()
    {
        $brand = $this->direksi_model->getBrandFromBudgetSetted();
        $activity = $this->direksi_model->getActivityFromBudgetSetted();
        $group = $this->direksi_model->getGroup();
        $data = array(
            'brand' => $brand,
            'activity' => $activity,
            'group' => $group,
        );
        $this->load->view('proposal/create_proposal_v', $data);
    }

    public function checkData()
    {
        $post = $_POST;
        $params = array();
        $budget_code = $this->direksi_model->getBudgetCode($post);

        if ($budget_code->num_rows() < 1) {
            $params['budget_code'] = false;
            echo json_encode($params);
            return false;
        }

        $budget_code = $budget_code->row()->BudgetCodeActivity;
        $end_date = $post['end_date'];
        $operating_budget = $this->direksi_model->getYTDOperatingBudget($budget_code, $end_date);
        $params['operating'] = $operating_budget;
        $params['success'] = true;
        $params['budget_code'] = $budget_code;
        echo json_encode($params);
    }

    public function createProposal2()
    {
        $budget_code_activity = $_POST['budget_code'];
        $activity_code = $_POST['activity'];
        $budget_code = preg_match_all('#([^/]*)#', $budget_code_activity, $matches);
        $budget_code = $matches[0][0] . '/' . $matches[0][2];
        $operating = $this->direksi_model->getOperatingActivity($budget_code, $activity_code);
        $YTD_purchase_activity = get_ytd_purchase($operating->row()->BrandCode, $operating->row()->StartPeriode) * ($operating->row()->Precentage / 100);
        $BudgetAllocated = $this->direksi_model->getBudgetAllocatedActivity($budget_code_activity);
        $data = [
            'number' => $this->direksi_model->getNumber(),
            'Allocated_budget' => $BudgetAllocated,
            'YTD_purchase_activity' => $YTD_purchase_activity,
        ];
        $this->load->view('proposal/create_proposal2_v', $data);
    }

    public function showModalItem()
    {
        $brand = $_POST['brand'];
        $item = $this->direksi_model->getItem($brand);
        $data = array(
            'item' => $item,
        );
        $this->load->view('proposal/modal_item', $data);
    }

    public function showModalCustomer()
    {
        $group = $_POST['group'];
        $customer = $this->direksi_model->getCustomer($group);
        $data = array(
            'customer' => $customer,
        );
        $this->load->view('proposal/modal_customer', $data);
    }

    public function simpanProposal()
    {
        // var_dump($_POST);
        // die;
        $this->direksi_model->insertProposal($_POST);
        if ($this->db->affected_rows() > 0) {
            $params = array(
                'success' => true
            );
        } else {
            $params = array(
                'success' => false
            );
        }
        echo json_encode($params);
    }

    public function showProposal()
    {
        $proposal = $this->direksi_model->getProposal();
        $data = array(
            'proposal' => $proposal,
        );
        $this->load->view('proposal/data_proposal_v', $data);
    }

    public function showProposalApproved($status)
    {
        $proposal = $this->direksi_model->getProposalApproved($status);
        $data = array(
            'proposal' => $proposal,
        );
        $this->load->view('proposal/data_proposal_v', $data);
    }

    public function showProposalDetail($number)
    {
        $BudgetCodeActivity = $this->db->query("SELECT BudgetCodeActivity FROM tb_operating_proposal WHERE ProposalNumber = '$number'")->row()->BudgetCodeActivity;
        $budget_source = $this->db->query("SELECT Budget_type FROM tb_operating_proposal WHERE ProposalNumber = '$number'")->row()->Budget_type;
        $budget_saldo = $this->db->query("SELECT Budget_saldo FROM tb_operating_proposal WHERE ProposalNumber = '$number'")->row()->Budget_saldo;
        $proposal = $this->direksi_model->getProposal($params['number'] = $number);
        $proposalItem = $this->direksi_model->getProposalItem($number);
        $proposalCustomer = $this->direksi_model->getProposalCustomer($number);
        $unbooked = $this->db->query("SELECT SUM(Budget_unbooked) AS TotalUnbooked FROM tb_operating_proposal WHERE BudgetCodeActivity = '$BudgetCodeActivity'")->row()->TotalUnbooked;
        $operatingProposal = $this->direksi_model->getOperatingProposal($number);
        $approvedBy = $this->direksi_model->getApprovedBy($number);
        $costingOther = $this->direksi_model->getCostingOther($number);
        $itemGroup = $this->direksi_model->getProposalItemGroupDetail($number);
        $data = array(
            'proposal' => $proposal,
            'proposalItem' => $proposalItem,
            'proposalCustomer' => $proposalCustomer,
            'operatingProposal' => $operatingProposal,
            'budget_source' => $budget_source,
            'budget_saldo' => $budget_saldo,
            'unbooked' => $unbooked,
            'approvedBy' => $approvedBy,
            'costingOther' => $costingOther,
            'itemGroup' => $itemGroup,
        );
        $this->load->view('proposal/data_proposal_detail_v', $data);
    }

    public function deleteProposal($number)
    {
        $this->direksi_model->deleteProposal($number);
        if ($this->db->affected_rows() > 0) {
            redirect(base_url($_SESSION['page']) . '/showProposal');
        } else {
            echo "Gagal hapus";
        }
    }

    public function sendEmailToKamProposalApproved()
    {


        $mail = new PHPMailer(true);

        // Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                       // Enable verbose debug output
        $mail->isSMTP();                                                // Send using SMTP
        $mail->Host       = 'mail.pandurasa.com ';                      // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                       // Enable SMTP authentication
        $mail->Username   = 'anp@pandurasa.com';                        // SMTP username
        $mail->Password   = '^kp0oV.!x,jm';                             // SMTP password
        // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;          // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                        // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        // Recipients
        // Add a recipient
        // $mail->addAddress('data.analis2@pandurasa.com');             // Add a recipient
        // $mail->addReplyTo('anp@pandurasa.com');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');
        // Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');                // Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');           // Optional name
        // Content
        // $mail->isHTML(true);                                         // Set email format to HTML

        $recipients = [
            'ari@pandurasa.com' => 'Ari Wahidin',
        ];

        $mail->Subject = 'ANP | Proposal Promotion';
        $no_proposal = 'PK01520230069';
        $page = encrypt('kam/detailProposal/' . $no_proposal);

        foreach ($recipients as $email => $name) {
            $mail->setFrom('anp@pandurasa.com', 'ANP Pandurasa');
            $mail->addAddress($email);
            $data = array(
                'penerima' => $name,
                'no_proposal' => $no_proposal,
                'page' => $page
            );

            $mail->msgHTML($this->load->view('email/body_email_to_kam', $data, true));
            if ($mail->send()) {
                echo 'Konfirmasi pembayaran telah berhasil';
            } else {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

            // Hapus penerima saat ini agar penerima berikutnya dapat ditambahkan
            $mail->clearAddresses();
        }
    }

    public function rejectProposal($number)
    {
        $this->direksi_model->rejectProposal($_POST);
        if ($this->db->affected_rows() > 0) {
            $params = array(
                'success' => true
            );
            echo json_encode($params);
        } else {
            $params = array(
                'success' => false
            );
            echo json_encode($params);
        }
    }

    public function approveProposal($number)
    {
        $this->direksi_model->approveProposal($_POST);
        if ($this->db->affected_rows() > 0) {
            $params = array(
                'success' => true
            );
            echo json_encode($params);
        } else {
            $params = array(
                'success' => false
            );
            echo json_encode($params);
        }
    }

    public function cancelProposal($number)
    {
        $this->direksi_model->cancelProposal($_POST);
        if ($this->db->affected_rows() > 0) {
            $params = array(
                'success' => true
            );
            echo json_encode($params);
        } else {
            $params = array(
                'success' => false
            );
            echo json_encode($params);
        }
    }

    public function createOperating()
    {
        $brand = $this->direksi_model->getBrand();
        $activity = $this->direksi_model->getActivity();
        $data = array(
            'brand' => $brand,
            'activity' => $activity,
        );
        $this->load->view('operating/create_operating_v', $data);
    }

    public function createOperating2()
    {
        $brand = $_POST['brand'];
        $start_month = date('Y-m-d', strtotime($_POST['start_month']));
        $end_month = date('Y-m-d', strtotime($_POST['end_month']));
        $begin = new DateTime($start_month);
        $end = new DateTime($end_month);
        $end = $end->modify('+1 month');
        $interval = new DateInterval('P1M');
        $daterange = new DatePeriod($begin, $interval, $end);
        $periode = array();

        $check = $this->direksi_model->checkOperatingAlreadyExist($brand, $start_month, $end_month);

        foreach ($daterange as $date) {
            array_push($periode, $date->format("Y-m-d"));
        }

        // awal validasi
        if ($check->num_rows() > 0) {
            echo "<script>
                alert('Data sudah ada');
            </script>";
            $this->createOperating();
            return false;
        } else if (count($periode) != 12) {
            echo "<script>
                alert('Periode harus 12 bulan');
            </script>";
            $this->createOperating();
            return false;
        }
        // akhir validasi 


        $data = array(
            'brand' => $_POST['brand'],
            'start_month' => $start_month,
            'end_month' => $end_month,
            'periode' => $periode,
        );
        $this->load->view('operating/create_operating2_v', $data);
    }

    public function simpanOperating()
    {
        // var_dump($_POST);
        // die;
        $this->direksi_model->simpanOperating($_POST);
        if ($this->db->affected_rows() > 0) {
            $params = array(
                'success' => true
            );
        } else {
            $params = array(
                'success' => false
            );
        }
        echo json_encode($params);
    }

    public function lihatOperatingActivity($brand, $number)
    {
        $budget_code = $brand . '/' . $number;
        $operating_activity = $this->direksi_model->getOperatingActivity($budget_code);
        $data = array(
            'brand' => $brand,
            'budget_code' => $budget_code,
            'operating_activity' => $operating_activity,
        );
        $this->load->view('operating/operating_activity_v', $data);
    }

    public function lihatOperatingActivityDetail($brand, $number, $activity)
    {
        $budget_code = $brand . '/' . $number . '/' . $activity;
        $operating_activity = $this->direksi_model->getOperatingActivityDetail($budget_code);
        $data = array(
            'operating_activity_detail' => $operating_activity,
        );
        $this->load->view('operating/operating_activity_detail_v', $data);
    }

    public function setOperatingActivity($brand, $number)
    {
        $budget_code = $brand . '/' . $number;
        $operating = $this->direksi_model->getOperating($budget_code);
        $activity = $this->direksi_model->getActivity();
        $data = array(
            'brand' => $brand,
            'operating' => $operating,
            'activity' => $activity,
            'budget_code' => $budget_code,
        );
        $this->load->view('operating/set_operating_activity_v', $data);
    }

    public function showFormActivity()
    {
        // var_dump($_POST);
        $budget_code = $_POST['budget_code'];
        $activity_code = $_POST['activity'];
        $operating = $this->direksi_model->getOperating($budget_code);
        $data = array(
            'budget_code' => $budget_code,
            'operating' => $operating,
            'activity' => $activity_code,
        );
        $this->load->view('operating/add_activity', $data);
    }

    public function simpanOperatingActivity()
    {
        $this->direksi_model->simpanOperatingActivity($_POST);
        if ($this->db->affected_rows() > 0) {
            $params = array('success' => true);
        } else {
            $params = array('success' => false);
        }
        echo json_encode($params);
    }

    public function checkAlreadyOperating()
    {
        var_dump($_POST);
    }

    public function showBudgetOperatingPurchase()
    {
        $operating_purchase = $this->direksi_model->getOperatingPurchase();
        $data = array(
            'operating_purchase' => $operating_purchase,
        );
        $this->load->view('operating/operating_purchase_v', $data);
    }

    public function showDetailBudget($brand, $no_urut)
    {
        $budget_code = $brand . '/' . $no_urut;
        $budget_detail = $this->direksi_model->get_detail_budget($budget_code);
        $budget_detail_header = $this->direksi_model->getHeaderOperating($budget_code);
        $activity = $this->direksi_model->getActivityFromTbOperatingActivity($budget_code);
        $ims = $this->direksi_model->getActualIMS($brand, $budget_code);
        $is_ims = $ims->row()->ims == 'Y' ? 'Yes' : 'No';
        $ims_percent = $ims->row()->ims == 'Y' ? round($ims->row()->ims_percent * 100) : 0;
        $ims_value = $ims->row()->ims == 'Y' ? round($ims->row()->ims_value) : 0;
        $data = array(
            'budget_detail' => $budget_detail,
            'brand_code' => $brand,
            'budget_code' => $budget_code,
            'budget_detail_header' => $budget_detail_header,
            'activity' => $activity,
            'is_ims' => $is_ims,
            'ims_percent' => $ims_percent,
            'ims_value' => $ims_value,
        );
        $this->load->view('operating/detail_budget_v', $data);
    }

    public function reportDetail()
    {
        $proposal = $this->direksi_model->getProposalView();
        $data = array(
            'proposal' => $proposal,
        );
        $this->load->view('report/report_proposal', $data);
    }

    public function loadDetailBudget()
    {
        $budgetCode = $this->input->post('budget_code');
        $operating = $this->direksi_model->getBudgetOperating($budgetCode);
        $budget_detail_header = $this->direksi_model->getHeaderOperating($budgetCode);
        $data = array(
            'budget_code' => $budgetCode,
            'operating' => $operating,
            'budget_detail_header' => $budget_detail_header,
        );

        $this->render('operating/detail_budget', $data);
    }

    
    public function loadTableProposal()
    {

        if (isset($_POST['brand'])) {
            if (count($_POST['brand']) > 0) {
                $params['brand'] = implode(",", $_POST['brand']);
            }
        }

        if (isset($_POST['activity'])) {
            if (count($_POST['activity']) > 0) {
                $params['activity'] = implode(",", $_POST['activity']);
            }
        }

        if (isset($_POST['status'])) {
            if (count($_POST['status']) > 0) {
                $params['status'] = implode(",", $_POST['status']);
            }
        }

        $proposal = $this->direksi_model->getProposalx($params);
        $data = array(
            'proposal' => $proposal,
        );

        $this->load->view('proposal/table_proposal', $data);
    }


    public function loadplan(){
        $plan_list_brand = $this->direksi_model->plan_list_brand();
        $plan_list_year = $this->direksi_model->plan_list_year();
        $plan_list_periode = $this->direksi_model->plan_list_periode();
        
        $var_brand = $_POST['var_brand'] ?? null;
        $var_year = $_POST['var_year'] ?? null;
        $var_periode = $_POST['var_periode'] ?? null;
        if ($var_brand){
            $tahun_list = $this->direksi_model->plan_list_year($var_brand);
            if ($var_year){
                $tahun_list = $this->direksi_model->plan_list_periode($var_brand,$var_year);
            }    
            
        }


        $data = array(
            'plan_list_brand' => $plan_list_brand,
            'plan_list_year' => $plan_list_year,
            'plan_list_periode' => $plan_list_periode,

            'var_brand' => $var_brand,
            'var_year' => $var_year,
            'var_periode' => $var_periode,
            
            'brand' => $this->direksi_model->getBrandProposalByPic(),
            'activity' => $this->direksi_model->getActivity()
        );

        if ($var_brand){
            
            $data['costkot'] = $this->direksi_model->costkot($var_brand);
            $data['hmaster']  = $this->direksi_model->anpdir1($var_brand);
            $data['filteract']  = $this->direksi_model->filteract($var_brand);
            $data['filterkota']  = $this->direksi_model->filterkota($var_brand);
            $data['brand'] =  $this->direksi_model->getBrand($var_brand)->row();
            $data['operating'] = $this->direksi_model->getBudgetOperatingbybrand($var_brand,$var_year,$var_periode);
            $data['header']  = $this->direksi_model->getHeaderOperatingbybrand($var_brand,$var_year,$var_periode);
            $data['proposal']  = $this->direksi_model->getProposalbybrand($var_brand);
            return $this->load->view('proposal/loadtableplan', $data);
        }

        
        $this->render('operating/loadplan', $data);
    }

    public function loadTableFund()
    {
        $budget_code = $this->input->post('budget_code');
        $budget = $this->direksi_model->getIncomingFund($budget_code);
        $data = array(
            'budget' => $budget
        );
        $this->load->view('operating/table_fund', $data);
    }

    public function simpanFund()
    {
        $post = $this->input->post();
        $this->direksi_model->simpanFund($post);
        if ($this->db->affected_rows() > 0) {
            $response = array('success' => true);
        } else {
            $response = array('success' => false);
        }
        echo json_encode($response);
    }

    public function loadTableOnTop()
    {
        $budget_code = $this->input->post('budget_code');
        $budget = $this->direksi_model->getBudgetOnTop($budget_code);
        $data = array(
            'budget_code' => $budget_code,
            'budget' => $budget
        );
        $this->load->view('operating/table_budget_ontop', $data);
    }

    public function loadTableOnTopResume()
    {
        // var_dump($_POST);
        $budget_code = $this->input->post('budget_code');
        $total_on_top = $this->direksi_model->totalOnTop($budget_code);
        $totalCostingOnTop = $this->direksi_model->totalCostingOnTop($budget_code);
        $balanceOnTop = $total_on_top - $totalCostingOnTop;
        $data = array(
            'totalOnTop' => $total_on_top,
            'totalCostingOnTop' => $totalCostingOnTop,
            'balanceOnTop' => $balanceOnTop
        );
        $this->load->view('operating/table_budget_ontop_resume', $data);
    }

    public function loadCreateOnTop()
    {
        $budget_code = $this->input->post('budget_code');
        $data = array(
            'month' => $this->direksi_model->functionGetMonthBudget($budget_code),
            'budget_code' => $budget_code,
        );
        $this->load->view('operating/modal_create_budget_ontop', $data);
    }

    public function loadModalEditOnTop()
    {
        $id = $this->input->post('id');
        $budget = $this->direksi_model->getBudgetOnTopById($id);
        // var_dump($budget->result());
        $data = array(
            'budget' => $budget
        );
        $this->load->view('operating/modal_edit_budget_ontop', $data);
    }

    public function editOnTop()
    {
        $post = $this->input->post();
        $this->direksi_model->editOnTop($post);
        if ($this->db->affected_rows() > 0) {
            $response = array('success' => true);
        } else {
            $response = array('success' => false);
        }
        echo json_encode($response);
    }

    public function createBudgetOnTop()
    {
        $post = $this->input->post();
        $create = $this->direksi_model->createBudgetOnTop($post);
        if ($this->db->affected_rows() > 0) {
            $response = array(
                'success' => true
            );
        } else {
            $response = array(
                'success' => false
            );
        }
        echo json_encode($response);
    }

    public function exportResumeProposalToExcel()
    {
        $post = $this->input->post();
        $proposal = $this->direksi_model->getTarikanProposalExcel($post);
        $data = array(
            'proposal' => $proposal
        );
        $this->load->view('report/proposal_excel', $data);
    }

    public function changePasswordPage()
    {
        $data = array();
        $this->render('settings/changePasswordPage', $data);
    }

    public function changePassword()
    {
        $post = $this->input->post();
        $this->direksi_model->changePassword($post);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Password berhasil diubah');
        } else {
            $this->session->set_flashdata('error', 'Gagal ubah password');
        }
        redirect(base_url($_SESSION['page'] . '/changePasswordPage'));
    }
}
