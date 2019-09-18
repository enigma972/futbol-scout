<?php 
namespace App\Utils;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
/**
 * 
 */
class RedirectIfIsLogin
{
	protected $token;
	protected $urlGenerator;
	
	public function __construct(TokenStorageInterface $token, UrlGeneratorInterface $urlGenerator)
	{
		$this->token = $token->getToken();
		$this->urlGenerator = $urlGenerator;
	}

	public function redirect()
	{
		if ($this->token->getUser()) {
			return new RedirectResponse($this->urlGenerator->generate('home'));
		}
	}
}