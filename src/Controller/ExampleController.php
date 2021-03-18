<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\TestForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExampleController extends AbstractController
{
    /**
     * @Route("/test-form"), methods={"GET,POST"}
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function testFormAction(Request $request)
    {
        $obj = new TestForm();
        $form = $this->createForm(TestForm::class, $obj);
        $form->handleRequest($request);

        $output = false;
        if ($form->isSubmitted() && $form->isValid()) {
            $date = $form->get('date')->getData();
            $timezone = $form->get('timezone')->getData();

            $timeZoneUTC = new \DateTimeZone("UTC");
            $timeZoneInput = new \DateTimeZone($timezone);

            $dateUTC = new \DateTime("now", $timeZoneUTC);

            $seconds = $timeZoneInput->getOffset($dateUTC);
            $minutes = $seconds / 60;

            $daysInFeb = cal_days_in_month(CAL_GREGORIAN, 2, (int)$date->format("Y"));
            $daysInSpecifiedMonth = cal_days_in_month(CAL_GREGORIAN, (int)$date->format("n"), (int)$date->format("Y"));
            $specifiedMonth = $date->format("F");


            $output .= "The timezone {$timezone} has {$minutes} minutes offset to UTC.<br />
	                    February in this year has {$daysInFeb} days.<br />
                        Specified month ({$specifiedMonth}) has {$daysInSpecifiedMonth} days.";
        }

        return $this->render(
            'test-form.html.twig',
            [
                'form' => $form->createView(),
                'output' => $output
            ]
        );
    }
}