<?php

namespace Config\ContactBundle\Entity\Repository;
use Doctrine\ORM\Query;

/**
 * FormRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FormRepository extends \Doctrine\ORM\EntityRepository
{

    public function getContactForm($formId)
    {

        $query = $this->getEntityManager()
            ->createQuery('SELECT f,i FROM ConfigContactBundle:Form f
                            LEFT JOIN f.input i
                            WHERE f.name = :formId order BY i.order ASC
                            ')
            ->setParameter('formId',$formId);
        $query->setHint(Query::HINT_CUSTOM_OUTPUT_WALKER, 'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker');
        $result = $query->getResult();
        if(!$result){
            return null;
        }
        return $result[0];
    }
}
