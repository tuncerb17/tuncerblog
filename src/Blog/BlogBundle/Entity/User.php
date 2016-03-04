<?php
// src/AppBundle/Entity/User.php

namespace Blog\BlogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Blog", mappedBy="user")
     */
    protected $blogs;

    public function __construct()
    {
        $this->blogs = new ArrayCollection();

        parent::__construct();
        // your own logic
    }


    /**
     * Add blogs
     *
     * @param \Blog\BlogBundle\Entity\Blog $blogs
     * @return User
     */
    public function addBlog(\Blog\BlogBundle\Entity\Blog $blogs)
    {
        $this->blogs[] = $blogs;

        return $this;
    }

    /**
     * Remove blogs
     *
     * @param \Blog\BlogBundle\Entity\Blog $blogs
     */
    public function removeBlog(\Blog\BlogBundle\Entity\Blog $blogs)
    {
        $this->blogs->removeElement($blogs);
    }

    /**
     * Get blogs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBlogs()
    {
        return $this->blogs;
    }
}
