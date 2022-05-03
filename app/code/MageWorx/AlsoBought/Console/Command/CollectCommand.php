<?php
/**
 * Copyright © MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MageWorx\AlsoBought\Console\Command;

use MageWorx\AlsoBought\Helper\Data;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Framework\Event\ManagerInterface as EventManagerInterface;
use Magento\Store\Model\StoreManagerInterface as StoreManagerInterface;
use Magento\Framework\App\State;

class CollectCommand extends Command
{
    /** @var EventManagerInterface */
    protected $eventManager;

    /** @var StoreManagerInterface */
    protected $storeManager;

    /**
     * @var State
     */
    protected $appState;

    /**
     * @var \MageWorx\AlsoBought\Model\Relation
     */
    protected $relation;

    /**
     * @var Data
     */
    protected $helper;


    /**
     * CollectCommand constructor.
     *
     * @param \MageWorx\AlsoBought\Model\Relation $relation
     * @param Data $helper
     * @param EventManagerInterface $eventManager
     * @param StoreManagerInterface $storeManager
     * @param State $appState
     */
    public function __construct(
        \MageWorx\AlsoBought\Model\Relation $relation,
        Data $helper,
        EventManagerInterface $eventManager,
        StoreManagerInterface $storeManager,
        State $appState
    ) {
        $this->relation     = $relation;
        $this->helper       = $helper;
        $this->storeManager = $storeManager;
        $this->eventManager = $eventManager;
        $this->appState     = $appState;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('mageworx-alsobought:collect');
        $this->setDescription(
            'Collect all available data (in separate table).'
        );
        parent::configure();
    }

    /**
     *
     * @return boolean
     */
    protected function isEnable()
    {
        return true;
    }

    /**
     * Dispatch event
     *
     * @return array
     */
    protected function performAction()
    {
        $result = ['message' => ''];
        try {
            $this->relation->collectRelations();
            $result['message'] = $this->getSuccessMessage();
        } catch (\Exception $e) {
            $result['message'] = $e->getMessage();
        }

        $result['time'] = $this->helper->getLastCollectTime();

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    protected function getDisplayMessage()
    {
        return 'Collecting...';
    }

    /**
     * Retrieve finish notice
     *
     * @return string
     */
    protected function getSuccessMessage()
    {
        return 'Data collecting has been finished successfully.';
    }

    /**
     * Perform cache management action
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln($this->getDisplayMessage());
        $result = $this->performAction();
        $output->writeln($result['message']);
        $output->writeln('Last collect time is ' . $result['time']);
    }
}