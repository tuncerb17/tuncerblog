<?php

namespace Blog\BlogBundle\Controller;

use Blog\BlogBundle\Entity\Blog;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class BlogController extends Controller
{

    public function addBlogAction(Request $request)
    {
        if ($request->isMethod('POST')) {

            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $post_name = $request->request->get('name');
            $post_content = $request->request->get('content');

            $post = new Blog();
            $post->setName($post_name);
            $post->setLink($this->slugify($post_name));
            $post->setContent($post_content);
            $post->setUser($user);

            $errors = $this->container->get('validator')->validate($post);

            if (count($errors) > 0) {
                throw new HttpException(400, $errors[0]->getMessage());
            }else{
                $em->persist($post);
                $em->flush();
            }


            return $this->redirect($this->generateUrl('blog_add_blog'));
        }
        else{
            return $this->render('BlogBlogBundle:Pages:addBlog.html.twig');
        }
    }

    public function allBlogAction(){

        $em = $this->getDoctrine()->getManager();

        $blogs =  $em->getRepository('Blog\BlogBundle\Entity\Blog')->findAll();

        return $this->render('BlogBlogBundle:Pages:all.html.twig',array('blogs' => $blogs));

    }

    public function oneBlogAction($slug){
        $em = $this->getDoctrine()->getManager();

        $blogs =  $em->getRepository('Blog\BlogBundle\Entity\Blog')->findByLink($slug);

        return $this->render('BlogBlogBundle:Pages:all.html.twig',array('blogs' => $blogs));
    }

    static public function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text))
        {
            return 'n-a';
        }

        return $text;
    }
}
