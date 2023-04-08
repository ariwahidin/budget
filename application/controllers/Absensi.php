<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Absensi extends CI_Controller {

	

	public function __construct()
	{
		parent::__construct();
		// check_not_login();
		// check_admin();
		$this->load->model(['budget_m','anggaran_m','employee_m', 'brand_m', 'promotion_m']);
	}

    public function index(){
        $this->template->load('template','absensi/tarik_absensi');
    }

    public function cek_absensi(){
        $start_date = '#'.$_POST['start_date'].'#';
        $end_date = '#'.$_POST['end_date'].'# +1';
        $con=odbc_connect("myConnection","","");
        $query = "SELECT * FROM syslog WHERE timeclock BETWEEN $start_date AND $end_date";
        $query_ex =  odbc_exec($con, $query);
        $data = [
            'data' => $query_ex,
        ];
        $this->template->load('template','absensi/absensi_data', $data);
    }

    public function koneksi(){
        $uid  = "";
        $pwd = "";
        $connectionInfo = array("UID" => $uid, "PWD" => $pwd, "Database"=>"PK-ANP");
        $serverName = "AW\Ari"; //serverName\instanceName
        $conn = sqlsrv_connect( $serverName, $connectionInfo);
        // if( $conn ) {
        //     echo "Connection established.<br />";
        // }else{
        //     echo "Connection could not be established.<br />";
        //     die( print_r( sqlsrv_errors(), true));
        // }
        return $conn;
    }

    public function chek_duplicate($badgenumber, $timeclock){

        $conn = $this->koneksi();
        $sql = "SELECT * FROM t_absensi WHERE badgenumber = '$badgenumber' AND  timeclock = '$timeclock'";
        $query = sqlsrv_query($conn, $sql, array(), array( "Scrollable" => 'static' ));

        if( $query === false ) {
            die( print_r( sqlsrv_errors(), true));
        }

        return(sqlsrv_num_rows($query));
    }

    public function insertAbsent(){

        $conn = $this->koneksi();
        for($i=0 ; $i < count($_POST['badgenumber']); $i++){

            $badgenumber = $_POST['badgenumber'][$i];
            $timeclock = $_POST['timeclock'][$i];
            $isproses = $_POST['isproses'][$i];
            $verifymode = $_POST['verifymode'][$i];
            $inoutmode = $_POST['inoutmode'][$i];
            $workcode = $_POST['workcode'][$i];

            $check = $this->chek_duplicate($badgenumber, $timeclock);
            $sql = "INSERT INTO t_absensi (badgenumber, timeclock, isproses, verifymode, inoutmode, workcode) 
                VALUES ('$badgenumber', '$timeclock', '$isproses', '$verifymode', '$inoutmode', '$workcode')";

            if($check == 0){
                $query = sqlsrv_query($conn, $sql);
                if(sqlsrv_rows_affected($query) > 0){
                    $hasil = 1;
                }
            }else{
                $hasil = 0;
            }

        }

        if($hasil = 1){
            $result = ['success' => true];
        }else{
            $result = ['success' => false];
        }

        echo json_encode($result);
    }
}