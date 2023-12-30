<!DOCTYPE html>
<html>
<head>
    <title>服务器状态监控</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 50px;
        }
        .server {
            margin-bottom: 30px;
            padding: 20px;
            border: 1px solid #ccc;
        }
        .status {
            font-size: 24px;
            margin-top: 20px;
        }
        .down {
            color: red;
        }
        .up {
            color: green;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">服务器状态</h1>
        <?php
            function getServerStatus($host, $port) {
                $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
                if ($socket === false) {
                    return "创建套接字失败";
                }

                $result = socket_connect($socket, $host, $port);
                if ($result === false) {
                    return "连接失败";
                }

                $response = '';
                while ($out = socket_read($socket, 2048)) {
                    $response .= $out;
                }

                socket_close($socket);

                return $response;
            }

            $server_statuses = [];
            $servers = [
                ["name" => "服务器 1", "host" => "127.0.0.1", "port" => 8888],  // 请替换为您的服务器详情
                ["name" => "服务器 2", "host" => "192.168.1.100", "port" => 8888]
                // 如有更多服务器，请添加
            ];

            foreach ($servers as $server) {
                $server_status = getServerStatus($server['host'], $server['port']);
                $server_info = json_decode($server_status, true);

                if ($server_info !== null) {
                    $server_statuses[] = [
                        "name" => $server['name'],
                        "status" => $server_info['status'],
                        "cpu_usage" => $server_info['cpu_usage'],
                        "memory_usage" => $server_info['memory_usage'],
                        "online_time" => $server_info['online_time'],
                        "cpu_model" => $server_info['cpu_model'],
                        "os" => $server_info['os'],
                        "hostname" => $server_info['hostname'],
                        "network_info" => $server_info['network_info']
                    ];
                }
            }

            foreach ($server_statuses as $server) {
                echo "<div class='server'>";
                echo "<h2>{$server['name']}</h2>";
                if ($server['status'] !== null) {
                    echo "<div class='status " . (($server['status'] === 'Server is up and running') ? 'up' : 'down') . "'>";
                    echo "<p>{$server['status']}</p>";
                    echo "<p>CPU 使用率: {$server['cpu_usage']}%</p>";
                    echo "<p>内存 使用率: {$server['memory_usage']}%</p>";
                    echo "<p>在线时间: {$server['online_time']}</p>";
                    echo "<p>CPU 型号: {$server['cpu_model']}</p>";
                    echo "<p>操作系统: {$server['os']}</p>";
                    echo "<p>主机名: {$server['hostname']}</p>";
                    echo "<p>网络发送: {$server['network_info']['sent']} 字节</p>";
                    echo "<p>网络接收: {$server['network_info']['received']} 字节</p>";
                    echo "</div>";
                } else {
                    echo "<div class='status down'>";
                    echo "<p>服务器状态不可用</p>";
                    echo "</div>";
                }
                echo "</div>";
            }
        ?>
    </div>

    <!-- Bootstrap JS (for some interactive components, if needed) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
