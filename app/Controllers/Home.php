<?php namespace App\Controllers;
use Config\Services;
class Home extends BaseController
{

	
	public function index()
	{
		// dd(session());
		return view('home');
	}

	
	public function showLoginForm()
	{
		return view('login');
	}


	public function showRegisterForm()
	{
		return view('register');
	}


	public function showSendResetPasswordForm()
	{
		return view('forgetPassword');
	}


	public function showResetPasswordForm()
	{
		return view('resetPassword');
	}

	//--------------------------------------------------------------------

}
