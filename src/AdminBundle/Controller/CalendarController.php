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
use Symfony\Component\HttpFoundation\Response;

class CalendarController extends CoreController
{
    public function indexAction(Request $request, $timestamp = null)
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

        // создаем пустую форму, если она в верху отработала
        $eventForm = $this->createForm(ScheduleEventForm::class);
        $eventsService = $this->get('app.sl.schedule');
        $events = $eventsService->getEventsForDate($timestamp);

        if (!$timestamp) {
            $timestamp = time();
        }

        return $this->render('AdminBundle:Calendar:custompage.html.twig', array(
            'eventForm' => $eventForm->createView(),
            'events' => $events,
            'date' => $timestamp,
            'base_template' => $this->getBaseTemplate(),
            'admin_pool' => $this->container->get('sonata.admin.pool'),
            'blocks' => $this->container->getParameter('sonata.admin.configuration.dashboard_blocks')
        ));
    }

    public function deleteAction(Request $request, ScheduleEvent $event)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($event);
        $em->flush();

        return new Response();
    }
}