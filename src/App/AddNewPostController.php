<?php

namespace App;

use Exception;

class AddNewPostController
{

    protected $posts_dir = __DIR__ . '/../Posts';
    
    public function add($req,$res,$args)
    {
        $validation = $this->validation($args);

        if ($validation === true)
        {
            $this->addPost(
                $args['body'],
                $req->getServerParams()['REMOTE_ADDR']
            );

            return $res->withJson([
              'status'  =>  true,
              'message' =>  'Post successfully added!'
            ]);
        }

        return $res->withJson([
            'status'    =>  false,
            'message'   =>  $validation
        ]);
    }


    protected  function validation($args)
    {
        try {
            $this->validateBodySize($args['body']);
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return true;
    }


    protected  function validateBodySize($body)
    {
        if (mb_strlen($body) < 5 || mb_strlen($body) > 512)
        {
            throw new Exception('Body must be 5-512 lenght');
        }

        return true;
    }

    protected  function  addPost($data,$ip)
    {
        $post_count = file_get_contents($this->posts_dir . '/counter');

        $body = [
            'content'   =>  $data,
            'client_ip' =>  $ip,
            'timestamp' =>  time()
        ];

        $post_count++;

        $file = fopen($this->posts_dir .'/data/'. $post_count,'w+');

        fwrite($file, json_encode($body, JSON_PRETTY_PRINT));

        fclose($file);

        file_put_contents($this->posts_dir . '/counter', $post_count);
        
        return  true;

    }


}
