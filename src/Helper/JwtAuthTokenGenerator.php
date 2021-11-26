<?php
namespace App\Helper;

class JwtAuthTokenGenerator {

	/**
	 * @var string
	 */
	private $sharedSecret;

	/**
	 * @var string
	 */
	private $issuer;

	public function __construct() {
		$this->sharedSecret = 'abcDEF12345!';
		$this->issuer = 'Patrick';
	}

	public function generateTokenForUserId(string $userId, int $leewaySeconds): string {
		$timeNow = time();

		$payload = [
			'uid' => $userId,

			'iat' => $timeNow,
			'nbf' => $timeNow - $leewaySeconds,
			'exp' => $timeNow + $leewaySeconds,

			'iss' => $this->issuer,
		];

		return \ReallySimpleJWT\Token::customPayload($payload, $this->sharedSecret);
	}

}
