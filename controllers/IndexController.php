<?php
/**
 * Description of IndexController
 * @RoutePrefix("/")
 * @author luosteve
 */
class IndexController extends Phalcon\Mvc\Controller
{
    /**
     * @Get("")
     */
    public function index()
    {
        echo $this->view->getRender(null, 'index');
    }
}
