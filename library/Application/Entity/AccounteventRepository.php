<?php
namespace Application\Entity;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * AccounteventRepository
 *
 * @author Siwei Mu (musiwei.work@gmail.com)
 * @copyright Newton's Nerds
 * @since 13 Mar 2014
 * @version 1.0
 * @package Application
 */
class AccounteventRepository extends EntityRepository
{

    private $_table = '\Application\Entity\Accountevent';
    private $_shortcut = 'a';
    
    /**
     * Fetch account events for datatable ajax function
     *
     * @author Siwei Mu
     * @param array $options            
     * @return array $output
     *        
     */
    public function fetchAccountEvents ($options)
    {

        $aColumns = array(
                'event',
                'happenedAt'
        );
        
        # build query - build as prepared statements to avoid sql injection
        $qb = $this->getEntityManager()->createQueryBuilder();
        
        $qb->add('select', $this->_shortcut)
           ->add('from', $this->_table . ' ' . $this->_shortcut);
        
        # ordering
        if (isset($options['iSortCol_0'])) {
            for ($i = 0; $i < intval($options['iSortingCols']); $i ++) {
                if ($options['bSortable_' . intval($options['iSortCol_' . $i])] ===
                         'true') {
                    switch ($options['sSortDir_' . $i]) {
                        case 'asc':
                            $qb->orderBy(
                                    $qb->expr()
                                        ->asc(
                                            $this->_shortcut . '.' .
                                             $aColumns[intval(
                                                    $options['iSortCol_' . $i])]));
                            break;
                        case 'desc':
                            $qb->orderBy(
                                    $qb->expr()
                                        ->desc(
                                            $this->_shortcut . '.' .
                                                     $aColumns[intval(
                                                            $options['iSortCol_' .
                                                             $i])]));
                            break;
                    }
                }
            }
        }
        
        # filtering
        if ($options['sSearch'] != '') {
            foreach ($aColumns as $aColumn) {
                $qb->orWhere(
                        $qb->expr()
                            ->like($this->_shortcut . '.' . $aColumn, '?' . $i))
                    ->setParameter($i, '%' . $options['sSearch'] . '%');
            }
        }
        
        # filtering - individual column
        for ($i = 0; $i < count($aColumns); $i ++) {
            if ($options['bSearchable_' . $i] === 'true' &&
                     $options['sSearch_' . $i] != '') {
                
                $qb->andWhere(
                        $qb->expr()
                            ->like($this->_shortcut . '.' . $aColumns[$i], '?' .
                         $i))
                    ->setParameter($i, '%' . $options['sSearch_' . $i] . '%');
            }
        }
        
        # display limited records
        if ($options['iDisplayLength'] != '-1') {
            $qb->setFirstResult($options['iDisplayStart'])->setMaxResults(
                    $options['iDisplayLength']);
        }
        
        $query = $qb->getQuery();
        $arrayResult = $query->getArrayResult();
        
        # length of data set after filtering
        $paginator = new Paginator($qb, $fetchJoinCollection = true);
        $iFilteredTotal = $paginator->count();
        
        # total length of data set, fetched by index to increase performance
        $dql = 'SELECT COUNT(' . $this->_shortcut . '.id) FROM ' . $this->_table . ' ' .
                 $this->_shortcut;
        $result = $this->getEntityManager()
            ->createQuery($dql)
            ->getSingleScalarResult();
        $iTotal = $result[1];
        
        # output
        $output = array(
                "sEcho" => intval($options['sEcho']),
                "iTotalRecords" => $iTotal,
                "iTotalDisplayRecords" => $iFilteredTotal,
                "aaData" => array()
        );
        
        foreach ($arrayResult as $singleResult) {
            $row = array();
            for ($i = 0; $i < count($aColumns); $i ++) {
                $cellValue = $singleResult[$aColumns[$i]];
                # check if value is datetime object
                if (is_a($cellValue, 'DateTime')) {
                    # yes, convert to string
                    $row[] = $cellValue->format('Y-m-d H:i:s');
                } else {
                    $row[] = $cellValue;
                }
            }
            
            # send data id (primary key) to front for xeditable plugin (optional)
            $row['DT_RowId'] = $singleResult['id'];
            
            # add class to row (optional)
            $row['DT_RowClass'] = 'highlight';
            
            # append row to result set
            $output['aaData'][] = $row;
        }
        
        return $output;
        /* $before = microtime(true);
         $after = microtime(true);
         echo ($after-$before) . " secs\n";*/
    }
    
    /**
     * Update account event field
     *
     * @author Siwei Mu
     * @param array $options
     * @return array $output
     *
     */
    public function updateAccountEvents ($id, $field, $value){
        
        $qb = $this->getEntityManager()->createQueryBuilder();
        
        $qb ->update($this->_table, $this->_shortcut)
            ->set($this->_shortcut.".".$field, '?1')
            ->where($qb->expr()->eq($this->_shortcut.".id", $id))
            ->setParameter(1, htmlentities($value))
            ->getQuery()
            ->execute();
    }
}
