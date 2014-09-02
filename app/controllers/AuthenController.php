<?php

define('CONSUMER_KEY', 'fXAK07nMftpQTmKFYjxkyHHSi');
define('CONSUMER_SECRET', 'CUqVpKp5XwzB1GCQUAmjz2F8v2GxQRbY5zQkUNfpfCZQD1achR');
define('OAUTH_CALLBACK', 'http://ghost.dev/index.php/callback');

require(__DIR__.'/../helpers/twitteroauth/twitteroauth.php');
class AuthenController extends BaseController {


	public function getLoginwithTwitter()
	{
		session_start();
		$twitteroauth = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
		// Requesting authentication tokens, the parameter is the URL we will be redirected to
		$request_token = $twitteroauth->getRequestToken(OAUTH_CALLBACK);

		$_SESSION['oauth_token'] = $request_token['oauth_token'];
		$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

		if($twitteroauth->http_code==200){
			$url = $twitteroauth->getAuthorizeURL($request_token['oauth_token']);
			return Redirect::away ( $url );
		} else {
			Throw new CHttpException("200", "something was wrong");
		}
	}

	public function TwitterCallback()
	{
		session_start();
		/* Create TwitteroAuth object with app key/secret and token key/secret from default phase */
		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);

		/* Request access tokens from twitter */
		$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);

		/* Save the access tokens. Normally these would be saved in a database for future use. */
		$_SESSION['access_token'] = $access_token;

		/* Remove no longer needed request tokens */
		unset($_SESSION['oauth_token']);
		unset($_SESSION['oauth_token_secret']);
		if (200 == $connection->http_code) {
			/* The user has been verified and the access tokens can be saved for future use */
			$_SESSION['status'] = 'verified';
			return Redirect::to(URL::action('AuthenController@showUserCredentials'));
		} else {
			/* Save HTTP status for error dialog on connnect page.*/
			Throw new CHttpException("200", "something was wrong");
		}
	}

	public function showUserCredentials()
	{
		session_start();
		$access_token = $_SESSION['access_token'];

		/* Create a TwitterOauth object with consumer/user tokens. */
		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

		/* If method is set change API call made. Test is called by default. */
		$content = $connection->get('account/verify_credentials');

		var_dump($content);
		return;
	}
}
