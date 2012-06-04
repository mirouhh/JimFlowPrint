<?php
namespace Jimdo\JimkanbanBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use \Symfony\Component\HttpFoundation\Response;
use \Symfony\Component\HttpFoundation\Request;

class PrintController extends Controller
{
    public function printticketAction(Request $request)
    {
        $data = $request->request->all();

        $templateDataService = $this->container->get('jimdo.template_data_view');
        $templateData = $templateDataService->getTemplateData();

        $printingService = $this->get('jimdo.gcp_printing');
        $response = new Response();
        $response->setStatusCode(200);

        try {
            $printingService->doPrint($templateData['printer'], $this->generateUrl('template_print_view', $data, true));

        } catch(\InvalidArgumentException $e) {
            $response->setStatusCode(500);
            $response->setContent($e->getMessage());
        }

        return $response;
    }

}
