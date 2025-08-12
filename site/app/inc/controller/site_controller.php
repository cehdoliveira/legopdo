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
		$return = $user->save();

		print_pre("Idx: " . $return, true);

		header('Content-Type: application/json');

		if ($return instanceof PDOStatement) {
			echo json_encode([
				"success" => true,
				"message" => "Usuário cadastrado com sucesso!"
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

	public function list_users($info)
	{
		$users = new users_model();
		$users->set_filter(array("active = 'yes'"));
		$users->load_data();
		$data = $users->data;

		header('Content-Type: application/json');
		echo json_encode([
			"data" => $data,
			"message" => "Usuários listados com sucesso!"
		]);
		exit;
	}
}
