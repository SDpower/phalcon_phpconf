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

    /**
     * @Get("encry")
     */
    public function Encryptionindex()
    {
        $this->view->disable();
        $soure = "phpconf2014";
        $Encryption = $this->crypt->encrypt($soure);
        echo "Encryption test:".$Encryption.' <br />'.PHP_EOL;
        echo "Decryption test:".$this->crypt->decrypt($Encryption).' <br />'.PHP_EOL;

    }
}
