<?php

// src/AppBundle/Model/Profile/EmployeeRepository.php
namespace ThinkBig\Bundle\EntityTransformBundle\Model;

use Doctrine\ORM\EntityRepository;


use ThinkBig\Bundle\EntityTransformBundle\Entity\Mapping;


class MappingRepository extends EntityRepository
{
    

    public function findByReference($params)
    {

        $index = 0;
        
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('u')->from(Mapping::class, 'u');

        foreach ($params as $data) {
            
            $qb->orWhere(sprintf("u.objectClass = :class_%d AND u.objectId = :id_%d", $index, $index));
            $qb->setParameter(sprintf('class_%d', $index), $data[0]);
            $qb->setParameter(sprintf('id_%d', $index), $data[1]);

            $index++;

        }

        return  $qb->getQuery()->getResult();

    }

}