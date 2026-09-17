<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class SessionEnd implements FilterInterface
{
	public function before(RequestInterface $request, $arguments = null)
	{
		// Start session
		$session = session();

		// Redirect if user is not logged in
		if (!$session->has('user'))
		{
			return redirect()->to('/Login');
		}

		// Get timestamp of last activity
		$lastActivity = $session->get('last_activity');

		// If inactive for more than 5 minutes, destroy session and redirect
		if ($lastActivity && (time() - $lastActivity > 300))
		{
			$session->destroy();
			return redirect()->to('/Login');
		}

		// Update activity timestamp
		$session->set('last_activity', time());
	}



	public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
	{
		// No post-processing needed
	}
}
