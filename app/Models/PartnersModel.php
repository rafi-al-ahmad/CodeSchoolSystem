<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class PartnersModel extends Model
{


    public function get_partners_offers($limit, $page, $key, $whereStatus = 1, $user = null)
    {
        $db = \Config\Database::connect();

        $date = date('Y-m-d');
        $page = ($page - 1) * $limit;
        $builder = $db->table('users');
        $builder->distinct();
        $builder->select('username,partner_service.id,  partner_service.status,service_name,image_url,service_price,service_after_discount,discount,cubon,end_date,city,area');
        $builder->join('partner_service', 'users.id = partner_service.user_id');
        $builder->where('role', 4);
        $builder->where('end_date >=', $date);

        if ($user != null) {
            $builder->where('city', $user->city );
            $builder->where('area', $user->area );
        }
        
        if ($whereStatus != -1)
            $builder->where('partner_service.status', $whereStatus);

        $builder->orderBy('partner_service.create_date', 'desc');
        if ($key == 'all') {
            $query   = $builder->get();
        } else {
            $query   = $builder->get($limit, $page);
        }
        return $query->getResult();
    }

    public function get_partners($limit, $page, $key, $user = null)
    {
        $db = \Config\Database::connect();

        $date = date('Y-m-d');
        $page = ($page - 1) * $limit;
        $builder = $db->table('users');
        $builder->where('role', 4);

        if ($user != null) {
            $builder->where('city', $user->city );
            $builder->where('area', $user->area );
        }
       
        if ($key == 'all') {
            $query   = $builder->get();
        } else {
            $query   = $builder->get($limit, $page);
        }
        return $query->getResult();
    }



    public function get_service($user_id, $limit, $page, $key)
    {
        $db = \Config\Database::connect();
        $date = date('Y-m-d');
        $page = ($page - 1) * $limit;
        $builder = $db->table('users');
        $builder->distinct();
        $builder->select('username, partner_service.user_id as id, service_name,  partner_service.status, image_url, service_price, service_after_discount, discount, cubon, end_date, users.city, users.area');
        $builder->join('partner_service', 'users.id = partner_service.user_id');
        $builder->where('role', 4);
        $builder->where('end_date >=', $date);

        $builder->where('user_id', $user_id);
        $builder->orderBy('partner_service.create_date', 'desc');
        if ($key == 'all') {
            $query   = $builder->get();
        } else {
            $query   = $builder->get($limit, $page);
        }
        return $query->getResult();
    }
    public function edit_service($data, $id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('partner_service');
        $builder->where('id', $id);
        $builder->update($data);
        return $db->affectedRows();
    }
    public function get_partner($user_id)
    {
        $db = \Config\Database::connect();
        $date = date('Y-m-d');

        $builder = $db->table('users');
        $builder->distinct();
        $builder->select('username,area,city,phone,email');

        $builder->where('role', 4);

        $builder->where('id', $user_id);


        $query   = $builder->get();

        return $query->getResult();
    }
    public function add_service($data)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('partner_service');
        return $builder->insert($data);
    }
    public function get_service_by_id($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('partner_service');
        $builder->select('id, service_name, image_url, 	service_price,service_after_discount,discount,cubon,end_date,status');
        $builder->where('id', $id);
        $query   = $builder->get();
        return $query->getRow();
    }
    public function delete_service($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('partner_service');
        $builder->where('id', $id);
        $builder->delete();
        return $db->affectedRows();
    }
    public function get_parent_partner_offer($user_id, $offer_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('parents_partner_service');
        $builder->select('*');
        $builder->where('parent_id', $user_id);
        $builder->where('partner_service_id', $offer_id);
        $query = $builder->get();
        return $query->getRow();
    }
    public function add_parent_partner_offer($data)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('parents_partner_service');
        return $builder->insert($data);
    }
    
    public function edit_partner($data, $id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->where('id', $id);
        $builder->where('role', 4);
        $builder->update($data);
        return $db->affectedRows();
    }

    public function delete_partners($ids)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->whereIn('id', $ids);
        $builder->where('role', 4);
        $builder->delete();
        return $db->affectedRows();
    }

}
