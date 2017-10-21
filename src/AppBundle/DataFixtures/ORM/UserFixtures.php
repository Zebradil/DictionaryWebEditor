<?php
declare(strict_types=1);

namespace AppBundle\DataFixtures\ORM;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $manipulator = $this->container->get('fos_user.util.user_manipulator');

        $manipulator->create('sadmin', '123', 'sadmin@dictor.dev', true, true);
        $manipulator->create('admin', '123', 'admin@dictor.dev', true, false);
        $manipulator->addRole('admin', 'ROLE_ADMIN');
        $manipulator->create('user', '123', 'user@dictor.dev', true, false);
    }
}
