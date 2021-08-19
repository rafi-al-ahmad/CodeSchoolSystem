<?php

namespace App\Controllers;

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: POST,GET, OPTIONS");
header("Access-Control-Allow-Headers: *");

use CodeIgniter\API\ResponseTrait;
use App\Models\StudentsModel;
use App\Models\UserModel;
use App\Models\SchoolModel;
use CodeIgniter\HTTP\RequestInterface;
use App\Controllers\Check;

class StudentsExtends extends Students
{
    use ResponseTrait;

    public function AddStudentsFromFile()
    {

        if ($this->request->getMethod() == 'post') {
            $check = new Check(); // Create an instance
            $result = $check->check();

            if ($result['code'] == 1) {

                $school_id = $this->request->getVar('school_id');
                $excelData = $this->request->getVar('excelData');

                if (!$school_id) {
                    $result = array('code' => -1, 'msg' => 'الرجاء إدخال حقل المدرسة ');
                    return $this->respond($result, 400);
                    exit;
                }


                if (!$excelData) {
                    $result = array('code' => -1, 'msg' => 'الرجاء إدخال حقل بيانات Excel ');
                    return $this->respond($result, 400);
                    exit;
                }

                $excelData = json_decode($excelData, true);

                if ($excelData !== []) {


                    $addedSuccessNum = 0;
                    $failedToAddNum = 0;

                    $model = new StudentsModel();


                    foreach ($excelData as  $value) {
                        try {

                            if ($value['full_name'] == '' || $value['student_number'] == '') {
                                throw new Exception();
                            }

                            $model->add_student([
                                'school_id' => $school_id,
                                'student_number' => $value['student_number'],
                                'full_name' => $value['full_name'],
                                'phone' => $value['phone'],
                                'class_id' => $value['class'],
                                'semestar_id' => $value['semestar'],
                            ]);

                            $addedSuccessNum++;
                        } catch (\Throwable $th) {
                            $failedToAddNum++;
                        }
                    }

                    return    $this->respond(['code' => 1, 'msg' => 'تم إضافة ' . $addedSuccessNum . ' عنصر وفشل ' . $failedToAddNum, 'data' => []], 200);
                } else {
                    $data = array('code' => -1, 'msg' => 'لا يوجد بيانات لإضافتها!', 'data' => []);
                    return    $this->respond($data, 400);
                }

            } else {
                $result = array(
                    'code' => $result['code'], 'msg' => $result['messages'],
                );
                return $this->respond($result, 400);
            }
        } else {
            $data = array('code' => -1, 'msg' => 'Method must be POST', 'data' => []);
            return  $this->respond($data, 200);
        }
    }
}
