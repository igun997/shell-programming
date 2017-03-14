<?php
/*
Creator  : SystemFive
Created  : 14-Maret-2017 10:55
Level	 : Menegah ke Bawah
*/
class BukaDB
{
    private $host;
    private $user;
    private $pass;
    private $db;
    public $mysqli;
    
    public function __construct()
    {
        $this->db_connect();
    }
    
    private function db_connect()
    {
        $this->host = 'localhost';
        $this->user = 'root';
        $this->pass = '';
        $this->db   = 'db_sijadwal';
        
        $this->mysqli = new mysqli($this->host, $this->user, $this->pass, $this->db);
        return $this->mysqli;
    }
    function days($tgl)
    {
        $hari = array("Minggu","Senin","Selasa","Rabu","Kamis","Jum'at","Sabtu");
        return $hari[(int) date("w",strtotime($tgl))];
    }
    function servercheck($server="",$port){
        //Check that the port value is not empty
        if(empty($port)){
            $port=80;
        }
        //Check that the server value is not empty
        if(empty($server)){
            $server='localhost';
        }
        //Connection
        $fp=@fsockopen($server, $port, $errno, $errstr, 1);
            //Check if connection is present
            if($fp){
                //Return Alive
                return 1;
            } else{
                //Return Dead
                return 0;
            }
        //Close Connection
        fclose($fp);
    }
    function flush_tabel ($tabel)
    {
        $tabel = mysqli_escape_string($this->mysqli, $tabel);
         $query = "DELETE FROM " . $tabel;
            $hasil = $this->mysqli->query($query);
            if ($hasil) {
                return json_encode(array(
                    "status" => 1
                ));
            } else {
                return json_encode(array(
                    "status" => 0,
                    "error" => mysqli_error($this->mysqli)
                ));
            }
    }
    function delete_db($tabel, $acuan, $acuan_value)
    {
        $acuan       = mysqli_escape_string($this->mysqli, $acuan);
        $acuan_value = mysqli_escape_string($this->mysqli, $acuan_value);
        if (!empty($acuan) && !empty($acuan_value)) {
            $query = "DELETE FROM " . $tabel . " WHERE " . $acuan . "='" . $acuan_value . "'";
            $hasil = $this->mysqli->query($query);
            if ($hasil) {
                return json_encode(array(
                    "status" => 1
                ));
            } else {
                return json_encode(array(
                    "status" => 0,
                    "error" => mysqli_error($this->mysqli)
                ));
            }
        } else {
            return json_encode(array(
                "status" => 0,
                "error" => "Tidak Ada Nilai "
            ));
        }
    }
    function gabung_db($select, $tabel_select, $join, $value_join, $value_tabel, $acuan="" , $acuan_value="" ,$acuan_dua="",$acuan_dua_value="",$acuan_tiga="",$acuan_tiga_value="")
    {
        
        $total_select = count($select);
        if ($total_select <= 1) {
            $query = "SELECT " . mysqli_escape_string($this->mysqli, $select) . " FROM " . mysqli_escape_string($this->mysqli, $tabel_select) . " JOIN " . mysqli_escape_string($this->mysqli, $join) . " ON " . mysqli_escape_string($this->mysqli, $join) . "." . mysqli_escape_string($this->mysqli, $value_join) . "=" . mysqli_escape_string($this->mysqli, $tabel_select) . "." . mysqli_escape_string($this->mysqli, $value_tabel);
            if ($acuan != null) {
                $query .= " WHERE " . mysqli_escape_string($this->mysqli, $acuan) . " = " . mysqli_escape_string($this->mysqli, $acuan_value);
            }
        } else {
            $query = "SELECT ";
            for ($counter_select = 0; $counter_select <= $total_select - 1; $counter_select++) {
                $query .= mysqli_escape_string($this->mysqli, $select[$counter_select]);
                if ($counter_select != count($select) - 1) {
                    $query .= ",";
                }
            }
            
            $query .= " FROM " . mysqli_escape_string($this->mysqli, $tabel_select) . " JOIN " . mysqli_escape_string($this->mysqli, $join) . " ON " . mysqli_escape_string($this->mysqli, $join) . "." . mysqli_escape_string($this->mysqli, $value_join) . "=" . mysqli_escape_string($this->mysqli, $tabel_select) . "." . mysqli_escape_string($this->mysqli, $value_tabel);
            if ($acuan != null) {
                $query .= " WHERE " . mysqli_escape_string($this->mysqli, $acuan) . " ='" . mysqli_escape_string($this->mysqli, $acuan_value)."'";
                if($acuan_dua != null)
                {
                    $query .= " AND ".mysqli_escape_string($this->mysqli, $acuan_dua)."='".mysqli_escape_string($this->mysqli, $acuan_dua_value)."'"; 
                }
                if($acuan_tiga != null)
                {
                     $query .= " OR ".mysqli_escape_string($this->mysqli, $acuan_tiga)."='".mysqli_escape_string($this->mysqli, $acuan_tiga_value)."'"; 
                }
            }
        }
        $hasil = $this->mysqli->query($query);
        if ($hasil) {
            $data = $hasil->fetch_all(MYSQLI_ASSOC);
            return json_encode($data);
        } else {
            return json_encode(array(
                "status" => 0,
                "error" => mysqli_error($this->mysqli)
            ));
        }
    }
    function gabung_db_tri($select, $tabel_select, $join, $value_join, $value_tabel, $acuan="" , $acuan_value="" ,$acuan_dua="",$acuan_dua_value="",$acuan_tiga="",$acuan_tiga_value="")
    {
        
        $total_select = count($select);
        if ($total_select <= 1) {
            $query = "SELECT " . mysqli_escape_string($this->mysqli, $select) . " FROM " . mysqli_escape_string($this->mysqli, $tabel_select) . " JOIN " . mysqli_escape_string($this->mysqli, $join) . " ON " . mysqli_escape_string($this->mysqli, $join) . "." . mysqli_escape_string($this->mysqli, $value_join) . "=" . mysqli_escape_string($this->mysqli, $tabel_select) . "." . mysqli_escape_string($this->mysqli, $value_tabel);
            if ($acuan != null) {
                $query .= " WHERE " . mysqli_escape_string($this->mysqli, $acuan) . " = " . mysqli_escape_string($this->mysqli, $acuan_value);
            }
        } else {
            $query = "SELECT ";
            for ($counter_select = 0; $counter_select <= $total_select - 1; $counter_select++) {
                $query .= mysqli_escape_string($this->mysqli, $select[$counter_select]);
                if ($counter_select != count($select) - 1) {
                    $query .= ",";
                }
            }
            
            $query .= " FROM " . mysqli_escape_string($this->mysqli, $tabel_select) . " JOIN " . mysqli_escape_string($this->mysqli, $join) . " ON " . mysqli_escape_string($this->mysqli, $join) . "." . mysqli_escape_string($this->mysqli, $value_join) . "=" . mysqli_escape_string($this->mysqli, $tabel_select) . "." . mysqli_escape_string($this->mysqli, $value_tabel);
            if ($acuan != null) {
                $query .= " WHERE " . mysqli_escape_string($this->mysqli, $acuan) . " ='" . mysqli_escape_string($this->mysqli, $acuan_value)."'";
                if($acuan_dua != null)
                {
                    $query .= " AND (".mysqli_escape_string($this->mysqli, $acuan_dua)."='".mysqli_escape_string($this->mysqli, $acuan_dua_value)."'"; 
                }
                if($acuan_tiga != null)
                {
                     $query .= " OR ".mysqli_escape_string($this->mysqli, $acuan_tiga)."='".mysqli_escape_string($this->mysqli, $acuan_tiga_value)."')"; 
                }
            }
        }
        $hasil = $this->mysqli->query($query);
        if ($hasil) {
            $data = $hasil->fetch_all(MYSQLI_ASSOC);
            return json_encode($data);
        } else {
            return json_encode(array(
                "status" => 0,
                "error" => mysqli_error($this->mysqli)
            ));
        }
    }
    function import_database($sql_file_OR_content)
    {
        set_time_limit(3000);
        $SQL_CONTENT = (strlen($sql_file_OR_content) > 300 ?  $sql_file_OR_content : file_get_contents($sql_file_OR_content)  );  
        $allLines = explode("\n",$SQL_CONTENT); 
            $zzzzzz = $this->mysqli->query('SET foreign_key_checks = 0');	        preg_match_all("/\nCREATE TABLE(.*?)\`(.*?)\`/si", "\n". $SQL_CONTENT, $target_tables); foreach ($target_tables[2] as $table){$this->mysqli->query('DROP TABLE IF EXISTS '.$table);}         $zzzzzz = $this->mysqli->query('SET foreign_key_checks = 1');    $this->mysqli->query("SET NAMES 'utf8'");	
        $templine = '';	// Temporary variable, used to store current query
        foreach ($allLines as $line)	{											// Loop through each line
            if (substr($line, 0, 2) != '--' && $line != '') {$templine .= $line; 	// (if it is not a comment..) Add this line to the current segment
                if (substr(trim($line), -1, 1) == ';') {		// If it has a semicolon at the end, it's the end of the query
                    if(!$this->mysqli->query($templine)){ $status = 'Error performing query \'<strong>' . $templine . '\': ' . $this->mysqli->error . '<br /><br />';  }  $templine = ''; // set variable to empty, to start picking up the lines after ";"
                }
            }
        }	
        
        return json_encode(array("status"=>1));
       
    }
    
    function upload_file($target_direktori,$files,$allowed_files,$prefix_name="")
    {
        $sistemApp = new sistemApp;
        $target_dir = $target_direktori;
        $files_base = basename($files["name"]);
        $target_file = $target_dir . $files_base;
        $uploadOk = 1;
        $FileType = pathinfo($target_file,PATHINFO_EXTENSION);
        if(in_array($FileType,$allowed_files))
        {
            if(move_uploaded_file($files["tmp_name"], $target_dir.$prefix_name."_".sha1($files_base).".".$FileType))
            {
                return json_encode(array("status"=>1,"files_name"=>$target_dir.$prefix_name."_".sha1($files_base).".".$FileType));
            }else{
                return json_encode(array("status"=>0,"error"=>"Gagal Upload Files"));
            }
        }else{
            return json_encode(array("status"=>0,"error"=>"File Tidak Di Ijinkan : .".$FileType));
        }
    }
    function export_database($tables=false, $backup_name=false){ 
	set_time_limit(3000); $this->mysqli->query("SET NAMES 'utf8'");
	$queryTables = $this->mysqli->query('SHOW TABLES'); while($row = $queryTables->fetch_row()) { $target_tables[] = $row[0]; }	if($tables !== false) { $target_tables = array_intersect( $target_tables, $tables); } 
	$content = "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\r\nSET time_zone = \"+00:00\";\r\n\r\n\r\n/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;\r\n/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;\r\n/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;\r\n/*!40101 SET NAMES utf8 */;\r\n--\r\n-- Database: `".$name."`\r\n--\r\n\r\n\r\n";
	foreach($target_tables as $table){
		if (empty($table)){ continue; } 
		$result	= $this->mysqli->query('SELECT * FROM `'.$table.'`');  	$fields_amount=$result->field_count;  $rows_num=$mysqli->affected_rows; 	$res = $this->mysqli->query('SHOW CREATE TABLE '.$table);	$TableMLine=$res->fetch_row(); 
		$content .= "\n\n".$TableMLine[1].";\n\n";   $TableMLine[1]=str_ireplace('CREATE TABLE `','CREATE TABLE IF NOT EXISTS `',$TableMLine[1]);
		for ($i = 0, $st_counter = 0; $i < $fields_amount;   $i++, $st_counter=0) {
			while($row = $result->fetch_row())	{ //when started (and every after 100 command cycle):
				if ($st_counter%100 == 0 || $st_counter == 0 )	{$content .= "\nINSERT INTO ".$table." VALUES";}
					$content .= "\n(";    for($j=0; $j<$fields_amount; $j++){ $row[$j] = str_replace("\n","\\n", addslashes($row[$j]) ); if (isset($row[$j])){$content .= '"'.$row[$j].'"' ;}  else{$content .= '""';}	   if ($j<($fields_amount-1)){$content.= ',';}   }        $content .=")";
				//every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
				if ( (($st_counter+1)%100==0 && $st_counter!=0) || $st_counter==$rows_num) {$content .= ";";} else {$content .= ",";}	$st_counter=$st_counter+1;
			}
		} $content .="\n\n\n";
	}
	$content .= "\r\n\r\n/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;\r\n/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;\r\n/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;";
	$backup_name = $backup_name ? $backup_name : $name.'___('.date('H-i-s').'_'.date('d-m-Y').').sql';
	ob_get_clean(); header('Content-Type: application/octet-stream');  header("Content-Transfer-Encoding: Binary");  header('Content-Length: '. (function_exists('mb_strlen') ? mb_strlen($content, '8bit'): strlen($content)) );    header("Content-disposition: attachment; filename=\"".$backup_name."\""); 
	echo $content; exit;
    }   
    function gabung_db_tiga($select, $tabel_utama, $tabel_join_satu, $tabel_join_dua, $value_utama, $value_utama_dua, $value_satu, $value_dua, $acuan = null, $acuan_value = null,$acuan_dua = null,$acuan_value_dua = null)
    {
        $total_select = count($select);
        if ($total_select > 1) {
            $query = "SELECT ";
            for ($counter_select = 0; $counter_select <= $total_select - 1; $counter_select++) {
                $query .= mysqli_escape_string($this->mysqli, $select[$counter_select]);
                if ($counter_select != count($select) - 1) {
                    $query .= ",";
                }
            }
            $query .= " FROM " . mysqli_escape_string($this->mysqli, $tabel_utama) . " JOIN " . mysqli_escape_string($this->mysqli, $tabel_join_satu) . " JOIN " . mysqli_escape_string($this->mysqli, $tabel_join_dua) . " ON " . mysqli_escape_string($this->mysqli, $tabel_utama) . "." . mysqli_escape_string($this->mysqli, $value_utama) . " = " . mysqli_escape_string($this->mysqli, $tabel_join_satu) . "." . mysqli_escape_string($this->mysqli, $value_satu) . " AND " . mysqli_escape_string($this->mysqli, $tabel_utama) . "." . mysqli_escape_string($this->mysqli, $value_utama_dua) . " = " . mysqli_escape_string($this->mysqli, $tabel_join_dua) . "." . mysqli_escape_string($this->mysqli, $value_dua);
        } else {
            $query = "SELECT " . mysqli_escape_string($this->mysqli, $select);
            
            $query .= " FROM " . mysqli_escape_string($this->mysqli, $tabel_utama) . " JOIN " . mysqli_escape_string($this->mysqli, $tabel_join_satu) . " JOIN " . mysqli_escape_string($this->mysqli, $tabel_join_dua) . " ON " . mysqli_escape_string($this->mysqli, $tabel_utama) . "." . mysqli_escape_string($this->mysqli, $value_utama) . " = " . mysqli_escape_string($this->mysqli, $tabel_join_satu) . "." . mysqli_escape_string($this->mysqli, $value_satu) . " AND " . mysqli_escape_string($this->mysqli, $tabel_utama) . "." . mysqli_escape_string($this->mysqli, $value_utama_dua) . " = " . mysqli_escape_string($this->mysqli, $tabel_join_dua) . "." . mysqli_escape_string($this->mysqli, $value_dua);
        }
        if ($acuan != null) {
            $query .= " WHERE " . mysqli_escape_string($this->mysqli, $acuan) . " = " . mysqli_escape_string($this->mysqli, $acuan_value);
            if($acuan_dua != null)
            {
                $query .= " AND ".mysqli_escape_string($this->mysqli, $acuan_value)."=".mysqli_escape_string($this->mysqli, $acuan_value_dua); 
            }
        }
        $hasil = $this->mysqli->query($query);
        if ($hasil) {
            $data = $hasil->fetch_all(MYSQLI_ASSOC);
            return json_encode($data);
        } else {
            return json_encode(array(
                "status" => 0,
                "error" => mysqli_error($this->mysqli)
            ));
        }
    }
   
    function hitung_data($tabel, $acuan = null, $acuan_value = null,$acuan_dua = null,$acuan_dua_value = null)
    {
        $acuan       = mysqli_escape_string($this->mysqli, $acuan);
        $acuan_value = mysqli_escape_string($this->mysqli, $acuan_value);
        if (empty($acuan)) {
            $query = "SELECT COUNT(*) as total FROM `" . $tabel . "`";
        } else {
            $query = "SELECT COUNT(*) as total FROM `" . $tabel . "`";
            $query .= " WHERE " . $acuan . "='" . $acuan_value . "'";
            if(!empty($acuan_dua))
            {
                $query .= " AND ".mysqli_escape_string($this->mysqli,$acuan_dua)."='".mysqli_escape_string($this->mysqli,$acuan_dua_value)."'";
            }
        }
        
        $hasil = $this->mysqli->query($query);
        if ($hasil) {
            $hasil_num = $hasil->fetch_assoc();
            return json_encode(array(
                "total" => $hasil_num["total"]
            ));
        } else {
            return json_encode(array(
                "total" => "Error = " . $hasil . " " . mysqli_error($this->mysqli)
            ));
        }
    }
    function single_select($table, $max_col)
    {
        $query = "SELECT max(".mysqli_escape_string($this->mysqli,$max_col).")  as maksimal FROM ".mysqli_escape_string($this->mysqli,$table);
        $hasil = $this->mysqli->query($query);
        if ($hasil) {
            $data = $hasil->fetch_all(MYSQLI_ASSOC);
            return json_encode($data);
        } else {
            return json_encode(array(
                "status" => 0,
                "error" => mysqli_error($this->mysqli)
            ));
        }
    }
    function update_db($tabel, $kolom, $kolom_value, $acuan = "", $acuan_value = "")
    {
        $total_kolom       = count($kolom);
        $total_kolom_value = count($kolom_value);
        $acuan             = mysqli_escape_string($this->mysqli, $acuan);
        $acuan_value       = mysqli_escape_string($this->mysqli, $acuan_value);
        if ($total_kolom > 1) {
            if ($total_kolom == $total_kolom_value) {
                $query = "UPDATE " . $tabel . " SET ";
                for ($counter_kolom = 0; $counter_kolom <= $total_kolom - 1; $counter_kolom++) {
                    $query .= mysqli_escape_string($this->mysqli, htmlspecialchars($kolom[$counter_kolom])) . "='" . mysqli_escape_string($this->mysqli,htmlspecialchars($kolom_value[$counter_kolom])) . "'";
                    if ($counter_kolom != count($kolom) - 1) {
                        $query .= ",";
                    }
                }
                $query .= " WHERE " . $acuan . " ='" . $acuan_value . "'";
                
            } else {
                return json_encode(array(
                    "status" => 0
                ));
            }
        } else {
            $query = "UPDATE " . $tabel . " SET " . $kolom . "='" . htmlentities($kolom_value) . "'" . " WHERE " . $acuan . "='" . $acuan_value . "'";
        }
        $hasil = $this->mysqli->query($query);
        if ($hasil) {
            return json_encode(array(
                "status" => 1
            ));
        } else {
            return json_encode(array(
                "status" => 0,
                "error" => mysqli_error($this->mysqli)
            ));
        }
        
        
    }
    function select_db($tabel, $kolom, $acuan = "", $acuan_value = "")
    {
        $total_kolom = count($kolom);
        $acuan       = mysqli_escape_string($this->mysqli, $acuan);
        $acuan_value = mysqli_escape_string($this->mysqli, $acuan_value);
        if (!empty($acuan)) {
            $query = "SELECT ";
            for ($counter_kolom = 0; $counter_kolom <= $total_kolom - 1; $counter_kolom++) {
                $query .= mysqli_escape_string($this->mysqli, $kolom[$counter_kolom]);
                ;
                if ($counter_kolom != count($kolom) - 1) {
                    $query .= ",";
                }
            }
            $query .= " FROM " . $tabel . " WHERE ";
            $query .= $acuan . "='" . $acuan_value . "'";
        } else {
            $query = "SELECT ";
            for ($counter_kolom = 0; $counter_kolom <= $total_kolom - 1; $counter_kolom++) {
                $query .= mysqli_escape_string($this->mysqli, $kolom[$counter_kolom]);
                ;
                if ($counter_kolom != count($kolom) - 1) {
                    $query .= ",";
                }
            }
            $query .= " FROM " . $tabel;
        }
        $hasil = $this->mysqli->query($query);
        if ($hasil) {
            $data = $hasil->fetch_all(MYSQLI_ASSOC);
            return json_encode($data);
        } else {
            return json_encode(array(
                "status" => 0,
                "error" => mysqli_error($this->mysqli),
                "query" => mysqli_real_escape_string($this->mysqli, $query)
            ));
        }
        
    }
    function insert_db($tabel, $kolom, $value)
    {
        $total_kolom = count($kolom);
        $total_value = count($value);
        if ($total_kolom == $total_value) {
            $query = "INSERT INTO " . $tabel;
            $query .= " (";
            for ($counter_kolom = 0; $counter_kolom <= $total_kolom - 1; $counter_kolom++) {
                $query .= mysqli_escape_string($this->mysqli, htmlspecialchars($kolom[$counter_kolom]));
                ;
                if ($counter_kolom != count($kolom) - 1) {
                    $query .= ",";
                }
            }
            $query .= ")";
            if ($total_value != 1) {
                $query .= " VALUES (";
            } else {
                $query .= " VALUE (";
            }
            for ($counter_value = 0; $counter_value <= $total_value - 1; $counter_value++) {
                
                $query .= "'" . mysqli_escape_string($this->mysqli, htmlspecialchars($value[$counter_value])) . "'";
                if ($counter_value != count($value) - 1) {
                    $query .= ",";
                }
            }
            $query .= ")";
            $hasil = $this->mysqli->query($query);
            if ($hasil) {
                return json_encode(array(
                    "status" => 1
                ));
            } else {
                return json_encode(array(
                    "status" => 0,
                    "error" => mysqli_error($this->mysqli)
                ));
            }
        } else {
            return json_encode(array(
                "status" => 404,
                "error" => "Table And Value Not Same !"
            ));
        }
        
        
    }
    function custom_query($string)
    {
        $hasil = $this->mysqli->query($string);
        if ($hasil) {
            $data = $hasil->fetch_all(MYSQLI_ASSOC);
            return json_encode($data);
        } else {
            return json_encode(array(
                "status" => 0,
                "error" => mysqli_error($this->mysqli),
                "query" => $string
            ));
        }
    }
    function sql_escape($string)
    {
        return mysqli_escape_string($this->mysqli, $string);
    }
}

$db = new BukaDB;
$list = $db->custom_query("SELECT list_days.hari,matkul.* FROM matkul JOIN list_days ON list_days.id_days = matkul.days_id JOIN users ON users.id_users = matkul.users_id WHERE users.id_users=1 AND list_days.hari = '".$db->days(date("d-m-Y"))."' ORDER BY matkul.days_id");
$list = json_decode($list);
$no = 1;
foreach($list as $obj_list)
{
    printf("%d. %s (%s) %s-%s\n",$no++,htmlspecialchars_decode($obj_list->nama),$obj_list->ruang_matkul,$obj_list->waktu_mulai,$obj_list->waktu_selesai);

}
?>