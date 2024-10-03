<?php


return [

    '' => function () {
        require './home.php';
    },
    '/home' => function () {
        require './home.php';
    },
    '/register' => function () {
        require './register.php';
    },
    '/login' => function () {
        require './login.php';
    },
    '/blog' => function () {
        require './blog_view.php';
    },
     '/post_detail' => function () {
        require './post_detail.php';
    }

];
?>