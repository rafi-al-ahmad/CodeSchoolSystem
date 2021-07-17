<?php
namespace App\Models;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
class SchoolModel extends Model
{
  
    public function add_school_info($data){
        $db      = \Config\Database::connect();
        $builder = $db->table('school_info');
       return  $builder->insert($data);
    }
    public function get_school($limit,$page,$key){
        $page=($page-1)*$limit;
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->select('users.id,education_type,category,school_number,username,email,city,phone,school_name');
        $builder->join('school_info', 'users.id = school_info.school_id');
        $builder->where('role', 2);
        $builder->orderBy('users.create_date', 'DESC');
        if($key=='all'){
            $query   = $builder->get();
        }
        else{
            $query   = $builder->get($limit, $page);
        }
      
        return $query->getResult();
    }
    public function edit_school($data,$id){
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->where('id',$id);
      return  $builder->update($data);
    
    }
    public function edit_info($data,$id){
        $db = \Config\Database::connect();
        $builder = $db->table('school_info');
        $builder->where('school_id',$id);
      return  $builder->update($data);
    
    }
    public function edit_service($data){
        $db = \Config\Database::connect();
        $builder = $db->table('sevices_schools');
        $builder->where('school_id',$data['school_id']);
        $builder->where('service_id',$data['service_id']);
       return $builder->update($data);
       return $db->affectedRows();
    }
    public function add_service($data){
        $db = \Config\Database::connect();
        $builder = $db->table('sevices_schools');
       
        $builder->insert($data);
        return $db->affectedRows();
    }
    
    public function get_service_by_id($service_id,$school_id){
        $db = \Config\Database::connect();
        $builder = $db->table('sevices_schools');
        $builder->select('id');
        $builder->where('service_id',$service_id);
        $builder->where('school_id',$school_id);
        $query   = $builder->get();  
        return $query->getRow();
       
    }
    public function get_services(){
        $db = \Config\Database::connect();
        $builder = $db->table('service_school');
        $builder->select('id,name');
        $builder->orderBy('create_date', 'DESC');
        $query   = $builder->get();  
        return $query->getResult();
       
    }
    public function get_school_by_id($id){
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->select('users.id,education_type,category,school_number,username,email,city,phone,school_name');
        $builder->join('school_info', 'users.id = school_info.school_id');
        $builder->where('role', 2);
        $query   = $builder->get();
        return $query->getRow();
       
    }
    public function delete_school($id){
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->where('id',$id);
         $builder->delete();
         return $db->affectedRows();
       
    }
    public function get_classes(){
        $db = \Config\Database::connect();
        $builder = $db->table('classes');
        $builder->select('id,name,code');
       
        $query   = $builder->get();  
        return $query->getResult();
       
    }
    public function get_sections(){
        $db = \Config\Database::connect();
        $builder = $db->table('sections');
        $builder->select('id,name');
       
        $query   = $builder->get();  
        return $query->getResult();
       
    }
    public function get_subjects($level_id=null,$school_id){
        $db = \Config\Database::connect();
        $builder = $db->table('subjects');
        $builder->select('id,name');
       if(!empty($level_id)){
        $builder->where('level_id', $level_id);
        $builder->where('school_id', $level_id);
       }
        $query   = $builder->get();  
        return $query->getResult();
       
    }
    public function get_period(){
        $db = \Config\Database::connect();
        $builder = $db->table('period');
        $builder->select('id,name');
       
        $query   = $builder->get();  
        return $query->getResult();
       
    }
    public function get_Semester(){
        $db = \Config\Database::connect();
        $builder = $db->table('semaster');
        $builder->select('id,name');
       
        $query   = $builder->get();  
        return $query->getResult();
       
    }
    public function add_asbense($data){
        $db = \Config\Database::connect();
        $builder = $db->table('absence_and_lag');
       
        $builder->insert($data);
        return $db->affectedRows();
    }
    public function add_table_school($data){
        $db = \Config\Database::connect();
        $builder = $db->table('school_table');
       
        $builder->insert($data);
        return $db->affectedRows();
    }
    public function add_exam_table_school($data){
        $db = \Config\Database::connect();
        $builder = $db->table('exam_table');
       
        $builder->insert($data);
        return $db->affectedRows();
    }
    public function get_student($limit,$page,$class_id=null,$semaster_id=null,$school_id,$key){
        $page=($page-1)*$limit;
        $db = \Config\Database::connect();
        $builder = $db->table('students');
        $builder->select('students.id student_id,full_name,student_number,class_id,users.phone parent_phone,classes.name class_name,semaster.name ');
        $builder->join('users', 'students.parent_id = users.id');
        $builder->join('classes', 'students.class_id = classes.id');
        $builder->join('semaster', 'students.semestar_id = semaster.id');
        $builder->where('role', 3);
        if(!empty($class_id)){
        $builder->where('class_id', $class_id);
        }
        if(!empty($semaster_id)){
        $builder->where('semestar_id', $semaster_id);
        }
        $builder->where('school_id', $school_id);
        $builder->orderBy('students.create_date', 'DESC');
        if($key=='all'){
            $query   = $builder->get();
        }
        else{
            $query   = $builder->get($limit, $page);
        }
        return $query->getResult();
    }
    public function get_asbense($limit,$page,$key){
        $page=($page-1)*$limit;
        $db = \Config\Database::connect();
        $builder = $db->table('absence_and_lag');
        $builder->select('students.id student_id,full_name,student_number,users.phone parent_phone,classes.name class_name,semaster.name semaster_name,monitoring_case,period,date,message');
        $builder->join('students', 'absence_and_lag.student_id = students.id');
        $builder->join('users', 'students.parent_id = users.id');
        $builder->join('classes', 'students.class_id = classes.id');
        $builder->join('semaster', 'students.semestar_id = semaster.id');
        $builder->where('role', 3);
        $builder->orderBy('absence_and_lag.create_date', 'DESC');
        if($key=='all'){
            $query   = $builder->get();
        }
        else{
            $query   = $builder->get($limit, $page);
        }
        return $query->getResult();
    }
    public function get_asbense_reply($limit,$page,$key){
        $page=($page-1)*$limit;
        $db = \Config\Database::connect();
        $builder = $db->table('absence_and_lag');
        $builder->select('absence_and_lag.id,is_read,students.id student_id,full_name,student_number,users.phone parent_phone,classes.name class_name,semaster.name semaster_name,monitoring_case,period,date,message,reply');
        $builder->join('students', 'absence_and_lag.student_id = students.id');
        $builder->join('users', 'students.parent_id = users.id');
        $builder->join('classes', 'students.class_id = classes.id');
        $builder->join('semaster', 'students.semestar_id = semaster.id');
        $builder->where('role', 3);
        $builder->orderBy('absence_and_lag.create_date', 'DESC');
        if($key=='all'){
            $query   = $builder->get();
        }
        else{
            $query   = $builder->get($limit, $page);
        }
        return $query->getResult();
    }
    public function get_service_by_school_id($school_id){
        $db = \Config\Database::connect();
        $builder = $db->table('sevices_schools');
        $builder->select('id,status,end_date');
        $builder->where('school_id',$school_id);
        $query   = $builder->get();  
        return $query->getResult();
       
    }
    public function add_parent_to_school($data){
        $db = \Config\Database::connect();
        $builder = $db->table('parent_school');
       
        $builder->insert($data);
        return $db->affectedRows();
    }
    public function get_service_status_by_school_id($school_id,$service_id){
        $db = \Config\Database::connect();
        $date=date('Y-m-d');
        $builder = $db->table('sevices_schools');
        $builder->select('id,status,end_date');
        $builder->where('school_id',$school_id);
        $builder->where('service_id',$service_id);
        $builder->where('status',1);
        $builder->where('end_date>=',$date);
        $query   = $builder->get();  
        return $query->getRow();
       
    }
    public function get_school_table($limit,$page,$school_id,$key,$class=null,$section=null,$semaster_id=null,$program_id){
        $page=($page-1)*$limit;
        $db = \Config\Database::connect();
        $builder = $db->table('school_table');
        $builder->select('day,subject_id,period.name period_name,subjects.name subject_name');
        $builder->join('subjects', 'school_table.subject_id = subjects.id');
        $builder->join('period', 'school_table.period = period.id');
        if(!empty($class)){
            $builder->where('class_id', $class);
            }
            if(!empty($semaster_id)){
            $builder->where('semestar_id', $semaster_id);
            }
            if(!empty($section)){
                $builder->where('section_id', $section);
                }
                if(!empty($program_id)){
                    $builder->where('school_table.program_id', $program_id);
                    }
                $builder->where('school_table.school_id', $school_id);
        $builder->orderBy('school_table.create_date', 'DESC');
        if($key=='all'){
            $query   = $builder->get();
        }
        else{
            $query   = $builder->get($limit, $page);
        }
        return $query->getResult();
    }
    public function get_program_by_level($level_id){
        $db = \Config\Database::connect();
        $builder = $db->table('school_table_type');
        $builder->select('id,name');
        $builder->where('educational_level', $level_id);
        $query   = $builder->get();  
        return $query->getResult();
       
    }
    public function get_subject_by_program($program_id){
        $db = \Config\Database::connect();
        $builder = $db->table('subjects');
        $builder->select('id,name');
        $builder->where('program_id', $program_id);
        $query   = $builder->get();  
        return $query->getResult();
       
    }
    public function add_subject($data){
        $db = \Config\Database::connect();
        $builder = $db->table('subjects');
      return $builder->insert($data);
       
       
    }
    public function add_program_name($data){
        $db = \Config\Database::connect();
        $builder = $db->table('program_name');
      return $builder->insert($data);
       
    }
    public function add_exam_name($data){
        $db = \Config\Database::connect();
        $builder = $db->table('exam_name');
      return $builder->insert($data);
       
    }
    public function get_program_school($school_id){
        $db = \Config\Database::connect();
        $builder = $db->table('program_name');
        $builder->select('id,name');
        $builder->where('school_id', $school_id);
        $query   = $builder->get();  
        return $query->getResult();
       
    }
    public function get_exam_school_name($school_id){
        $db = \Config\Database::connect();
        $builder = $db->table('exam_name');
        $builder->select('id,name');
        $builder->where('school_id', $school_id);
        $query   = $builder->get();  
        return $query->getResult();
       
    }
    public function get_school_exam_table($limit,$page,$key,$class=null,$section=null,$program_id=null,$school_id){
        $page=($page-1)*$limit;
        $db = \Config\Database::connect();
        $builder = $db->table('exam_table');
        $builder->select('day,date,subject_id,subjects.name subject_name,classes.name class_name,exam_name.name program_name');
        $builder->join('subjects', 'exam_table.subject_id = subjects.id');
        $builder->join('classes', 'exam_table.class_id = classes.id');
        $builder->join('exam_name', 'exam_table.exam_id = exam_name.id');
        if(!empty($class)){
            $builder->where('class_id', $class);
            }
           
            if(!empty($section)){
                $builder->where('section_id', $section);
                }
                if(!empty($program_id)){
                    $builder->where('program_id', $section);
                    }
                $builder->where('exam_table.school_id', $school_id);
        $builder->orderBy('exam_table.create_date', 'DESC');
        if($key=='all'){
            $query   = $builder->get();
        }
        else{
            $query   = $builder->get($limit, $page);
        }
        return $query->getResult();
    }
    public function get_parent_exam_table($limit,$page,$key,$school_id){
        $page=($page-1)*$limit;
        $school_id=explode(",",$school_id);
        $db = \Config\Database::connect();
        $builder = $db->table('exam_table');
        $builder->select('day,date,subject_id,subjects.name subject_name,classes.name class_name,exam_name.name program_name');
        $builder->join('subjects', 'exam_table.subject_id = subjects.id');
        $builder->join('classes', 'exam_table.class_id = classes.id');
        $builder->join('exam_name', 'exam_table.exam_id = exam_name.id');
     
                $builder->wherein('exam_table.school_id', $school_id);
                $builder->groupBy("exam_id");
        $builder->orderBy('exam_table.create_date', 'DESC');
        if($key=='all'){
            $query   = $builder->get();
        }
        else{
            $query   = $builder->get($limit, $page);
        }
        return $query->getResult();
    }
    public function get_parent_exam_table2($limit,$page,$key,$school_id){
        $page=($page-1)*$limit;
        // $school_id=explode(",",$school_id);
        // var_dump($school_id);
        $db = \Config\Database::connect();
       $sql='
       SELECT day,date,subjects.name subject_name,school_name
       FROM exam_table 
       join subjects on exam_table.subject_id = subjects.id left join school_info on exam_table.school_id = school_info.school_id
       where exam_table.school_id in ('.$school_id.') and exam_id IN 
       ( 
       SELECT max(exam_id) 
       FROM exam_table
       group by school_id 
       );
         ';
        $query =$db->query($sql);
        return $query->getResult();
    }
    public function get_parent_school_table2($limit,$page,$key,$school_id){
        $page=($page-1)*$limit;
        // $school_id=explode(",",$school_id);
        // var_dump($school_id);
        $db = \Config\Database::connect();
       $sql='
       SELECT day,subjects.name subject_name,school_name,period.name
       FROM school_table 
       join subjects on school_table.subject_id = subjects.id left join school_info on school_table.school_id = school_info.school_id left join period on school_table.period = period.id
       where school_table.school_id in ('.$school_id.') and school_table.program_id IN 
       ( 
       SELECT max(program_id) 
       FROM school_table
       group by school_id 
       );
         ';
        $query =$db->query($sql);
        return $query->getResult();
    }
    public function add_period($data){
        $db = \Config\Database::connect();
        $builder = $db->table('period');
      return $builder->insert($data);
       
    }
        public function get_school_parent($school_id){
      
        $school_id=explode(",",$school_id);
        $db = \Config\Database::connect();
        $builder = $db->table('school_info');
        $builder->select('school_id,school_name');
        $builder->wherein('school_id',$school_id);
        $builder->orderBy('create_date', 'DESC');
        
            $query   = $builder->get();
        
           
        return $query->getResult();
    }
      public function edit_absence_and_lag($data,$id){
        $db = \Config\Database::connect();
        $builder = $db->table('absence_and_lag');
        $builder->where('id',$id);
      return  $builder->update($data);
    
    }
}