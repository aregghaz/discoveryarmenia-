<?php
namespace Config\ContactBundle\Twig;

use Twig_Extension;
use Twig_Filter_Method;
use Twig_SimpleFilter;
use Twig_SimpleFunction;
use Symfony\Component\DependencyInjection\ContainerInterface;


class ContactExtension extends Twig_Extension
{
    protected $container;

    public function __construct(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function getFunctions()
    {
        return array(
            new Twig_SimpleFunction("contactForm", array($this, "contactForm"),array('is_safe' => array('html'))),
        );
    }
    public function contactForm($contactFormId) {
        $em = $this->container->get('doctrine')->getManager();
        $session = $this->container->get('session');
        $token = uniqid();
        $session->set('_token_form',$token);

        $form = $em->getRepository('ConfigContactBundle:Form')->getContactForm($contactFormId);
        $inputs = $form->getInput();
        // generate inputs
        $rout = $this->container->get('router')->generate('sonata_admin_send_mail', array('hash' => $token));
        $groupClass = $form->getGroupClass();
        $inputClass = $form->getInputClass();
        $output = '<form role="form" action="'.$rout.'" method="post" novalidate>';
        
        foreach ($inputs as $input){
            $output .= '<div class="'.$groupClass.' clear">';
            if($input->getLabel()){
                $output .= '<label>'.$input->getLabel().'</label>';
            }
            switch ($input->getType()){
                case 'textarea':
                    $output .= '<textarea 
                                    class="'.$inputClass.'"
                                    placeholder="'.$input->getPlaceHolder().'" 
                                    id="'.$token.'_form" type="'.$input->getType().'" 
                                    name="'.$token.'['.$input->getName().']'.'"
                    ></textarea>';
                    break;
                case 'captcha':
                    $output .= '
                                  
                                    <input  class="'.$inputClass.'"
                                                id="'.$token.'_form" 
                                                name="'.$input->getType().'" 
                                                type="text" 
                                                placeholder="'.$input->getPlaceHolder().'"
                                            >
                                   ';
                    break;
                default:
                    $output .= '<input  
                                    class="'.$inputClass.'"
                                    placeholder="'.$input->getPlaceHolder().'" 
                                    id="'.$token.'_form" type="'.$input->getType().'" 
                                    name="'.$token.'['.$input->getName().']'.'">';
                    break;
            }


            $output .= '</div>';
        }
        $output .= '<div class="form_group"><input type="submit" name="'.$token.'[send]'.'"></div>';
        $output .= '<input type="hidden" name="_token" value="'.$contactFormId.'"></form>';

        return $output;
        /*var_dump(dump($output));
        exit;*/
    }

    public function getName()
    {
        return 'contact_extension';
    }
}