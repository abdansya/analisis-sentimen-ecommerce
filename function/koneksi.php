<?php
    
/**
* 
*/
set_time_limit(0);
class Koneksi {
  public $host = 'localhost';
  public $user = 'root';
  public $pass = '';
  public $db = 'ansen_ecommerce';
  public $con;
  
  public function __construct() {
    $this->con = new mysqli($this->host, $this->user, $this->pass, $this->db);
    if ($this->con) {
      // echo "berhasil koneksi";
    }
  }

  public function __destruct()
  {
  	$this->con->close();
  }
}

?>