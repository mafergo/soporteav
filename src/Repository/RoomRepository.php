<?php
/**
 * Soporteav Project
 * Repository/RoomRepository.php
 */

namespace US\Soporteav\Repository;

use Doctrine\ORM\EntityRepository;
use US\Soporteav\Entity\Room;


/**
 * Class RoomRepository
 */
class RoomRepository extends EntityRepository
{
    /**
     * @param array $criteria
     * @param array $orderBy
     * @param null $limit
     * @param null $offset
     * @return array Room
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return parent::findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * Guarda un Centro en la base de datos
     * @param Room $room
     */
    public function save(Room $room)
    {
        parent::getEntityManager()->persist($room);
        parent::getEntityManager()->flush();
    }

    /**
     * @param mixed $id
     * @param null $lockMode
     * @param null $lockVersion
     * @return null|item
     */
    public function find($id, $lockMode = null, $lockVersion = null)
    {
        return parent::find($id, $lockMode, $lockVersion);
    }


    /**
     * @param Room $room
     */
    public function delete(Room $room)
    {
        parent::getEntityManager()->remove($room);
        parent::getEntityManager()->flush();
    }

    /**
     * Cuenta el número de Centros existente.
     *
     * @return integer Número total de Centros.
     */
    public function count()
    {
        $dql = 'SELECT COUNT(c.id) FROM US\Soporteav\Entity\Room c';
        $query = parent::getEntityManager()->createQuery($dql);
        return $query->getSingleScalarResult();
    }
}