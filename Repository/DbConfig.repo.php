<?php

/**
 * DbConfig.php Database Class base model for other models
 * 
 * PHP Version 7.4.4
 * 
 * @category  PHP_WebApplication_Software
 * @package   SideHustle Todo App
 * @author    SolveStation <hello@solvestation.com>
 * @copyright 2021 SolveStation Technologies
 * @license   SSLIC: https://solvestation.com
 * @link      https://solvestation.com
 */

abstract class DbConfig
{
    const SYSTEM_TIMEZONE           = 'Africa/Lagos';

    protected $dbHost       = "localhost";
    protected $dbUser       = "root";
    protected $dbPass       = "html5001#";
    protected $dbName       = "todo";
    protected $dbCharset    = "utf8mb4";
    protected $dbHandler, $dbStmt;

    /**
     * Creates or resume an existing database connection...
     * 
     * @return null|void
     */
    public function __construct()
    {
        $dsn = "mysql:host=" . $this->dbHost . ';dbname=' . $this->dbName;

        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        try {
            $this->dbHandler = new PDO($dsn, $this->dbUser, $this->dbPass, $options);
        } catch (Exception $e) {
            var_dump(
                'Couldn\'t Establish A Database Connection. 
				Due to the following reason: ' . $e->getMessage()
            );
        }
    }

    /**
     * Creates a PDO statement object
     * 
     * @param string $query to query the db statement
     * 
     * @return null|void
     */
    public function query($query)
    {
        $this->dbStmt = $this->dbHandler->prepare($query);
    }

    /**
     * Matches the correct datatype to the PDO Statement Object
     * 
     * @param $param $value $type parameter, value and type
     * 
     * @return null|void
     */
    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {

            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
                    break;
            }
        }

        $this->dbStmt->bindValue($param, $value, $type);
    }

    /**
     * Executes a PDO Statement Object or a db query...
     * 
     * @return bool
     */
    public function execute()
    {
        $this->dbStmt->execute();
        return true;
    }

    /**
     * Executes a PDO Statement Object an returns a single database record 
     * as an associative array...
     * 
     * @return null|void
     */
    public function fetch()
    {
        $this->execute();
        return $this->dbStmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Executes a PDO Statement Object an returns multiple database record 
     * as an associative array...
     * 
     * @return null|void
     */
    public function fetchAll()
    {
        $this->execute();
        return $this->dbStmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Fetch Column record count from database record
     * 
     * @return null|void
     */
    public function fetchColumn()
    {
        $this->execute();
        return $this->dbStmt->fetchColumn();
    }
}
