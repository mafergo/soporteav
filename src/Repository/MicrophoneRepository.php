<?php
/**
 * Soporteav Project
 * Repository/MicrophoneRepository.php
 */

namespace US\Soporteav\Repository;

use Doctrine\ORM\EntityRepository;
use US\Soporteav\Entity\microphone;


/**
 * Class MicrophoneRepository
 */
class MicrophoneRepository extends EntityRepository
{
    /**
     * @param array $criteria
     * @param array $orderBy
     * @param null $limit
     * @param null $offset
     * @return array Microphone
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    //public function findBy(array $criteria, array $orderBy = 'id', $limit = null, $offset = null)
    {
        return parent::findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * Guarda una incidencia en la base de datos
     * @param Microphone $microphone
     */
    public function save(Microphone $microphone)
    {
        parent::getEntityManager()->persist($microphone);
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
     * @param Center $center
     */
    public function delete(Microphone $microphone)
    {
        parent::getEntityManager()->remove($microphone);
        parent::getEntityManager()->flush();
    }

    /**
     * Cuenta el número de Centros existente.
     *
     * @return integer Número total de Centros.
     */
    public function count()
    {
        $dql = 'SELECT COUNT(c.id) FROM US\Soporteav\Entity\Microphone c';
        $query = parent::getEntityManager()->createQuery($dql);
        return $query->getSingleScalarResult();
    }
}