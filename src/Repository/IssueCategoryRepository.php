<?php
/**
 * Soporteav Project
 * Repository/IssueRepository.php
 */

namespace US\Soporteav\Repository;

use Doctrine\ORM\EntityRepository;
use US\Soporteav\Entity\Issue\Category;


/**
 * Class IssueCategoryRepository
 */
class IssueCategoryRepository extends EntityRepository
{
    /**
     * @param array $criteria
     * @param array $orderBy
     * @param null $limit
     * @param null $offset
     * @return array Category[]
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    //public function findBy(array $criteria, array $orderBy = 'id', $limit = null, $offset = null)
    {
        return parent::findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * @param Category $category
     */
    public function save(Category $category)
    {
        parent::getEntityManager()->persist($category);
        parent::getEntityManager()->flush();
    }

    /**
     * @param mixed $id
     * @param null $lockMode
     * @param null $lockVersion
     * @return object|null
     */
    public function find($id, $lockMode = null, $lockVersion = null)
    {
        return parent::find($id, $lockMode, $lockVersion);
    }


    /**
     * @param Category $category
     */
    public function delete(Category $category)
    {
        parent::getEntityManager()->remove($category);
        parent::getEntityManager()->flush();
    }


}