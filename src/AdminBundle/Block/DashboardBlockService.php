<?php
//
//namespace AdminBundle\Block;
//
//use AppBundle\Service\StatisticService;
//use Sonata\AdminBundle\Form\FormMapper;
//use Sonata\BlockBundle\Block\BlockContextInterface;
//use Sonata\BlockBundle\Block\Service\AbstractBlockService;
//use Sonata\BlockBundle\Model\BlockInterface;
//use Sonata\CoreBundle\Validator\ErrorElement;
//use Symfony\Component\HttpFoundation\Response;
//
//class DashboardBlockService extends AbstractBlockService {
//
//    /**
//     * @var StatisticService
//     */
//    protected $statisticService;
//
//    /**
//     * @param StatisticService $statisticService
//     */
//    public function setStatisticService($statisticService) {
//        $this->statisticService = $statisticService;
//    }
//
//    public function getName() {
//        return 'My Newsletter';
//    }
//
//    public function getDefaultSettings() {
//        return array();
//    }
//
//    public function validateBlock(ErrorElement $errorElement, BlockInterface $block) {
//    }
//
//    public function buildEditForm(FormMapper $formMapper, BlockInterface $block) {
//    }
//
//    public function execute(BlockContextInterface $block, Response $response = null) {
//        $settings = array_merge($this->getDefaultSettings(), $block->getSettings());
//
//        return $this->renderResponse('GentellelaBundle::dashboard.block.html.twig', array(
//                'block' => $block,
//                'settings' => $settings,
//                'stat' => $this->statisticService
//                )
//        );
//    }
//}