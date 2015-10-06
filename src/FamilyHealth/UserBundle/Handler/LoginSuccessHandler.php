<?php

namespace FamilyHealth\UserBundle\Handler;


use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;


class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface{


    protected $router;
    protected $security;

    public function __construct(Router $router, AuthorizationCheckerInterface $authorizationCheckerInterface)
    {
        $this->router = $router;
        $this->security = $authorizationCheckerInterface;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token){

//        die('on auth success');

        $url = $request->headers->get('referer');

        if ($this->security->isGranted('ROLE_SUPER_ADMIN') or $this->security->isGranted('ROLE_ADMIN'))
        {
            $response = new RedirectResponse($this->router->generate('family_health_admin_dashboard'));
            $url = $this->router->generate('family_health_admin_dashboard');
        }elseif ($this->security->isGranted('ROLE_MEMBER'))
        {
            // redirect the user to where they were before the login process begun.
//            $referer_url = $request->headers->get('referer');
            $referer_url = $this->router->generate('family_health_member_homepage');
            $url = $referer_url;

            $response = new RedirectResponse($referer_url);
        }
        else{
            $response = new RedirectResponse($this->router->generate('fos_user_security_logout'));
            $url = $this->router->generate('fos_user_security_logout');
        }

        if ($request->isXmlHttpRequest()) {
            $result = array('success' => true,'redirectUrl' => $url);
            $response = new Response(json_encode($result));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }else{
            return $response;
        }

    }

//    public function onAuthenticationFailure(Request $request, AuthenticationException $exception) {
//
//        $result['test'] = 'auth failure';
//        if ($request->isXmlHttpRequest()) {
//            $result = array('success' => false, 'message' => $exception->getMessage());
//            $response = new Response(json_encode($result));
//            $response->headers->set('Content-Type', 'application/json');
//            return $response;
//        }
//        return new Response();
//    }
}