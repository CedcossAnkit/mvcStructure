<?php

use Phalcon\Mvc\Controller;
use Firebase\JWT\JWT;

class TestController extends Controller
{

    public function testAction()
    {
        $eventManger = $this->eventmanager;
        echo $this->CreateToken("ankit", "akaginhotry");
        // $eventManger->fire("eventhandler:helloEvent", $this);
        // die("test Controller");
        $this->logger->info("logger working");
        $helper = new \App\Components\Helper();
        echo $helper->Escaper("<script>alert('hacked')</script>");

        $this->session->set("name", "ankit aginhotry");
        $this->session->a = 10;

        echo $this->session->get("name");
        echo "<br>";
        $this->response->setStatusCode(200, 'Found');
        $this->response->setContent("Successfull, Response Send");
        $this->response->send();
        // echo ;
        // echo $helper->hello();
        // echo $this->config->msg;
        die;
    }

    public function CreateToken($role, $email)
    {
        $key = "example_key";
        $payload = array(
            "iss" => "http://example.org",
            "aud" => "http://example.com",
            "iat" => 1356999524,
            "nbf" => 1357000000,
            'email' => $email,
            'role' => $role
        );

        $jwt = new JWT();

        $encryptedKey = $jwt->encode($payload, $key, 'HS256');
        return $encryptedKey;
    }

    public function aclAction()
    {
        $helper = new App\Components\Helper();
        $helper->BuildAclAction();
    }
}
