<?php
declare(strict_types=1);

namespace AppBundle\Entity;

use Ion\Orm\Annotation\{Entity, Column, ManyToOne};
use Ion\Validator\Annotation\Assert;
use Ion\Sanitizer\Annotation\Sanitize;
use Ion\Serializer\Annotation\{Group, Expose, Expand};

/**
 * @Entity
 */
class Article
{

    /**
     * @Column('string', length=200)
     * @Assert\Title
     * @Sanitize\Title
     * @Expose
     * @Group({'default'})
     */
    private $title;

    /**
     * @Column('string', length=200)
     * @Assert\CanonicalName
     * @Sanitize\CanonicalName
     * @Expose
     * @Group({'default'})
     */
    private $title;

    /**
     * @Column('string')
     * @Assert\Html
     * @Sanitize\Html
     * @Expose
     * @Group({'default'})
     */
    private $content;

    /**
     * @ManyToOne(Category::class)
     * @Expose
     * @Group({'extended'})
     * @Expand
     */
    private $category;
}