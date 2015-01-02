<?php

namespace Brouwkuyp\Bundle\DashboardBundle\Controller;

use Brouwkuyp\Bundle\ServiceBundle\Repository\BatchRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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
     */
    public function indexAction()
    {
        $batches = $this->batchRepository->findAll();

        return [
            'batches' => $batches
        ];
    }
}
