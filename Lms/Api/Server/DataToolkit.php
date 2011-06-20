<?php
/**
 * API-функции работы с Lms_DataToolkit
 * 
 * @copyright 2006-2010 LanMediaService, Ltd.
 * @license    http://www.lms.by/license/1_0.txt
 * @author Ilya Spesivtsev
 * @version $Id: update.php 162 2009-11-17 10:55:13Z macondos $
 * @package Api
 */

/** 
 * @package Api
 */
class Lms_Api_Server_DataToolkit extends Lms_Api_Server_Abstract
{
    function select($params)
    {
        if (Lms_User::getUser()->isAllowed($params["table"], 'select')) {
            $dbProvider = new Lms_DataToolkit_Provider();
            $result = $dbProvider->select(
                $params["dbalias"],
                $params["table"],
                $params["fields"],
                isset($params["conditions"])? $params["conditions"] : null,
                isset($params["order_by"])? $params["order_by"] : null,
                isset($params["direction"])? (($params["direction"]==='-1') ? 'DESC' : (($params["direction"]==='1') ? 'ASC' : '')) : '',
                isset($params["page_size"]) ? (int)($params["page_size"]) : 20,
                isset($params["offset"]) ? (int)($params["offset"]) : 0
            );
            return new Lms_Api_Response(200, 'OK', $result);
        } else {
            return new Lms_Api_Response(403, 'Forbidden');
        }
    }

    function getRecord($params)
    {
        if (Lms_User::getUser()->isAllowed($params["table"], 'select')) {
            $dbProvider = new Lms_DataToolkit_Provider();
            $result = $dbProvider->getRecord(
                $params["dbalias"],
                $params["table"],
                $params["fields"],
                $params["key"]
            );
            return new Lms_Api_Response(200, 'OK', $result);
        } else {
            return new Lms_Api_Response(403, 'Forbidden');
        }
    }

    function update($params)
    {
        if (Lms_User::getUser()->isAllowed($params["table"], 'update')) {
            $dbProvider = new Lms_DataToolkit_Provider();

            $result = $dbProvider->update(
                $params["dbalias"],
                $params["table"],
                $params["data"]
            );
            return new Lms_Api_Response(200, 'OK', $result);
        } else {
            return new Lms_Api_Response(403, 'Forbidden');
        }
    }

    function insert($params)
    {
        if (Lms_User::getUser()->isAllowed($params["table"], 'insert')) {
            $dbProvider = new Lms_DataToolkit_Provider();

            $result = $dbProvider->insert(
                $params["dbalias"],
                $params["table"],
                $params["data"]
            );
            return new Lms_Api_Response(200, 'OK', $result);
        } else {
            return new Lms_Api_Response(403, 'Forbidden');
        }
    }

    function delete($params)
    {
        if (Lms_User::getUser()->isAllowed($params["table"], 'delete')) {
            $dbProvider = new Lms_DataToolkit_Provider();
            $result = $dbProvider->delete(
                $params["dbalias"],
                $params["table"],
                $params["conditions"]
            );
            return new Lms_Api_Response(200, 'OK', $result);
        } else {
            return new Lms_Api_Response(403, 'Forbidden');
        }
    }
}