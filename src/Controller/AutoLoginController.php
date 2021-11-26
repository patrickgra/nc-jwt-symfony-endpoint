<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AutoLoginController extends AbstractController {

	/**
	 * @Route("/nextcloud/auto-login", name="nextcloud.auto_login", methods={"GET"})
	 */
	public function autoLogin(Request $request,\App\Helper\JwtAuthTokenGenerator $jwtAuthTokenGenerator): RedirectResponse {
		// This is the relative Nextcloud URL that the user wants to go to.
		$targetPath = (string) $request->query->get('targetPath', '/');

		$targetPathSanitized = \filter_var($targetPath, \FILTER_SANITIZE_URL);
		if ($targetPathSanitized === false) {
			$targetPath = '/';
		} else {
			$targetPath = $targetPathSanitized;
		}

		/** @var \App\UserBundle\Entity\User|null $user 
		$user = $this->getUser();

		if ($user === null) {
			// User not logged into our system.
			// Let's start a login flow, which would lead us back here.
			return $this->redirectToRoute('user.login', [
				'next' => $this->generateUrl('nextcloud.auto_login', [
					'targetPath' => $targetPath,
				]),
			]);
		}

		$userId = $user->getNextcloudUserId();**/
		$userId = 'patrick';

		// This controlls how long the JWT token would be valid.
		// Both your systems' clocks need to be in sync with a deviation of not more
		// than the specified number of seconds.
		$leewaySeconds = 10;

		$token = $jwtAuthTokenGenerator->generateTokenForUserId($userId, $leewaySeconds);

		$redirectUrl = sprintf(
			'http://192.168.0.15/index.html/apps/jwtauth/?token=%s&targetPath=%s',
			urlencode($token),
			urlencode($targetPath)
		);

		return $this->redirect($redirectUrl);
	}

}
