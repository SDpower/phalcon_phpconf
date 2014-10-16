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

    /**
     * @Get("cookie")
     */
    public function Cookie()
    {
         //Check if the cookie has previously set
        if ($this->cookies->has('remember-me')) {
            //Get the cookie
            $rememberMe = $this->cookies->get('remember-me');
            //Get the cookie's value
            $value = $rememberMe->getValue();
            echo "Value = ".$value.PHP_EOL;
        } else {
            $value = time();
            //Set the cookie 30sec
            $this->cookies->set('remember-me',$value,time() + 30);
            echo "Set Cookies : Value = ".$value.PHP_EOL;
            //Sends the cookies to the client Cookies
            $this->cookies->send();
        }
    }

    /**
     *
     * @Get("hashing")
     */
    public function Hashing()
    {
        $password = '123456';
        echo "Password = {$password}"."<br />".PHP_EOL;
        $hasgPassword = $this->security->hash($password);
        echo "hasgPassword = {$hasgPassword}"."<br />".PHP_EOL;
        echo "Test mach: ".
                ($this->security->checkHash($password, $hasgPassword) ?
                "true":"false").
                "<br />".PHP_EOL;
        echo "Test not mach: ".
                ($this->security->checkHash('12', $hasgPassword) ?
                "true":"false").
                "<br />".PHP_EOL;
    }
}
