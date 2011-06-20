<?php
/**
 * Провайдер данных для Lms_DataToolkit
 * 
 *
 * @copyright 2006-2010 LanMediaService, Ltd.
 * @license    http://www.lms.by/license/1_0.txt
 * @author Ilya Spesivtsev
 * @version $Id: update.php 162 2009-11-17 10:55:13Z macondos $
 * @package Lms_DataToolkit
 */

/** 
 * @package Lms_DataToolkit
 */
class Lms_DataToolkit_Provider
{
    private static $handlers = array();
    
    public static function setHandler($dbAlias, $table, $event, $callback)
    {
        self::$handlers[$dbAlias][$table][$event] = $callback;
    }
    
    public function select($dbAlias, $table, $fields, $conditions, $orderBy, $direction, $pagesize, $offset)
    {
        $db = Lms_Db::get($dbAlias);
        $whereStatement = '';
        if (is_array($conditions)) {
            $sqlBuilder = new Lms_SqlBuilder();
            $sqlBuilder->setSafeMode(false);
            //$sqlBuilder->allow(array('ident'));
            $whereStatement = "WHERE " . $sqlBuilder->parse($conditions);
        }
        $total = null;
        $records = $db->selectPage(
            $total,
            "SELECT ?# FROM ?_$table $whereStatement {ORDER BY ?# $direction} {LIMIT ?d, ?d}",
            array_values($fields),
            $orderBy? $orderBy : DBSIMPLE_SKIP,
            $offset, 
            $pagesize? $pagesize : DBSIMPLE_SKIP
        );

        $result = array('total' => $total,
                        'records' => $records);
        return $result;
    }

    function getRecord($dbAlias, $table, $fields, $key)
    {
        $db = Lms_Db::get($dbAlias);
        $whereStatement = $this->_buildInWhereByKeys($key, $db);
        $result = $db->selectRow(
            "SELECT ?# FROM ?_$table WHERE $whereStatement ",
            array_values($fields)
        );
        return $result;
    }

    public function update($dbAlias, $table, $data)
    {
        $db = Lms_Db::get($dbAlias);
        $affected = 0;
        foreach ($data as $update){
            $values = $update['values'];
            $conditions = $update['conditions'];
            $sqlBuilder = new Lms_SqlBuilder();
            $sqlBuilder->setSafeMode(false);
            $whereStatement = "WHERE " . $sqlBuilder->parse($conditions);
            $affected += $db->query(
                "UPDATE ?_$table SET ?a $whereStatement LIMIT 1",
                $values
            );
        }
        return $affected;
    }

    function insert($dbAlias, $table, $data)
    {
        $db = Lms_Db::get($dbAlias);
        $inserted = array();
        foreach ($data as $recordNumber => $value) {
            $lastId = $db->query(
                "INSERT INTO ?_$table SET ?a",
                $value
            );
            if (isset(self::$handlers[$dbAlias][$table]['afterInsert'])) {
                call_user_func(self::$handlers[$dbAlias][$table]['afterInsert'], $this, $lastId, $value);
            }
            $inserted[$recordNumber] = $lastId;
        }
        return $inserted;
    }

    function delete($dbAlias, $table, $conditions)
    {
        $db = Lms_Db::get($dbAlias);
        $sqlBuilder = new Lms_SqlBuilder();
        $sqlBuilder->setSafeMode(false);
        $whereStatement = $sqlBuilder->parse($conditions);
        $affected = $db->query("DELETE FROM ?_$table WHERE $whereStatement");
        return $affected;
    }

    function _buildInWhereByKeys($keys, $db)
    {
        $conditions = array();
        foreach($keys as $keyField => $keyValue){
            $conditions[] = $db->escape($keyField, true) . "=" . $db->escape($keyValue, false);
        }
        return implode(" AND ", $conditions);
    }
}