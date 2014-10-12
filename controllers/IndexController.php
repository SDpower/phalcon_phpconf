<?php
/**
 * Description of IndexController
 *
 * @author luosteve
 */
class IndexController extends Phalcon\Mvc\Controller
{
    public function index()
    {
        echo $this->view->getRender(null, 'index');
    }
}
