<?php
namespace PHPMVC\Controllers;

use PHPMVC\LIB\FrontController;
use PHPMVC\LIB\Template;
use PHPMVC\LIB\Validate;

abstract class AbstractController
{
    use Validate;
    
    protected $_controller;
    protected $_action;
    protected $_params;

    protected $_template;
    protected $_registry;

    protected $_data = [];

    public function __get ($key)
    {
        return $this->_registry->$key;
    }

    public function notFoundAction()
    {
        $this->_view();
    }

    public function setController ($controllerName)
    {
        $this->_controller = $controllerName;
    }

    public function setAction ($ActionName)
    {
        $this->_action = $ActionName;
    }

    public function setTemplate($template)
    {
        $this->_template = $template;
    }

    public function setRegistry($registry)
    {
        $this->_registry = $registry;
    }

    public function setParams ($params)
    {
        $this->_params = $params;
    }

    protected function _view()
    {   
        $view = VIEWS_PATH . $this->_controller . DS . $this->_action . '.view.php';
        if($this->_action == FrontController::NOT_FOUND_ACTION || !file_exists($view)) {
            $view = VIEWS_PATH . '404' . DS . '404.view.php';
        }

        $this->_data = array_merge($this->_data, $this->_registry->language->getDictionary());
        $this->_template->setRegistry($this->_registry);
        $this->_template->setActionViewFile($view);
        $this->_template->setAppData($this->_data);
        $this->_template->renderApp();

    }

}