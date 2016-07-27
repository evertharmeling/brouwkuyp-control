<?php

namespace Brouwkuyp\Bundle\DashboardBundle\Controller;

use Brouwkuyp\Bundle\ServiceBundle\Entity\Batch;
use Brouwkuyp\Bundle\ServiceBundle\Repository\BatchRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class BatchController
{
    /**
     * @var BatchRepository
     */
    private $batchRepository;

    /**
     * @param BatchRepository $batchRepository
     */
    public function __construct(BatchRepository $batchRepository)
    {
        $this->batchRepository = $batchRepository;
    }

    /**
     * @Template
     * @return array
     */
    public function indexAction()
    {
        return [
            'batches' => $this->batchRepository->findAll()
        ];
    }

    /**
     * @param  Batch $batch
     * @Template
     * @return array
     */
    public function detailAction(Batch $batch)
    {
        return [
            'batch' => $batch
        ];
    }
}
