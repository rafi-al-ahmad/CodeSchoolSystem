<?php

namespace App\Controllers;

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: POST,GET, OPTIONS");
header("Access-Control-Allow-Headers: *");

use CodeIgniter\API\ResponseTrait;
use App\Models\TeachersModel;
use CodeIgniter\HTTP\RequestInterface;
use App\Controllers\Check;
use Exception;

class TeachersExtends extends Teachers
{
    use ResponseTrait;
 
    
    public function AddTeachersFromFile()
    {

        if ($this->request->getMethod() == 'post') {
            $check = new Check(); // Create an instance
            $result = $check->check();

            if ($result['code'] == 1) {

                $school_id = $this->request->getVar('school_id');

                if (!$school_id) {
                    $result = array('code' => -1, 'msg' => 'الرجاء إدخال حقل المدرسة ');
                    return $this->respond($result, 400);
                    exit;
                }
            
                $excelData = $this->request->getVar('excelData');
                
                if (!$excelData) {
                    $result = array('code' => -1, 'msg' => 'الرجاء إدخال حقل بيانات Excel ');
                    return $this->respond($result, 400);
                    exit;
                }
                

                $excelData = json_decode($excelData, true);
                // print_r($excelData);
                if ($excelData !== []) {
                    
                    $addedSuccessNum = 0;
                    $failedToAddNum = 0;
                    
                    $model = new TeachersModel();


                    foreach ($excelData as  $value) {
                        // continue;
                        try {
                            if ($value['full_name'] == '' || $value['teacher_number'] == '') {
                                throw new Exception();
                            }
                            
                            $model->add_teacher([
                                'school_id' => $school_id,
                                'full_name' => $value['full_name'],
                                'teacher_number' => str_replace("$", "", $value['teacher_number']),
                                'phone' => str_replace("$", "", $value['phone']),
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
            return    $this->respond($data, 200);
        }
    }


    public function DeleteTeachers()
    {

        if ($this->request->getMethod() == 'delete') {
            $check = new Check(); // Create an instance
            $result = $check->check();

            if ($result['code'] == 1) {
                $input = $this->request->getRawInput();;
                $ids = isset($input['ids']) ? $input['ids'] : '';
                if (!$ids) {
                    $data = array('code' => -1, 'msg' => 'Please insert ids flied', 'data' => []);
                    return  $this->respond($data, 400);
                    exit;
                }
                $model = new TeachersModel();

                $delete = $model->delete_teachers($ids);
                if ($delete >= 1) {
                    $data = array('code' => 1, 'msg' => 'تم حذف '.$delete.' من السجلات بنجاح.', 'data' => []);
                    return  $this->respond($data, 200);
                } else {
                    $data = array('code' => -1, 'msg' => 'fail', 'data' => []);
                    return  $this->respond($data, 400);
                }
            } else {
                $result = array(
                    'code' => $result['code'], 'msg' => $result['messages'],
                );
                return $this->respond($result, 400);
            }
        } else {
            $data = array('code' => -1, 'msg' => 'Method must be Delete', 'data' => []);
            return  $this->respond($data, 200);
        }
    }
}
