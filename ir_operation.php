<?php
session_start();
if(isset($_SESSION["user_id"])){
    echo "使用者". $_SESSION["user_id"];
}
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>家電控制</title>
    <script>
        const gestureMapping = {}; // 初始化
        const userId = <?php echo json_encode($_SESSION['user_id']); ?>;//$_SESSION[user_id]轉為json 
        var address = null;
        var command = null;
        // 顯示IR可用的功能按鈕
        window.onload = function() {
            loadIr();
            const newIrDataForm = document.getElementById('newIrDataForm');
            const deleteIrDataForm = document.getElementById('deleteIrDataForm');
            newIrDataForm.addEventListener('submit', newHandleSubmit);
            deleteIrDataForm.addEventListener('submit', deleteHandleSubmit);
            console.log(newIrDataForm);
            console.log(deleteIrDataForm);
        };
        //處理新增ir code
        function newHandleSubmit(event) {
            event.preventDefault(); //防止表格為空時按下按鈕發生error

            // 獲取input data
            const irName = document.querySelector('input[name="irName"]').value;
            const deviceId = document.querySelector('input[name="deviceId"]').value;
            const gesture = document.querySelector('input[name="gesture"]').value;
            if(address != null && command != null){
                const item = [irName, deviceId, gesture, address, command, userId];
                update_ir_data(item);//將資料傳回python更新database
        
                console.log('IR:', irName);
                console.log('裝置:', deviceId);
                console.log('手勢:', gesture);
                console.log('address:', address);
                console.log('command:', command);
                console.log('user:', userId);
            }else{
                alert("請輸入紅外線");
            }

        }
        //處理刪除ir code
        function deleteHandleSubmit(event){
            event.preventDefault();
            const irCodeId = document.querySelector('input[name="irCodeId"]').value;
            console.log('刪除IR:', irCodeId);
            update_ir_data(irCodeId);//將資料傳回python更新database
        }
        //從 database中讀取ir code
        function loadIr() {
        
            console.log(userId);
            fetch('http://127.0.0.1:8082/get_ir_data', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ userId: userId })
            })
            .then(response => response.json())
            .then(data => {
                const mappingForm = document.getElementById("mappingForm");
                const ul = document.createElement('ul');
                const buttonContainer = document.getElementById("buttonContainer");
                console.log(data);
                //從資料庫取的資料
                data.forEach((item) => {
                    const [irId, irName, gesture] = item;
                    gestureMapping[irId] = { irName, gesture };
                    const display = document.getElementById('irDisplay');
                    display.innerHTML += 'irId: ' + item[0] + ' 指令: ' + item[1] + '<br>';
                });
                
                // 遍歷data存入
                for (const [irId, { irName, gesture }] of Object.entries(gestureMapping)) {
                    const button = document.createElement("button");
                    button.innerHTML = irName; // 按鈕名稱
                    button.id = `btn-${irId}`; // 按紐的 ID

                    // 點擊上方按鈕，發送IR
                    button.onclick = function() {
                        const event = {"userId":userId , "irId":irId};
                        console.log(event);
                        sendControlRequest(event);
                        console.log(irId);
                    };

                    buttonContainer.appendChild(button); // 按鈕加到頁面
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
        
        // 向python發送button資料
        function sendControlRequest(action) {
            fetch('http://localhost:8082/control', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ action: action })//使用action傳送給python
            })
            .then(response => 
                response.json())
            .then(data => {//接收到的ir code
                if (data.address && data.command) {
                    address = data.address;
                    command = data.command;
                    const display = document.getElementById('irDataReturn');
                    display.innerHTML = `Address: ${data.address}, Command: ${data.command}`;//使用html顯示
                }else{
                    alert(data.message);   
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert("操作失敗！");
            });
        }
        //新增刪除ir_data
        function update_ir_data(item) {
            console.log(item);
            fetch('http://localhost:8082/update_ir_data', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ item: item })
            })
            .then(response => {

                return response.json(); 
            })
            .then(data => {
                alert(data.message); 
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

    </script>
</head>
<body>
    <h1>按鈕</h1>
    <div id="buttonContainer"></div>
    <h1>設備管理</h1>
    <form method="post" id = "newIrDataForm">
        <h2>添加Ir</h2>
        Ir名稱: <input type="text" name="irName" required><br>
        裝置: <input type="number" name="deviceId" required><br>
        手勢: <input type="number" name="gesture" required><br>
        
        <button type="submit">加入IR</button>
    </form>
    <h5 id="irDataReturn"></h5><button onclick="sendControlRequest(0)">按下輸入紅外線</button>

    <form method = "post" id = "deleteIrDataForm">
        <h2>删除操作</h2>
        IrID: <input type="number" name="irCodeId" required><br>
        <button type="submit">刪除操作</button>
    </form>
    <div id="irDisplay"></div>
</body>
</html>