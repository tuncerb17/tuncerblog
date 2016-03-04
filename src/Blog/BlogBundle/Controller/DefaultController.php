<?php

namespace Blog\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function homeAction()
    {
        return $this->render('BlogBlogBundle:Pages:home.html.twig');
    }

    public function aboutAction()
    {
        return $this->render('BlogBlogBundle:Pages:about.html.twig');
    }
}
