<?php

class Common extends CI_Model {

    //insert data into database and returns true and false.
    //used mostly when primary key field is not an auto increment.
    function insert_data($data, $tablename) {
        if ($this->db->insert($tablename, $data)) {
            return true;
        } else {
            return false;
        }
    }

    //insert data into database and returns last insert id or 0
    function insert_data_getid($data, $tablename) {
        if ($this->db->insert($tablename, $data)) {
            return $this->db->insert_id();
        } else {
            return 0;
        }
    }

    //update database and returns true and false based on single column
    function update_data($data, $tablename, $columnname, $columnid) {
        $this->db->where($columnname, $columnid);
        if ($this->db->update($tablename, $data)) {
            return true;
        } else {
            return false;
        }
    }

    function update_data_by_conditions($data, $tablename, $conditions) {
        if ($this->db->update($tablename, $data, $conditions)) {
            return true;
        } else {
            return false;
        }
    }

    function checkName($table, $name_colume, $value_colume, $table_id = '', $id = '', $name_colume1 = '', $value_colume1 = '', $name_colume2 = '', $value_colume2 = '', $name_colume3 = '', $value_colume3 = '', $name_colume4 = '', $value_colume4 = '', $name_colume5 = '', $value_colume5 = '', $name_colume6 = '', $value_colume6 = '') {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($name_colume, $value_colume);
        if ($name_colume1 != '') {
            $this->db->where($name_colume1, $value_colume1);
        }

        if ($name_colume2 != '') {
            $this->db->where($name_colume2, $value_colume2);
        }

        if ($name_colume3 != '') {
            $this->db->where($name_colume3, $value_colume3);
        }

        if ($name_colume4 != '') {
            $this->db->where($name_colume4, $value_colume4);
        }

        if ($name_colume5 != '') {
            $this->db->where($name_colume5, $value_colume5);
        }

        if ($name_colume6 != '') {
            $this->db->where($name_colume6, $value_colume6);
        }

        if ($id != '') {
            $notequal = $table_id . ' !=';
            $this->db->where($notequal, (int) $id);
        }
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return array();
        }
    }

    // change status
    function change_status($data, $tablename, $columnname, $columnid) {
        $this->db->where($columnname, $columnid);
        if ($this->db->update($tablename, $data)) {
            return true;
        } else {
            return false;
        }
    }

    // select data using column id
    function select_data_by_id($tablename, $columnname, $columnid, $data = '*', $join_str = array()) {
        $this->db->select($data);
        $this->db->from($tablename);
        //if join_str array is not empty then implement the join query
        if (!empty($join_str)) {
            foreach ($join_str as $join) {
                //check for join type
                if (!isset($join['join_type'])) {
                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id']);
                } else {
                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id'], $join['join_type']);
                }
            }
        }
        $this->db->where($columnname, $columnid);
        $query = $this->db->get();
        return $query->result_array();
    }

    // select data using multiple conditions
    function select_data_by_condition($tablename, $condition_array = array(), $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '', $condition_or_arr = array(),$where_in = array()) {
        $this->db->select($data);
        $this->db->from($tablename);

        //if join_str array is not empty then implement the join query
        if (!empty($join_str)) {
            foreach ($join_str as $join) {
                if (!isset($join['join_type'])) {
                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id']);
                } else {
                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id'], $join['join_type']);
                }
            }
        }

        //condition array pass to where condition
        $this->db->where($condition_array);

        
        if (!empty($condition_or_arr)) {
            $this->db->group_start();
            $this->db->or_where($condition_or_arr);
            $this->db->group_end();
        }

        if (!empty($where_in)) {
            foreach ($where_in as $f_kay => $f_value) {
                $this->db->where_in($f_kay,$f_value);
            }
        }
        //Setting Limit for Paging
        if ($limit != '' && $offset == 0) {
            $this->db->limit($limit);
        } else if ($limit != '' && $offset != 0) {
            $this->db->limit($limit, $offset);
        }

        if ($groupby != '') {
            $this->db->group_by($groupby);
        }
        //order by query
        //  $this->db->distinct();
        if ($sortby != '' && $orderby != '') {
            $this->db->order_by($sortby, $orderby);
        }

        $query = $this->db->get();

        //if limit is empty then returns total count
        if ($limit == '') {
            $query->num_rows();
        }
        //if limit is not empty then return result array
        return $query->result_array();
    }

    //new method

    // select data using multiple conditions
    function select_data_by_condition_single($tablename, $condition_array = array(), $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '', $condition_or_arr = array(),$where_in = array()) {
        $this->db->select($data);
        $this->db->from($tablename);

        //if join_str array is not empty then implement the join query
        if (!empty($join_str)) {
            foreach ($join_str as $join) {
                if (!isset($join['join_type'])) {
                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id']);
                } else {
                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id'], $join['join_type']);
                }
            }
        }

        //condition array pass to where condition
        $this->db->where($condition_array);

        
        if (!empty($condition_or_arr)) {
            $this->db->group_start();
            $this->db->or_where($condition_or_arr);
            $this->db->group_end();
        }

        if (!empty($where_in)) {
            foreach ($where_in as $f_kay => $f_value) {
                $this->db->where_in($f_kay,$f_value);
            }
        }
        //Setting Limit for Paging
        if ($limit != '' && $offset == 0) {
            $this->db->limit($limit);
        } else if ($limit != '' && $offset != 0) {
            $this->db->limit($limit, $offset);
        }

        if ($groupby != '') {
            $this->db->group_by($groupby);
        }
        //order by query
        //  $this->db->distinct();
        if ($sortby != '' && $orderby != '') {
            $this->db->order_by($sortby, $orderby);
        }

        $query = $this->db->get();

        //if limit is empty then returns total count
        if ($limit == '') {
            $query->num_rows();
        }
        //if limit is not empty then return result array
        return $query->row_array();
    }


    //new method

    // select data using multiple conditions and search keyword
    function select_data_by_search($tablename, $search_condition, $condition_array = array(), $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array()) {

        $this->db->select($data);
        $this->db->from($tablename);

        //if join_str array is not empty then implement the join query
        if (!empty($join_str)) {
            foreach ($join_str as $join) {
                if (!isset($join['join_type'])) {
                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id']);
                } else {
                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id'], $join['join_type']);
                }
            }
        }

        if ($search_condition != '') {
            $this->db->where($search_condition);
        }
        if (!empty($condition_array)) {
            $this->db->where($condition_array);
        }

        //Setting Limit for Paging
        if ($limit != '' && $offset == 0) {
            $this->db->limit($limit);
        } else if ($limit != '' && $offset != 0) {
            $this->db->limit($limit, $offset);
        }
        //order by query
        if ($sortby != '' && $orderby != '') {
            $this->db->order_by($sortby, $orderby);
        }

        $query = $this->db->get();
        //if limit is empty then returns total count
        if ($limit == '') {
            $query->num_rows();
        }
        //if limit is not empty then return result array
        return $query->result_array();
    }

    //table records count
    function get_count_of_table($table) {
        $query = $this->db->get($table)->num_rows();
        return $query;
    }

    // delete data
    function delete_data($tablename, $columnname, $columnid) {
        $this->db->where($columnname, $columnid);
        if ($this->db->delete($tablename)) {
            return true;
        } else {
            return false;
        }
    }

    // delete all data
    function delete_all_data($tablename) {
        if ($this->db->empty_table($tablename)) {
            return true;
        } else {
            return false;
        }
    }

    // check unique avaliblity
    function check_unique_avalibility($tablename, $columname1, $columnid1_value, $columname2, $columnid2_value, $condition_array) {

        // if edit than $columnid2_value use
        if ($columnid2_value != '') {
            $this->db->where($columname2 . " != ", $columnid2_value);
        }

        if (!empty($condition_array)) {
            $this->db->where($condition_array);
        }

        $this->db->where($columname1, $columnid1_value);
        $query = $this->db->get($tablename);
        return $query->result();
    }

    public function selectDataById($table, $id, $filed) {
        $this->db->where($filed, $id);
        // $this->db->where('status', 'Enable');
        if ($sortby != '' && $orderby != "") {
            $this->db->order_by($sortby, $orderby);
        }
        $query = $this->db->get($table);
        if ($query->num_rows() > 0) {

            return $query->result();
        } else {
            return array();
        }
    }

    public function selectRecord($table) {
        $query = $this->db->get($table);
        return $query->row_array();
    }

    function get_all_record($tablename, $data, $sortby, $orderby) {
        $this->db->select($data);
        $this->db->from($tablename);
        //$this->db->where('status', 'Enable');
        if ($sortby != '' && $orderby != "") {
            $this->db->order_by($sortby, $orderby);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    /*
     * Function Name :selectRecordById
     * Parameters :variables
     * Return :array
     */

    public function selectRecordById($table, $id, $filed) {

        $this->db->where($filed, $id);
        $query = $this->db->get($table);
        return $query->row_array();
    }
    
    public function selectRecordByName($table, $name, $filed) {

        $this->db->where($filed, $name);
        $query = $this->db->get($table);
        return $query->row_array();
    }

    /*
     * Function Name :saveTableImg
     * Parameters :variables
     * Return :variable
     */

    public function saveTableImg($tablename, $filed, $id, $data) {


        $this->db->where($filed, $id);
        $que = $this->db->update($tablename, $data);
        return $que;
    }

    /*
     * Function Name :checkAddTimeRecord
     * Parameters :variables
     * Return :variable
     */

    public function checkAddTimeRecord($columnVal, $columnName, $table) {

        $this->db->where($columnName, $columnVal);
        $query = $this->db->get($table);
        $num = $query->num_rows();

        if ($num != 0) {
            $res = 1;
        } else {
            $res = 0;
        }
        return $res;
    }

    /*
     * Function Name :checkEditTimeRecord
     * Parameters :variables
     * Return :variable
     */

    public function checkEditTimeRecord($columnVal, $columnName, $table, $id, $tableid) {

        $notequal = '<>';
        $tableId = $tableid . " " . $notequal;

        $this->db->where($tableId, $id);
        $this->db->where($columnName, $columnVal);
        $query = $this->db->get($table);
        $num = $query->num_rows();

        if ($num > 0) {
            $this->db->where($columnName, $columnVal);
            $query = $this->db->get($table);
            $rnum = $query->num_rows();
            if ($rnum > 0) {
                $res = 1;
            } else {
                $res = 0;
            }
        } else {
            $res = 0;
        }

        return $res;
    }

    function getSettingDetails() {
        return $this->db->get('settings')->result_array();
    }

    function select_data_by_allcondition($tablename, $condition_array = array(), $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '', $like = array()) {
        $this->db->select($data);
        $this->db->from($tablename);
        //if join_str array is not empty then implement the join query
        if (!empty($join_str)) {
            foreach ($join_str as $join) {
                if (!isset($join['join_type'])) {
                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id']);
                } else {
                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id'], $join['join_type']);
                }
            }
        }

        //condition array pass to where condition
        $this->db->where($condition_array);



        //Setting Limit for Paging
        if ($limit != '' && $offset == 0) {
            $this->db->limit($limit);
        } else if ($limit != '' && $offset != 0) {
            $this->db->limit($limit, $offset);
        }
        if ($groupby != '') {
            $this->db->group_by($groupby);
        }
        if ($sortby != '' && $orderby != '') {
            $this->db->order_by($sortby, $orderby);
        }


        if (!empty($like)) {
//            $this->db->group_start();
            foreach ($like as $key => $value) {
                $this->db->or_like($key, $value);
            }
//            $this->db->group_end();
        }

        $query = $this->db->get();
        //if limit is empty then returns total count
        if ($limit == '') {
            $query->num_rows();
        }

        //if limit is not empty then return result array
        return $query->result_array();
    }

    /*
     * This function is to create the data source of the Jquery Datatable
     * 
     * @param $tablename Name of the Table in database
     * @param $datatable_fields Fields in datatable that are available for filtering in datatable andnumber of column and order sequence is must maintan with apearance in datatable and add blank filed for not related to database fileds.
     * @param $condition_array conditions for Query 
     * @param $data The field set to be return to datatables, it can contain any number of fileds
     * @param $request The Get or Post Request Sent from Datatable
     * @param $join_str Join array for Query
     * @param $group_by Group by clause array if present in query
     * @return JSON data for datatable
     */

    function getDataTableSource($tablename, $datatable_fields = array(), $conditions_array = array(), $data = '*', $request, $join_str = array(), $group_by = array(), $condition_or_arr = array()) {
        //Fields tobe display in datatable
        //$this->db->distinct();
        $this->db->select($data, false);
        $this->db->from($tablename);
        //Making Join with tables if provided
        if (!empty($join_str)) {
            foreach ($join_str as $join) {
                if (!isset($join['join_type'])) {
                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id']);
                } else {
                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id'], $join['join_type']);
                }
            }
        }

        //Conditions for Query  that is defaultly available to Datatable data source.
        if (!empty($conditions_array)) {
            $this->db->where($conditions_array);
        }
        if (!empty($condition_or_arr)) {
            $this->db->group_start();
            $this->db->or_where($condition_or_arr);
            $this->db->group_end();
        }
        //Applying groupby clause to query
        if (!empty($group_by)) {
            $this->db->group_by($group_by);
        }
        //echo $this->db->last_query();die();
        //Total record in query tobe return
        $output['recordsTotal'] = $this->db->count_all_results(NULL, FALSE);

        //Filtering based on the datatable_fileds
        if ($request['search']['value'] != '') {
            $this->db->group_start();
            for ($i = 0; $i < count($datatable_fields); $i++) {
                if ($request['columns'][$i]['searchable'] == true) {
                    $this->db->or_like($datatable_fields[$i], $request['search']['value']);
                }
            }
            $this->db->group_end();
        }

        //Total number of records return after filtering not no of record display on page.
        //It must be counted before limiting the resultset.
        $output['recordsFiltered'] = $this->db->count_all_results(NULL, FALSE);

        //Setting Limit for Paging
        if ($request['length'] != -1) {
            $this->db->limit($request['length'], $request['start']);
        }


        //ordering the query
        if (isset($request['order']) && count($request['order'])) {
            for ($i = 0; $i < count($request['order']); $i++) {
                if ($request['columns'][$request['order'][$i]['column']]['orderable'] == true) {
                    $this->db->order_by($datatable_fields[$request['order'][$i]['column']] . ' ' . $request['order'][$i]['dir']);
                }
            }
        }

        $query = $this->db->get();
        $output['draw'] = $request['draw'];
        $output['data'] = $query->result_array();
        // echo $this->db->last_query();die();
        return json_encode($output);
    }
    
    function getDataTableSourcesortby($tablename, $datatable_fields = array(), $conditions_array = array(), $data = '*', $request, $join_str = array(), $group_by = array(), $sortby = '', $orderby = '') {
        $output = array();
        //Fields tobe display in datatable
        $this->db->select($data);
        $this->db->from($tablename);
        //Making Join with tables if provided
        if (!empty($join_str)) {
            foreach ($join_str as $join) {
                if (!isset($join['join_type'])) {
                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id']);
                } else {
                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id'], $join['join_type']);
                }
            }
        }
        if ($sortby != '' && $orderby != '') {
            $this->db->order_by($sortby, $orderby);
        }
        //Conditions for Query  that is defaultly available to Datatable data source.
        if (!empty($conditions_array)) {
            $this->db->where($conditions_array);
        }

        //Applying groupby clause to query
        if (!empty($group_by)) {
            $this->db->group_by($group_by);
        }

        //Total record in query tobe return
        $output['recordsTotal'] = $this->db->count_all_results(NULL, FALSE);

        //Filtering based on the datatable_fileds
        if ($request['search']['value'] != '') {
            $this->db->group_start();
            for ($i = 0; $i < count($datatable_fields); $i++) {
                if ($request['columns'][$i]['searchable'] == true) {
                    $this->db->or_like($datatable_fields[$i], $request['search']['value']);
                }
            }
            $this->db->group_end();
        }

        //Total number of records return after filtering not no of record display on page.
        //It must be counted before limiting the resultset.
        $output['recordsFiltered'] = $this->db->count_all_results(NULL, FALSE);

        //Setting Limit for Paging
        if ($request['length'] != -1) {
            $this->db->limit($request['length'], $request['start']);
        }


        //ordering the query
        if (isset($request['order']) && count($request['order'])) {
            for ($i = 0; $i < count($request['order']); $i++) {
                if ($request['columns'][$request['order'][$i]['column']]['orderable'] == true) {
                    $this->db->order_by($datatable_fields[$request['order'][$i]['column']] . ' ' . $request['order'][$i]['dir']);
                }
            }
        }

        $query = $this->db->get();
        $output['draw'] = $request['draw'];
        $output['data'] = $query->result_array();
        //print_r($output); die();
        return json_encode($output);
    }

    public function select_data_by_multiple_condition($tablename, $condition_array = array(), $data = '*', $where_in_col = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '', $condition_or_arr = array(), $where_in_val = array()) {
        //select_data_by_multiple_condition('biometric_student_attendance', $condition_arr, $selected,$where_in,$orderby, '', '', $join_str,'','');
        $this->db->select($data);
        $this->db->from($tablename);

        //if join_str array is not empty then implement the join query
        if (!empty($join_str)) {
            foreach ($join_str as $join) {
                if (!isset($join['join_type'])) {
                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id']);
                } else {
                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id'], $join['join_type']);
                }
            }
        }

        //condition array pass to where condition
        $this->db->where($condition_array);
        //$this->db->where('student_assignment_reply.student_id is null');
        if (!empty($where_in_val)) {
            $this->db->where_in($where_in_col, $where_in_val);
        } else {
            $this->db->where_in($where_in_col);
        }
        if (!empty($condition_or_arr)) {
            $this->db->group_start();
            $this->db->or_where($condition_or_arr);
            $this->db->group_end();
        }
        //Setting Limit for Paging
        if ($limit != '' && $offset == 0) {
            $this->db->limit($limit);
        } else if ($limit != '' && $offset != 0) {
            $this->db->limit($limit, $offset);
        }

        if ($groupby != '') {
            $this->db->group_by($groupby);
        }
        //order by query

        if ($orderby = '') {
            $this->db->order_by($orderby);
        }


        $query = $this->db->get();

        //if limit is empty then returns total count
        if ($limit == '') {
            $query->num_rows();
        }
        //if limit is not empty then return result array
        return $query->result_array();
    }

    function getDataTableSourcorderby($tablename, $datatable_fields = array(), $conditions_array = array(), $data = '*', $request, $join_str = array(), $group_by = array(), $orderby = '') {
        $output = array();
        //Fields tobe display in datatable
        $this->db->select($data);
        $this->db->from($tablename);
        //Making Join with tables if provided
        if (!empty($join_str)) {
            foreach ($join_str as $join) {
                if (!isset($join['join_type'])) {
                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id']);
                } else {
                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id'], $join['join_type']);
                }
            }
        }
        if ($orderby = '') {
            $this->db->order_by($orderby);
        }

        //Conditions for Query  that is defaultly available to Datatable data source.
        if (!empty($conditions_array)) {
            $this->db->where($conditions_array);
        }

        //Applying groupby clause to query
        if (!empty($group_by)) {
            $this->db->group_by($group_by);
        }

        //Total record in query tobe return
        $output['recordsTotal'] = $this->db->count_all_results(NULL, FALSE);

        //Filtering based on the datatable_fileds
        if ($request['search']['value'] != '') {
            $this->db->group_start();
            for ($i = 0; $i < count($datatable_fields); $i++) {
                if ($request['columns'][$i]['searchable'] == true) {
                    $this->db->or_like($datatable_fields[$i], $request['search']['value']);
                }
            }
            $this->db->group_end();
        }

        //Total number of records return after filtering not no of record display on page.
        //It must be counted before limiting the resultset.
        $output['recordsFiltered'] = $this->db->count_all_results(NULL, FALSE);

        //Setting Limit for Paging
        if ($request['length'] != -1) {
            $this->db->limit($request['length'], $request['start']);
        }


        //ordering the query
        if (isset($request['order']) && count($request['order'])) {
            for ($i = 0; $i < count($request['order']); $i++) {
                if ($request['columns'][$request['order'][$i]['column']]['orderable'] == true) {
                    $this->db->order_by($datatable_fields[$request['order'][$i]['column']] . ' ' . $request['order'][$i]['dir']);
                }
            }
        }

        $query = $this->db->get();
        $output['draw'] = $request['draw'];
        $output['data'] = $query->result_array();
        //print_r($output); die();
        return json_encode($output);
    }

    function select_data_by_search_groupby($tablename, $search_condition, $condition_array = array(), $data = '*', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '') {

        $this->db->select($data);
        $this->db->from($tablename);

        //if join_str array is not empty then implement the join query
        if (!empty($join_str)) {
            foreach ($join_str as $join) {
                if (!isset($join['join_type'])) {
                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id']);
                } else {
                    $this->db->join($join['table'], $join['join_table_id'] . '=' . $join['from_table_id'], $join['join_type']);
                }
            }
        }

        if ($search_condition != '') {
            $this->db->where($search_condition);
        }
        if (!empty($condition_array)) {
            $this->db->where($condition_array);
        }

        //Setting Limit for Paging
        if ($limit != '' && $offset == 0) {
            $this->db->limit($limit);
        } else if ($limit != '' && $offset != 0) {
            $this->db->limit($limit, $offset);
        }

        if ($groupby != '') {
            $this->db->group_by($groupby);
        }

        if ($orderby = '') {
            $this->db->order_by($orderby);
        }


        $query = $this->db->get();
        //if limit is empty then returns total count
        if ($limit == '') {
            $query->num_rows();
        }
        //if limit is not empty then return result array
        return $query->result_array();
    }


    /*------------------- Menu And Roles Funcation Start ---------------------*/

    function display_menu($item_array, $assign_menu = '', $active_menu = '') {
        $str = '<ul class="nav nav-pills" id="mainNav">';
        for ($i = 0; $i < count($item_array); $i++) {
            $active = '';
            if (!empty($active_menu)) {
                if (in_array($item_array[$i]['id'], $active_menu)) {
                    $active = " active selected ";
                }
            }

            if ($item_array[$i]['menu_id'] == null) {
                if ($item_array[$i]['url'] != '') {
                    $url = base_url() . $item_array[$i]['url'];
                } else {
                    $url = "javascript:void(0);";
                }
                if ($this->has_chield($item_array[$i]['id'], $item_array)) {                    
                    if ($this->session->userdata('is_superadmin') == '0') {
                        if (!empty($assign_menu)) {
                            if (in_array($item_array[$i]['id'], $assign_menu)) {
                                $str .= '<li class="dropdown' . $active . '">';
                                $str .= '<a href="' . $url . '" class="nav-link dropdown-toggle">';
                                $str .= '';
                                // $str .= $item_array[$i]['logo'] . " " . $item_array[$i]['name'];
                                $str .=  $item_array[$i]['name'];
                                $str .= '</a>';
                                $str .= $this->recursive($item_array[$i]['id'], $item_array, $assign_menu, $active_menu);
                            }
                        }
                    } else {
                        $str .= '<li class="dropdown ' . $active . '">';
                        $str .= '<a href="' . $url . '" class="nav-link dropdown-toggle">';
                        $str .= '';
                        // $str .= $item_array[$i]['logo'] . " " . $item_array[$i]['name'];
                        $str .= $item_array[$i]['name'];
                        $str .= '</a>';
                        $str .= $this->recursive($item_array[$i]['id'], $item_array, $assign_menu, $active_menu);
                    }
                } else {
                    if ($this->session->userdata('is_superadmin') == '0') {
                        if (!empty($assign_menu)) {
                            if (in_array($item_array[$i]['id'], $assign_menu)) {

                                $str .= '<li class="' . $active . '">';
                                $str .= '<a href="' . $url . '" class="nav-link">';
                                $str .= '';
                                // $str .= $item_array[$i]['logo'] . " " . $item_array[$i]['name'];
                                $str .=  $item_array[$i]['name'];
                                $str .= '</a>';
                            }
                        }
                    } else {
                        $str .= '<li class="' . $active . '">';
                        $str .= '<a href="' . $url . '" class="nav-link">';
                        $str .= '';
                        // $str .= $item_array[$i]['logo'] . " " . $item_array[$i]['name'];
                        $str .= $item_array[$i]['name'];
                        $str .= '</a>';
                    }
                }
                $str .= '</li>';
            }
        }
        $str .= '</ul>';
        return $str;
    }

    function recursive($menu_id, $item_array, $assign_menu, $active_menu) {
        $str = '<ul class="dropdown-menu cust_scroll_bar">';
        for ($i = 0; $i < count($item_array); $i++) {
            $active = '';
            if (!empty($active_menu)) {
                if (in_array($item_array[$i]['id'], $active_menu)) {
                    $active = " active ";
                }
            }
            if ($item_array[$i]['menu_id'] == $menu_id) {
                if ($item_array[$i]['url'] != '') {
                    $url = base_url() . $item_array[$i]['url'];
                } else {
                    $url = "javascript:void(0);";
                }

                if ($this->has_chield($item_array[$i]['id'], $item_array)) {
                    if ($this->session->userdata('is_superadmin') == '0') {
                        if (!empty($assign_menu)) {
                            if (in_array($item_array[$i]['id'], $assign_menu)) {
                                $str .= '<li class="dropdown' . $active . '">';
                                $str .= '<a href="' . $url . '" class="nav-link ' . $active . '">';
                                $str .= '<i class="icon-angle-right"></i>';
                                // $str .= '<span class="title">' . $item_array[$i]['logo'] . " " . $item_array[$i]['name'] . '</span>';
                                $str .= '<span class="title">' . $item_array[$i]['name'] . '</span>';
                                $str .= '</a>';
                                $str .= $this->recursive($item_array[$i]['id'], $item_array, $assign_menu, $active_menu);
                            }
                        }
                    } else {
                        $str .= '<li class="dropdown' . $active . '">';
                        $str .= '<a href="' . $url . '" class="nav-link ' . $active . '">';
                        $str .= '<i class="icon-angle-right"></i>';
                        // $str .= '<span class="title">' . $item_array[$i]['logo'] . " " . $item_array[$i]['name'] . '</span>';
                        $str .= '<span class="title">' .$item_array[$i]['name'] . '</span>';
                        $str .= '</a>';
                        $str .= $this->recursive($item_array[$i]['id'], $item_array, $assign_menu, $active_menu);
                    }
                } else {
                    if ($this->session->userdata('is_superadmin') == '0') {
                        if (!empty($assign_menu)) {
                            if (in_array($item_array[$i]['id'], $assign_menu)) {
                                $str .= '<li class="' . $active . '">';
                                $str .= '<a href="' . $url . '" class="nav-link ' . $active . '">';
                                // $str .= '<i class="icon-angle-right"></i>';
                                // $str .= '<span class="title">' . $item_array[$i]['logo'] . " " . $item_array[$i]['name'] . '</span>';
                                $str .= '<span class="title">' . $item_array[$i]['name'] . '</span>';
                                $str .= '</a>';
                            }
                        }
                    } else {
                        $str .= '<li class="' . $active . '">';
                        $str .= '<a href="' . $url . '" class="nav-link ' . $active . '">';
                        $str .= '<i class="icon-angle-right"></i>';
                        // $str .= '<span class="title">' . $item_array[$i]['logo'] . " " . $item_array[$i]['name'] . '</span>';
                        $str .= '<span class="title">'  . $item_array[$i]['name'] . '</span>';
                        $str .= '</a>';
                    }
                }
                $str .= '</li>';
            }
        }
        $str .= '</ul>';
        return $str;
    }

    function display_menu1($item_array, $menu_arr) {
        $str = '<ol class="dd-list">';
        for ($i = 0; $i < count($item_array); $i++) {
            $dashboard = "";
            if($item_array[$i]['id'] == "2") {
                $dashboard = "checked disabled ";
            }
            $checked = "";
            if (!empty($menu_arr)) {
                if (in_array($item_array[$i]['id'], $menu_arr)) {
                    $checked = "checked";
                }
            }
            if ($item_array[$i]['menu_id'] == null) {
                if ($item_array[$i]['url'] != '') {
                    $url = site_url() . $item_array[$i]['url'];
                } else {
                    $url = "javascript:void(0);";
                }

                if ($this->has_chield($item_array[$i]['id'], $item_array)) {
                    $str .= '<a href="#' . $item_array[$i]['id'] . '" class="list-group-item list-group-item" data-toggle="collapse" data-parent="#MainMenu"><b><i class="fa fa-plus"></i>&nbsp;' . $item_array[$i]['name'] . '<b></a>';
                    $str .= '</a>';
                    $str .= '<div class="collapse" id="' . $item_array[$i]['id'] . '">';
                    $str .= $this->recursive1($item_array[$i]['id'], $item_array, $menu_arr);
                } else {
                    $str .= '<div class="list-group-item list-group-item">';
                    $str .= '<label><input type="checkbox" id="' . $item_array[$i]['id'] . '" name="menu[]" value="' . $item_array[$i]['id'] . '" ' .$dashboard. $checked . '>&nbsp;';
                    $str .= '<b>'.$item_array[$i]['name'] . '</b></label>';
                    $str .= '</a>';
                }
                $str .= '</div>';
            }
        }
        $str .= '</ol>';
        return $str;
    }

    function recursive1($menu_id, $item_array, $menu_arr) {
        $str = '';
        for ($i = 0; $i < count($item_array); $i++) {
            $checked = "";
            if (!empty($menu_arr)) {
                if (in_array($item_array[$i]['id'], $menu_arr)) {
                    $checked = "checked";
                }
            }
            if ($item_array[$i]['menu_id'] == $menu_id) {
                if ($item_array[$i]['url'] != '') {
                    $url = site_url() . $item_array[$i]['url'];
                } else {
                    $url = "javascript:void(0);";
                }
                if ($this->has_chield($item_array[$i]['id'], $item_array)) {
                    $str .= '<a href="#' . $item_array[$i]['id'] . '" class="list-group-item list-group-item" data-toggle="collapse" data-parent="#MainMenu">&nbsp;&nbsp;&nbsp;<i class="fa fa-plus"></i>&nbsp;' . $item_array[$i]['name'] . '</a>';
                    $str .= '<div class="collapse" id="' . $item_array[$i]['id'] . '">';
                    $str .= $this->recursive2($item_array[$i]['id'], $item_array, $menu_arr);
                    $str .= '</div>';
                } else {
                    $str .= '<div class="list-group-item list-group-item">';
                    $str .= '&nbsp;&nbsp;&nbsp;<label><input type="checkbox" id="' . $item_array[$i]['id'] . '"  name="menu[]" value="' . $item_array[$i]['id'] . '" ' . $checked . '>';
                    $str .= '&nbsp;<b>' . $item_array[$i]['name'] . '</b></label>';
                    $str .= '</a>';
                    $str .= '</div>';
                }
            }
        }

        return $str;
    }

    function recursive2($menu_id, $item_array, $menu_arr) {
        $str = '';
        for ($i = 0; $i < count($item_array); $i++) {
            $checked = "";
            if (!empty($menu_arr)) {
                if (in_array($item_array[$i]['id'], $menu_arr)) {
                    $checked = "checked";
                }
            }
            if ($item_array[$i]['menu_id'] == $menu_id) {
                if ($item_array[$i]['url'] != '') {
                    $url = site_url() . $item_array[$i]['url'];
                } else {
                    $url = "javascript:void(0);";
                }
                if ($this->has_chield($item_array[$i]['id'], $item_array)) {
                    $str .= '<a href="" class="list-group-item">' . $item_array[$i]['name'] . '</a>';
                    $str = '<div class="collapse" id="' . $item_array[$i]['id'] . '">';
                    $str .= '</div>';
                } else {
                    $str .= '<div class="list-group-item list-group-item">';
                    $str .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="' . $item_array[$i]['id'] . '"  name="menu[]" value="' . $item_array[$i]['id'] . '" ' . $checked . '>';
                    $str .= '<a href="#' . $item_array[$i]['id'] . '" data-toggle="collapse" data-parent="#MainMenu">' . $item_array[$i]['name'] . '</a>';
                    $str .= '</a>';
                    $str .= '</div>';
                }
            }
        }

        return $str;
    }

    function has_chield($menu_id, $item_array) {
        $temp = 0;
        for ($i = 0; $i < count($item_array); $i++) {
            if ($item_array[$i]['menu_id'] == $menu_id) {
                $temp = 1;
                return true;
                break;
            }
        }
        if ($temp == 0) {
            return false;
        }
    }
    
    /*------------------- Menu And Roles Funcation Stop --------------------*/

    public function get_email_byid($mail_id)
    {
        $query = $this->db->get_where('email_format', array('mail_id' => $mail_id,'status'=>'Enabled'));
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }


    public function select_userabsent_count($userId)
    {
         $this->db->select('*');
        if(!empty($_GET['month']))
          $this->db->where('MONTH(date)', date($_GET['month']));
        else
            $this->db->where('MONTH(date)', date('m'));

        if(!empty($_GET['year']))
          $this->db->where('YEAR(date)', date($_GET['year']));
        else
            $this->db->where('YEAR(date)', date('Y'));

          $query = $this->db->get("members_attendance");
         $data = $query->result();
          $absentCount = 0;
          foreach ($data as $key => $value) {
              $info = json_decode($value->attendance_info);
              $info = json_decode(json_encode($info), true);

              if(isset($info[$userId]) && $info[$userId] == 0) {
                $absentCount += 1; 
              }
          }
          return $absentCount;
          
    }

    public function get_member_credit_info($userId,$filter) {
        $this->db->select('sum(member_credit_debit.debit_amount) as total_debited');
        $this->db->where('member_credit_debit.user_id', $userId);
         if(!empty($filter))
         {
            $this->db->where('MONTH(member_credit_debit.date)', date($filter['month']));
            $this->db->where('YEAR(member_credit_debit.date)', date($filter['year']));    
         }
         else
         {
          
        $this->db->where('MONTH(member_credit_debit.date)', date('m'));
        $this->db->where('YEAR(member_credit_debit.date)', date('Y'));  
         }
        $query = $this->db->get('member_credit_debit');
        return $query->row_array();
    }

    public function getMembers() {

        return $this->db->where('status','active')->get('members')->result();
    }

    public function getMonthlyStatement($userId,$filter) {
        $this->db->select('users_detail_info.*,members.full_name, members.post');
        $this->db->join('users_detail_info', 'members.id=users_detail_info.user_id', 'left');
        $this->db->where('users_detail_info.user_id', $userId);
        if(!empty($filter))
         {
            $this->db->where('MONTH(users_detail_info.created_at)', date($filter['month']));
            $this->db->where('YEAR(users_detail_info.created_at)', date($filter['year']));    
         }
         else
         {
          
        $this->db->where('MONTH(users_detail_info.created_at)', date('m'));
        $this->db->where('YEAR(users_detail_info.created_at)', date('Y'));
         }
        
        $query = $this->db->get('members');
        return $query->row();
    }

   
}
