<?php

namespace App\Components;

use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Adapter\Role;
use Phalcon\Acl\Adapter\Component;
use Phalcon\Http\Request;


use Phalcon\Escaper;

class Helper
{

    public function hello()
    {
        return "hello world";
    }

    public function Escaper($data)
    {
        $escaper = new Escaper();
        $escaperData = $escaper->escapeHtml($data);
        return $escaperData;
    }

    public function BuildAclAction()
    {
        $aclFile = APP_PATH . "/security/acl.cache";
        if (file_exists($aclFile) !== true) {
            $acl = new Memory();
            $acl->addRole("admin");
            $acl->addRole("guest");
            $acl->addRole("manager");

            $acl->addComponent(
                'test',
                [
                    'test'
                ]
            );

            $acl->allow("guest", "test", "test");
            file_put_contents($aclFile, serialize($acl));
        } else {
            $acl = unserialize(file_get_contents($aclFile));
        }

        $request= new Request();
        $role = $request->get("role");
        if (true == $acl->isAllowed($role, "test", "test")) {
            die("access granted");
        } else {
            die("access denied");
        }
    }
}
