<?php

readonly class ViewController {

	private const string BASE_PATH = "%s/src/Views/%s.php";

	public function __construct(private string $view) {
	}	
	
	public function call(mixed $data): void
	{
		include_once $this->getBasePath();
	}

	private function getBasePath(): string
	{
		return sprintf(
			self::BASE_PATH,
			$_SERVER["DOCUMENT_ROOT"],
			$this->view
		);
	}
}