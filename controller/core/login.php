<?php

defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Core_Login extends Controller {

	public function action_login()
	{
		if ($this->request->method() == Request::POST)
		{
			$post = Validation::factory($this->request->post())
					->rule('username', 'not_empty')
					->rule('username', 'alpha_numeric', array(':value', TRUE))
					->rule('password', 'not_empty');

			if (!is_null($this->request->post('remember')))
			{
				$post->rule('remember', 'not_empty')
						->rule('remember', 'equals', array(':value', 'on'));
			}

			if ($post->check())
			{
				if (Auth::instance()->login($this->request->post('username'), $this->request->post('password'), $this->request->post('remember')))
				{
					echo 'Logged in as : ' . Auth::instance()->get_user()->username;
				}
				else
				{
					echo 'those data are incorrect';
				}
			}
			else
			{
				$errors = $post->errors('');
			}
		}
	}

	public function action_logout()
	{
		Auth::instance()->logout(TRUE);
		$this->request->redirect('/welcome/login');
	}

}
