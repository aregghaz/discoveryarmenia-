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

use Config\UserBundle\Form\Type\RegistrationFormType;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContext;

class SecurityController extends ContainerAware
{
    public function loginAction()
    {
        $form = $this->container->get('fos_user.registration.form');
        //$form = $this->createForm(new RegistrationFormType());
        $request = $this->container->get('request');
        /* @var $request \Symfony\Component\HttpFoundation\Request */
        $session = $request->getSession();
        /* @var $session \Symfony\Component\HttpFoundation\Session\Session */

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } elseif (null !== $session && $session->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = '';
        }

        if ($error) {
            // TODO: this is a potential security risk (see http://trac.symfony-project.org/ticket/9523)
            $error = $error->getMessage();
        }
        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get(SecurityContext::LAST_USERNAME);

        $csrfToken = $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate');

        return $this->renderLogin(array(
            'last_username' => $lastUsername,
            'error'         => $error,
            'csrf_token' => $csrfToken,
            'email' => '',
            'form' => $form->createView(),
        ));
    }

    /**
     * Renders the login template with the given parameters. Overwrite this function in
     * an extended controller to provide additional data for the login template.
     *
     * @param array $data
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderLogin(array $data)
    {
        $template = sprintf('ConfigUserBundle:Security:login.html.%s', $this->container->getParameter('fos_user.template.engine'));

        return $this->container->get('templating')->renderResponse($template, $data);
    }

    public function checkAction()
    {
        throw new \RuntimeException('You must configure the check path to be handled by the firewall using form_login in your security firewall configuration.');
    }

    public function logoutAction()
    {
        throw new \RuntimeException('You must activate the logout in your security firewall configuration.');
    }

    public function activateAction($code)
    {
        $em = $this->container->get('doctrine')->getManager();

        $user = $em->getRepository('ConfigUserBundle:User')->findOneByCode($code);

        if (!$user)
        {
            $twig = $this->container->get('templating');

            $content = $twig->render('TravelMainBundle:Exception:wrongUser.html.twig');

            return new Response($content, 404, array('Content-Type', 'text/html'));
        }
        else
        {
            $user->setEnabled(true);
            $user->setCode('');
            $em->persist($user);
            $em->flush();

            $email = $user->getEmail();
            $csrfToken = $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate');
            return $this->renderLogin(array(
                'email' => $email,
                'csrf_token' => $csrfToken,
                'error'         => '',
            ));
        }
    }
}
