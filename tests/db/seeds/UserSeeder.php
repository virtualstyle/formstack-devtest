<?php

use Phinx\Seed\AbstractSeed;

class UserSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $data = array(
          array(
              'username' => 'userone',
              'password' => '*668425423DB5193AF921380129F465A6425216D0',
              //password1
              'email' => 'userone@test.com',
              'firstname' => 'user',
              'lastname' => 'one',
          ),
          array(
              'username' => 'user2',
              'password' => '*DC52755F3C09F5923046BD42AFA76BD1D80DF2E9',
              //password2
              'email' => 'user2@test.com',
              'firstname' => 'two',
              'lastname' => '2',
          ),
          array(
              'username' => 'user3',
              'password' => '*40C3E7D386A2FADBDF69ACEBE7AA4DC3C723D798',
              //password3
              'email' => 'user3@test.com',
              'firstname' => 'three',
              'lastname' => '3',
          ),
          array(
              'username' => 'user4',
              'password' => '*F97AEB38B3275C06D822FC9341A2151642C81988',
              //password4
              'email' => 'user4@test.com',
              'firstname' => 'four',
              'lastname' => '4',
          ),
          array(
              'username' => 'user5',
              'password' => '*5A6AB0B9E84ED1EEC9E8AE9C926922C5D1EDF908',
              //password5
              'email' => 'user5@test.com',
              'firstname' => 'five',
              'lastname' => '5',
          ),
        );

        $posts = $this->table('user');
        $posts->insert($data)
            ->save();
    }
}
