<?php
namespace controllers;

use models\Fortune;
use Ubiquity\orm\DAO;

class SwooleFortunes extends \Ubiquity\controllers\Controller {

	public function index() {
		$dbInstance=DAO::pool('swoole');
		$fortunes = DAO::getAll(Fortune::class, '', false);
		$fortunes[] = (new Fortune())->setId(0)->setMessage('Additional fortune added at request time.');
		\usort($fortunes, function ($left, $right) {
			return $left->message <=> $right->message;
		});
		DAO::freePool($dbInstance);
		$this->loadView('Fortunes/index.php', [
			'fortunes' => $fortunes
		]);
	}
}
