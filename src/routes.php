<?php
// Routes

use App\GetPostController;
use App\AddNewPostController;

$app->get('/new/{body}',function($req,$res,$args){
    return (new AddNewPostController())->add($req,$res,$args);
});

$app->get('/post/{id:[0-9]+}',function($req,$res,$args){
    return (new GetPostController())->show($req,$res,$args);
});