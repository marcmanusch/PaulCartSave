<?php

namespace PaulCartSave\Models;

use Shopware\Components\Model\ModelRepository;

class Repository extends ModelRepository
{

    /**
     * Helper function to create the query builder for the "getListQuery" function.
     * This function can be hooked to modify the query builder of the query object.
     *
     * @param null $filter
     * @param null $orderBy
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getListQueryBuilder($filter = null, $orderBy = null)
    {
        $builder = $this->getEntityManager()->createQueryBuilder();

        $builder->select(array('rating_export_google'))
            ->from($this->getEntityName(), 'rating_export_google');

        $this->addFilter($builder, $filter);
        $this->addOrderBy($builder, $orderBy);

        return $builder;
    }
}
