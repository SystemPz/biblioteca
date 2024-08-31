<?php
/**
 * Class Database
 */
/*header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');*/
//header("Content-type: application/json; charset=utf-8");
class DataBase
{
    protected $_host = "127.0.0.1";
    protected $_user = "develop";
    protected $_pass = "codex";
    protected $_data = "scbets";
    public $db;
    /**
     * Conexion function
     */
    public function __construct() {
        try {
            $this->db = new PDO("mysql:host=" . $this->_host . ";dbname=" . $this->_data, $this->_user, $this->_pass);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->exec("set names utf8");
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getConexion()
    {
        try {
            return $this->db;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Select function
     *
     * @param [type] $tbl
     * @param [type] $columns
     * @param string $where
     * @return void
     */
    public function setSelect($tbl, $columns, $where = '')
    {
        try {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $this->db->prepare("SELECT {$columns} FROM {$tbl}");
            if ($where != '') {
                $stmt = $this->db->prepare("SELECT {$columns} FROM {$tbl} WHERE {$where}");
            }
            $stmt->execute([$columns]);            
            return $stmt;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Fetch Array function
     *
     * @param [type] $consult
     * @return void
     */
    public function setFetchArray($consult)
    {
        try {
            // decodifica arreglos y objetos
            //$stmt = $consult->fetch(PDO::FETCH_LAZY);
            //$stmt = $consult->fetchAll(PDO::FETCH_ASSOC);
            $stmt = $consult->fetchAll(PDO::FETCH_OBJ);
            return $stmt;
        } catch (PDOException $e) {
            return 0;
        }
    }

    /**
     * Num Rows function
     *
     * @param [type] $consult
     * @return void
     */
    public function setNumRows($consult)
    {
        try {
            $stmt = $consult->rowCount();
            return $stmt;
        } catch (PDOException $e) {
            return 0;
        }
    }

    public function setCoutRows($consult)
    {
        try {
            return count($consult);
        } catch (PDOException $e) {
            return 0;
        }
    }

    /**
     * Insert function
     *
     * @param [type] $tbl
     * @param [type] $clmns
     * @param [type] $values
     * @return void
     */
    public function setInsert($tbl, $clmns, $values)
    {
        try {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $num = $this->db->exec("INSERT INTO {$tbl} ($clmns) VALUES ({$values})");
            return $num;
        } catch(PDOException $e){
            return false;
        }
    }

    /**
     * Update function
     *
     * @param [type] $tbl
     * @param [type] $clmn
     * @param string $where
     * @return void
     */
    public function setUpdate($tbl, $clmn, $where = '')
    {
        try {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if ($where != '') {
              $num = $this->db->exec("UPDATE {$tbl} SET {$clmn} WHERE {$where}");
            }
            return $num;
        } catch(PDOException $e){
            return false;
        }
    }

    /**
     * Delete function
     *
     * @param [type] $tbl
     * @param string $where
     * @return void
     */
    public function setDelete($tbl, $where = '')
    {
        try {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if ($where != '') {
              $num = $this->db->exec("DELETE FROM {$tbl} WHERE {$where}");
            }
            return $num;
        } catch(PDOException $e){
            return false;
        }
    }   

    /**
     * Free Consult function
     *
     * @param [type] $resx
     * @return void
     */
    public function setFree($resx)
    {
        $resx->closeCursor();
    }

    /**
     * Close DataBase function
     *
     * @return void
     */
    public function getClose()
    {
        unset($this->db);
    }

}

/*$con = new DataBase();
if ($con->getConexion()) {
    echo 'true';
}
$res = $con->setSelect("comunidades", "*");
$lis = $con->setFetchArray($res);
echo "<".count($lis).">";
foreach($lis as $i){
    print'---'.($i->comCodigo);
}
print_r($i->comCodigo)
// $lis['comCodigo'];
//print_r(json_encode($lis));*/
?>