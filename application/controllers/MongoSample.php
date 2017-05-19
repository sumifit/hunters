<?php

include_once $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."application".DIRECTORY_SEPARATOR."config".DIRECTORY_SEPARATOR."bootstrap.php";
include_once DIST_PHP."PHPMailerAutoload.php";


/**
 * Created by PhpStorm.
 * User: dev
 * Date: 17/04/2017
 * Time: 20:03
 */
class MongoSample
{
    private $conString;
    private $db = "huntersdb";

    public function __construct()
    {
        if(DEBUG) $this->setConString("mongodb://localhost:27017/huntersdb?authSource=huntersdb&connectTimeoutMS=1000");
        else $this->setConString("mongodb://hunters_usr:hunters%402017@104.154.101.161:27017/huntersdb?authSource=huntersdb&connectTimeoutMS=3000");
    }

    /**
     * @return string
     */
    public function getDb()
    {
        return $this->db;
    }

    /**
     * @param string $db
     */
    public function setDb($db)
    {
        $this->db = $db;
    }

    /**
     * @return string
     */
    public function getConString()
    {
        return $this->conString;
    }

    /**
     * @param string $conString
     */
    public function setConString($conString)
    {
        $this->conString = $conString;
    }

    public function getNamespace($collection)
    {
        return $this->getDb() . "." . $collection;
    }

    public function push($collection, $document, $multi = false, $upsert = false)
    {
        $manager = new \MongoDB\Driver\Manager($this->getConString());
        $insRec = new MongoDB\Driver\BulkWrite;

        $insRec->update(['_id' => new MongoDB\BSON\ObjectID($_SESSION['_id'])], ['$push' => $document], ['multi' => $multi, 'upsert' => $upsert]);

        $result = $manager->executeBulkWrite($this->getNamespace($collection), $insRec);

        return (boolean)$result->getModifiedCount();
    }

    public function insert($collection, $data)
    {
        $manager = new \MongoDB\Driver\Manager($this->getConString());
        $insRec = new MongoDB\Driver\BulkWrite;

        $insRec->insert($data);

        $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);

        $result = $manager->executeBulkWrite($this->getNamespace($collection), $insRec, $writeConcern);

        return (boolean)$result->getInsertedCount();
    }

    public function pull($collection, $document, $multi = false, $upsert = false)
    {
        $manager = new \MongoDB\Driver\Manager($this->getConString());
        $insRec = new MongoDB\Driver\BulkWrite;

        $insRec->update(['_id' => new MongoDB\BSON\ObjectID($_SESSION['_id'])], ['$pull' => ["{$collection}" => $document]], ['multi' => false, 'upsert' => false]);

        $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);

        $result = $manager->executeBulkWrite($this->getNamespace($collection), $insRec, $writeConcern);

        echo json_encode(['success' => $result->getModifiedCount()]);

    }
    public function getMongo($collection, $filter = [], $options = [])
    {
        $manager = new \MongoDB\Driver\Manager($this->getConString());

        $query = new MongoDB\Driver\Query($filter, $options);

        $cursor = $manager->executeQuery($this->getNamespace($collection), $query);

        foreach ($cursor as $row) {
            return true;
        }
        return false;
    }

    public function get($collection, $filter = [], $options = [])
    {
        $result = [];
        $manager = new \MongoDB\Driver\Manager($this->getConString());

        $query = new MongoDB\Driver\Query($filter, $options);

        $cursor = $manager->executeQuery($this->getNamespace($collection), $query);

        foreach ($cursor as $row) {
            array_push($result, $row);
        }
        return $result;
    }

    public function update($collection, $filter, $alter, $multi = false, $upsert = false)
    {
        $manager = new \MongoDB\Driver\Manager($this->getConString());
        $insRec = new MongoDB\Driver\BulkWrite;

        $insRec->update($filter, ['$set' => $alter], ['multi' => $multi, 'upsert' => $upsert]);

        $result = $manager->executeBulkWrite($this->getNamespace($collection), $insRec);

        return (boolean)$result->getModifiedCount();
    }
}