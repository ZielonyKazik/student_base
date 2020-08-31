<?php

namespace App\Repository;

use App\Entity\Student;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Student|null find($id, $lockMode = null, $lockVersion = null)
 * @method Student|null findOneBy(array $criteria, array $orderBy = null)
 * @method Student[]    findAll()
 * @method Student[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Student::class);
    }

    public function findPublicColumnsByAlbumNo($user_id, $conditions = [])
    {
        $query = $this->createQueryBuilder('stud')
            ->select(['stud.name', 'stud.surname', 'stud.start_year', 'stud.semester', 'stud.album_no'])
            ->where('stud.user_id = :user_id')
            ->setParameter(':user_id', $user_id);

        foreach ($conditions as $param => $values) {
            $query->andWhere($query->expr()->in(sprintf('stud.%s', $param), sprintf(':%s', $param)))
                ->setParameter(':%s', $values);
        }
        return $query->orderBy('stud.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /*
    public function findOneBySomeField($value): ?Student
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
