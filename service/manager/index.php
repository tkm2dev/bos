<?php
/**
 **** AppzStory Back Office Management System Template ****
 * Index Get ALL Manager
 * 
 * @link https://appzstory.dev
 * @author Yothin Sapsamran (Jame AppzStory Studio)
 */
header('Content-Type: application/json');
require_once '../connect.php';

/**
 |--------------------------------------------------------------------------
 | ดึงข้อมูล admin ทั้งหมด
 | 'SELECT * FROM admin'
 |--------------------------------------------------------------------------
*/
/** 
 * กำหนดข้อมูลสำหรับการ Response ไปยังฝั่ง Client
 * 
 * @return array 
 */



 
// $limit = $_GET['length'];
// $offset = $_GET['start'];
// $search = $_GET['search']['value'];

// $sql = 'SELECT id, name, email FROM users WHERE name LIKE :search LIMIT :limit OFFSET :offset';
// $stmt = $pdo->prepare($sql);
// $stmt->execute([
//     ':search' => "%$search%",
//     ':limit' => (int)$limit,
//     ':offset' => (int)$offset
// ]);

// $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// // หาจำนวนรายการทั้งหมด
// $stmtCount = $pdo->query('SELECT COUNT(*) FROM users');
// $total = $stmtCount->fetchColumn();

// // หาจำนวนรายการที่ตรงตามการค้นหา
// $stmtFilteredCount = $pdo->prepare('SELECT COUNT(*) FROM users WHERE name LIKE ?');
// $stmtFilteredCount->execute(["%$search%"]);
// $totalFiltered = $stmtFilteredCount->fetchColumn();

// $response = [
//     "draw" => intval($_GET['draw']),
//     "recordsTotal" => $total,
//     "recordsFiltered" => $totalFiltered,
//     "data" => $data
// ];

// echo json_encode($response);




$response = [
    'status' => true,
    'response' => array([
            'id' => '1',
            'username' => 'admin',
            'fisrt_name' => 'Yothin',
            'last_name' => 'Sapsamran',
            'email' => 'yothin@gmail.com',
            'status' => 'superadmin',
            'updated_at' => '2020-10-01 20:50:40',
            'created_at' => '2020-10-01 20:50:40'
        ],[
            'id' => '2',
            'username' => 'admin2',
            'fisrt_name' => 'AppzStory',
            'last_name' => 'Sapsamran',
            'email' => 'appzstory@gmail.com',
            'status' => 'admin',
            'updated_at' => '2020-10-01 20:50:40',
            'created_at' => '2020-10-01 20:50:40'
        ]
    ),
    'message' => 'Get Data Manager Success'
];
http_response_code(200);
echo json_encode($response);
