<?php
class site_controller
{
	public function logout()
	{
		unset($_SESSION[constant("cAppKey")]);
		basic_redir($GLOBALS["home_url"]);
	}

	public static function check_login()
	{
		return isset($_SESSION[constant("cAppKey")]["credential"]["idx"]) && (int)$_SESSION[constant("cAppKey")]["credential"]["idx"] > 0;
	}

	public function display($info)
	{
		$vueController = 'app';
		include(constant("cRootServer") . "ui/common/head.php");
		include(constant("cRootServer") . "ui/common/header.php");
		include(constant("cRootServer") . "ui/page/home.php");
		include(constant("cRootServer") . "ui/common/footer.php");
		include(constant("cRootServer") . "ui/common/foot.php");
	}

	public function register($info)
	{
		$vueController = 'register';
		include(constant("cRootServer") . "ui/common/head.php");
		include(constant("cRootServer") . "ui/common/header.php");
		include(constant("cRootServer") . "ui/page/register.php");
		include(constant("cRootServer") . "ui/common/footer.php");
		include(constant("cRootServer") . "ui/common/foot.php");
	}

	public function save($info)
	{

		$user = new users_model();
		$user->populate($info["post"]);
		$result = $user->save();
		$lastId = $user->lastId();

		print_pre($lastId, true);

		header('Content-Type: application/json');

		if ($result instanceof PDOStatement) {
			
			echo json_encode([
				"success" => true,
				"message" => "Usuário cadastrado com sucesso!",
				"id" => $lastId
			]);
		} else {
			http_response_code(500);
			echo json_encode([
				"success" => false,
				"message" => "Erro ao cadastrar usuário."
			]);
		}
		exit;
	}
}
