<?php

namespace  App;

use Exception;

class GetPostController
{
    protected $posts_dir = __DIR__ . '/../Posts';

    public function show($req,$res,$args)
    {
        try {
            $post = $this->findPost($args['id']);
        } catch (Exception $e) {
            return $res->withJson([
                'status'    =>  false,
                'message'   =>  $e->getMessage()
            ]);
        }

        return $res->withJson([
            'status'    =>  true,
            'message'   =>  $post
        ]);
    }

    protected  function findPost($id)
    {
        $path = $this->posts_dir . '/data/' . $id;

        if (file_exists($path))
        {
            return json_decode(file_get_contents($path));
        }

        throw new Exception('Post ' . $id . ' not found');
    }
}