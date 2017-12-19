<?php  

class Ssl {
  
    public $pubkey;
    public $privkey;
  
    function __construct() {  
        $this->pubkey = file_get_contents(dirname(__FILE__).'/pubkey.key');
        $this->privkey = file_get_contents(dirname(__FILE__).'/privatekey.key');
    }

    public function encrypt($data) {
        if (openssl_public_encrypt($data, $encrypted, $this->pubkey)) {
            $temp=str_replace('/','_',base64_encode($encrypted));
            $temp=str_replace('+','$',$temp);
            $data=str_replace('=','.',$temp);
        }else
            throw new Exception('Unable to encrypt data. Perhaps it is bigger than the key size?');
        return $data;
    }

    public function decrypt($data) {
        $temp=str_replace('_','/',$data);
        $temp=str_replace('$','+',$temp);
        $temp=str_replace('.','=',$temp);
        if (openssl_private_decrypt(base64_decode($temp), $decrypted, $this->privkey))
            $data = $decrypted;
        else
            $data = '';
        return $data;
    }
}