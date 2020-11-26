<?php
namespace App\Controller;
use App\Model;
use App\View;

class SignUpAction extends Action
{

	protected \App\Model\Promoter $promoter;
	
	public function createViewOnFail()
	{
		return new \App\View\signUpView($this->context, $this->promoter, $this->messages);
	}

	public function createViewOnSuccess()
	{
		return new \App\View\signUpSuccessView($this->context, []);
	}
	
	public function execute()
	{
		parent::execute();
		$this->executed = true;
		if(!isset($_POST['id']))
		{
			$this->promoter = new \App\Model\Promoter([]);
			$this->success = false;
		}
		else
		{
			$this->promoter = new \App\Model\Promoter($_POST);
			$this->messages = \App\Model\PromoterList::validate($this->promoter);
			$this->validateInput();

			if(empty($this->messages)) 
			{
				try 
				{
					$this->signUp();
					if(empty($this->messages)) 
					{
						\App\Model\PromoterList::save($this->promoter);
						$this->success = true;
					}
				}
				catch (Exception $e) {
					$this->messages[] = 'Fehler beim Speichern';
					$this->messages[] = $e->getMessage();
				}
			}
		}
		
		return $this->success;
		
	}
	
	protected function validateInput()
	{
		if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			$this->messages[] = 'Die E-Mail-Adresse ist nicht gültig.';
		}
		if(($_POST['passwort']??'') != ($_POST['passwort2']??'')) {
			$this->messages[] = 'Die eingegebenen Passwörter sind nicht gleich.';
		}
		// ggf. noch mehr Tests auf schlechte Passwörter durchführen
		if(!empty($_POST['email']) && $_POST['email']==$_POST['passwort']) {
			$this->messages[] = 'Das Passwort darf nicht gleich der E-Mail-Adresse sein.';
		}
		if(!empty($promoter->benutzername) && $promoter->benutzername==$_POST['passwort']) {
			$this->messages[] = 'Das Passwort darf nicht gleich dem Anmeldenamen sein.';
		}
		if(mb_strlen($_POST['passwort']) < 8) {
			$this->messages[] = 'Das eingegebene Passwort ist zu kurz.';
		}
		
		return empty($this->messages);
		
	}
	
	protected function signUp()
	{
		try
		{
			$my_context = $this->context;
			$my_promoter = $this->promoter;
			$auth = new \Delight\Auth\Auth($this->context->database);

			$UserId = $auth->register(
				$_POST['email'], 
				$_POST['passwort'], 
				'', 
				function($selector, $token) use ($my_context, $my_promoter) 
				{
					$empfaenger = $_POST["email"];
					$betreff = "Deine neues Benutzerkonto auf " . $my_context->domain;
					$url = 'http://' . $my_context->domain . '/index.php' . 
						'?action=accountActivate' . 
						'&selector=' . \urlencode($selector) .
						'&token=' . \urlencode($token);
					$nachricht = "Hallo, " . $my_promoter->name . "\r\n" .
						"\r\n" .
						"Du hast Dich erfolgreich auf " . $my_context->domain . " registriert. Bitte aktiviere Dein Konto durch Klick auf folgenden Link:" . "\r\n" .
						$url . "\r\n" .
						"Danach kannst Du Dich mit Deinen Benutzerdaten im Veranstalterbereich anmelden." . "\r\n" .
						"\r\n" .
						"Viel Spaß auf " . $my_context->domain;
					$header = "From: webmaster@". $my_context->domain . "\r\n" .
						"Reply-To: webmaster@" . $my_context->domain . "\r\n" .
						"X-Mailer: PHP/" . phpversion();
					
					if($_SERVER['SERVER_NAME'] == "localhost")
					{
						echo '<a href="' . $url . '">' .$url . '</a>';
					}
					else
					{
						mail($empfaenger, $betreff, $nachricht, $header);
						mail('meunum.4.tomsel@neverbox.com', 'Registrierung erfolgt', $empfaenger . ' wurde registriert.', $header);
					}
				}
			);
			$this->promoter->userId = $UserId;
		}
		catch (\Delight\Auth\InvalidEmailException $e) {
			$this->messages[] = 'Ungültige Email-Adresse';
		}
		catch (\Delight\Auth\InvalidPasswordException $e) {
			$this->messages[] = 'Ungültiges Passwort';
		}
		catch (\Delight\Auth\UserAlreadyExistsException $e) {
			$this->messages[] = 'Der Benutzer existiert bereits';
		}
		catch (\Delight\Auth\TooManyRequestsException $e) {
			$this->messages[] = 'Zu viele Versuche';
		}
		
	}
}