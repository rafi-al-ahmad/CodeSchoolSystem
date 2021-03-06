<?php

namespace App\Controllers;

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: POST,GET, OPTIONS");
header("Access-Control-Allow-Headers: *");

use CodeIgniter\API\ResponseTrait;
use App\Models\MessaingModel;
use App\Models\UserModel;
use App\Models\StudentsModel;
use App\Models\TeachersModel;
use App\Models\EmployeeModel;
use CodeIgniter\HTTP\RequestInterface;
use App\Controllers\Check;
use App\Models\CoursesModel;
use App\Models\MessaingModelExtends;
use App\Models\SchoolModel;
use App\Models\TemplateModel;

class Messaging extends BaseController
{
	use ResponseTrait;
	public function MailArchive()
	{

		if ($this->request->getMethod() == 'get') {
			$check = new Check(); // Create an instance
			$result = $check->check();

			if ($result['code'] == 1) {
				$key = $this->request->getVar('key');
				$page = $this->request->getVar('page');

				$limit = $this->request->getVar('limit');
				if (empty($key) || $key != 'all') {
					if (!$page) {
						$result = array('code' => -1, 'msg' => 'الرجاء إدخال حقل الصفحة ');
						return $this->respond($result, 400);
						exit;
					}
					if (!$limit) {
						$result = array('code' => -1, 'msg' => 'الرجاء إدخال حقل عدد العناصر ');
						return $this->respond($result, 400);
						exit;
					}
				}
				$model = new MessaingModel();
				$result = $model->MailArhive($limit, $page, $key);
				if (!empty($result)) {
					$data = array('code' => 1, 'msg' => 'success', 'data' => $result);
					return	$this->respond($data, 200);
				} else {
					$data = array('code' => 1, 'msg' => 'no data found', 'data' => []);
					return	$this->respond($data, 200);
				}
			} else {
				$result = array(
					'code' => $result['code'], 'msg' => $result['messages'],
				);
				return $this->respond($result, 400);
			}
		} else {
			$data = array('code' => -1, 'msg' => 'Method must be GET', 'data' => []);
			return	$this->respond($data, 200);
		}
	}
	public function SendGeneralMail()
	{

		if ($this->request->getMethod() == 'post') {
			$check = new Check(); // Create an instance
			$result = $check->check();

			if ($result['code'] == 1) {
				$model = new MessaingModel();
				$user = new UserModel();
				$school_id = $this->request->getVar('school_id');
				$template_id = $this->request->getVar('template_id');
				$group = $this->request->getVar('group');
				if (!$school_id) {
					$result = array('code' => -1, 'msg' => 'الرجاء إدخال حقل المدرسة ');
					return $this->respond($result, 400);
					exit;
				}
				if (!$template_id) {
					$result = array('code' => -1, 'msg' => 'الرجاء إدخال حقل القالب ');
					return $this->respond($result, 400);
					exit;
				}
				if (!$group) {
					$result = array('code' => -1, 'msg' => 'الرجاء إدخال حقل المجموعة ');
					return $this->respond($result, 400);
					exit;
				}
				$school = $user->get_user_role($school_id);
				if ($school->role != 2) {
					$result = array('code' => -1, 'msg' => 'الرجاء إدخال مستخدم مدرسة  ');
					return $this->respond($result, 400);
					exit;
				}
				if ($group == 1 || $group == 2 || $group == 3) {
					$data = array('school_id' => $school_id, 'sender_type' => $group, 'template_id' => $template_id);

					if ($model->add_general_email($data)) {
						$data = array('code' => 1, 'msg' => 'success', 'data' => []);
						return	$this->respond($data, 200);
					} else {
						$data = array('code' => 1, 'msg' => 'no data found', 'data' => []);
						return	$this->respond($data, 200);
					}
				} else {
					$result = array('code' => -1, 'msg' => 'الرجاء إدخال مجموعة صحيحة  ');
					return $this->respond($result, 400);
					exit;
				}
			} else {
				$result = array(
					'code' => $result['code'], 'msg' => $result['messages'],
				);
				return $this->respond($result, 400);
			}
		} else {
			$data = array('code' => -1, 'msg' => 'Method must be POST', 'data' => []);
			return	$this->respond($data, 200);
		}
	}
	public function GetGeneralMessage()
	{

		if ($this->request->getMethod() == 'get') {
			$check = new Check(); // Create an instance
			$result = $check->check();

			if ($result['code'] == 1) {
				$school_id = $this->request->getVar('school_id');

				$group = $this->request->getVar('group');
				if (!$school_id) {
					$result = array('code' => -1, 'msg' => 'الرجاء إدخال حقل المدرسة ');
					return $this->respond($result, 400);
					exit;
				}
				if (!$group) {
					$result = array('code' => -1, 'msg' => 'الرجاء إدخال حقل المجموعة ');
					return $this->respond($result, 400);
					exit;
				}
				$page = $this->request->getVar('page');

				$limit = $this->request->getVar('limit');
				$key = $this->request->getVar('key');
				if (empty($key) || $key != 'all') {
					if (!$page) {
						$result = array('code' => -1, 'msg' => 'الرجاء إدخال حقل الصفحة ');
						return $this->respond($result, 400);
						exit;
					}
					if (!$limit) {
						$result = array('code' => -1, 'msg' => 'الرجاء إدخال حقل عدد العناصر ');
						return $this->respond($result, 400);
						exit;
					}
				}
				if ($group == 1 || $group == 2 || $group == 3) {
					if ($group == 1) {
						$model = new StudentsModel();
						$result = $model->get_students($school_id, $limit, $page, $key);
						$data = array('code' => 1, 'msg' => 'success', 'data' => $result, 'total_count' => count($result));
						return	$this->respond($data, 200);
					}
					if ($group == 2) {
						$model = new TeachersModel();
						$result = $model->get_teachers($school_id, $limit, $page, $key);
						$data = array('code' => 1, 'msg' => 'success', 'data' => $result, 'total_count' => count($result));
						return	$this->respond($data, 200);
					}
					if ($group == 3) {
						$model = new EmployeeModel();
						$result = $model->get_employee($school_id, $limit, $page, $key);
						$data = array('code' => 1, 'msg' => 'success', 'data' => $result, 'total_count' => count($result));
						return	$this->respond($data, 200);
					} else {
						$data = array('code' => 1, 'msg' => 'no datat found', 'data' => []);
						return	$this->respond($data, 200);
					}
				} else {
					$result = array('code' => -1, 'msg' => 'الرجاء إدخال مجموعة صحيحة  ');
					return $this->respond($result, 400);
					exit;
				}
			} else {
				$result = array(
					'code' => $result['code'], 'msg' => $result['messages'],
				);
				return $this->respond($result, 400);
			}
		} else {
			$data = array('code' => -1, 'msg' => 'Method must be GET', 'data' => []);
			return	$this->respond($data, 200);
		}
	}
	public function GetArchiveGeneralMessage()
	{
		if ($this->request->getMethod() == 'get') {
			$check = new Check(); // Create an instance
			$result = $check->check();

			if ($result['code'] == 1) {
				$school_id = $this->request->getVar('school_id');

				$group = $this->request->getVar('group');
				$date = $this->request->getVar('date');

				if (!$school_id) {
					$result = array('code' => -1, 'msg' => 'الرجاء إدخال حقل المدرسة ');
					return $this->respond($result, 400);
					exit;
				}
				if (!$group) {
					$result = array('code' => -1, 'msg' => 'الرجاء إدخال حقل المجموعة ');
					return $this->respond($result, 400);
					exit;
				}
				$page = $this->request->getVar('page');

				$limit = $this->request->getVar('limit');
				$key = $this->request->getVar('key');
				if (empty($key) || $key != 'all') {
					if (!$page) {
						$result = array('code' => -1, 'msg' => 'الرجاء إدخال حقل الصفحة ');
						return $this->respond($result, 400);
						exit;
					}
					if (!$limit) {
						$result = array('code' => -1, 'msg' => 'الرجاء إدخال حقل عدد العناصر ');
						return $this->respond($result, 400);
						exit;
					}
				}
				if ($group == 1 || $group == 2 || $group == 3) {
					$model = new MessaingModel();
					if ($group == 1) {

						$result = $model->get_archive_message_students($school_id, $date, $limit, $page, $key);
						$data = array('code' => 1, 'msg' => 'success', 'data' => $result, 'total_count' => count($result));
						return	$this->respond($data, 200);
					}
					if ($group == 2) {

						$result = $model->get_archive_message_teacher($school_id, $date, $limit, $page, $key);
						$data = array('code' => 1, 'msg' => 'success', 'data' => $result, 'total_count' => count($result));
						return	$this->respond($data, 200);
					}
					if ($group == 3) {
						// 	$model=new EmployeeModel();
						$result = $model->get_archive_message_employee($school_id, $date, $limit, $page, $key);
						$data = array('code' => 1, 'msg' => 'success', 'data' => $result, 'total_count' => count($result));
						return	$this->respond($data, 200);
					} else {
						$data = array('code' => 1, 'msg' => 'no datat found', 'data' => []);
						return	$this->respond($data, 200);
					}
				} else {
					$result = array('code' => -1, 'msg' => 'الرجاء إدخال مجموعة صحيحة  ');
					return $this->respond($result, 400);
					exit;
				}
			} else {
				$result = array(
					'code' => $result['code'], 'msg' => $result['messages'],
				);
				return $this->respond($result, 400);
			}
		} else {
			$data = array('code' => -1, 'msg' => 'Method must be GET', 'data' => []);
			return	$this->respond($data, 200);
		}
	}




	public function getGeneralMessageArchive()
	{
		if ($this->request->getMethod() == 'get') {
			$check = new Check(); // Create an instance
			$result = $check->check();

			if ($result['code'] == 1) {
				$school_id = $this->request->getVar('school_id');

				$group = $this->request->getVar('group');
				$date = $this->request->getVar('date');

				if (!$school_id) {
					$result = array('code' => -1, 'msg' => 'الرجاء إدخال حقل المدرسة ');
					return $this->respond($result, 400);
					exit;
				}
				if (!$group) {
					$result = array('code' => -1, 'msg' => 'الرجاء إدخال حقل المجموعة ');
					return $this->respond($result, 400);
					exit;
				}
				$page = $this->request->getVar('page');

				$limit = $this->request->getVar('limit');
				$key = $this->request->getVar('key');
				if (empty($key) || $key != 'all') {
					if (!$page) {
						$result = array('code' => -1, 'msg' => 'الرجاء إدخال حقل الصفحة ');
						return $this->respond($result, 400);
						exit;
					}
					if (!$limit) {
						$result = array('code' => -1, 'msg' => 'الرجاء إدخال حقل عدد العناصر ');
						return $this->respond($result, 400);
						exit;
					}
				}
				if ($group == 1 || $group == 2 || $group == 3 || $group == 4) {
					$model = new MessaingModelExtends();
					if ($group == 1) {

						$result = $model->get_students_messages_archive($school_id, $date, $limit, $page, $key);
						$data = array('code' => 1, 'msg' => 'success', 'data' => $result, 'total_count' => count($result));
						return	$this->respond($data, 200);
					}
					if ($group == 2) {

						$result = $model->get_teacher_messages_archive($school_id, $date, $limit, $page, $key);
						$data = array('code' => 1, 'msg' => 'success', 'data' => $result, 'total_count' => count($result));
						return	$this->respond($data, 200);
					}
					if ($group == 3) {
						// 	$model=new EmployeeModel();
						$result = $model->get_employee_messages_archive($school_id, $date, $limit, $page, $key);
						$data = array('code' => 1, 'msg' => 'success', 'data' => $result, 'total_count' => count($result));
						return	$this->respond($data, 200);
					} if ($group == 4) {
						// 	$model=new EmployeeModel();
						$result = $model->get_course_students_messages_archive($school_id, $date, $limit, $page, $key);
						$data = array('code' => 1, 'msg' => 'success', 'data' => $result, 'total_count' => count($result));
						return	$this->respond($data, 200);
					} else {
						$data = array('code' => 1, 'msg' => 'no datat found', 'data' => []);
						return	$this->respond($data, 200);
					}
				} else {
					$result = array('code' => -1, 'msg' => 'الرجاء إدخال مجموعة صحيحة  ');
					return $this->respond($result, 400);
					exit;
				}
			} else {
				$result = array(
					'code' => $result['code'], 'msg' => $result['messages'],
				);
				return $this->respond($result, 400);
			}
		} else {
			$data = array('code' => -1, 'msg' => 'Method must be GET', 'data' => []);
			return	$this->respond($data, 200);
		}
	}

	public function SendGeneralMessagesToUsers()
	{
		if ($this->request->getMethod() == 'post') {
			$check = new Check(); // Create an instance
			$result = $check->check();

			if ($result['code'] == 1) {

				$model = new MessaingModelExtends();
				$user = new UserModel();

				$school_id = $this->request->getVar('school_id');
				$template_id = $this->request->getVar('template_id');
				$usersData = $this->request->getVar('usersData');
				$group = $this->request->getVar('group');

				if (!$group) {
					$result = array('code' => -1, 'msg' => 'الرجاء تحديد المجموعة ');
					return $this->respond($result, 400);
					exit;
				}

				if (!$school_id) {
					$result = array('code' => -1, 'msg' => 'الرجاء إدخال حقل المدرسة');
					return $this->respond($result, 400);
					exit;
				}

				if (!$template_id) {
					$result = array('code' => -1, 'msg' => 'الرجاء تحديد القالب');
					return $this->respond($result, 400);
					exit;
				}

				if (!$usersData) {
					$result = array('code' => -1, 'msg' => 'الرجاء تحديد المستخدمين');
					return $this->respond($result, 400);
					exit;
				}

				$usersData = json_decode($usersData, true);

				$school = $user->get_user_role($school_id);
				if ($school->role != 2) {
					$result = array('code' => -1, 'msg' => 'يجب ان يكون المستخدم مدرسة');
					return $this->respond($result, 400);
					exit;
				}
				$template_modal = new TemplateModel();

				$school_modal = new SchoolModel();

				$template = $template_modal->get_template_by_id($template_id);
				$schoolGate = (new Schools())->getSchoolActiveGateById($school_id)[0];

				$successCount = 0;

				$userType = null;

				if ($group == 1) {
					$userType = 'students';
				} else if ($group == 2) {
					$userType = 'teachers';
				} else if ($group == 3) {
					$userType = 'employees';
				} else if ($group == 4) {
					$userType = 'coursesStudents';
				}


				if ($template != null && $userType != null) {
					foreach ($usersData as $user) {

						if ($user['phone'] == null) {
							continue;
						}
						$message = $template->content;

						$message = str_replace("@STUDENT@", $user['name'], $message);
						$message = str_replace("@DATE@", $user['date'], $message);

						$temp = $model->add_general_message([
							"user_id" => $user['id'],
							"user_type" => $userType,
							"message" => $message,
							"school_id" => $school_id,
						]);


						// add messages to send queue
						$school_modal->add_toSent([
							"user_id" => $user['id'],
							"message" => $message,
							"phone" => $user['phone'],
							"school_id" => $school_id,
							"message_archive_id" => $temp->connID->insert_id,
							"school_gate_id" => $schoolGate->id,
							"type" => 'publicMessage',
						]);

						$successCount++;
					}
				}

				$data = ['code' => 1, 'msg' => 'تم اضافة ' . $successCount . ' عنصر بنجاح. سيتم ارسال الاشعارات باقرب وقت ممكن', 'data' => []];
				return	$this->respond($data, 200);
			} else {
				$result = array(
					'code' => $result['code'], 'msg' => $result['messages'],
				);
				return $this->respond($result, 400);
			}
		} else {
			$data = array('code' => -1, 'msg' => 'Method must be POST', 'data' => []);
			return	$this->respond($data, 200);
		}
	}
	public function SendGeneralMessagesToGroup()
	{
		if ($this->request->getMethod() == 'post') {
			$check = new Check(); // Create an instance
			$result = $check->check();

			if ($result['code'] == 1) {

				$model = new MessaingModelExtends();
				$user = new UserModel();

				$school_id = $this->request->getVar('school_id');
				$template_id = $this->request->getVar('template_id');
				$usersData = $this->request->getVar('usersData');
				$group = $this->request->getVar('group');
				$date = $this->request->getVar('date');

				if (!$group) {
					$result = array('code' => -1, 'msg' => 'الرجاء تحديد المجموعة ');
					return $this->respond($result, 400);
					exit;
				}

				if (!$school_id) {
					$result = array('code' => -1, 'msg' => 'الرجاء إدخال حقل المدرسة');
					return $this->respond($result, 400);
					exit;
				}

				if (!$template_id) {
					$result = array('code' => -1, 'msg' => 'الرجاء تحديد القالب');
					return $this->respond($result, 400);
					exit;
				}


				$school = $user->get_user_role($school_id);
				if ($school->role != 2) {
					$result = array('code' => -1, 'msg' => 'يجب ان يكون المستخدم مدرسة');
					return $this->respond($result, 400);
					exit;
				}
				$template_modal = new TemplateModel();

				$school_modal = new SchoolModel();

				$template = $template_modal->get_template_by_id($template_id);
				$schoolGate = (new Schools())->getSchoolActiveGateById($school_id)[0];
				$successCount = 0;

				$userType = null;

				if ($group == 1) {

					$usersData = (new StudentsModel())->get_students($school_id, 0, 0, "all");
					$userType = 'students';
				} else if ($group == 2) {

					$usersData = (new TeachersModel())->get_teachers($school_id, 0, 0, "all");
					$userType = 'teachers';
				} else if ($group == 3) {

					$usersData = (new EmployeeModel())->get_employee($school_id, 0, 0, "all");
					$userType = 'employees';

				} else if ($group == 4) {
					$usersData = (new CoursesModel())->get_courses($school_id, 0, 0, "all");
					$userType = 'coursesStudents';
				}

				if ($template != null && $userType != null) {
					foreach ($usersData as $user) {

						$message = $template->content;

						if ($userType == 'employees') {
							$message = str_replace("@STUDENT@", $user->name, $message);
						} else if($userType == 'coursesStudents') {
							$message = str_replace("@STUDENT@", $user->student_name, $message);
						} else {
							$message = str_replace("@STUDENT@", $user->full_name, $message);
						}

						if ($user->phone == null) {
							continue;
						}
						
						$message = str_replace("@DATE@", $date, $message);

						$temp = $model->add_general_message([
							"user_id" => $user->id,
							"user_type" => $userType,
							"message" => $message,
							
							"school_id" => $school_id,
						]);

						// add messages to send queue
						$school_modal->add_toSent([
							"user_id" => $user->id,
							"message" => $message,
							"phone" => $user->phone,
							"school_id" => $school_id,
							"message_archive_id" => $temp->connID->insert_id,
							"school_gate_id" => $schoolGate->id,
							"type" => 'publicMessage',
						]);

						$successCount++;
					}
				}

				$data = ['code' => 1, 'msg' => 'تم اضافة ' . $successCount . ' عنصر بنجاح. سيتم ارسال الاشعارات باقرب وقت ممكن', 'data' => []];
				return	$this->respond($data, 200);
			} else {
				$result = array(
					'code' => $result['code'], 'msg' => $result['messages'],
				);
				return $this->respond($result, 400);
			}
		} else {
			$data = array('code' => -1, 'msg' => 'Method must be POST', 'data' => []);
			return	$this->respond($data, 200);
		}
	}
}
