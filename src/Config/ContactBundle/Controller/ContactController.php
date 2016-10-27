<?php

namespace Config\ContactBundle\Controller;


use Config\MediaBundle\Entity\Translations\MediaTranslations;
use Config\MediaBundle\Lib\FileManager;
use Config\MediaBundle\Model\File;
//use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sonata\AdminBundle\Exception\ModelManagerException;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;


class ContactController extends Controller
{
    const TEMPLATE = 'ConfigContactBundle:Template:';

    protected function rpHash($value) {
        $hash = 5381;
        $value = strtolower($value);


        //$hash = md5($value);
        for($i = 0; $i < strlen($value); $i++) {
          //  $hash = (($hash << 5) + $hash) + ord(substr($value, $i));
            $hash .=  ord(substr($value, $i));
        }

        return md5($hash);
    }

    public function sendMailAction(Request $request,$hash){

        $session = $this->get('session');
        $token = $session->get('_token_form');
        $em = $this->getDoctrine()->getManager();
        $captcha = $request->request->get('captchaHash');
        $salt = $this->rpHash($request->request->get('captcha'));


        if(isset($hash) && !empty($hash) && $token === $hash && $captcha == $salt){
            if ($request->isMethod('POST')) {
                $formId = $request->request->get('_token');
                $form = $em->getRepository('ConfigContactBundle:Form')->getContactForm($formId);




                $to = $form->getTo(true);
                $messages = $form->getMessage();

                $all = $request->request->all();
                unset($all[$token]['send']);

                $parameters = $all[$token];
                $cnt = 0;

                foreach ($parameters as $key => $parameter){
                    $cnt++;
                    $pattern = '/{'.$key.'}/';
                    $fromString = $form->getFrom();
                    $subjectString = $form->getSubject();
                    $fromResult = preg_replace($pattern,$parameter,$fromString);
                    $subjectResult = preg_replace($pattern,$parameter,$subjectString);
                    if($fromString !== $fromResult){
                        $from = $fromResult;
                    }
                    if($subjectString !== $subjectResult){
                        $subject = $subjectResult;
                    }
                    else{
                        $subject = $subjectResult;
                    }

                    if($cnt <=1){
                        $string = $messages;
                        $result = preg_replace($pattern,$parameter,$string);
                    }
                    else{
                        $string = preg_replace($pattern,$parameter,$result);
                        $result = preg_replace($pattern,$parameter,$string);

                    }
                }
                $html = $form->getHtml();
               
                $message = \Swift_Message::newInstance()
                    ->setSubject($subject)
                    ->setFrom($from)
                    ->setTo($to);
                    /*if($form->getTemplate()){
                        $message->setBody(
                            $this->renderView(
                                self::TEMPLATE.$form->getTemplate()->getName().'.html.twig',
                                $parameters
                            ),
                            'text/html'
                        );
                    }
                    else{*/
                        if($html){
                            $message->setBody(
                                $result,
                                'text/html'
                            );
                        }
                        else{
                            $message->setBody($result);
                        }
                   // }

                $this->get('mailer')->send($message);

                $request->getSession()->getFlashBag()->add('success-send', 'mail_send');
                $session->remove('_token_form');
                return $this->redirect($this->container->get('request')->headers->get('referer'));
            }
            $session->remove('_token_form');
        }
        else{
            $session->remove('_token_form');
            $request->getSession()->getFlashBag()->add('error-send', 'mail_error');
            return $this->redirect($request->headers->get('referer'));
        }
    }
}