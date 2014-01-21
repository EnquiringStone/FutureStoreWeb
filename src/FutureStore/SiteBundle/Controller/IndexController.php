<?php
/**
 * Created by PhpStorm.
 * User: johan
 * Date: 1/21/14
 * Time: 5:16 PM
 */
namespace FutureStore\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexController extends Controller {
	public function indexAction() {
		return $this->render('FutureStoreSiteBundle:Index:index.html.twig');
	}
}