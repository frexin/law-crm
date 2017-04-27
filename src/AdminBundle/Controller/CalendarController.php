<?php
/**
 * Created by PhpStorm.
 * User: andrewalf
 * Date: 26.04.17
 * Time: 19:28
 */

namespace AdminBundle\Controller;

use AdminBundle\Forms\ScheduleEventForm;
use AppBundle\Entity\ScheduleEvent;
use AppBundle\Enums\ScheduleEventsStatuses;
use Sonata\AdminBundle\Controller\CoreController;
use Symfony\Component\HttpFoundation\Request;

//class CalendarController extends CoreController
class CalendarController extends CoreController
{
    public function indexAction(Request $request, $date = null)
    {
        $eventForm = $this->createForm(ScheduleEventForm::class);
        $eventForm->handleRequest($request);

        if ($eventForm->isSubmitted() && $eventForm->isValid()) {
            $data = $eventForm->getData();

            $scheduleEvent = new ScheduleEvent();
            $scheduleEvent->setDate($data['startDate']);
            $scheduleEvent->setDescription($data['description']);
            $scheduleEvent->setType($data['type']);
            $scheduleEvent->setStatus(ScheduleEventsStatuses::STATUS_WAITING);
            $scheduleEvent->setUser($this->get('security.token_storage')->getToken()->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($scheduleEvent);
            $em->flush();
        }

        $eventsService = $this->get('app.sl.schedule');
        $events = $eventsService->getEventsForDate();

        return $this->render('AdminBundle:Calendar:custompage.html.twig', array(
            'eventForm' => $eventForm->createView(),
            'events' => $events,
            'base_template' => $this->getBaseTemplate(),
            'admin_pool' => $this->container->get('sonata.admin.pool'),
            'blocks' => $this->container->getParameter('sonata.admin.configuration.dashboard_blocks')
        ));
    }
}