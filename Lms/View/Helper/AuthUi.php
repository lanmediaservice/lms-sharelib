<?php
/**
 * View-хелпер для добавления авторизации в пользовательский интерфейс
 * 
 *
 * @copyright 2006-2010 LanMediaService, Ltd.
 * @license    http://www.lms.by/license/1_0.txt
 * @author Ilya Spesivtsev
 * @version $Id: AuthUi.php 291 2009-12-28 12:55:20Z macondos $
 * @category   Lms
 * @package    Zend_View
 * @subpackage Helper
 */
 
/**
 * @category   Lms
 * @package    Zend_View
 * @subpackage Helper
 */
class Lms_View_Helper_AuthUi extends Zend_View_Helper_Abstract
{
    public function authUi()
    {
        return $this;
    }

    public function prepareLayout()
    {
        $headScript = $this->view->headScript();
        $headScript->appendFile($this->view->findPath('js/LMS/Auth/UI.js'));
        $headScript->appendFile($this->view->findPath('js/LMS/Auth/Action.js'));
        $script = <<<JS
    LMS.Action.addMethods(LMS.Auth.Action);
    LMS.UI.addMethods(LMS.Auth.UI);
    LMS.Connector.connect(action, 'hideAuthErrors', ui, 'hideAuthErrors');
    LMS.Connector.connect(action, 'authError', ui, 'showAuthErrors');
    LMS.Connector.connect(action, 'authSuccessful', ui, 'showAuthSuccessful');
    //LMS.Connector.connect(action, 'exit', ui, '...');
JS;
        $headScript->appendScript($script);

        $this->view->headLink()->appendStylesheet(
            $this->view->findPath('css/auth.css')
        );

        $this->view->layout()->authControl = $this->view->render(
            'auth/control.phtml'
        );

        if (!$this->view->auth->hasIdentity()) {
            $this->view->layout()->authForm = $this->view->render(
                'auth/form.phtml'
            );
        } else {
            $this->view->layout()->authForm = '';
        }
    }


}