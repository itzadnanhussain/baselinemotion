<?php

if (!function_exists('getByWhere')) {
    function getByWhere($table, $select = '*', $where = array(), $orderBy = array(), $limit = 0, $offset = 0, $whereLike = array(), $whereIn = array(), $groupBy = '', $distinct = '')
    {
        $thiz = &get_instance();
        $thiz->db->select($select);
        $tableArr = explode(',', $table);
        $thiz->db->from($tableArr[0]);
        unset($tableArr[0]);
        if (count($tableArr) > 0) {
            foreach ($tableArr as $key => $tbStr) {
                $tbArr = explode('-', $tbStr);
                $thiz->db->join($tbArr[0], $tbArr[1], $tbArr[2]);
            }
        }
        // if (count($where) > 0) {
        //   foreach ($where as $key => $val) {
        //     $key = explode('=>', $key)[0];
        //     $thiz->db->where($key, $val);
        //   }
        // }
        if (count($where) > 0) {
            foreach ($where as $key => $val) {
                $key = explode('=>', $key)[0];
                if ($val == 'DATE_FORMAT') {
                    $thiz->db->where($key);
                } else {
                    $thiz->db->where($key, $val);
                }
            }
        }
        if (count($whereLike) > 0) {
            $likeCount = 1;
            $thiz->db->group_start();
            foreach ($whereLike as $keyLike =>  $likeRec) {
                $keyLike = explode('=>', $keyLike)[0];
                if ($likeCount == 1) {
                    $thiz->db->like($keyLike, $likeRec, 'both', false);
                } else {
                    $thiz->db->or_like($keyLike, $likeRec, 'both', false);
                }
                $likeCount++;
            }
            $thiz->db->group_end();
        }
        if (count($whereIn) > 0) {
            $thiz->db->where_in($whereIn[0], $whereIn[1]);
        }
        if ($limit > 0) {
            $thiz->db->limit($limit, $offset);
        }
        if ($groupBy) {
            $thiz->db->group_by($groupBy);
        }
        if (count($orderBy)) {
            $thiz->db->order_by($orderBy[0], $orderBy[1]);
        }
        if (!empty($distinct)) {
            $thiz->db->distinct($distinct);
        }
        $query = $thiz->db->get();
        if ($query->num_rows()) {
            return $query->result();
        } else {
            return false;
        }
    }
}
if (!function_exists('getByWhereCount')) {
    function getByWhereCount($table, $where = array(), $whereLike = array())
    {
        $thiz = &get_instance();
        $thiz->db->select('COUNT(*) as count');
        $tableArr = explode(',', $table);
        $thiz->db->from($tableArr[0]);
        unset($tableArr[0]);
        if (count($tableArr) > 0) {
            foreach ($tableArr as $key => $tbStr) {
                $tbArr = explode('-', $tbStr);
                $thiz->db->join($tbArr[0], $tbArr[1], $tbArr[2]);
            }
        }
        if (count($where) > 0) {
            foreach ($where as $key => $val) {
                $key = explode('=>', $key)[0];
                $thiz->db->where($key, $val);
            }
        }
        if (count($whereLike) > 0) {
            $likeCount = 1;
            $thiz->db->group_start();
            foreach ($whereLike as $keyLike =>  $likeRec) {
                if ($likeCount == 1) {
                    $thiz->db->like($keyLike, $likeRec, 'both', false);
                } else {
                    $thiz->db->or_like($keyLike, $likeRec, 'both', false);
                }
                $likeCount++;
            }
            $thiz->db->group_end();
        }
        $query = $thiz->db->get();
        return $query->row()->count;
    }
}

if (!function_exists('addNew')) {
    function addNew($table, $data)
    {
        $thiz = &get_instance();
        $thiz->db->insert($table, $data);
        $result = $thiz->db->insert_id();
        if (!$result) {
            $result = $thiz->db->error();
        }
        return $result;
    }
}
if (!function_exists('updateByWhere')) {
    function updateByWhere($table, $data, $where)
    {
        $thiz = &get_instance();
        if (count($where) > 0) {
            foreach ($where as $key => $val) {
                $thiz->db->where($key, $val);
            }
            $result = $thiz->db->update($table, $data);
            if (!$result) {
                $result = $thiz->db->error();
            }
            return $result;
        } else {
            return false;
        }
    }
}
if (!function_exists('updateByWhereLike')) {
    function updateByWhereLike($table, $data, $whereLike)
    {
        $thiz = &get_instance();
        if (count($whereLike) > 0) {
            $likeCount = 1;
            foreach ($whereLike as $keyLike =>  $likeRec) {
                $keyLike = explode('=>', $keyLike);
                $keyField = $keyLike[0];
                if ($keyLike[1]) {
                    $fieldSide = $keyLike[1];
                } else {
                    $fieldSide = 'both';
                }
                if ($likeCount == 1) {
                    $thiz->db->like($keyField, $likeRec, $fieldSide, false);
                } else {
                    $thiz->db->or_like($keyField, $likeRec, $fieldSide, false);
                }
                $likeCount++;
            }
            $result = $thiz->db->update($table, $data);
            if (!$result) {
                $result = $thiz->db->error();
            }
            return $result;
        } else {
            return false;
        }
    }
}
if (!function_exists('deleteRecords')) {
    function deleteRecords($table, $field, $where = array())
    {
        $thiz = &get_instance();
        if (count($where) > 0) {
            $thiz->db->where_in($field, $where);
            $result = $thiz->db->delete($table);
            if (!$result) {
                $result = $thiz->db->error();
            }
            return $result;
        } else {
            return false;
        }
    }
}
if (!function_exists('deleteRecordWhere')) {
    function deleteRecordWhere($table, $where = array())
    {
        $thiz = &get_instance();
        if (count($where) > 0) {
            foreach ($where as $key => $val) {
                $thiz->db->where($key, $val);
            }
            $result = $thiz->db->delete($table);
            if (!$result) {
                $result = $thiz->db->error();
            }
            return $result;
        } else {
            return false;
        }
    }
}
if(!function_exists('deleteAllRecords'))
{
    function deleteAllRecords($table)
    {
        $thiz=&get_instance();
        $res=$thiz->db->empty_table($table);
        return $res;

    }
}
