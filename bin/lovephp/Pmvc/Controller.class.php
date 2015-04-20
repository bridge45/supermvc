<?php

/**
 * Controller
 */
class Controller
{
    /*
     * 视图对象
     */
    protected $view_instance;

    public function __construct()
    {
        $this->_create_view_instance();
    }

    public function __call($method, $args)
    {
        echo $method . '不存在' . $args;
    }

    private function _create_view_instance()
    {
        //实例化视图
        $this->view_instance = new Smarty;
        $this->view_instance->setCompileDir(C('view.config.tmpc_dir'));
        $this->view_instance->setCacheDir(C('view.config.template_dir'));
        $this->view_instance->cache_lifetime = 0; //缓存时间
        $this->view_instance->left_delimiter = C('view.config.left_delimiter');
        $this->view_instance->right_delimiter = C('view.config.right_delimiter');
        $this->view_instance->force_compile = C('view.config.force_compile');;
    }

    /**
     * displays a Smarty template
     *
     * @param string $template the resource handle of the template file or template object
     * @param mixed $cache_id cache id to be used with this template
     * @param mixed $compile_id compile id to be used with this template
     * @param object $parent next higher level of Smarty variables
     */
    protected function display($template = null, $cache_id = null, $compile_id = null, $parent = null)
    {
        $this->view_instance->display($template, $cache_id, $compile_id, $parent);
    }

    /**
     * assigns a Smarty variable
     *
     * @param  array|string $tpl_var the template variable name(s)
     * @param  mixed $value the value to assign
     * @param  boolean $nocache if true any output of this variable will be not cached
     *
     * @return Smarty_Internal_Data current Smarty_Internal_Data (or Smarty or Smarty_Internal_Template) instance for chaining
     */
    protected function assign($tpl_var, $value = null, $nocache = false)
    {
        $this->view_instance->assign($tpl_var, $value, $nocache);
        return $this;
    }


}


