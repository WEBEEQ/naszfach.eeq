<?php
// src/AppBundle/Controller/AjaxController.php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AjaxController extends Controller
{
    public function firmAction(Request $request)
    {
        $inData = $request->get('inData');
        $commentData = $this->getDoctrine()->getRepository('AppBundle:Firm')->getCommentData($inData);

        if ($commentData) {
            $outData = str_replace(
                "\r",
                '<br />',
                str_replace(
                    "\n",
                    '<br />',
                    str_replace(
                        "\r\n",
                        '<br />',
                        $commentData['commentText']
                    )
                )
            )
                . '<br />' . $commentData['commentTypeName'] . ', '
                . $commentData['commentDateAdded']->format('d.m.Y H:i:s');
        } else {
            $outData = 'Brak komentarza do wyświetlenia!';
        }

        $response = array('code' => 100, 'success' => true, 'outData' => $outData);

        return new JsonResponse($response);
    }

    public function searchAction(Request $request)
    {
        $inData = $request->get('inData');
        $inData2 = $request->get('inData2');
        $formCites = $this->getDoctrine()->getRepository('AppBundle:City')->getCities($inData);

        $outData = '<select id="search_form_city" name="search_form[city]">';
        $outData .= '<option value="0"></option>';
        foreach ($formCites as $formCity) {
            $outData .= '<option value="' . $formCity->getId() . '"'
                . (($formCity->getId() == $inData2) ? ' selected="selected"' : '')
                . '>' . $formCity->getName() . '</option>';
        }
        $outData .= '</select>';

        $response = array('code' => 100, 'success' => true, 'outData' => $outData);

        return new JsonResponse($response);
    }
}
