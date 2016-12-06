<?php

namespace AppBundle\Controller\Ajax;

use AppBundle\Entity\UserEvent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

/**
 * @Route("/ajax/bootstrapTable")
 */
class BootstrapTableController extends Controller {
	private $jsonEncoder;

	public function __construct() {
		$this->jsonEncoder = new JsonEncoder();
	}

	/**
	 * @Route("/users.json", name="ajax_bootstrap-table_users", methods="GET")
	 */
	public function listAction(Request $request) {
		$search = $request->get('search', null);
		$sort = $request->get('sort', 'registrationDate');
		$order = $request->get('order', 'desc');
		$offset = $request->get('offset', '');
		$limit = $request->get('limit', '10');

		$em = $this->getDoctrine()->getManager();
		$users = $this->listUsers($em, $search, $sort, $order, $offset, $limit);
		$usersCount = $this->countUsers($em);

		$response = new Response();

		$response->setContent($this->encodeUsersToJson($users, $usersCount));
		$response->setStatusCode(Response::HTTP_OK);

		$response->headers->set('Content-Type', 'application/json');

		return $response;
	}

	private function encodeUsersToJson(array $users, $usersCount)
    {
		$result = array();

		foreach ($users as $user) {
			$birthDate = $user->getBirthDate();
			if (!is_null($birthDate)) {
				$birthDate = $birthDate->format('d/m/Y');
			}

			$registrationDate = $user->getRegistrationDate();
			if (!is_null($registrationDate)) {
				$registrationDate = $registrationDate->format('d/m/Y');
			}

			$result[] = array(
				'name' => $user->getName(),
				'surname' => $user->getSurname(),
                'email' => $user->getEmail(),
                'birthDate' => $birthDate,
				'phone' => $user->getPhoneNumber(),
                'city' => $user->getCityName(),
				'address' => $user->getStreetName().' '.$user->getStreetNumber(),
                'zipCode' => $user->getZipCode(),
                'country' => $user->getCountryName(),
                'region' => $user->getCountryRegion(),
                'taxCode' => $user->getTaxCode(),
                'registrationDate' => $registrationDate,
                'enabled' =>
					'<span class="tag tag-table tag-'.
					($user->isEnabled() ? 'success' : 'dark').
					'">'.
					($user->isEnabled() ? 'Active' : 'Inactive').
					'</span>',
                'op' =>
					'<a href="'.($this->generateUrl('userView', array('id'=>$user->getId()))).'" class="btn btn-sm btn-icon btn-raised btn-default waves-effect" data-toggle="tooltip" data-original-title="View user">'.
            			'<i class="icon md-eye" aria-hidden="true"></i>'.
					'</a> '.
					'<button type="button" class="btn btn-sm btn-icon btn-raised btn-danger waves-effect" data-toggle="tooltip" data-original-title="Delete user">'.
						'<i class="icon md-delete" aria-hidden="true"></i>'.
					'</button>'
			);
		}

		$result = array(
			'total' => $usersCount,
			'rows' => $result  
		);
        
        return $this->jsonEncoder->encode($result, $format = 'json');
    }

	private function listUsers($em, $search, $sort, $order, $offset, $limit) {
		$qb = $em->createQueryBuilder();

		$qb->select('u');
		$qb->from('AppBundle:User', 'u');

		if (!empty($search)) {
			$qb->where('u.name like :search or u.surname like :search');
			$qb->setParameter('search', '%'.$search.'%');
		}

		$qb->setFirstResult($offset);
		$qb->setMaxResults($limit);

		$qb->orderBy('u.'.$sort, $order);

		return $qb->getQuery()->getResult();
	}

	private function countUsers($em) {
		$qb = $em->createQueryBuilder();

		$qb->select('count(u)');
		$qb->from('AppBundle:User', 'u');

		return $qb->getQuery()->getSingleScalarResult();
	}
}
