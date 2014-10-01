<?php

namespace Dorin\Bundles\SlinkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

// To use DOM
use Symfony\Component\DomCrawler\Crawler;

use Dorin\Bundles\SlinkBundle\Entity\Site;

class DefaultController extends Controller
{
    /**
     * @Route("/slink", name="slink_home")
     * @Template()
     */
    public function homeAction(Request $request)
    {


        if($request->query->get('v')){

            $em = $this->getDoctrine()->getManager();

            // Load Short Url
            $site = $em->getRepository('DorinBundlesSlinkBundle:Site')->findOneBy(array('short' => $request->query->get('v')));

            // Check if the Short Url exists into the database
            if ( !is_null($site) ){
                return $this->redirect($site->getUrl());
            }

        }

        $date_of_today = new \DateTime('now');

        // New Site Object
        $site = new Site();
        $site->setCreatedAt($date_of_today);

        // Form Builder
        $form = $this->createFormBuilder($site)
        ->add('url', 'text', array(
            'required' => true,
            'attr'=> array(
                'class' => 'form-control',
                'placeholder' => 'Paste here your link. Example: https://www.youtube.com/watch?v=PwBgnn3NCh0'
                )))
        ->add('save', 'submit', array(
            'attr' => array(
                'class' => 'btn btn-lg btn-default'
                )))
        ->getForm();

        $form->handleRequest($request);


        if($form->isValid()){

            $generateShortUrl = uniqid();

            $title_website = $this->get_title($request->get('form[url]', null, true));

            // Check if the site works. If not show an error.
            if(!is_null($title_website)){

                $site->setTitle($title_website);
                $site->setShortUrl($generateShortUrl);

                // Check if the new short link have life.
                if($request->get('available') == 'on'){
                    $site->setExpiration('1');
                }else{
                    $site->setExpiration('0');
                }

                $em = $this->getDoctrine()->getManager();
                $em->persist($site);
                $em->flush();

                return $this->redirect($this->generateUrl('slink_home', array('success' => true, 'short' => $generateShortUrl )));

                // return array(
                //     'title' => 'Slink.com',
                //     'success' => $request->query->get('success'),
                //     'short' => $request->query->get('short')
                // );    

            }

        }

        return array(
                'title' => 'Slink.com',
                'success' => false,
                'form' => $form->createView()
            );    
    }

    // /**
    //  * @Route("/slink/success", name="slink_success")
    //  * @Template()
    //  */
    // public function successAction(Request $request)
    // {

    //     return array(
    //             'title' => 'Slink.com',
    //             'success' => $request->query->get('success'),
    //             'short' => $request->query->get('short')
    //         );    
    // }

    // /**
    //  * @Route("/slink/{site}", name="slink_show")
    //  * @Template()
    //  */
    // public function showAction($site)
    // {




    //     // return array(
                
    //     //     );    
    // }


    /**
     * @Route("/slink/about", name="slink_about")
     * @Template()
     */
    public function aboutAction()
    {
        return array(
                'title' => 'Slink.com - About'
            );        
    }

    /**
     * @Route("/slink/contact", name="slink_contact")
     * @Template()
     */
    public function contactAction()
    {
        return array(
                'title' => 'Slink.com - Contact'
            );
    }

    /**
     * @Route("/slink/terms_and_conditions", name="slink_terms_and_conditions")
     * @Template()
     */
    public function terms_and_conditionsAction()
    {
        return array(
                'title' => 'Slink.com - Terms and conditions'
            );
    }

    // Methods

    function file_get_contents_curl($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }        

    function getTitle($Url){
        $str = $this->file_get_contents_curl($Url);
        if(strlen($str)>0){
            preg_match("/\<title\>(.*)\<\/title\>/",$str,$title);
            return $title[1];
        }
    }

   // Get the title through DOM 
    function get_title($url)
        {

            // for HTML5 websites
            libxml_use_internal_errors(true);

            $doc = new \DOMDocument();
            $doc->loadHTML(\file_get_contents($url));

            // find the title
            $titlelist = $doc->getElementsByTagName("title");
            if($titlelist->length > 0){
              return $titlelist->item(0)->nodeValue;
            }else{
                return '0';
            }
        }

}
