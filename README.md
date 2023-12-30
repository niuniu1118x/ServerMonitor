# 服务器状态监控系统

系统由两个文件组成，一个是用 Python 编写的服务器监控脚本 `server_monitor.py`，另一个是用 PHP 编写的服务器状态显示界面 `server_status_display.php`。

### Python 监控脚本：`server_monitor.py`

Python 监控脚本负责监视服务器状态并通过 TCP 服务器提供状态信息。它获取服务器的 CPU 使用率、内存使用率、在线时间、CPU 型号、操作系统信息以及网络流量信息，并在TCP服务器上监听并提供这些信息。

### PHP 显示界面：`server_status_display.php`

PHP 显示界面用于从 Python TCP 服务器获取服务器状态信息，并在网页上显示。它展示了连接到 Python TCP 服务器以获取服务器状态信息，并将这些信息以易读的格式呈现在网页上。

### 使用方式

1. 将 `server_monitor.py` 放置在服务器上并运行它。确保 Python 环境已安装相应的依赖。
2. 将 `server_status_display.php` 放置在 Web 服务器目录下，并在浏览器中访问此文件的 URL。
3. 在 `server_status_display.php` 中修改服务器列表 (`$servers` 数组) 为您要监控的服务器地址和端口。
```python
# 示例：修改服务器列表
$servers = [
    ["name" => "服务器 1", "host" => "127.0.0.1", "port" => 8888],
    ["name" => "服务器 2", "host" => "192.168.1.100", "port" => 8888]
    // 添加更多服务器...
];
```
4. 在浏览器中打开 `server_status_display.php`，您将在页面上看到服务器的状态信息。
