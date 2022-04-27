<?php

use Phalcon\Mvc\Controller;

class TestController extends Controller
{

    public function testAction()
    {
        // die("test Controller");
        $this->logger->info("logger working");
        $helper = new \App\Components\Helper();
        echo $helper->Escaper("<script>alert('hacked')</script>");

        $eventManger = $this->eventmanager;
        $this->session->set("name", "ankit aginhotry");
        $this->session->a = 10;

        echo $this->session->get("name");
        echo "<br>";
        $this->response->setStatusCode(200, 'Found');
        $this->response->setContent("Successfull, Response Send");
        $this->response->send();
        // $eventManger->fire("eventhandler:helloEvent", $this);
        // echo ;
        // echo $helper->hello();
        // echo $this->config->msg;
        die;
    }
}
