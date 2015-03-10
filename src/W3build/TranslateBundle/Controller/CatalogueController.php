<?php

namespace W3build\Bundle\Core\TranslateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use \W3build\Component\DataGrid;
use \W3build\Bundle\Core\TranslateBundle\Form\Type;

class CatalogueController extends Controller
{
    /**
     * @Route("/", name="admin_translate_list")
     * @Template()
     */
    public function indexAction(Request $request)
    {

        $data = $this->getDoctrine()->getRepository('W3buildCoreTranslateBundle:MsgId')->findAll();
        $page = $request->get('page') ? $request->get('page') : 1;
        $dataGrid = new DataGrid\DataGrid($data);
        $dataGrid->setItemsPerPage(10)
            ->setPage($page)
            ->setColumn(new DataGrid\Column\Column('Msg Id', 'getMsgId'))
            ->addAction(DataGrid\DataGrid::EDIT_ACTION, '{{ path(\'admin_translate_edit\', {\'msgId\' : $getId }) }}')
        ;

        return array('dataGrid' => $dataGrid);
    }

    /**
     * @Route("/add/", name="admin_translate_add")
     * @Template()
     */
    public function addAction(Request $request){
        $locales = $this->getDoctrine()->getRepository('W3buildCoreTranslateBundle:Locale')->findAllActive();

        $form = $this->createForm(new Type\MsgIdType($locales));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();

            $msgId = new \W3build\Bundle\Core\TranslateBundle\Entity\MsgId();
            $msgId->setMsgId($data['msgId']);


            $manager = $this->getDoctrine()->getManager();
            $manager->persist($msgId);
            $manager->flush();
            foreach($locales as $locale){
                $msgStr = new \W3build\Bundle\Core\TranslateBundle\Entity\MsgStr($msgId, $locale);
                $msgStr->setMsgStr($data['msgStr_' . $locale->getCode()]);
                $manager->persist($msgStr);
            }

            $manager->flush();
            $this->_clearCache($locales);
            return $this->redirect($this->generateUrl('admin_translate_list'));
        }

        return array('form' => $form->createView());
    }

    protected function _clearCache($locales){
        $path = realpath('./../app/cache/dev/translations/');
        foreach($locales as $locale){
            $localeFile = $path . '/catalogue.' . $locale->getCode() . '.php';
            if(file_exists($localeFile)){
                unlink($localeFile);
                if(file_exists($localeFile . '.meta')){
                    unlink($localeFile . '.meta');
                }
            }
            continue;
        }
    }

    /**
     * @Route("/edit/{msgId}", requirements={"msgId" = "\d+"}, name="admin_translate_edit")
     * @Template()
     */
    public function editAction(Request $request, $msgId){
        $locales = $this->getDoctrine()->getRepository('W3buildCoreTranslateBundle:Locale')->findAllActive();

        $msgId = $this->getDoctrine()->getRepository('W3buildCoreTranslateBundle:MsgId')->find($msgId);

        $data = array(
            'msgId' => $msgId->getMsgId()
        );

        $existMsgStrLocales = array();
        foreach($msgId->getMsgStrings() as $msgStr){
            $existMsgStrLocales[] = $msgStr->getLocale()->getCode();
            $data['msgStr_' . $msgStr->getLocale()->getCode()] = $msgStr->getMsgStr();
        }

        $form = $this->createForm(new Type\MsgIdType($locales), $data);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();

            $msgId->setMsgId($data['msgId']);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($msgId);
            $manager->flush();
            foreach($msgId->getMsgStrings() as $msgStr){
                $msgStr->setMsgStr($data['msgStr_' . $msgStr->getLocale()->getCode()]);
            }
            foreach($locales as $locale){
                if(!in_array($locale->getCode(), $existMsgStrLocales)){
                    $msgStr = new \W3build\Bundle\Core\TranslateBundle\Entity\MsgStr($msgId, $locale);
                    $msgStr->setMsgStr($data['msgStr_' . $locale->getCode()]);
                    $manager->persist($msgStr);
                }
            }

            $manager->flush();
            $this->_clearCache($locales);
            return $this->redirect($this->generateUrl('admin_translate_list'));
        }

        return array('form' => $form->createView());
    }
}
