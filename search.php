<?php
session_start();
if(isset($_SESSION["user_id"])){
    echo "使用者". $_SESSION["user_id"];
}
// 資料庫連接設置
$servername = "localhost";
$username = "root"; // 請替換為你的使用者名稱
$password = ""; // 請替換為你的密碼
$dbname = "project"; // 請替換為你的資料庫名稱

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header("Location: login.php");
}
// 創建連接
$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連接
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 查詢資料
$user_id = $_SESSION["user_id"];
$user_id = $conn->real_escape_string($user_id);
$sql = "SELECT * FROM device_usage WHERE user_id='$user_id'";//查次數
$time = "SELECT * FROM user_activity WHERE user_id='$user_id'";//查時間
$result = $conn->query($sql);
$activity = $conn->query($time);

// 檢查結果並顯示
if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>切換頁面</th>
                <th>網頁上滑</th>
                <th>網頁下滑</th>
                <th>上一首音樂次數</th>
                <th>下一首音樂次數</th>
                <th>簡報下一頁次數</th>
                <th>簡報上一頁次數</th>
                <th>手指繪畫次數</th>
                <th>音量增加次數</th>
                <th>音量增加次數</th>
                
            </tr>";

    // 輸出每一行
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['user_id']}</td>
                <td>{$row['appliance_change']}</td>
                <td>{$row['scroll_up_gesture_count']}</td>
                <td>{$row['scroll_down_gesture_count']}</td>
                <td>{$row['previous_music_gesture_count']}</td>
                <td>{$row['next_music_gesture_count']}</td>
                <td>{$row['next_slide_gesture_count']}</td>
                <td>{$row['previous_slide_gesture_count']}</td>
                <td>{$row['drawing_gesture_count']}</td>
                <td>{$row['volume_increase_gesture_count']}</td>
                <td>{$row['volume_decrease_gesture_count']}</td>
                
              </tr>";
    }
    echo "</table>";
} else {
    echo "沒有資料可顯示";
}

if ($activity->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>操作</th>
                <th>使用時間</th>
            </tr>";

    // 輸出每一行
    while($row = $activity->fetch_assoc()) {
        echo "<tr>
                <td>{$row['activity']}</td>
                <td>{$row['activity_time']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "沒有資料可顯示";
}
$conn->close();
?>