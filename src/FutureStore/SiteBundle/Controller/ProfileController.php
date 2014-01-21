<?php
/**
 * Created by PhpStorm.
 * User: johan
 * Date: 1/21/14
 * Time: 5:43 PM
 */
namespace FutureStore\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProfileController extends Controller {
	public function indexAction() {
		return $this->render('FutureStoreSiteBundle:Profile:index.html.twig');
	}
}