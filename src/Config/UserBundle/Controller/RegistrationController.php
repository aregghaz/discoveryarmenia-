<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Config\UserBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\AccountStatusException;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Security\Core\SecurityContext;
/**
 * Overriding Registration controller from FosUserBundle
 *
 * Class Registration
 * @package Config\UserBundle\Controller
 */
class RegistrationController extends ContainerAware

{
    public function registerAction()
    {
        $em = $this->container->get('doctrine')->getEntityManager();

        $form = $this->container->get('fos_user.registration.form');
        $formHandler = $this->container->get('fos_user.registration.form.handler');
        $confirmationEnabled = $this->container->getParameter('fos_user.registration.confirmation.enabled');
        $request = $this->container->get('request');
        /* @var $request \Symfony\Component\HttpFoundation\Request */
        $session = $request->getSession();
        /* @var $session \Symfony\Component\HttpFoundation\Session\Session */
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } elseif (null !== $session && $session->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = '';
        }
        $process = $formHandler->process($confirmationEnabled);
        if ($process) {
            $user = $form->getData();

            $code = md5(uniqid(rand(), true));

          
            $user->setEnabled(false);
            $user->setCode($code);
            $em->persist($user);
            $em->flush();

            $username = $form->getData()->getUsername();

            $subject = 'Registration Activation';
            $email = 'bayazetyan@gmail.com';
            $the_message = 'iYerevan account <br /><br />
                            Dear '.$username.', <br />
                            To finish setting up this iYerevan account, you just need to verify your Account. <br />
                            <a href="http://www.iyerevan.am/am/activate/'.$code.'">Verify “'.$username.'” account</a> <br /><br />
                            Thanks, The iYerevan administration. <br /><br /><br />

                            iYerevan էլեկտրոնային հաշիվ <br /><br />
                            Հարգելի '.$username.', <br />
                            Որպեսզի ավարտեք iYerevan հաշվի գրանցումը, պարզապես անհրաժեշտ է հաստատել Ձեր հաշիվը: <br />
                            <a href="http://www.iyerevan.am/am/activate/'.$code.'">Հաստատել “'.$username.'” հաշիվը</a> <br /><br />
                            Շնորհակալություն, iYerevan.am ադմինիստրացիա:
                            ';
            $recipient = $user->getEmail();

            $message = \Swift_Message::newInstance()
                ->setSubject($subject)
                ->setFrom($email)
                ->setTo($recipient)
                ->setContentType('text/html')
                ->setBody($the_message);

            $this->container->get('mailer')->send($message);

            $name = $user->getUsername();

            return $this->container->get('templating')->renderResponse('ConfigUserBundle:Registration:email.html.twig', array('name' => $name));
        }

        return $this->container->get('templating')->renderResponse('ConfigUserBundle:Registration:register.html.'.$this->getEngine(), array(
            'form' => $form->createView(),'error'         => $error,
        ));
    }

    /**
     * Tell the user to check his email provider
     */
    public function checkEmailAction()
    {
        $email = $this->container->get('session')->get('fos_user_send_confirmation_email/email');
        $this->container->get('session')->remove('fos_user_send_confirmation_email/email');
        $user = $this->container->get('fos_user.user_manager')->findUserByEmail($email);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with email "%s" does not exist', $email));
        }

        return $this->container->get('templating')->renderResponse('FOSUserBundle:Registration:checkEmail.html.'.$this->getEngine(), array(
            'user' => $user,
        ));
    }

    /**
     * Receive the confirmation token from user email provider, login the user
     */
    public function confirmAction($token)
    {
        $user = $this->container->get('fos_user.user_manager')->findUserByConfirmationToken($token);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with confirmation token "%s" does not exist', $token));
        }

        $user->setConfirmationToken(null);
        $user->setEnabled(true);
        $user->setLastLogin(new \DateTime());

        $this->container->get('fos_user.user_manager')->updateUser($user);
        $response = new RedirectResponse($this->container->get('router')->generate('fos_user_registration_confirmed'));
        $this->authenticateUser($user, $response);

        return $response;
    }

    /**
     * Tell the user his account is now confirmed
     */
    public function confirmedAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        return $this->container->get('templating')->renderResponse('FOSUserBundle:Registration:confirmed.html.'.$this->getEngine(), array(
            'user' => $user,
        ));
    }

    /**
     * Authenticate a user with Symfony Security
     *
     * @param \FOS\UserBundle\Model\UserInterface        $user
     * @param \Symfony\Component\HttpFoundation\Response $response
     */
    protected function authenticateUser(UserInterface $user, Response $response)
    {
        try {
            $this->container->get('fos_user.security.login_manager')->loginUser(
                $this->container->getParameter('fos_user.firewall_name'),
                $user,
                $response);
        } catch (AccountStatusException $ex) {
            // We simply do not authenticate users which do not pass the user
            // checker (not enabled, expired, etc.).
        }
    }

    /**
     * @param string $action
     * @param string $value
     */
    protected function setFlash($action, $value)
    {
        $this->container->get('session')->getFlashBag()->set($action, $value);
    }

    protected function getEngine()
    {
        return $this->container->getParameter('fos_user.template.engine');
    }
}
